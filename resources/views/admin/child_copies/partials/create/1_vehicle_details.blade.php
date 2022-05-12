<div class="row gx-5">
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4 pb-1">
            @if ($prefix === 'post')
            <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[sev_no]" value="1" {{ in_array('sev_no', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-input-sev-entry-no">
                <label class="custom-control-label" for="{{ $prefix }}-input-sev-entry-no"></label>
            </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-input-sev-entry-no">SEV Entry No</label>
            <div class="form-control-wrap">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">SEV</span>
                    </div>
                    <input type="text" class="form-control" id="{{ $prefix }}-input-sev-entry-no" name="{{ $key }}[vehicle][sev_no]" value="{{ $childCopy->data['vehicle']['sev_no'] ?? '' }}" maxlength="150" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4 pb-1">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[vin_location]" value="1" {{ in_array('vin_location', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-select-vin-location-selectized">
                    <label class="custom-control-label" for="{{ $prefix }}-select-vin-location"></label>
                </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-select-vin-location">VIN Location</label>
            <div class="form-control-wrap">
                <select class="form-control selectize w-100" name="{{ $key }}[vehicle][vin_location]" id="{{ $prefix }}-select-vin-location">
                    <option></option>
                    @foreach ($vin_locations AS $location)
                        <option value="{{ $location }}" {{ isset($childCopy->data['vehicle']['vin_location']) && $childCopy->data['vehicle']['vin_location'] == $location ? 'selected=selected' : '' }}>{{ $location }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4 pb-1">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[make]" value="1" {{ in_array('make', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-select-make-selectized">
                    <label class="custom-control-label" for="{{ $prefix }}-select-make"></label>
                </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-select-make">Make</label>
            <div class="form-control-wrap">
                <select class="form-control selectize w-100 vehicle-make" name="{{ $key }}[vehicle][make]" id="{{ $prefix }}-select-make">
                    <option></option>
                    @foreach ($makes AS $make)
                        <option value="{{ $make }}" {{ isset($childCopy->make) && $childCopy->make == $make ? 'selected=selected' : '' }}>{{ $make }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row gx-5">
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4 pb-1">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[model]" value="1" {{ in_array('model', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-select-model-selectized">
                    <label class="custom-control-label" for="{{ $prefix }}-select-model"></label>
                </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-select-model">Model</label>
            <div class="form-control-wrap">
                <select class="form-control selectize vehicle-model w-100" name="{{ $key }}[vehicle][model]" id="{{ $prefix }}-select-model">
                    <option value="{{ $childCopy->model ?? '' }}" {{ isset($childCopy->model) ? 'selected=selected' : '' }}>{{ $childCopy->model ?? '' }}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4 pb-1">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[model_code]" value="1" {{ in_array('model_code', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-select-model-code">
                    <label class="custom-control-label" for="{{ $prefix }}-select-model-code"></label>
                </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-select-model-code">Model Code</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control w-100" id="{{ $prefix }}-select-model-code" name="{{ $key }}[vehicle][model_code]" value="{{ $childCopy->data['vehicle']['model_code'] ?? '' }}" maxlength="150" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4 pb-1">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[category]" value="1" {{ in_array('category', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-select-category-selectized">
                    <label class="custom-control-label" for="{{ $prefix }}-select-category"></label>
                </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-select-category">Category</label>
            <div class="form-control-wrap">
                <select class="form-control selectize w-100" name="{{ $key }}[vehicle][category]" id="{{ $prefix }}-select-category">
                    <option></option>
                    @foreach ($categories AS $category)
                        <option value="{{ $category }}" {{ isset($childCopy->data['vehicle']['category']) && $childCopy->data['vehicle']['category'] == $category ? 'selected=selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4 pb-1">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[body_type]" value="1" {{ in_array('body_type', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-select-body-type-selectized">
                    <label class="custom-control-label" for="{{ $prefix }}-select-body-type"></label>
                </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-select-body-type">Body Shape</label>
            <div class="form-control-wrap">
                <select class="form-control selectize w-100" name="{{ $key }}[vehicle][body_type]" id="{{ $prefix }}-select-body-type">
                    <option></option>
                    @foreach ($body_types AS $body_type)
                        <option value="{{ $body_type }}" {{ isset($childCopy->data['vehicle']['body_type']) && $childCopy->data['vehicle']['body_type'] == $body_type ? 'selected=selected' : '' }}>{{ $body_type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4 pb-1">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[build_range]" value="1" {{ in_array('build_range', $visible_columns) ? 'checked=checked' : '' }}  id="{{ $prefix }}-input-build-date-starts">
                    <label class="custom-control-label" for="{{ $prefix }}-input-build-date-starts"></label>
                </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-input-build-date-starts">Build Date Range</label>
            <div class="form-control-wrap">
                <div class="d-flex">
                    <div>
                        <div class="input-group input-group-date-picker" style="width: 200px">
                            <input type="text" class="form-control year-month-picker" name="{{ $key }}[vehicle][build_range_starts]" value="{{ $childCopy->data['vehicle']['build_range_starts'] ?? '' }}" id="{{ $prefix }}-input-build-date-starts" aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                                <span class="input-group-text">
                                    <span class="input-group-addon p-0" id="{{ $prefix }}-img-addon">
                                           <em class="icon ni ni-calendar-check fs-18px"></em>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="input-group input-group-date-picker" style="width: 200px">
                            <input type="text" class="form-control year-month-picker skip" placeholder="Optional" name="{{ $key }}[vehicle][build_range_ends]" value="{{ $childCopy->data['vehicle']['build_range_ends'] ?? '' }}" aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                                <span class="input-group-text">
                                    <span class="input-group-addon p-0" id="{{ $prefix }}-img-addon">
                                       <em class="icon ni ni-calendar-check fs-18px"></em>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-1"><small class="text-muted">Keep the end date empty, if the vehicle is still in production.</small></div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4 {{ $prefix === 'post' ? 'mt-1 pb-2' : 'pb-1' }}">
            <label class="form-label required" for="{{ $prefix }}-input-build-date">Build Date</label>
            <div class="form-control-wrap">
                <div class="input-group input-group-date-picker" id="{{ $prefix }}-input-group-date-build-date" style="width: 200px">
                    <input type="text" class="form-control year-month-picker" name="{{ $key }}[vehicle][build_date]" value="{{ $childCopy->data['vehicle']['build_date'] ?? ''}}" id="{{ $prefix }}-input-build-date" aria-describedby="img-addon" autocomplete="off"/>
                    <div class="input-group-append" style="height: 36px">
                        <span class="input-group-text">
                            <span class="input-group-addon p-0" id="{{ $prefix }}-img-addon">
                               <em class="icon ni ni-calendar-check fs-18px"></em>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group mb-4 pb-1">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[steering_location]" value="1" {{ in_array('steering_location', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-input-steering-location">
                    <label class="custom-control-label" for="{{ $prefix }}-input-steering-location"></label>
                </div>
            @endif
            <label class="form-label required" for="{{ $prefix }}-select-steering-location">Steering Location</label>
            <div class="form-control-wrap">
                <select class="form-control selectize w-100" name="{{ $key }}[vehicle][steering_location]" id="{{ $prefix }}-select-steering-location">
                    <option></option>
                    @foreach ($steering_locations AS $location)
                        <option value="{{ $location }}" {{ isset($childCopy->data['vehicle']['steering_location']) && $childCopy->data['vehicle']['steering_location'] == $location ? 'selected=selected' : '' }}>{{ $location }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-4 pb-1">
    @if ($prefix === 'post')
        <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
            <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[mass]" value="1" {{ in_array('mass', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-input-mass">
            <label class="custom-control-label" for="{{ $prefix }}-input-mass"></label>
        </div>
    @endif
    <label class="form-label required" for="{{ $prefix }}-input-mass">Unladen Mass (Tare + Fuel)</label>
    <div class="form-control-wrap">
        <input type="text" class="form-control" id="{{ $prefix }}-input-mass" name="{{ $key }}[vehicle][mass]" value="{{ $childCopy->data['vehicle']['mass'] ?? ''}}" maxlength="150" autocomplete="off">
    </div>
</div>
@if ($prefix !== 'post')
<div class="form-group mb-4 pb-1">
    <label class="form-label required" for="{{ $prefix }}-select-recall-check-link">Vehicle Recall Check Link</label>
    <div class="form-control-wrap">
        <select class="form-control selectize w-100" name="{{ $key }}[vehicle][check_link]" id="{{ $prefix }}-select-recall-check-link">
            <option></option>
            @foreach ($check_links AS $link)
                <option value="{{ $link }}" {{ isset($childCopy->data['vehicle']['check_link']) && $childCopy->data['vehicle']['check_link'] == $link ? 'selected=selected' : '' }}>{{ $link }}</option>
            @endforeach
        </select>
    </div>
</div>
@endif
<div class="content-separator my-5" style="font-size: 1rem">
    <span class="px-3">VARIANTS</span>
</div>
<div class="row">
    <div class="col-5">
        @if ($prefix === 'post')
            <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[doors]" value="1" {{ in_array('doors', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-hading-doors-side">
                <label class="custom-control-label" for="{{ $prefix }}-hading-doors-side"></label>
            </div>
        @endif
        <label class="d-inline-block fw-bold fs-7 mb-4 pb-3" for="{{ $prefix }}-hading-doors-side">DOORS</label>
        <div class="d-flex">
            <div class="form-group mr-3">
                <label class="required mb-1" for="{{ $prefix }}-select-doors-side">Side</label>
                <div class="form-control-wrap">
                    <select class="form-control selectize" name="{{ $key }}[vehicle][doors][side]" id="{{ $prefix }}-select-doors-side" style="width: 175px">
                        @if (isset($childCopy->data['vehicle']['doors']['side']))
                            <option value="{{ $childCopy->data['vehicle']['doors']['side'] }}">{{ $childCopy->data['vehicle']['doors']['side'] }}</option>
                        @else
                            <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="required mb-1" for="{{ $prefix }}-select-doors-rear">Rear / Hatch</label>
                <div class="form-control-wrap">
                    <select class="form-control selectize" name="{{ $key }}[vehicle][doors][rear]" id="{{ $prefix }}-select-doors-rear" style="width: 175px">
                        @if (isset($childCopy->data['vehicle']['doors']['rear']))
                            <option value="{{ $childCopy->data['vehicle']['doors']['rear'] }}">{{ $childCopy->data['vehicle']['doors']['rear'] }}</option>
                        @else
                            <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-7">
        <div class="form-group mb-4 pb-1">
            @if ($prefix === 'post')
                <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[seats]" value="1" {{ in_array('seats', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-table-seats">
                    <label class="custom-control-label" for="{{ $prefix }}-table-seats"></label>
                </div>
            @endif
            <label class="d-inline-block fw-bold fs-7 mb-2 pb-1" for="{{ $prefix }}-table-seats">SEATS</label>
            <table class="table table-sm table-bordered mt-2" style="width: initial">
                <thead>
                <tr>
                    <th class="align-middle" style="width: 100px">Rows</th>
                    <th class="text-center align-middle" style="width: 80px">1</th>
                    <th class="text-center align-middle" style="width: 80px">2</th>
                    <th class="text-center align-middle" style="width: 80px">3</th>
                    <th class="text-center align-middle" style="width: 80px">4</th>
                    <th class="text-center align-middle" style="width: 80px">5</th>
                    <th class="text-center align-middle" style="width: 80px">6</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="align-middle bg-light-grey">Seats</td>
                    <td><input type="text" class="form-control form-control-sm unsigned-integer border-bottom-dashed text-center w-100" name="{{ $key }}[vehicle][seats][1]" value="{{ $childCopy->data['vehicle']['seats'][1] ?? '2'}}" /></td>
                    <td><input type="text" class="form-control form-control-sm unsigned-integer border-bottom-dashed text-center w-100" name="{{ $key }}[vehicle][seats][2]" value="{{ $childCopy->data['vehicle']['seats'][2] ?? '0'}}" /></td>
                    <td><input type="text" class="form-control form-control-sm unsigned-integer border-bottom-dashed text-center w-100" name="{{ $key }}[vehicle][seats][3]" value="{{ $childCopy->data['vehicle']['seats'][3] ?? '0'}}" /></td>
                    <td><input type="text" class="form-control form-control-sm unsigned-integer border-bottom-dashed text-center w-100" name="{{ $key }}[vehicle][seats][4]" value="{{ $childCopy->data['vehicle']['seats'][4] ?? '0'}}" /></td>
                    <td><input type="text" class="form-control form-control-sm unsigned-integer border-bottom-dashed text-center w-100" name="{{ $key }}[vehicle][seats][5]" value="{{ $childCopy->data['vehicle']['seats'][5] ?? '0'}}" /></td>
                    <td><input type="text" class="form-control form-control-sm unsigned-integer border-bottom-dashed text-center w-100" name="{{ $key }}[vehicle][seats][6]" value="{{ $childCopy->data['vehicle']['seats'][6] ?? '0'}}" /></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-5">
        @if ($prefix === 'post')
            <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[tyres]" value="1" {{ in_array('tyres', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-heading-tyres">
                <label class="custom-control-label" for="{{ $prefix }}-heading-tyres"></label>
            </div>
        @endif
        <label class="d-inline-block fw-bold fs-7 pb-3" for="{{ $prefix }}-heading-tyres">TYRES</label>
        <div class="form-group mb-4">
            <label class="required mb-1" for="{{ $prefix }}-input-type-code">Code</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="{{ $prefix }}-input-type-code" name="{{ $key }}[vehicle][tyre_code]" value="{{ $childCopy->data['vehicle']['tyre_code'] ?? ''}}" style="width: 370px" maxlength="150" autocomplete="off">
            </div>
        </div>
        <div>
            <label class="required" for="{{ $prefix }}-input-tyre-pressure-front">Inflation Pressures (kPa)</label>
            <div class="d-flex">
                <div class="form-group mr-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="height: 40px">
                            <span class="input-group-text">Front</span>
                        </div>
                        <span class="border p-1" style="width:115px">
                            <input type="text" class="form-control form-control-sm unsigned-integer w-75 mx-auto text-right border-bottom-dashed" value="{{ $childCopy->data['vehicle']['tyre_pressure']['front'] ?? ''}}" name="{{ $key }}[vehicle][tyre_pressure][front]" id="{{ $prefix }}-input-tyre-pressure-front" maxlength="150" autocomplete="off" style="height: 24px"/>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend" style="height: 40px">
                            <span class="input-group-text" id="{{ $prefix }}-basic-addon1">Rear</span>
                        </div>
                        <span class="border p-1" style="width:115px">
                            <input type="text" class="form-control form-control-sm unsigned-integer w-75 mx-auto text-right border-bottom-dashed" name="{{ $key }}[vehicle][tyre_pressure][rear]" value="{{ $childCopy->data['vehicle']['tyre_pressure']['rear'] ?? ''}}" maxlength="150" autocomplete="off" style="height: 24px" />
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-7">
        @if ($prefix === 'post')
            <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
                <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[rims]" value="1" {{ in_array('rims', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-heading-rims">
                <label class="custom-control-label" for="{{ $prefix }}-checkbox-measurement-under-bonnet"></label>
            </div>
        @endif
        <label class="d-inline-block fw-bold fs-7 pb-3" for="{{ $prefix }}-heading-rims">RIMS</label>
        <div class="d-flex">
            <div class="form-group mr-3">
                <label class="required mb-1" for="{{ $prefix }}-input-rim-size">Size & Profile</label>
                <input type="text" class="form-control" id="{{ $prefix }}-input-rim-size" name="{{ $key }}[vehicle][rim_size]" value="{{ $childCopy->data['vehicle']['rim_size'] ?? ''}}" maxlength="150" autocomplete="off" style="width: 230px">
                <div class="feedback"></div>
            </div>
            <div class="form-group">
                <label class="required mb-1" for="{{ $prefix }}-input-rim-offset">Offset (mm)</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">+</span>
                    </div>
                    <input type="text" class="form-control" id="{{ $prefix }}-input-rim-offset"  name="{{ $key }}[vehicle][rim_offset]" value="{{ $childCopy->data['vehicle']['rim_offset'] ?? ''}}" autocomplete="off" style="width: 100px">
                </div>
                <div class="feedback"></div>
            </div>
        </div>
    </div>
</div>
<div>
    @if ($prefix === 'post')
        <div class="custom-control pt-1 mb-1 custom-control-xs custom-checkbox">
            <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[dimensions]" value="1" {{ in_array('dimensions', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-heading-dimensions">
            <label class="custom-control-label" for="{{ $prefix }}-checkbox-measurement-under-bonnet"></label>
        </div>
    @endif
    <label class="d-inline-block fw-bold fs-7 mt-4 mb-3 pb-2 required" for="{{ $prefix }}-heading-dimensions">DIMENSIONS (mm)</label>
</div>
<div class="form-group pb-5">
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th class="text-center">OAL</th>
            <th class="text-center">OAW</th>
            <th class="text-center">OAH</th>
            <th class="text-center">WB</th>
            <th class="text-center">ROH</th>
            <th class="text-center">Running Clearance</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="{{ $key }}[vehicle][dimensions][OAL]" value="{{ $childCopy->data['vehicle']['dimensions']['OAL'] ?? ''}}" autocomplete="off" style="width: 80px"/></td>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="{{ $key }}[vehicle][dimensions][OAW]" value="{{ $childCopy->data['vehicle']['dimensions']['OAW'] ?? ''}}" autocomplete="off" style="width: 80px"/></td>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="{{ $key }}[vehicle][dimensions][OAH]" value="{{ $childCopy->data['vehicle']['dimensions']['OAH'] ?? ''}}" autocomplete="off" style="width: 80px"/></td>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="{{ $key }}[vehicle][dimensions][WB]" value="{{ $childCopy->data['vehicle']['dimensions']['WB'] ?? ''}}" autocomplete="off" style="width: 80px"/></td>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="{{ $key }}[vehicle][dimensions][ROH]" value="{{ $childCopy->data['vehicle']['dimensions']['ROH'] ?? ''}}" autocomplete="off" style="width: 80px"/></td>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="{{ $key }}[vehicle][dimensions][GC]" value="{{ $childCopy->data['vehicle']['dimensions']['GC'] ?? ''}}" autocomplete="off" style="width: 80px"/></td>
        </tr>
        </tbody>
    </table>
</div>

<script>
    $(function() {
        $('.year-month-picker').each(function() {
            activateYearMonthPicker($(this).closest('div.input-group'))
        })
    })
</script>
