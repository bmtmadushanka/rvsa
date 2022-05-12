@unless (empty($tab_data))
    <table class="datatable table mb-3">
        <thead>
        <tr>
            <th class="text-nowrap"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <tr>
            <td class="p-0 border-bottom">
                @foreach ($tab_data AS $update)
                    <div class="nk-ibx-item px-2">
                        <div class="nk-ibx-item-elem nk-ibx-item-user flex-grow-1">
                            <em class="icon ni ni-file-pdf"></em> New version of {{ $update->childCopy->make }} {{ $update->childCopy->model }} {{ $update->childCopy->model_code }} {{ str_replace('<br>', ' ', $update->childCopy->description) }} has been published.<br/>
                            <span class="small text-muted">{{ date('Y-M-d G:i:s A', strtotime($update->created_at)) }}</span>
                        </div>
                    </div>
                @endforeach
            </td>
        </tr>
        </tbody>
    </table>
@else
    <div class="nk-ibx-item p-5 nk-ibx-item-fluid justify-content-center fs-17px">
        <div style="position: absolute; top: 100px"><em class="icon ni ni-info mr-1"></em> No recent updates found. Please stay tuned!</div>
    </div>
@endunless
