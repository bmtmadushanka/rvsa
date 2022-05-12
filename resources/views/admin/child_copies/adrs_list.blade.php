<button class="btn btn-outline-secondary" style="position: absolute; right: 25px; top: 22px;" id="btn-download-full-adrs">Download</button>
<table class="table table-bordered table-hover bg-white">
    <thead>
    <tr>
        <th style="width: 40px"></th>
        <th class="text-right" style="width:120px">Number</th>
        <th>Name</th>
        <th class="text-center" style="width:80px">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($child_copy_adrs AS $adr)
        <tr>
            <td>
                <div class="custom-control pt-1 ml-1 mb-1 custom-control-xs custom-checkbox">
                    <input type="checkbox" class="custom-control-input skip" name="download_adrs[]" value="{{ $adr['id'] }}" id="download-adr-{{ $adr['id'] }}">
                    <label class="custom-control-label" for="download-adr-{{ $adr['id'] }}"></label>
                </div>
            </td>
            <td class="text-right align-middle">{{ $adr['number'] }}</td>
            <td class="align-middle">{{ $adr['name'] }}</td>
            <td class="text-center text-nowrap">
                <a class="btn btn-sm btn-outline-secondary mr-1" href="/admin/child-copy/adr/{{ $adr['id'] }}/edit"><em class="icon ni ni-edit-alt"></em></a>
                {{--<button class="btn btn-sm btn-outline-danger mr-1 btn-delete-child-copy-adr" data-id="{{ $adr['id'] }}"><em class="icon ni ni-trash"></em></button>--}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<form method="POST" action="/child-copy/{{ $childCopy->id }}/download_adrs" target="_blank" id="form-post-adrs">
    @csrf
    <input type="hidden" name="adrs" value="" />
</form>
<script>
    $(function() {
        $('body').on('click', '.btn-delete-child-copy-adr', function() {
            let $$ = $(this);

            if ($('.btn-delete-child-copy-adr').length <= 1) {
                notify('error', 'Cannot delete the ADR. At least one ADR is required');
            } else {
                Swal.fire(confirmSwalDelete('Are you sure that you want to delete the ADR? Once done, the action cannot be undone.')).then((result) => {
                    if (result.value) {
                        $.ajax({
                            cache: false,
                            method: 'DELETE',
                            type: 'DELETE',
                            url: APP_URL + 'admin/child-copy/adr/' + $$.data('id') + '/delete',
                            timeout: 20000,
                            data: {
                                '_method': 'DELETE',
                                '_token': $('meta[name=csrf-token]').attr('content'),
                            },
                        }).done(function (j) {
                            if (typeof j.status !== 'undefined') {
                                if (typeof j.msg !== 'undefined') {
                                    announce(j.status, j.msg);
                                }
                                if (typeof j.redirect !== 'undefined') {
                                    redirect(j.redirect);
                                }
                            } else {
                                notify('error', 'We have encountered an error. Please contact your IT Department');
                            }
                        }).fail(function (xhr, status) {
                            handler(xhr, status)
                        })
                    }
                });
            }
        });

        $('body').on('click', '#btn-download-full-adrs', function() {

            let $$ = $(this);
            let adrs = [];

            $('input[name="download_adrs[]"]:checked').each(function(i, v) {
                adrs.push($(v).val());
            })

            if (adrs.length <= 0) {
                return notify('error', 'No ADR is selected. Please select the ADR(s)');
            }

            $('#form-post-adrs').find('input[name=adrs]').val(adrs).end().submit();

        })
    })
</script>
