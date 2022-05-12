<h4 class="float-right mt-1 mb-0"><b>{{ $title }}</b></h4>
<button type="button" class="btn btn-sm btn-danger btn-drawer-md-close"><em class="icon ni ni-cross-sm"></em></button>
<button type="button" class="btn btn-sm btn-light btn-refresh-global-entity" data-target="{{ $target }}"><em class="icon ni ni-reload-alt"></em></button>
<div class="clearfix"></div>
<hr>
<div class="drawer-container-title">
    <b>Existing {{ $title }}</b>
    <a class="btn btn-sm btn-success d-inline-block ml-1 btn-add-global-entity text-white" data-entity="{{ $entity }}" style="height: 30px"><em class="icon ni ni-plus-sm"></em></a>
</div>
<table class="table table-bordered table-sm mb-4 table-global-entity vl-middle mb-5">
    <thead>
    <tr>
        <th class="text-center" style="width: 65px">Status</th>
        <th style="width: 300px">Make</th>
        <th>Name</th>
        <th class="text-center" style="width: 65px">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data AS $value)
        <tr>
            <td class="align-middle text-center">
                <span class="badge badge-status badge-{{ $value->status['color'] }}">{{ $value->status['text'] }}</span>
                <input type="hidden" name="is_active" value="{{ $value->is_active }}" />
            </td>
            <td class="align-middle">{{ $value->make->name }}</td>
            <td class="align-middle">{{ $value->name }}</td>
            <td>
                <div class="text-center text-nowrap">
                    <a class="btn btn-sm btn-outline-secondary btn-edit-global-entity" data-entity="{{ $entity }}" data-id="{{ $value->id }}" data-make-id="{{ $value->make->id }}"><em class="icon ni ni-edit-alt"></em></a>
                    <a class="btn btn-sm btn-outline-danger btn-delete-global-entity" data-target="{{ $target }}" data-id="{{ $value->id }}"><em class="icon ni ni-trash"></em></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="card border mb-5" style="display: none">
    <div class="card-header"></div>
    <div class="card-body px-3 pt-4 pb-2">
        <form class="ajax manage-global-entity" method="post" data-target="admin/catalog/{{ $target }}" data-callback="callback_manage_global_entity">
            @csrf
            <fieldset>
                <div class="form-group mb-4">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="custom-switch-active-model" name="is_active" checked="checked" value="1">
                        <label class="custom-control-label" for="custom-switch-active-model">Active</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label required">Make</label>
                    <div class="form-control-wrap">
                        <select class="form-select" required name="make_id" style="width: 400px">
                            <option ></option>
                            @foreach($makes AS $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <div class="feedback"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label required">Name</label>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" name="name" id="input-entity" placeholder="Name" autocomplete="off" required style="width: 400px" />
                        <div class="feedback"></div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="reset" class="btn btn-sm btn-secondary" style="width: 120px">Reset</button>
                    <button type="submit" class="btn btn-sm btn-primary" style="width: 120px">Save</button>
                    <input type="hidden" name="_method" value="">
                </div>
            </fieldset>
        </form>
    </div>
</div>
