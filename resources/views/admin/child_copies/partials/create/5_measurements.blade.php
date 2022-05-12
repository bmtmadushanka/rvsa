<!-- Under Bonnet -->
<div class="font-weight-bold" style="font-size: 15px">
    <div class="form-group pt-3 pb-1">
        <div class="custom-control custom-control-xs custom-checkbox">
            <input type="checkbox" class="custom-control-input checkbox-measurement" name="dimensions[under_bonnet]" value="13" {{ isset($childCopy->data['measurements']['under_bonnet']) ? 'checked: checked' : '' }} id="checkbox-measurement-under-bonnet">
            <label class="custom-control-label" for="checkbox-measurement-under-bonnet"><strong>UNDER BONNET</strong></label>
        </div>
    </div>
    <div id="wrapper-dimensions" style="display: {{ isset($childCopy->data['dimensions']['ub']) ? 'block' : 'none' }}">
        <div class="form-group mb-0" style="top: -52px; left: 250px">
            <div class="form-control-wrap fw-normal mt-2">
                <div class="form-check form-check-inline mr-4">
                    <input class="form-check-input skip" type="radio" name="dimensions[ub]" id="radio-measurement-type-a-b" value="A-B" {{ isset($childCopy->data['dimensions']['ub']) && $childCopy->data['dimensions']['ub'] == 'A-B' ? 'checked=checked' : ''}}>
                    <label class="form-check-label" for="radio-measurement-type-a-b">Dimensions A & B</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input skip" type="radio" name="dimensions[ub]" id="radio-measurement-type-ab" value="AB" {{ isset($childCopy->data['dimensions']['ub']) && $childCopy->data['dimensions']['ub'] == 'AB' ? 'checked=checked' : ''}}>
                    <label class="form-check-label" for="radio-measurement-type-ab">Dimensions A / Dimensions B</label>
                </div>
            </div>
        </div>
        <div id="wrapper-dimensions-a-b" style="display: {{ isset($childCopy->data['measurements']['under_bonnet']['A-B']) ? 'block' : 'none' }}">
            <label class="ml-3 mb-0">DIMENSIONS A & B</label>
            <hr />
            <table class="table table-borderless mb-5" style="width: 100%">
                <thead>
                <tr style="background: transparent">
                    <th>Heading</th>
                    <th colspan="2">Image</th>
                    <th>Description</th>
                    <th class="text-nowrap">Sort Order</th>
                </tr>
                </thead>
                <tbody>
                @for ($i = 1; $i <=4; $i++)
                    <tr>
                        <td class="align-middle" style="width: 250px">
                            <input type="text" class="form-control skip" name="measurements[under_bonnet][A-B][heading][]" value="{{ $childCopy->data['measurements']['under_bonnet']['A-B'][$i-1]['heading'] ?? 'Dimensions A & B' }}" maxlength="25" />
                        </td>
                        <td class="align-middle text-center">
                            @if (!empty($childCopy->data['measurements']['under_bonnet']['A-B'][$i-1]['image']))
                                <img src="{{ config('app.asset_url') }}images/child/{{$childCopy->id}}/measurements/under_bonnet/{{ $childCopy->data['measurements']['under_bonnet']['A-B'][$i-1]['image'] }}?t={{ time() }}" style="width: 100px" />
                                <button class="btn btn-xs btn-secondary mt-1 btn-edit-image">Edit</button>
                            @else
                                <img src="{{ config('app.url') }}/images/image_placeholder.png" style="width: 100px" />
                            @endif
                        </td>
                        <td class="align-middle" style="width: 200px;">
                            <input type="file" class="skip image" name="measurements[under_bonnet][A-B][image][]" accept="image/*">
                        </td>
                        <td style="width: 350px">
                            <textarea class="form-control skip" name="measurements[under_bonnet][A-B][description][]" rows="3">{{ $childCopy->data['measurements']['under_bonnet']['A-B'][$i-1]['description'] ?? '' }}</textarea>
                        </td>
                        <td class="align-middle">
                            <input type="text" class="form-control text-right" name="measurements[under_bonnet][A-B][sort_order][]" value="{{ $childCopy->data['measurements']['under_bonnet']['A-B'][$i-1]['sort_order'] ?? $i }}" style="width: 65px" />
                            <input type="hidden" name="measurements[under_bonnet][A-B][id][]" value="{{ $childCopy->data['measurements']['under_bonnet'][$i-1]['id'] ?? $i }}"/>
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
        <div id="wrapper-dimensions-ab" style="display: {{ isset($childCopy->data['measurements']['under_bonnet']['A']) || isset($childCopy->data['measurements']['under_bonnet']['B']) ? 'block' : 'none' }}">
            <label class="ml-3 mb-0">DIMENSIONS A</label>
            <hr />
            <table class="table table-borderless mb-5" style="width: 100%">
                <thead>
                <tr style="background: transparent">
                    <th>Heading</th>
                    <th colspan="2">Image</th>
                    <th>Description</th>
                    <th class="text-nowrap">Sort Order</th>
                </tr>
                </thead>
                <tbody>
                @for ($i = 1; $i <=4; $i++)
                    <tr>
                        <td class="align-middle" style="width: 250px">
                            <input type="text" class="form-control skip" name="measurements[under_bonnet][A][heading][]" value="{{ $childCopy->data['measurements']['under_bonnet']['A'][$i-1]['heading'] ?? 'Dimensions A' }}" maxlength="25" />
                        </td>
                        <td class="align-middle text-center">
                            @if (!empty($childCopy->data['measurements']['under_bonnet']['A'][$i-1]['image']))
                                <img src="{{ config('app.asset_url') }}images/child/{{$childCopy->id}}/measurements/under_bonnet/{{ $childCopy->data['measurements']['under_bonnet']['A'][$i-1]['image'] }}?t={{ time() }}" style="width: 100px" />
                                <button class="btn btn-xs btn-secondary mt-1 btn-edit-image">Edit</button>
                            @else
                                <img src="{{ config('app.url') }}/images/image_placeholder.png" style="width: 100px" />
                            @endif
                        </td>
                        <td class="align-middle" style="width: 200px;">
                            <input type="file" class="skip image" name="measurements[under_bonnet][A][image][]" accept="image/*">
                        </td>
                        <td style="width: 350px">
                            <textarea class="form-control skip" name="measurements[under_bonnet][A][description][]" rows="3">{{ $childCopy->data['measurements']['under_bonnet']['A'][$i-1]['description'] ?? '' }}</textarea>
                        </td>
                        <td class="align-middle">
                            <input type="text" class="form-control text-right" name="measurements[under_bonnet][A][sort_order][]" value="{{ $childCopy->data['measurements']['under_bonnet']['A'][$i-1]['sort_order'] ?? $i }}" style="width: 65px" />
                            <input type="hidden" name="measurements[under_bonnet][A][id][]" value="{{ $childCopy->data['measurements']['under_bonnet']['A'][$i-1]['id'] ?? $i }}"/>
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>

            <label class="ml-3 mb-0">DIMENSIONS B</label>
            <hr />
            <table class="table table-borderless mb-5" style="width: 100%">
                <thead>
                <tr style="background: transparent">
                    <th>Heading</th>
                    <th colspan="2">Image</th>
                    <th>Description</th>
                    <th class="text-nowrap">Sort Order</th>
                </tr>
                </thead>
                <tbody>
                @for ($i = 1; $i <=4; $i++)
                    <tr>
                        <td class="align-middle" style="width: 250px">
                            <input type="text" class="form-control skip" name="measurements[under_bonnet][B][heading][]" value="{{ $childCopy->data['measurements']['under_bonnet']['B'][$i-1]['heading'] ?? 'Dimensions B' }}" maxlength="25" />
                        </td>
                        <td class="align-middle text-center">
                            @if (!empty($childCopy->data['measurements']['under_bonnet']['B'][$i-1]['image']))
                                <img src="{{ config('app.asset_url') }}images/child/{{$childCopy->id}}/measurements/under_bonnet/{{ $childCopy->data['measurements']['under_bonnet']['B'][$i-1]['image'] }}?t={{ time() }}" style="width: 100px" />
                                <button class="btn btn-xs btn-secondary mt-1 btn-edit-image">Edit</button>
                            @else
                                <img src="{{ config('app.url') }}/images/image_placeholder.png" style="width: 100px" />
                            @endif
                        </td>
                        <td class="align-middle" style="width: 200px;">
                            <input type="file" class="skip image" name="measurements[under_bonnet][B][image][]" accept="image/*">
                        </td>
                        <td style="width: 350px">
                            <textarea class="form-control skip" name="measurements[under_bonnet][B][description][]" rows="3">{{ $childCopy->data['measurements']['under_bonnet']['B'][$i-1]['description'] ?? '' }}</textarea>
                        </td>
                        <td class="align-middle">
                            <input type="text" class="form-control text-right" name="measurements[under_bonnet][B][sort_order][]" value="{{ $childCopy->data['measurements']['under_bonnet']['B'][$i-1]['sort_order'] ?? $i }}" style="width: 65px" />
                            <input type="hidden" name="measurements[under_bonnet][B][id][]" value="{{ $childCopy->data['measurements']['under_bonnet']['B'][$i-1]['id'] ?? $i }}"/>
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr/>


