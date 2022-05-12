<table class="datatable-init table" id="table-user-reports">
    <thead>
    <tr>
        <th class="text-right">ID</th>
        <th style="width: 130px">Make</th>
        <th style="width: 230px">Model</th>
        <th>VIN</th>
        <th>Description</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($reports AS $report)
        <tr>
            <td style="width: 80px" class="align-middle text-right">{{  sprintf('%03d', $report->id) }}</td>
            <td class="align-middle">{{ $report->child->make }}</td>
            <td class="align-middle">{{ $report->child->model }}<br/>{{ $report->child->model_code }}</td>
            <td class="align-middle">{{ $report->vin }}</td>
            <td class="align-middle">{!! $report->child->description !!}</td>
            <td class="text-center text-nowrap">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                    <div class="dropdown-menu" style="">
                        <>
                        <ul class="link-list-opt no-bdr">
                            <li><a class="dropdown-item" href="/report/{{ $report->id }}/download/report" target="_blank"><em class="icon ni ni-download pos-rel" style="bottom: 2px"></em><span>Model Report</span></a></li>
                            <li><a class="dropdown-item" href="/report/{{ $report->id }}/mark/report" target="_blank"><em class="icon ni ni-download pos-rel" style="bottom: 2px"></em><span>Mark</span></a></li>
                            <li><a class="dropdown-item" href="/report/{{ $report->id }}/download/consumer-notice" target="_blank"><em class="icon ni ni-download pos-rel" style="bottom: 2px"></em><span> Consumer Information Notice</span></a></li>
                            @ifBackEnd
                            <li><a class="dropdown-item" href="/report/{{ $report->id }}/download/sticker" target="_blank"><em class="icon ni ni-download pos-rel" style="bottom: 2px"></em><span>Identification Label</span></a></li>
                            @if ($report->noise_test)
                            <li><a class="dropdown-item" href="/report/{{ $report->id }}/download/noise-test" target="_blank"><em class="icon ni ni-download pos-rel" style="bottom: 2px"></em><span>Noise Test Report</span></a></li>
                            @endif
                            @endIfBackEnd
                        </ul>
                        @ifBackEnd
                        <ul class="link-list-opt border-top mt-2">
                            <li><a class="dropdown-item btn-edit-noise-test-report" data-id="{{ $report->id }}" href="javascript:void(0)"><em class="icon ni ni-{{ $report->noise_test ? 'pen' : 'plus' }} pos-rel" style="bottom: 2px"></em><span>Noise Test Report</span></a></li>
                        </ul>
                        @endIfBackEnd
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('table#table-user-reports thead th.sorting:first ').trigger('click');
        }, 250);
    })
</script>
@ifBackEnd
    @push('styles')
        <link rel="stylesheet" href="/css/plugins/bootstrap-datetimepicker.min.css" />
    @endpush
    @push('scripts-post')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment-with-locales.min.js"></script>
        <script src="/js/plugins/bootstrap-datetimepicker.min.js"></script>
    @endpush
    <script>
        $(function() {
            $('body').on('click', '.btn-edit-noise-test-report', function () {

                let $$ = $(this);
                $.ajax({
                    cache: false,
                    url: APP_URL + 'admin/report/' + $$.data('id') + '/noise-test/',
                    timeout: 20000
                }).done(function (j) {
                    if (typeof j.status !== 'undefined') {
                        if (typeof j.msg !== 'undefined') {
                            notify(j.status, j.msg);
                        }
                        if (typeof j.data !== 'undefined') {
                            let myModal = $('#modal-common')
                            myModal.find('.modal-dialog').removeClass('modal-sm modal-xl').addClass('modal-lg');
                            myModal.find('.modal-content').html(j.data);
                            myModal.modal('show');
                        }
                    } else {
                        notify('error', 'We have encountered an error. Please contact your IT Department');
                    }
                }).fail(function (xhr, status) {
                    handler(xhr, status)
                });

            })
        });
    </script>
@endIfBackEnd
