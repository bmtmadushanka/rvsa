<div class="page-content">
    <h2>PHOTOGRAPHS (Mandatory requirement for the RAV)</h2>
    <p>Photographs in the directions as indicated below are part of the Model Report master & the AVV should use them to compare against the actual SEV’s entry vehicle being inspected. The AVV is further required to produce a matching set of photographs of the actual vehicle &
        upload them into their MR storage file.
    </p>
    <table class="table table-bordered mt-5 w-100">
        <tbody>
        <tr class="image" data-id="8.1">
            @for ($i = 1; $i<=2; $i++)
                <td>
                    <div class="text-center fw-bold pt-1 pb-2 fs-13"><span class="placeholder-empty">Heading</span></div>
                    <div class="text-center pb-3">
                        <img src="{{ config('app.url') . '/images/image_placeholder.png' }}" alt="" style="object-fit: contain; width: 450px; height: 225px">
                    </div>
                </td>
            @endfor
        </tr>
        </tbody>
    </table>
</div>