<!-- Under Body Front -->
<div class="font-weight-bold" style="font-size: 15px">
    <div class="form-group py-1">
        <div class="custom-control custom-control-xs custom-checkbox">
            <input type="checkbox" class="custom-control-input checkbox-measurement" name="dimensions[under_body_front]" value="14" {{ isset($childCopy->data['measurements']['under_body_front']) ? 'checked: checked' : '' }} id="checkbox-measurement-under-body-front">
            <label class="custom-control-label" for="checkbox-measurement-under-body-front"><strong>UNDER BODY FRONT</strong></label>
        </div>
    </div>
    <table class="table table-borderless mb-5" style="width: 100%; display: {{ isset($childCopy->data['measurements']['under_body_front']) ? 'block' : 'none' }}">
        <thead>
        <tr style="background: transparent">
            <th>Heading</th>
            <th colspan="2">Image</th>
            <th>Description</th>
            <th class="text-nowrap">Sort Order</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 1; $i <=4; $i++)
            <tr>
                <td class="align-middle" style="width: 250px">
                    <input type="text" class="form-control skip" name="measurements[under_body_front][heading][]" value="{{ $childCopy->data['measurements']['under_body_front'][$i-1]['heading'] ?? 'Dimensions C & D' }}" maxlength="25" />
                </td>
                <td class="align-middle text-center">
                    @if (!empty($childCopy->data['measurements']['under_body_front'][$i-1]['image']))
                        <img src="{{ config('app.asset_url') }}images/child/{{$childCopy->id}}/measurements/under_body_front/{{ $childCopy->data['measurements']['under_body_front'][$i-1]['image'] }}?t={{ time() }}" style="width: 100px" />
                        <button class="btn btn-xs btn-secondary mt-1 btn-edit-image">Edit</button>
                    @else
                        <img src="{{ config('app.url') }}/images/image_placeholder.png" style="width: 100px" />
                    @endif
                </td>
                <td class="align-middle" style="width: 200px;">
                    <input type="file" class="skip image" name="measurements[under_body_front][image][]" accept="image/*">
                </td>
                <td style="width: 350px">
                    <textarea class="form-control skip" name="measurements[under_body_front][description][]" rows="3">{{ $childCopy->data['measurements']['under_body_front'][$i-1]['description'] ?? '' }}</textarea>
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-right" name="measurements[under_body_front][sort_order][]" value="{{ $childCopy->data['measurements']['under_body_front'][$i-1]['sort_order'] ?? $i }}" style="width: 65px" />
                    <input type="hidden" name="measurements[under_body_front][id][]" value="{{ $childCopy->data['measurements']['under_body_front'][$i-1]['id'] ?? $i }}"/>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
