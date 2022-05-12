<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[engine]" value="1" {{ in_array('engine', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-input-engine-model">
                    <label class="custom-control-label" for="{{ $prefix }}-input-engine-model"></label>
                </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-input-engine-model">Model</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" name="{{ $key }}[engine][model]" value="{{ $childCopy->data['engine']['model'] ?? ''}}" id="{{ $prefix }}-input-engine-model" maxlength="150" autocomplete="off">
            </div>
        </div>
    </div>
</div>
<div class="row gx-5">
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4">
            <label class="form-label required" for="{{ $prefix }}-select-capacity">Capacity</label>
            <div class="form-control-wrap">
                <div class="input-group">
                    <select class="form-control selectize" name="{{ $key }}[engine][capacity]" id="{{ $prefix }}-select-capacity">
                        <option></option>
                        @foreach ($engine_capacity AS $capacity)
                            <option {{ isset($childCopy->data['engine']['capacity']) && $childCopy->data['engine']['capacity'] == $capacity ? 'selected=selected' : '' }}>{{ $capacity }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append" style="height: 34px">
                        <span class="input-group-text">CC</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4">
            <label class="form-label required" for="{{ $prefix }}-select-configuration">Configuration</label>
            <div class="form-control-wrap">
                <div class="input-group">
                    <select class="form-control selectize w-100" name="{{ $key }}[engine][config]" id="{{ $prefix }}-select-configuration">
                        <option></option>
                        @foreach ($engine_configs AS $config)
                            <option {{ isset($childCopy->data['engine']['config']) && $childCopy->data['engine']['config'] == $config ? 'selected=selected' : '' }}>{{ $config }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4">
            <label class="form-label required" for="{{ $prefix }}-select-motive-power">Motive Power</label>
            <div class="form-control-wrap">
                <select class="form-control selectize" name="{{ $key }}[engine][motive_power]" id="{{ $prefix }}-select-motive-power">
                    <option></option>
                    @foreach ($motive_power AS $power)
                        <option {{ isset($childCopy->data['engine']['motive_power']) && $childCopy->data['engine']['motive_power'] == $power ? 'selected=selected' : '' }}>{{ $power }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4">
            <label class="form-label required" for="{{ $prefix }}-select-induction-type">Induction Type</label>
            <div class="form-control-wrap">
                <select class="form-control selectize w-100" name="{{ $key }}[engine][induction_type]" id="{{ $prefix }}-select-induction-type" style="width: 200px">
                    <option></option>
                    @foreach ($induction_types AS $type)
                        <option {{ isset($childCopy->data['engine']['induction_type']) && $childCopy->data['engine']['induction_type'] == $type ? 'selected=selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="content-separator my-5" style="font-size: 1rem"><span class="px-3">TRANSMISSION</span></div>
<div class="row gx-5">
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[transmission]" value="1" {{ in_array('transmission', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-select-transmission-model-selectized">
                    <label class="custom-control-label" for="{{ $prefix }}-select-transmission-model"></label>
                </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-select-transmission-model">Model</label>
            <div class="form-control-wrap">
                <select class="form-control selectize w-100" name="{{ $key }}[transmission][model]" id="{{ $prefix }}-select-transmission-model" style="width: 200px">
                    <option></option>
                    @foreach ($transmission_models AS $type)
                        <option {{ isset($childCopy->data['transmission']['model']) && $childCopy->data['transmission']['model'] == $type ? 'selected=selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4">
            <label class="form-label required" for="{{ $prefix }}-radio-transmission-type-manual">Type</label>
            <div class="form-control-wrap radio-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="{{ $key }}[transmission][type]" {{ isset($childCopy->data['transmission']['type']) && $childCopy->data['transmission']['type'] == 'Manual' ? 'checked=checked' : '' }} id="{{ $prefix }}-radio-transmission-type-manual" value="Manual">
                    <label class="form-check-label" for="{{ $prefix }}-radio-transmission-type-manual">Manual</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="{{ $key }}[transmission][type]" {{ isset($childCopy->data['transmission']['type']) && $childCopy->data['transmission']['type'] == 'Automatic' ? 'checked=checked' : '' }} id="{{ $prefix }}-radio-transmission-type-auto" value="Automatic">
                    <label class="form-check-label" for="{{ $prefix }}-radio-transmission-type-auto">Automatic</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="{{ $key }}[transmission][type]" {{ isset($childCopy->data['transmission']['type']) && $childCopy->data['transmission']['type'] == 'CVT' ? 'checked=checked' : '' }} id="{{ $prefix }}-radio-transmission-type-cvt" value="CVT">
                    <label class="form-check-label" for="{{ $prefix }}-radio-transmission-type-cvt">CVT</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4">
            <label class="form-label required" for="{{ $prefix }}-select-drive-train-configs">Drive Tran Configuration</label>
            <div class="form-control-wrap">
                <select class="form-control selectize w-100" name="{{ $key }}[transmission][drive_train_config]" id="{{ $prefix }}-select-drive-train-configs" style="width: 200px">
                    <option></option>
                    @foreach ($transmission_configs AS $config)
                        <option {{ isset($childCopy->data['transmission']['drive_train_config']) && $childCopy->data['transmission']['drive_train_config'] == $config ? 'selected=selected' : '' }}>{{ $config }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
