<div class="my-4">
    @foreach ($adrs AS $adr)
        <div class="custom-control custom-control-sm custom-checkbox custom-control-pro mr-1 mb-1 d-inline-block" style="width: 160px">
            <input type="checkbox" class="custom-control-input d-inline-block" name="adrs[]" id="{{ $adr['number'] }}" value="{{ $adr['id'] }}" {{ (isset($childCopy) && in_array($adr['number'], $childCopy->adrs->keyBy('number')->keys()->toArray())) ? 'checked=checked' : '' }}/>
            <label class="custom-control-label" for="{{ $adr['number'] }}" style="width: 160px">{{ $adr['title'] }} </label>
        </div>
    @endforeach
</div>