</div>
<hr/>

<!-- Under Body Rear -->
<div class="font-weight-bold" style="font-size: 15px">
    <div class="form-group py-1">
        <div class="custom-control custom-control-xs custom-checkbox">
            <input type="checkbox" class="custom-control-input checkbox-measurement" name="dimensions[under_body_rear]" value="15" {{ isset($childCopy->data['measurements']['under_body_rear']) ? 'checked: checked' : '' }} id="checkbox-under-body-rear">
            <label class="custom-control-label" for="checkbox-under-body-rear"><strong>UNDER BODY REAR</strong></label>
        </div>
    </div>
    <table class="table table-borderless mb-5" style="width: 100%; display: {{ isset($childCopy->data['measurements']['under_body_rear']) ? 'block' : 'none' }}">
        <thead>
        <tr style="background: transparent">
            <th>Heading</th>
            <th colspan="2">Image</th>
            <th>Description</th>
            <th class="text-nowrap">Sort Order</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 1; $i <=4; $i++)
            <tr>
                <td class="align-middle" style="width: 250px">
                    <input type="text" class="form-control skip" name="measurements[under_body_rear][heading][]" value="{{ $childCopy->data['measurements']['under_body_rear'][$i-1]['heading'] ?? 'Dimensions E & F' }}" maxlength="25" />
                </td>
                <td class="align-middle text-center">
                    @if (!empty($childCopy->data['measurements']['under_body_rear'][$i-1]['image']))
                        <img src="{{ config('app.asset_url') }}images/child/{{$childCopy->id}}/measurements/under_body_rear/{{ $childCopy->data['measurements']['under_body_rear'][$i-1]['image'] }}?t={{ time() }}" style="width: 100px" />
                        <button class="btn btn-xs btn-secondary mt-1 btn-edit-image">Edit</button>
                    @else
                        <img src="{{ config('app.url') }}/images/image_placeholder.png" style="width: 100px" />
                    @endif
                </td>
                <td class="align-middle" style="width: 200px;">
                    <input type="file" class="skip image" name="measurements[under_body_rear][image][]" accept="image/*">
                </td>
                <td style="width: 350px">
                    <textarea class="form-control skip" name="measurements[under_body_rear][description][]" rows="3">{{ $childCopy->data['measurements']['under_body_rear'][$i-1]['description'] ?? '' }}</textarea>
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-right" name="measurements[under_body_rear][sort_order][]" value="{{ $childCopy->data['measurements']['under_body_rear'][$i-1]['sort_order'] ?? $i }}" style="width: 65px" />
                    <input type="hidden" name="measurements[under_body_rear][id][]" value="{{ $childCopy->data['measurements']['under_body_rear'][$i-1]['id'] ?? $i }}"/>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
