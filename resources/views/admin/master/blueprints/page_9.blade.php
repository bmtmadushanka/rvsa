<div class="page-content">
    <table class="table table-bordered w-100 table-fixed">
        <tbody>
        <tr class="image" data-id="9.1">
            @for($i = 1; $i <= 4; $i++)
            <td class="p-0" style="width: 25%">
                <div class="text-center fw-bold pt-1 fs-13"><span class="placeholder-empty">Heading</span></div>
                <div class="text-center p-2">
                    <img src="{{ config('app.url') . '/images/image_placeholder.png' }}" alt="" style="object-fit: contain; width: 100%; height: 225px">
                </div>
            </td>
            @endfor
        </tr>
        </tbody>
    </table>
    <table class="table table-bordered w-100 table-fixed" style="margin-top: 15px">
        <tbody>
        <tr class="image" data-id="9.2">
            @for($i = 1; $i <= 4; $i++)
            <td class="p-0" style="width: 25%">
                <div class="text-center fw-bold pt-1 fs-13"><span class="placeholder-empty">Heading</span></div>
                <div class="text-center p-2">
                    <img src="{{ config('app.url') . '/images/image_placeholder.png' }}" alt="" style="object-fit: contain; width: 100%; height: 225px">
                </div>
            </td>
            @endfor
        </tr>
        </tbody>
    </table>
</div>
