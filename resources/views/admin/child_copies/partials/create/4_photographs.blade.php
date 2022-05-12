<table class="table table-borderless" style="width: 100%">
    <thead>
    <tr>
        <th>Heading</th>
        <th colspan="2">Image</th>
        <th>Sort Order</th>
    </tr>
    </thead>
    <tbody>
    @for ($i = 1; $i<=10; $i++)
        <tr style="height: 100px">
            <td class="align-middle" style="width: 300px"><input type="text" class="form-control" name="photos[rav][heading][]" value="{{ !empty($childCopy) ? $childCopy->data['rav'][$i-1]['heading'] : $photo_headings[$i] }}" style="width: 250px"></td>
            <td class="align-middle text-center" style="width: 100px">
                @if (!empty($childCopy))
                    <img src="{{ config('app.asset_url') }}images/child/{{$childCopy->id}}/rav/{{ $childCopy->data['rav'][$i-1]['image'] }}?t={{ time() }}" style="width: 100px" />
                    <button class="btn btn-xs btn-secondary mt-1 btn-edit-image">Edit</button>
                @else
                    <img src="{{ config('app.url') }}/images/image_placeholder.png" style="width: 100px" />
                @endif
            </td>
            <td class="align-middle">
                <div class="custom-file">
                    <input class="image" type="file" name="photos[rav][image][]" accept="image/*">
                </div>
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-right" name="photos[rav][sort_order][]" value="{{ !empty($childCopy) ? $childCopy->data['rav'][$i-1]['sort_order'] : $i }}" style="width: 65px" />
                <input type="hidden" class="form-control text-right" name="photos[rav][id][]" value="{{ !empty($childCopy) ? $childCopy->data['rav'][$i-1]['id'] : $i }}" style="width: 65px" />
            </td>
        </tr>
    @endfor
    </tbody>
</table>