</div>
<hr/>


<!-- Under Body Center / Rear -->
<div class="font-weight-bold" style="font-size: 15px">
    <div class="form-group py-1">
        <div class="custom-control custom-control-xs custom-checkbox">
            <input type="checkbox" class="custom-control-input checkbox-measurement" name="dimensions[under_body_center_rear]" value="16" {{ isset($childCopy->data['measurements']['under_body_center_rear']) ? 'checked: checked' : '' }} id="checkbox-under-body-center-rear">
            <label class="custom-control-label" for="checkbox-under-body-center-rear"><strong>UNDER BODY CENTER / REAR</strong></label>
        </div>
    </div>
    <table class="table table-borderless mb-5" style="width: 100%; display: {{ isset($childCopy->data['measurements']['under_body_center_rear']) ? 'block' : 'none' }}">
        <thead>
        <tr style="background: transparent">
            <th>Heading</th>
            <th colspan="2">Image</th>
            <th>Description</th>
            <th class="text-nowrap">Sort Order</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 1; $i <=4; $i++)
            <tr>
                <td class="align-middle" style="width: 250px">
                    <input type="text" class="form-control skip" name="measurements[under_body_center_rear][heading][]" value="{{ $childCopy->data['measurements']['under_body_center_rear'][$i-1]['heading'] ?? 'Dimensions E & F' }}" maxlength="25" />
                </td>
                <td class="align-middle text-center">
                    @if (!empty($childCopy->data['measurements']['under_body_center_rear'][$i-1]['image']))
                        <img src="{{ config('app.asset_url') }}images/child/{{$childCopy->id}}/measurements/under_body_center_rear/{{ $childCopy->data['measurements']['under_body_center_rear'][$i-1]['image'] }}?t={{ time() }}" style="width: 100px" />
                        <button class="btn btn-xs btn-secondary mt-1 btn-edit-image">Edit</button>
                    @else
                        <img src="{{ config('app.url') }}/images/image_placeholder.png" style="width: 100px" />
                    @endif
                </td>
                <td class="align-middle" style="width: 200px;">
                    <input type="file" class="skip image" name="measurements[under_body_center_rear][image][]" accept="image/*">
                </td>
                <td style="width: 350px">
                    <textarea class="form-control skip" name="measurements[under_body_center_rear][description][]" rows="3">{{ $childCopy->data['measurements']['under_body_center_rear'][$i-1]['description'] ?? '' }}</textarea>
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-right" name="measurements[under_body_center_rear][sort_order][]" value="{{ $childCopy->data['measurements']['under_body_center_rear'][$i-1]['sort_order'] ?? $i }}" style="width: 65px" />
                    <input type="hidden" name="measurements[under_body_center_rear][id][]" value="{{ $childCopy->data['measurements']['under_body_center_rear'][$i-1]['id'] ?? $i }}"/>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
</div>
<hr/>

