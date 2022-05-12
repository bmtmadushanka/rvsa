@ifFrontEnd
<div class="card" id="card-discussion"><div class="card-inner">
@endIfFrontEnd
    <div class="bg-white {{ $isBackEnd ? 'p-0' : 'px-0 py-5' }} w-100 wrapper-table-notifications {{ $isBackEnd ? 'filter-right' : '' }}" style="{{ $isBackEnd ? '' : 'overflow:hidden' }}" id="table-discussion">
        @if ($discussions->isNotEmpty())
            @ifBackEnd
            <div class="loading">Loading</div>
            <div id="table-discusssions" style="visibility: hidden">
                <div style="position: relative; top: 20px; left: 12px">
                    <div class="custom-control custom-control-sm custom-checkbox">
                        <input type="checkbox" class="custom-control-input nk-dt-item-check" id="checkbox-discussion-bulk-assign">
                        <label class="custom-control-label" for="checkbox-discussion-bulk-assign"></label>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                        <div class="dropdown-menu dropdown-menu-right px-3 pt-2 pb-5" style="min-width: 250px">
                            <div class="form-group">
                                <label class="form-label">Assigned to</label>
                                <select class="form-select discussion-assignee">
                                    <option value=""></option>
                                    @foreach ($admins AS $admin)
                                        <option value="{{ $admin->id }}"><a href="javascript:void(0)">{{ $admin->first_name }} {{ $admin->last_name }}</a></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts.discussions.table')
            </div>
            @notBackEnd
                @include('layouts.discussions.table')
            @endIfBackEnd
        @else
            <div class="p-5 nk-ibx-item-fluid text-center w-100 fs-17px">
                @ifBackEnd
                <div class="mt-5"><em class="icon ni ni-info mr-1"></em> No discussions are available.</div>
                @notBackEnd
                <div class="mt-5">
                    <em class="icon ni ni-info mr-1"></em> You have not started any discussion yet.!
                </div>
                <a class="btn btn-outline-secondary mt-4" data-toggle="modal" data-target="#new-ticket"><em class="icon ni ni-plus-sm"></em> Start Discussion</a>
                @endIfBackEnd
            </div>
        @endif
    </div>
@ifFrontEnd</div></div>@endIfFrontEnd


<script>
    $(function() {

        @ifBackEnd
        setTimeout(function() {
            $('#table-discusssions').css('visibility', 'visible').prev().remove();
        }, 100);
        @endIfBackEnd

        $('body').on('click', '.btn-discussion-toggle-read', function() {

            let $$ = $(this);
            $$.tooltip('hide');
            let url = 'discussion/' + $$.data('id') + '/toggle';
            @ifBackEnd
                url = 'admin/discussion/' + $$.data('id') + '/toggle-read';
                $$.closest('.wrapper-table-notifications').addClass('loading').html('Please wait');
            @endIfBackEnd

            $.ajax({
                cache: false,
                method: 'POST',
                url: APP_URL + url,
                timeout: 20000,
                data: {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                },
            }).done(function (j) {
                if (typeof j.status !== 'undefined') {
                    if (typeof j.msg !== 'undefined') {
                        notify(j.status, j.msg);
                    }
                    if (typeof j.redirect !== 'undefined') {
                        redirect(j.redirect);
                    } else {
                        $$.attr('data-original-title', 'Mark as ' + j.data.status);
                        if (j.data.status == 'unread') {
                            $$.closest('div.nk-ibx-item').removeClass('is-unread').find('em.icon-read-mail').removeClass('ni-mail-fill').addClass('ni-mail');
                        } else {
                            $$.closest('div.nk-ibx-item').addClass('is-unread').find('em.icon-read-mail').removeClass('ni-mail').addClass('ni-mail-fill');
                        }
                        $$.tooltip('show');
                    }
                } else {
                    notify('error', 'We have encountered an error. Please contact your IT Department');
                }
            }).fail(function (xhr, status) {
                handler(xhr, status)
            });
        });

        $('body').on('click', '.btn-discussion-delete', function() {
            let $$ = $(this);
            $$.tooltip( 'hide' );
            Swal.fire(confirmSwal('Are you sure that you want to delete the discussion?')).then((result) => {
                if (result.value) {
                    $.ajax({
                        cache: false,
                        method: 'DELETE',
                        url: APP_URL + 'discussion/' + $$.data('id') + '/delete',
                        timeout: 20000,
                        data: {
                            '_method': 'DELETE',
                            '_token': $('meta[name=csrf-token]').attr('content'),
                        },
                    }).done(function (j) {
                        if (typeof j.status !== 'undefined') {
                            if (typeof j.msg !== 'undefined') {
                                notify(j.status, j.msg);
                            }
                            if (j.status == 'success') {
                                $$.tooltip( 'hide' );
                                $$.closest('.nk-ibx-item').slideUp('fast', function(){
                                    $(this).remove();
                                })
                            }
                        } else {
                            notify('error', 'We have encountered an error. Please contact your IT Department');
                        }
                    }).fail(function (xhr, status) {
                        handler(xhr, status)
                    });
                }
            })
        });

        $('body').on('click', '#checkbox-discussion-bulk-assign', function() {
            let $$ = $(this);
            $('#nk-ibx-list .checkbox-assigned-me').each(function() {
                $(this).prop('checked', $$.prop('checked'))
            })
        })

        $('body').on('change', '.discussion-assignee', function() {
            $$ = $(this);
            $$.closest('.dropdown-menu').removeClass('show');

            if ($$.val().length > 0) {
                let ids = [];
                $('#nk-ibx-list .checkbox-assigned-me').each(function () {
                    if ($(this).is(':checked')) {
                        ids.push($(this).val());
                    }
                })

                if (ids.length < 1) {
                    notify('error', 'No discussions are selected. Please select the discussion(s) from the list');
                    return false;
                }

                $$.closest('.wrapper-table-notifications').addClass('loading').html('Please wait');
                $.ajax({
                    cache: false,
                    method: 'POST',
                    url: APP_URL + 'admin/discussions/bulk-assign',
                    timeout: 20000,
                    data: {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        'ids': ids,
                        'assignee': $$.val()
                    },
                }).done(function (j) {
                    if (typeof j.status !== 'undefined') {
                        if (typeof j.msg !== 'undefined') {
                            notify(j.status, j.msg);
                        }
                        if (typeof j.redirect !== 'undefined')
                        {
                            redirect(j.redirect);
                        }
                        $$.tooltip( 'show' );
                    } else {
                        notify('error', 'We have encountered an error. Please contact your IT Department');
                    }
                }).fail(function (xhr, status) {
                    handler(xhr, status)
                });
            }
        })

        $('body').on('click', '.btn-discussion-toggle-assign', function() {
            let $$ = $(this);
            $$.closest('.wrapper-table-notifications').addClass('loading').html('Please wait');
            $.ajax({
                cache: false,
                method: 'POST',
                url: APP_URL + 'admin/discussion/' + $$.data('id') + '/toggle-assign',
                timeout: 20000,
                data: {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                },
            }).done(function (j) {
                if (typeof j.status !== 'undefined') {
                    if (typeof j.msg !== 'undefined') {
                        notify(j.status, j.msg);
                    }
                    if (typeof j.redirect !== 'undefined')
                    {
                        redirect(j.redirect);
                    }
                    $$.tooltip( 'show' );
                } else {
                    notify('error', 'We have encountered an error. Please contact your IT Department');
                }
            }).fail(function (xhr, status) {
                handler(xhr, status)
            });
        })
    })
</script>
