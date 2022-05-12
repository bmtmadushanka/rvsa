<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterCopy;
use App\Traits\ChildCopyTrait;
use App\Traits\CommonTrait;
use App\Traits\MasterCopyTrait;
use App\Traits\VersionChangeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MasterCopyController extends Controller
{
    use CommonTrait, MasterCopyTrait, ChildCopyTrait, VersionChangeTrait;

    public function index()
    {
        return view('admin.master.list', [
            'master_copies' => MasterCopy::latest()->get()->groupBy('batch_id'),
        ]);
    }

    public function create(Request $request)
    {
        $blueprints = range(1, 33);

        foreach ($blueprints AS $blueprint)
        {
            if (in_array($blueprint, [2, 3])) {
                continue;
            }

            $pages[$blueprint] = view('admin.master.blueprints.page_'. $blueprint, [
                'is_blueprint' => true
            ]);
        }

        return view('admin.master.create', [
            'pages' => $pages,
        ]);
    }

    public function store(Request $request)
    {
        $this->ajax_verify($request);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:60']
        ]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        List($pages, $history) = $this->append_indexes($request);

        try {

            return DB::transaction(function() use($request, $pages) {
                $master = MasterCopy::create([
                    'name' => $request->name,
                    'version' => date('dmY-Hi'),
                    'created_by' => auth()->user()->id
                ]);

                $master->update(['batch_id' => $master->id]);

                $master->pages()->createMany($pages);

                return $this->ajax_msg('success', '', '', '/admin/master-copy?item=' . $master->batch_id);
            });



        } catch (\Exception $e) {
            report($e);
            Log::error($e->getMessage());
            dd('Something went wrong. Please contact your System Administrator');
        }

    }

    public function edit(Request $request, MasterCopy $masterCopy)
    {
        $pages = [];

        foreach ($masterCopy->pages->sortBy('sort_order') AS $page) {
            if ($page->sort_order === 2) {
                continue;
            }

            $pages[$page->sort_order == 1 ? $page->sort_order : $page->sort_order + 1] = [
                'blueprint_id' => $page->blueprint_id,
                //'text' => json_decode(html_entity_decode($page->text)),
                'text' => $page->sort_order === 1 ? json_decode(html_entity_decode($page->text)) : preg_replace('/src *= *[\"]?([^\"]*)/', 'src="' . config('app.url'). '/images/image_placeholder.png', json_decode(html_entity_decode($page->text))),
                'sort_order' => $page->sort_order == 1 ? $page->sort_order : $page->sort_order+1,
                'page_id' => $page->id
            ];
        }

        return view('admin.master.create', [
            'masterCopy' => $masterCopy,
            'pages' => $pages
        ]);
    }

    public function update(Request $request, MasterCopy $masterCopy)
    {
        $this->ajax_verify($request);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:60']
        ]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        if (! $request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        }
      //  print_r($request->all());exit;
        List($pages, $history) = $this->append_indexes($request, $masterCopy);

        //dd($history);exit;

        try {

            return DB::transaction(function() use($masterCopy, $request, $pages, $history) {

                if ($request->is_new_version) {

                    $deleted_pages = array_filter($pages, function ($page) {
                        return ($page['is_delete'] == 1);
                    });

                    $pages = array_diff_key($pages, $deleted_pages);

                    $masterCopyNew = MasterCopy::create([
                        'name' => $request->name,
                        'version' => date('dmY-Hi'),
                        'batch_id' => $masterCopy->batch_id,
                        'created_by' => auth()->user()->id
                    ]);

                    $masterCopyNew->pages()->createMany($pages);

                    // get all the child copies associated with the master copy and group by the batch_id.
                    $childCopiesGrouped = $masterCopy->childCopies->sortByDesc('created_at')->groupBy('batch_id');

                    // if the group has a latest active child copy, duplicate it and attach with the newly created master,
                    // else connect all the latest inactive child copies with the newly created master.
                    foreach ($childCopiesGrouped AS $childCopies) {
                        foreach ($childCopies AS $childCopy) {

                            if ($childCopy->is_active) {
                                $new_child_copy = $this->duplicate_child_copy($childCopy, TRUE, $masterCopyNew->id);

                                $this->store_version_changes($new_child_copy, ['master_copy' => [
                                    'old' => $masterCopy->name . ' (' . $masterCopy->version . ')',
                                    'new' => $masterCopyNew->name . ' (' . $masterCopyNew->version . ')',
                                ]], 'main', $childCopy->id);

                                // create revision history for master copy
                                if (!empty($history)) {
                                    $this->store_version_changes($masterCopyNew, $history, NULL, $masterCopy->id);
                                }

                                continue;

                            } else {
                                $this->update_content($request, $masterCopy, $pages);

                                // create revision history for master copy
                                if (!empty($history)) {
                                    $this->store_version_changes($masterCopyNew, $history, NULL, $masterCopy->id);
                                }
                            }
                        }
                    }

                } else {
                    $this->update_content($request, $masterCopy, $pages);
                }

                return $this->ajax_msg('success', '', '', '/admin/master-copy?item=' . $masterCopy->batch_id);

            });

        } catch (\Exception $e) {
            report($e);
            Log::error($e->getMessage());
            dd('Something went wrong. Please contact your System Administrator');
        }

    }

    public function generate()
    {
        return view('admin.master.generate', [
            'blueprints' => $this->blueprints
        ]);
    }

    public function destroy(Request $request, MasterCopy $masterCopy)
    {
        $this->ajax_verify($request);

        if ($masterCopy->childCopies->count()) {
            return $this->ajax_msg('error', 'The master copy is linked with some Child Copies. Therefore the action cannot be done');
        }

        $masterCopy->delete();
        return $this->ajax_msg('success', '', '', true);
    }

    public function version_changes(Request $request, MasterCopy $masterCopy)
    {
        $this->ajax_verify($request);

        $html = view('admin.master.version_changes.modal', compact('masterCopy'))->render();
        return $this->ajax_msg('success', '', $html);

    }

    private function append_indexes($request, $masterCopy = NULL)
    {
        List ($pages, $indexes, $history) = $this->prepare_pages($request, $masterCopy);

        $index = [
            'page_id' => $masterCopy ? 2 : 0,
            'sort_order' => 2,
            'text' => NULL,
            'html' => json_encode(view('admin.master.blueprints.page_2', compact('indexes'))->render()),
            'is_delete' => 0
        ];
        array_splice( $pages, 1, 0, [$index]);

        ksort($pages);

        $i = 1;
        foreach ($pages AS $k => $page) {
            if ($page['is_delete'] == 1) {
                continue;
            }
            $pages[$k]['sort_order'] = $i++;
        }

        return [$pages, $history];

    }

    private function prepare_pages($request, $masterCopy = NULL)
    {
        $pages = $index = $history = [];

        $old_pages = [];
        if ($masterCopy) {
            $old_pages = $masterCopy->pages->keyBy('id')->toArray();
        }


        foreach ($request->sort_order AS $k => $sort_order) {

            if ($k == 0) {
                continue;
            }

            // prepare history
            if ($request->page[$k] == 0) {
                $history[]['page_' . $sort_order]['status'] = 'created';
            } else if ($request->is_delete[$k] == 1) {
                $history[]['page_' . $sort_order]['status'] = 'deleted';
            } else {
                $changes = $this->change_version_master_copy([
                    'text' => json_decode($old_pages[$request->page[$k]]['text']),
                    'sort_order' => $k == 1 ? $k : $old_pages[$request->page[$k]]['sort_order'] + 1
                ], [
                    'text' => $request['content'][$k],
                    'sort_order' => $sort_order
                ]);

                if ($changes) {
                    $history[]['page_' . $sort_order] = [
                        'status' => 'updated',
                        'changes' => $changes
                    ];
                }
            }

            // prepare indexes
            $tags = ['h1', 'h2'];
            $lines = preg_split('/\r\n|\r|\n|<br>|<br \/>|<br\/>/', $request['content'][$k]);
            foreach ($lines AS $line) {
                foreach ($tags AS $tag) {
                    preg_match_all("/<$tag\b[^>]*>(.*?)<\/$tag>/", $line, $matches);
                    if (!empty (array_filter($matches))) {
                        $index[] = array_map(function($heading) use($tag, $sort_order) {
                            return array_merge([
                                'level' => $tag == 'h1' ? 1 : 2,
                                'text' => $this->format_title(ucwords(strtolower(trim($heading, ENT_QUOTES)))),
                                'page' => $sort_order
                        ]);
                        }, $matches[1]);
                    }
                }
            }

            // prepare pages
            $pages[$k] = [
                'page_id' => $request->page[$k],
                'is_delete' => $request->is_delete[$k],
            ];

            if (!$request->is_delete[$k]) {
                $pages[$k] = $pages[$k] + [
                    'sort_order' => $sort_order,
                    'blueprint_id' => $request['blueprint_id'][$k],
                    'text' => json_encode($request['content'][$k]),
                    'html' => json_encode($this->replace_variables($request['blueprint_id'][$k], $request['content'][$k])),
                ];
            }

        }

        $indexes = [];
        $previous_level = 1;
        foreach(call_user_func_array('array_merge',$index) AS $k => $index) {
            if ($previous_level === 2 && $index['level'] === 1) {
                $indexes[] = [];
            }
            $indexes[] = $index;
            $previous_level = $index['level'];
        }

        ksort($pages);

        return [$pages, $indexes, $history];
    }

    function format_title($title) {

        $cap = true;
        $text='';
        for ($x = 0; $x < strlen($title); $x++) {
            $letter = substr($title, $x, 1);
            if ($letter == "." || $letter == "!" || $letter == "?" || $letter == "(") {
                $cap = true;
            } elseif ($letter != " " && $cap == true) {
                $letter = strtoupper($letter);
                $cap = false;
            }
            $text .= $letter;
        }
        return str_replace('Avv', 'AVV', $text);
    }

    private function update_content($request, $masterCopy, $pages)
    {
        $new_pages = array_filter($pages, function ($page) {
            return ($page['page_id'] == 0);
        });

        $existing_pages = collect(array_diff_key($pages, $new_pages))->keyBy('page_id')->toArray();
        $index_page = $existing_pages[2];
        unset($existing_pages[2]);
        $existing_pages[array_keys($existing_pages)[0] + 1] = $index_page;

        // update master
        $masterCopy->update([
            'is_active' => $request->is_active ?? 1,
            'name' => $request->name
        ]);

        // update existing pages
        foreach ($masterCopy->pages AS $page) {

            if ($existing_pages[$page->id]['is_delete'] == 1) {
                $page->delete();
            } else {
                $page->update($existing_pages[$page->id]);
            }
        }

        // create newly added pages
        $masterCopy->pages()->createMany($new_pages);
    }

}
