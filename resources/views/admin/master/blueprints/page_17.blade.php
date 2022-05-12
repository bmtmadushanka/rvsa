<div class="page-content">
    <table class="table table-bordered w-100 table-fixed">
        <thead>
        <tr>
            <td colspan="4" class="text-center fw-bold pt-2 pb-3 fs-14">Under Body Center Measurements</td>
        </tr>
        </thead>
        <tbody class="image" data-id="17.1">
        <tr>
            @for($i = 1; $i <= 4; $i++)
                <td class="border-bottom-0 p-0 align-top" style="width: 25%">
                    <div class="text-center fw-bold pt-1 fs-13"><span class="placeholder-empty">Heading</span></div>
                    <div class="text-center p-2">
                        <img src="{{ config('app.url') . '/images/image_placeholder.png' }}" alt="" style="object-fit: contain; width: 100%; height: 225px">
                    </div>
                </td>
            @endfor
        </tr>
        <tr>
            @for($i = 1; $i <= 4; $i++)
                <td class="border-top-0 align-top p-2 text-center"><span class="placeholder-empty">Description</span></td>
            @endfor
        </tr>
        </tbody>
    </table>
</div>
