<?php

namespace App\Http\Controllers\Admin;

use App\Events\CompressImagesEvent;
use App\Events\NewModelReportAddedEvent;
use App\Events\VersionChangedEvent;
use App\Http\Controllers\Controller;
use App\Models\Adr;
use App\Models\AdrMod;
use App\Models\ChildCopy;
use App\Models\EngineCapacity;
use App\Models\EngineConfiguration;
use App\Models\EngineInduction;
use App\Models\EngineMotivePower;
use App\Models\MasterCopy;
use App\Models\TransmissionDriveTrainConfig;
use App\Models\TransmissionModel;
use App\Models\VehicleBodyType;
use App\Models\VehicleCategory;
use App\Models\VehicleMake;
use App\Models\VehicleRecallCheckLink;
use App\Models\VehicleSteeringLocation;
use App\Models\VehicleVinLocation;
use App\Traits\ChildCopyTrait;
use App\Traits\CommonTrait;
use App\Traits\MasterCopyTrait;
use App\Traits\VersionChangeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ChildCopyController extends Controller
{
    use CommonTrait, MasterCopyTrait, ChildCopyTrait, VersionChangeTrait;

    public function search(Request $request)
    {
        $this->ajax_verify($request);

        /*if (MasterCopy::where([
            'make' => $data['vehicle']['make'],
            'model' => $data['vehicle']['model'],
            'model_code' => $data['vehicle']['model_code'],
        ])->exists()) {
            // time() . mt_rand() . '.'
        }*/
    }

    public function index()
    {
        return view('admin.child_copies.list', [
            'child_copies' => ChildCopy::latest()->get()->groupBy('batch_id'),
            'master_copies' => MasterCopy::active()->get(),
        ]);
    }

    public function create()
    {
        if (empty($_GET['master'])){
            abort(404);
        }

        return view('admin.child_copies.create', array_merge(
            $this->get_common_data(),
            $this->get_child_copy_specific_data($_GET['master']),
        ));

    }

    public function store(Request $request)
    {
        //$this->ajax_verify($request);
        $data = $request->all();
        // Validation is done in the front end using jquery

        $data = array_merge($data, $data['gen']);
        $data['mods']['post'] = $data['gen'];
        unset($data['gen']);

        // save preloaded data
        $this->save_preloaded_data($data);

        // format data
        $master_data = array_merge($this->format_data($data), [
            'master_copy_id' => $data['master_copy_id'],
            'version' => date('dmY-Hi'),
            'created_by' => auth()->user()->id,
            'data' => ''
        ]);

        // sort rav images
        $rav_images = $this->sort_rav_images($data);

        // sort_measurements
        $measurements = [];

        if (!empty($data['dimensions'])) {
            $this->format_dimensions($data, $measurements);
        }
        unset($data['photos'], $data['measurements']);

        // format adr_mods        ;
        $data['adr_mods'] = $this->format_adr_mods($data);

        // save master copy
        return DB::transaction(function () use ($master_data, $data, $rav_images, $measurements) {

            try {

                $childCopy = ChildCopy::create($master_data);
                unset($data['_token'], $data['price'], $data['master']);

                foreach ($rav_images AS $k => $image) {
                    $data['rav'][$k] = $image;
                    $data['rav'][$k]['image'] = time() . mt_rand() . '.' . $image['image']->extension();
                    $image['image']->move(public_path('uploads/images/child/' . $childCopy->id . '/rav'),  $data['rav'][$k]['image']);
                }

                foreach ($measurements AS $location => $values) {
                    foreach ($values AS $k => $value) {
                        if ($location === 'under_bonnet') {
                            foreach($value AS $i => $v) {
                                $data['measurements'][$location][$k][$i] = $v;
                                if (!empty($v['image'])) {
                                    $data['measurements'][$location][$k][$i]['image'] = time() . mt_rand() . '.' . $v['image']->extension();
                                    $v['image']->move(public_path('uploads/images/child/' . $childCopy->id . '/measurements/' . $location), $data['measurements'][$location][$k][$i]['image']);
                                } else {
                                    $data['measurements'][$location][$k][$i]['heading'] = $data['measurements'][$location][$k][$i]['description'] = '';
                                }
                            }
                        } else {
                            $data['measurements'][$location][$k] = $value;
                            if (!empty($value['image'])) {
                                $data['measurements'][$location][$k]['image'] = time() . mt_rand() . '.' . $value['image']->extension();
                                $value['image']->move(public_path('uploads/images/child/' . $childCopy->id . '/measurements/' . $location), $data['measurements'][$location][$k]['image']);
                            } else {
                                $data['measurements'][$location][$k]['heading'] = $data['measurements'][$location][$k]['description'] = '';
                            }
                        }
                    }
                }

                // save adrs
                $adrs = Adr::find($data['adrs'], ['id', 'number', 'name', 'text', 'html', 'evidence'])->toArray();

                $childCopy->adrs()->createMany(array_map(function ($adr) {
                    return array_merge($adr, [
                        'parent_adr_id' => $adr['id'],
                        'is_common_adr' => ((int)(str_replace('/', '', $adr['number']))) > 10000 ? 1 : 0
                    ]);
                }, $adrs));

                // create default mods
                $childCopy->mods()->create([
                    'variant_id' => 1,
                    'post' => json_encode($data['mods']['post']),
                    'created_by' => auth()->user()->id
                ]);

                unset($data['adrs'], $data['mods'], $data['model_report_number'], $data['master_copy_id']);
                $childCopy->update(['batch_id' => $childCopy->id, 'data' => $data]);

                event(new CompressImagesEvent($childCopy->id));

                return redirect('/admin/child-copy?item=' . $childCopy->batch_id);

            } catch (\Exception $e) {
                Log::error($e->getMessage());
                dd('Unable to create the Child Copy. Please contact your System Administrator');
            }

        });

    }

    public function show()
    {
        abort(404);
    }

    public function edit(Request $request, ChildCopy $childCopy)
    {
        return view('admin.child_copies.create', array_merge([
                'childCopy' => $childCopy,
                'child_copy_adrs' => $this->sort_adrs($childCopy->adrs),
            ],
            $this->get_common_data(),
            $this->get_child_copy_specific_data($childCopy->master_copy_id)
        ) + [
            'changes' => $this->format_version_changes_keys($childCopy),
            'masterCopy' => $childCopy->master,
        ]);
    }

    public function update(Request $request, $id)
    {
        $childCopy = ChildCopy::find($id);

        $data = $request->all();
        // validation is done in the front end using jquery

        $data = array_merge($data, $data['gen']);
        unset($data['gen']);

        // save preloaded data
        $this->save_preloaded_data($data);

        // format data
        $master_data = $this->format_data($data);

        // format adr_mods;
        $data['adr_mods'] = $this->format_adr_mods($data);

        $data_modified = [];

        $data_modified['vehicle'] = $data['vehicle'];
        $data_modified['engine'] = $data['engine'];
        $data_modified['transmission'] = $data['transmission'];
        $data_modified['other_variant'] = $data['other_variant'];
        $data_modified['other_variant_value'] = $data['other_variant_value'];
        $data_modified['adr_mods'] = $data['adr_mods'];
        $data_modified['dimensions'] = $data['dimensions'];
        $data_modified['oem_figures'] = $data['oem_figures'];
        $data_modified['adrs'] = $data['adrs'];

        // sort rav images
        $data_modified['rav'] = $this->sort_rav_images($data, $childCopy->data['rav']);

        // sort_measurements
        $data_modified['measurements'] = [];
        if (!empty($data['dimensions'])) {
            $this->format_dimensions($data, $data_modified['measurements'], $childCopy['data']['measurements']);
        }
        unset($data['photos'], $data['measurements']);

        $is_new_version = $data['is_new_version'] ?? 0;

        // update data
        return DB::transaction(function () use($childCopy, $master_data, $data_modified, $is_new_version) {

            try {

                $has_images_updated = FALSE;

                if ($is_new_version) {

                    $newChildCopy = $this->duplicate_child_copy($childCopy);
                    $this->copy_images(public_path('uploads/images/child/' . $childCopy->id), public_path('uploads/images/child/' . $newChildCopy->id));

                } else {
                    $childCopy->update($master_data);
                }

                //updating photos
                foreach ($data_modified['rav'] AS $k => $image) {
                    if (is_object($image['image'])) {
                        $data_modified['rav'][$k]['image'] = time() . mt_rand() . '.' . $image['image']->extension();
                        $image['image']->move(public_path('uploads/images/child/' . ($is_new_version ? $newChildCopy->id : $childCopy->id) . '/rav'),  $data_modified['rav'][$k]['image']);
                        $has_images_updated = TRUE;
                    }
                }

                // updating measurements
                foreach ($data_modified['measurements'] AS $location => $values) {
                    foreach ($values AS $k => $value) {
                        if ($location === 'under_bonnet') {
                            foreach($value AS $i => $v) {
                                if (is_object($v['image'])) {
                                    $data_modified['measurements'][$location][$k][$i] = $v;
                                    $data_modified['measurements'][$location][$k][$i]['image'] = time() . mt_rand() . '.' . $v['image']->extension();
                                    $v['image']->move(public_path('uploads/images/child/' . ($is_new_version ? $newChildCopy->id : $childCopy->id) . '/measurements/' . $location), $data_modified['measurements'][$location][$k][$i]['image']);
                                    $has_images_updated = TRUE;
                                }
                            }
                        } else {
                            if (is_object($value['image'])) {
                                $data_modified['measurements'][$location][$k] = $value;
                                $data_modified['measurements'][$location][$k]['image'] = time() . mt_rand() . '.' . $value['image']->extension();
                                $value['image']->move(public_path('uploads/images/child/' . ($is_new_version ? $newChildCopy->id : $childCopy->id) . '/measurements/' . $location), $data_modified['measurements'][$location][$k]['image']);
                                $has_images_updated = TRUE;
                            }
                        }
                    }
                }

                // update adrs
                $adrs = Adr::find($data_modified['adrs'], ['id', 'number', 'name', 'text', 'html', 'evidence']);

                $all_adr_numbers = $adrs->keyBy('number')->Keys()->toArray();
                $existing_adr_numbers = $childCopy->adrs->keyBy('number')->Keys()->toArray();

                // find the new adrs that is required to be saved or/and removed
                $new_adr_numbers = array_diff($all_adr_numbers, $existing_adr_numbers);
                $deleted_adr_numbers = array_diff($existing_adr_numbers, $all_adr_numbers);

                if ($is_new_version) {

                    // duplicate adrs
                    // take existing from old child copy + new from the common
                    $existingAdrs = $childCopy->adrs->except($childCopy->adrs()->whereIn('number', $deleted_adr_numbers)->pluck('id')->toArray());
                    $newAdrs = $adrs->whereIn('number', $new_adr_numbers);

                    $newChildCopy->adrs()->createMany(array_map(function($adr) {
                        return array_merge($adr, [
                            'parent_adr_id' => $adr['parent_adr_id'] ?? $adr['id'],
                            'pdf' => $adr['pdf'] ?? '',
                            'is_common_adr' => ((float)(str_replace('/', '.', $adr['number']))) > 1000 ? 1 : 0
                        ]);
                    }, ($newAdrs->merge($existingAdrs))->map(function($adr) {
                        return $adr->only(['id', 'parent_adr_id', 'number', 'name', 'text', 'html', 'evidence', 'pdf']);
                    })->toArray()));

                    $newChildCopy->update(array_merge($master_data, ['data' => $data_modified]));

                    $this->change_version_child_copy($childCopy, $newChildCopy, $new_adr_numbers, $deleted_adr_numbers);

                } else {

                    foreach ($new_adr_numbers as $number) {
                        $childCopy->adrs()->create(array_merge($adrs->keyBy('number')[$number]->toArray(), [
                            'parent_adr_id' => $adrs->keyBy('number')[$number]['id'],
                            'is_common_adr' => ((float)(str_replace('/', '.', $adrs->keyBy('number')[$number]['number']))) > 1000 ? 1 : 0
                            ])
                        );
                    }

                    foreach ($deleted_adr_numbers as $number) {
                        $childCopy->adrs()->where('number', $number)->delete();
                    }

                    $childCopy->update(['data' => $data_modified]);

                }

                if ($has_images_updated) {
                    event(new CompressImagesEvent($is_new_version ? $newChildCopy->id : $childCopy->id));
                }

                return redirect('/admin/child-copy?item=' . $childCopy->id);

            } catch (\Exception $e) {
                report($e);
                Log::error($e->getMessage());
                //dd('Something went wrong. Please Contact your System Administrator');
            }

        });


    }

    public function edit_column(Request $request, ChildCopy $childCopy)
    {
        $this->ajax_verify($request);

        if (!in_array($request->column, ['price', 'approval_code'])) {
            return $this->ajax_msg('error', 'Invalid Request. Please contact your System Administrator');
        }

        $html = view('admin.child_copies.update_column', [
            'column' => $request->column,
            'report' => $childCopy
        ])->render();

        return $this->ajax_msg('success', '', $html);

    }

    public function edit_index(Request $request, ChildCopy $childCopy)
    {
        if (empty($childCopy->indexes)) {
            $pages[2] = $childCopy->master->pages->firstWhere('sort_order', 2)->html;
            $pages[29] = $childCopy->master->pages->firstWhere('blueprint_id', 29)->text;
        } else {
            $pages[2] = $childCopy->indexes[2]['html'];
            $pages[29] = $childCopy->indexes[29]['text'];
        }

        return view('admin.child_copies.index', [
            'pages' => $pages,
            'child_copy_id' => $childCopy->id
        ]);
    }

    public function update_column(Request $request, ChildCopy $childCopy)
    {
        $this->ajax_verify($request);

        $data = $request->except('_token', '_method');

        $column = array_keys($data)[0];

        if (!in_array($column, ['price', 'approval_code'])) {
            return $this->ajax_msg('error', 'Invalid Request. Please contact your System Administrator');
        }

        $rules = ['required'];
        if ($column == 'price') {
            $rules = array_merge($rules, ['numeric']);
            $data['price'] = (float)preg_replace('@[^0-9.-]+@', '', $data['price']);
        } else {
            $rules = array_merge($rules, ['string', 'max:150']);
        }

        $validator = Validator::make($data, [$column => $rules]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        try {
            $update_data = [$column => $data[$column]];
            if ($column === 'approval_code' && $childCopy->is_active == 0) {

                $update_data['is_active'] = 1;

                // make inactive all the previously created child copies
                $reports = ChildCopy::where('batch_id', $childCopy->batch_id)->orderBy('id', 'DESC')->where('id', '<', $childCopy->id)->get();
                if ($reports) {
                    foreach ($reports AS $report) {
                        $report->update(['is_active' => 0, 'is_readonly' => 1]);
                    }
                }

                if ($childCopy->id != $childCopy->batch_id) {
                    event(new VersionChangedEvent($childCopy));
                } else {
                    event(new NewModelReportAddedEvent($childCopy));
                }

            }

            $childCopy->update($update_data);

            return $this->ajax_msg('success', 'The value has ben updated', '',  'admin/child-copy');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            dd('Something went wrong. Please contact your system administrator');
        }

    }

    public function update_index(Request $request, ChildCopy $childCopy)
    {
        $this->ajax_verify($request);

        try {

            $indexes = [
                2 => ['html' => json_encode($request['content'][2])],
                29 => [
                    'text' => json_encode($request['content'][29]),
                    'html' => json_encode($this->replace_variables(29, $request['content'][29]))
                ]
            ];

            $childCopy->update(['indexes' => $indexes]);

            return $this->ajax_msg('success', '', '','/admin/child-copy?item=' . $childCopy->id);

        } catch (\Exception $e) {
            report($e);
            Log::error($e->getMessage());
            dd('Something went wrong. Please contact your System Administrator');
        }
    }

    public function destroy(Request $request, $id)
    {
        $this->ajax_verify($request);
        $childCopy = ChildCopy::find($id);

        $childCopy->delete();

        $parent = ChildCopy::find($childCopy->batch_id);
        if ($parent) {
            return $this->ajax_msg('success', '', '', 'admin/child-copy?item=' . $childCopy->batch_id);
        } else {
            return $this->ajax_msg('success', '', '', 'admin/child-copy');
        }

    }

    private function get_child_copy_specific_data($master_id)
    {
        $data = [
            'master' => MasterCopy::findOrFail($master_id),
            'page_title' => 'Create Child Copy',
            'adr_mods' => AdrMod::active()->orderBy('adr_number')->get(),
            'photo_headings' => $this->get_photo_headings(),
            'key' => 'gen',
            'prefix' => '0'
        ];

        $data['adrs'] = $this->sort_adrs(Adr::active()->get());
        return $data;
    }

    private function save_preloaded_data($data)
    {
        VehicleMake::firstOrCreate(['name' => $data['vehicle']['make']]);
        VehicleMake::firstWhere('name', $data['vehicle']['make'])->models()->firstOrCreate(['name' => $data['vehicle']['model']]);

        VehicleBodyType::firstOrCreate(['name' => $data['vehicle']['body_type']]);
        VehicleCategory::firstOrCreate(['name' => $data['vehicle']['category']]);
        VehicleRecallCheckLink::firstOrCreate(['name' => $data['vehicle']['check_link']]);
        VehicleVinLocation::firstOrCreate(['name' => $data['vehicle']['vin_location']]);
        VehicleSteeringLocation::firstOrCreate(['name' => $data['vehicle']['steering_location']]);
        VehicleBodyType::firstOrCreate(['name' => $data['vehicle']['body_type']]);

        EngineCapacity::firstOrCreate(['name' => $data['engine']['capacity']]);
        EngineConfiguration::firstOrCreate(['name' => $data['engine']['config']]);
        EngineMotivePower::firstOrCreate(['name' => $data['engine']['motive_power']]);
        EngineInduction::firstOrCreate(['name' => $data['engine']['induction_type']]);

        TransmissionModel::firstOrCreate(['name' => $data['transmission']['model']]);
        TransmissionDriveTrainConfig::firstOrCreate(['name' => $data['transmission']['drive_train_config']]);
    }

    private function format_data(array $data)
    {
        $data['vehicle']['seats'] = array_filter($data['vehicle']['seats']);

        $description = ($data['vehicle']['doors']['side'] + $data['vehicle']['doors']['rear']) . 'DR ' . $data['engine']['capacity'] . 'CC ' . $data['engine']['motive_power'] . ' ' . ucfirst($data['transmission']['type']) . '<br>';
        $description .= array_sum($data['vehicle']['seats']) . ' Seat ' . $data['vehicle']['category'] . ' ' . $data['vehicle']['build_range_starts'] . ' to ' . (!empty($data['vehicle']['build_range_ends']) ? $data['vehicle']['build_range_ends'] : 'Current');

        return [
            'name' => $data['model_report_number'],
            'make' => $data['vehicle']['make'],
            'model' => $data['vehicle']['model'],
            'model_code' => $data['vehicle']['model_code'],
            'price' => $data['price'],
            'description' => $description,
        ];
    }

    private function format_adr_mods(array $data)
    {
        $adr_modifications = [];
        foreach ($data['adr_mods']['adr_number'] AS $i => $number) {
            if ($i > 0) {
                $adr_modifications[$i] = [
                    'adr_number' => $number,
                    'description' => $data['adr_mods']['description'][$i],
                    'part_numbers' => $data['adr_mods']['part_number'][$i],
                    'sort_order' => $data['adr_mods']['sort_order'][$i]
                ];

                AdrMod::firstOrCreate([
                    'adr_number' => $number,
                    'description' => $data['adr_mods']['description'][$i]
                ]);
            }

        }

        usort( $adr_modifications, function($a, $b) {
            return $a['sort_order'] - $b['sort_order'];
        });

        return $adr_modifications;
    }

    public function version_changes(Request $request, ChildCopy $childCopy)
    {
        $this->ajax_verify($request);
        $masterCopy = $childCopy->master;

        $changes = $this->format_version_changes_keys($childCopy);

        $html = view('admin.child_copies.partials.version_change_modal', compact('childCopy', 'masterCopy', 'changes'))->render();
        return $this->ajax_msg('success', '', $html);

    }

    private function sort_measurements($data, $existing_images = [])
    {
        $measurements = [];

        if ($existing_images) {
            $existing_images = collect($existing_images)->keyBy('id');
        }

        foreach ($data['id'] AS $k => $id) {
            $measurements[$id] = [
                'id' => $id,
                'heading' => $data['heading'][$k] ?? '',
                'image' => $data['image'][$k] ?? ($existing_images[$id]['image'] ?? ''),
                'sort_order' => $data['sort_order'][$k] ?? 0,
                'description' =>$data['description'][$k] ?? ''
            ];
        }

        usort( $measurements, function($a, $b) {
            return $a['sort_order'] - $b['sort_order'];
        });
        return $measurements;

    }

    private function sort_rav_images(array $data, $existing_images = [])
    {
        $rav_images = [];
        if ($existing_images) {
            $existing_images = collect($existing_images)->keyBy('id');
        }

        foreach ($data['photos']['rav']['id'] AS $k => $id) {
            $rav_images[$id] = [
                'id' => $id,
                'heading' => $data['photos']['rav']['heading'][$k],
                'sort_order' =>$data['photos']['rav']['sort_order'][$k],
                'image' => $existing_images ? $existing_images[$id]['image'] : '',
            ];

            if (!empty($data['photos']['rav']['image'][$k])) {
                $rav_images[$id]['image'] = $data['photos']['rav']['image'][$k];
            }
        }

        usort( $rav_images, function($a, $b) {
            return $a['sort_order'] - $b['sort_order'];
        });

        return $rav_images;
    }

    private function copy_images($source, $dest, $permissions = 0755)
    {
        $sourceHash = $this->hashDirectory($source);
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        if (is_file($source)) {
            return copy($source, $dest);
        }

        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }

        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            if ($sourceHash != $this->hashDirectory($source . "/" . $entry)) {
                $this->copy_images("$source/$entry", "$dest/$entry", $permissions);
            }
        }

        $dir->close();
        return true;
    }

    // In case of coping a directory inside itself, there is a need to hash check the directory otherwise and infinite loop of coping is generated
    function hashDirectory($directory)
    {
        if (!is_dir($directory)) {
            return false;
        }

        $files = array();
        $dir = dir($directory);

        while (false !== ($file = $dir->read())) {
            if ($file != '.' and $file != '..') {
                if (is_dir($directory . '/' . $file)) {
                    $files[] = $this->hashDirectory($directory . '/' . $file);
                } else {
                    $files[] = md5_file($directory . '/' . $file);
                }
            }
        }

        $dir->close();

        return md5(implode('', $files));
    }

    private function format_dimensions($data, &$measurements, $existing_images = [])
    {
        foreach ($data['dimensions'] AS $key => $value) {
            if ($key != 'ub') {
                if ($key === 'under_bonnet' && isset($data['dimensions']['ub'])) {
                    if ($data['dimensions']['ub'] == 'A-B') {
                        $measurements[$key]['A-B'] = $this->sort_measurements($data['measurements'][$key]['A-B'], $existing_images[$key]['A-B'] ?? []);
                    } else {
                        $measurements[$key]['A'] = $this->sort_measurements($data['measurements'][$key]['A'], $existing_images[$key]['A'] ?? []);
                        $measurements[$key]['B'] = $this->sort_measurements($data['measurements'][$key]['B'], $existing_images[$key]['B'] ?? []);
                    }
                } else {
                    $measurements[$key] = $this->sort_measurements($data['measurements'][$key], $existing_images[$key] ?? []);
                }
            }
        }
    }

    private function format_version_changes_keys($childCopy) {

        $changes = [];

        if ($childCopy->versionChanges) {
            foreach ($childCopy->versionChanges['data'] as $key => $change) {

                if (preg_match('/.(\d+)/', $key, $output)) {
                    $key = preg_replace('/.(\d+)/', '.' . ($output[1] + 1) . '.', $key);
                }

                if ($key === 'other_variant') {
                    $change['old'] = $this->other_variants[$change['old']];
                    $change['new'] = $this->other_variants[$change['new']];
                }

                $key_formatteed = ucwords(str_replace('.', ' ', str_replace('_', ' ', $key)));
                $key_formatteed = str_replace('Adr', 'ADR', $key_formatteed);
                $key_formatteed = str_replace('Rav', 'RAV', $key_formatteed);

                $changes[$key_formatteed] = $change;

            }
        }

        return $changes;
    }

    private function sort_adrs($adrs)
    {
        $adr_sorted = [];
        foreach ($adrs AS $adr)
        {
            $adr_sorted[str_replace('/', '.', $adr['number'])] = [
                'id' => $adr['id'],
                'number' => $adr['number'],
                'name' => $adr->name,
                'title' => $adr['is_common_adr'] ? $adr->name : $adr['number']
            ];
        }
        ksort($adr_sorted);
        return $adr_sorted;
    }

}