<!-- Under Body Center -->
<div class="font-weight-bold" style="font-size: 15px">
    <div class="form-group py-1">
        <div class="custom-control custom-control-xs custom-checkbox">
            <input type="checkbox" class="custom-control-input checkbox-measurement" name="dimensions[under_body_center]" value="17" {{ isset($childCopy->data['measurements']['under_body_center']) ? 'checked: checked' : '' }} id="checkbox-under-body-center">
            <label class="custom-control-label" for="checkbox-under-body-center"><strong>UNDER BODY CENTER</strong></label>
        </div>
    </div>
    <table class="table table-borderless mb-5" style="width: 100%; display: {{ isset($childCopy->data['measurements']['under_body_center']) ? 'block' : 'none' }}">
        <thead>
        <tr style="background: transparent">
            <th>Heading</th>
            <th colspan="2">Image</th>
            <th>Description</th>
            <th class="text-nowrap">Sort Order</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 1; $i <=4; $i++)
            <tr>
                <td class="align-middle" style="width: 250px">
                    <input type="text" class="form-control skip" name="measurements[under_body_center][heading][]" value="{{ $childCopy->data['measurements']['under_body_center'][$i-1]['heading'] ?? 'Dimensions G & H' }}" maxlength="25" />
                </td>
                <td class="align-middle text-center">
                    @if (!empty($childCopy->data['measurements']['under_body_center'][$i-1]['image']))
                        <img src="{{ config('app.asset_url') }}images/child/{{$childCopy->id}}/measurements/under_body_center/{{ $childCopy->data['measurements']['under_body_center'][$i-1]['image'] }}?t={{ time() }}" style="width: 100px" />
                        <button class="btn btn-xs btn-secondary mt-1 btn-edit-image">Edit</button>
                    @else
                        <img src="{{ config('app.url') }}/images/image_placeholder.png" style="width: 100px" />
                    @endif
                </td>
                <td class="align-middle" style="width: 200px;">
                    <input type="file" class="skip image" name="measurements[under_body_center][image][]" accept="image/*">
                </td>
                <td style="width: 350px">
                    <textarea class="form-control skip" name="measurements[under_body_center][description][]" rows="3">{{ $childCopy->data['measurements']['under_body_center'][$i-1]['description'] ?? '' }}</textarea>
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-right" name="measurements[under_body_center][sort_order][]" value="{{ $childCopy->data['measurements']['under_body_center'][$i-1]['sort_order'] ?? $i }}" style="width: 65px" />
                    <input type="hidden" name="measurements[under_body_center][id][]" value="{{ $childCopy->data['measurements']['under_body_center'][$i-1]['id'] ?? $i }}"/>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
</div>

<hr/>
<!-- OEM Figures -->
<label class="d-block fw-bold fs-7 mt-5 mb-3 pb-2 required" for="0-heading-dimensions">OEM FIGURES (mm)</label>
<div class="form-group pb-5">
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th class="text-center">A</th>
            <th class="text-center">B</th>
            <th class="text-center">C</th>
            <th class="text-center">D</th>
            <th class="text-center">E</th>
            <th class="text-center">F</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="oem_figures[A]" value="{{ $childCopy->data['oem_figures']['A'] ?? '' }}" autocomplete="off" style="width: 80px"></td>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="oem_figures[B]" value="{{ $childCopy->data['oem_figures']['B'] ?? '' }}" autocomplete="off" style="width: 80px"></td>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="oem_figures[C]" value="{{ $childCopy->data['oem_figures']['C'] ?? '' }}" autocomplete="off" style="width: 80px"></td>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="oem_figures[D]" value="{{ $childCopy->data['oem_figures']['D'] ?? '' }}" autocomplete="off" style="width: 80px"></td>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="oem_figures[E]" value="{{ $childCopy->data['oem_figures']['E'] ?? '' }}" autocomplete="off" style="width: 80px"></td>
            <td><input type="text" class="form-control unsigned-integer text-center mx-auto w-75 border-bottom-dashed p-0" name="oem_figures[F]" value="{{ $childCopy->data['oem_figures']['F'] ?? '' }}" autocomplete="off" style="width: 80px"></td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    $(function() {
        $('body').on('click', '.checkbox-measurement', function() {
            let $$ = $(this);
            if ($$.prop('checked')) {
                $$.closest('.form-group').next().slideDown('fast');
            } else {
                $$.closest('.form-group').next().slideUp('fast');
            }
        })

        $('body').on('change', 'input[name="dimensions[ub]"]', function() {
            let $$ = $(this);
            if ($$.val() === 'A-B') {
                $$.closest('div#wrapper-dimensions').find('div#wrapper-dimensions-a-b').slideDown('fast').next().hide();
            } else {
                $$.closest('div#wrapper-dimensions').find('div#wrapper-dimensions-ab').slideDown('fast').prev().hide();
            }
        })
    })
</script>
