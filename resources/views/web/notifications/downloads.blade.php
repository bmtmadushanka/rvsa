@unless ($tab_data->isEmpty())
    <table class="datatable table mb-3 pb-5">
        <thead>
        <tr>
            <th class="text-nowrap"></th>
        </tr>
        </thead>
        <tbody id="nk-ibx-list" style="height: 100%; overflow: hidden scroll">
        @foreach ($tab_data AS $download)
        <tr>
            <td class="p-0">
                <div class="nk-ibx-item px-2">
                    <div class="nk-ibx-item-elem nk-ibx-item-user flex-grow-1">
                        <em class="icon ni ni-file-{{ $download->type === 'consumer' ? 'check' : 'pdf' }} mr-1" style="font-size: 1.5rem; position: relative; top: 5px; color:{{ $download->type === 'consumer' ? 'blue' : 'red' }}"></em>
                        {{ $download->type === 'consumer' ? 'The consumer notice of the ' : 'The model' }} report (VIN {{ $download->report->vin }}) has been downloaded at {{ date('Y-M-d G:i:s A', strtotime($download->downloaded_at)) }}.
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="nk-ibx-item p-5 nk-ibx-item-fluid justify-content-center fs-17px">
        <div style="position: absolute; top: 100px"><em class="icon ni ni-info mr-1"></em> You don't have recent downloads yet!</div>
    </div>
@endunless
