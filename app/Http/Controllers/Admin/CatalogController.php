<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adr;
use App\Models\VehicleMake;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class CatalogController extends Controller
{
    use CommonTrait;
    private $category = '';
    private $module = '';
    private $model = '';

    public function __construct(Request $request)
    {
        $this->ajax_verify($request);
        foreach ($request->route()->parameters() AS $key => $value) {
            $this->$key = $value;
        }
        $this->target = $this->category . '/' . $this->module;
        $this->model = 'App\\Models\\' . ucfirst($this->category) . ucfirst(Str::camel($this->module));

    }

    public function index()
    {
        $title = ucfirst($this->category) . ' ' . ucwords(str_replace('-', ' ', Str::plural($this->module)));
        $entity = $this->category . '-' . $this->module;
        $target = $this->target;

        if ($entity === 'adr-mod') {
            $data = $this->model::orderBy('adr_number')->get()->sortByDesc('is_active');
            $html = view('admin.catalog.adr_mods', compact(['entity', 'target', 'title', 'data']))->render();
        } else {
            $data = $this->model::orderBy('name')->get()->sortByDesc('is_active');
            if ($entity === 'vehicle-model') {
                $makes = VehicleMake::all()->pluck('name', 'id');
                $html = view('admin.catalog.vehicle_model', compact(['entity', 'target', 'title', 'data', 'makes']))->render();
            } else {
                $drawer_size = $entity === 'vehicle-recall-check-link' ? 'md' : 'sm';
                $html = view('admin.catalog.common', compact(['entity', 'target', 'title', 'drawer_size', 'data']))->render();
            }
        }

        return $this->ajax_msg('success', '', $html);
    }

    public function store(Request $request)
    {
        $rules = [];
        if ($request->segment(3) === 'vehicle' && $request->segment(4) === 'model') {
            $rules = [
                'make_id' => ['required'],
                'name' => ['required', 'string', 'max:150', Rule::unique('vehicle_models')->where(function ($query) use ($request) {
                    return $query->where('make_id', $request->input('make_id'))
                        ->where('name', $request->input('name'))->whereNull('deleted_at');
                })]
            ];
        } else if ($request->segment(3) === 'adr' && $request->segment(4) === 'mod') {
            $rules = [
                'description' => ['required', 'string', 'max:400'],
                'adr_number' => ['required', 'max:150', 'unique:'. $request->segment(3) .'_'. str_replace('-', '_', Str::plural($request->segment(4))) .',adr_number,NULL,id,deleted_at,NULL'],
            ];
        } else {
            $rules = ['name' => 'required|string|max:'. ($request->segment(4) === 'recall-check-link' ? '1850' : '150') .'|unique:'. $request->segment(3) .'_'. str_replace('-', '_', Str::plural($request->segment(4))) .',name,NULL,id,deleted_at,NULL'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        if (! $request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        }

        try {
            $this->model::create($request->all());
        } catch (\Exception $e) {
            return report($e);
        }

        return $this->ajax_msg('success', '', $this->target);
    }

    public function update(Request $request)
    {
        $model = $this->model::findOrFail($this->id);

        $rules = [];
        if ($request->segment(3) === 'vehicle' && $request->segment(4) === 'model') {
            $rules = [
                'make_id' => ['required'],
                'name' => ['required', 'max:150', Rule::unique('vehicle_models')->where(function ($query) use ($request, $model) {
                    return $query->where([
                        'make_id' => $request->make_id,
                        'name' => $request->name
                    ])->where('id', '!=', $this->id);
                })]
            ];
        } else if ($request->segment(3) === 'adr' && $request->segment(4) === 'mod') {
            $rules = [
                'description' => ['required', 'string', 'max:400'],
                'adr_number' => ['required', 'max:150', 'unique:'. $request->segment(3) .'_'. str_replace('-', '_', Str::plural($request->segment(4))) .',adr_number,' . $this->id . ',id,deleted_at,NULL']
            ];
        } else {
            $rules = ['name' => 'required|max:'. ($request->segment(4) === 'recall-check-link' ? '1850' : '150') .'|unique:'. $request->segment(3) .'_'. str_replace('-', '_', Str::plural($request->segment(4))) .',name,' . $this->id. ',id,deleted_at,NULL'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        if (! $request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        }

        try {
            $model->update($request->all());
        } catch (\Exception $e) {
            return report($e);
        }

        return $this->ajax_msg('success', '', $this->target);
    }

    public function destroy()
    {
        $model = $this->model::findOrFail($this->id);
        try {
            $model->delete();
        } catch (\Exception $e) {
            return report($e);
        }

        return $this->ajax_msg('success', '', '', true);
    }
}
