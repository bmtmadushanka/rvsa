@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/{{ $isBackEnd ? 'admin/' : '' }}dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1">Discussion Items</h2>
                    <div class="float-right">
                        <a type="button" class="btn btn-outline-primary float-right" href="#" data-toggle="modal" data-target="#new-ticket" ><em class="icon ni ni-plus mr-1"></em> New Discussion</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            <div class="{{ $isBackEnd ? 'nk-ibx' : '' }}">
                @ifBackEnd
                @include('layouts.discussions.aside')
                @endIfBackEnd
                @include('layouts.discussions.content')
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" id="new-ticket">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">New Discussion Item</h6>
                    <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                </div>
                <div class="modal-body p-1">
                    <form class="form ajax" method="POST" action="discussion/create" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-inner">
                                <div class="form-group mb-1">
                                    <div class="form-label-group">
                                        <label class="form-label required" for="input-subject">Subject</label>
                                    </div>
                                    <div class="form-control-wrap">
                                    @ifFrontEnd
                                        <select class="form-control" name="subject" required>
                                            <option value=""></option>
                                            @foreach ($subjects AS $id => $subject)
                                            @if (in_array($id, [4, 5]) && $reports->isEmpty()) @continue @endif
                                            <option value="{{ $id }}">{{ $subject }}</option>
                                            @endforeach
                                        </select>
                                    @endIfFrontEnd
                                    @ifBackEnd
                                    <input type="text" class="form-control" required name="subject" maxlength="100" autocomplete="off"/>
                                    @endIfBackEnd
                                    </div>
                                    <div class="feedback"></div>
                                </div>
                                @ifFrontEnd
                                <div class="form-group mb-1" id="wrapper-vin" style="display: none">
                                    <div class="form-label-group">
                                        <label class="form-label required" for="select-vin">VIN</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="select-vin" name="vin" style="max-width: 300px">
                                            <option></option>
                                            @foreach ($reports AS $report)
                                                <option value="{{ $report->id }}">{{ $report->child->make }} {{ $report->child->model }} - {{ $report->vin }}</option>
                                            @endforeach
                                        </select>
                                        <div class="feedback"></div>
                                    </div>
                                </div>
                                @endIfFrontEnd
                                @ifBackEnd
                                <div class="form-group mb-1">
                                    <div class="form-label-group">
                                        <label class="form-label required" for="select-user">User</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="select-vin" name="assignee" style="max-width: 300px">
                                            <option></option>
                                            @foreach ($users->where('is_admin', '!=', 1) AS $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} {{ !empty($user->client->raw_company_name) ? '(' . $user->client->raw_company_name . ')'  : '' }}</option>
                                            @endforeach
                                        </select>
                                        <div class="feedback"></div>
                                    </div>
                                </div>
                                @endIfBackEnd
                                <div class="form-group mb-1">
                                    <div class="form-label-group">
                                        <label class="form-label required" for="textarea-message">Message</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control px-2" id="textarea-message" name="message" required maxlength="6000" rows="12" placeholder="Type your message here"></textarea>
                                    </div>
                                    <div class="feedback"></div>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label" for="customFileLabel">Any Supporting document (optional) @ifFrontEnd <span class="text-muted">(Max 20MB)</span></label> @endIfFrontEnd
                                    <div class="form-control-wrap" style="width: 400px;">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="file" id="customFile" accept="image/jpg,image/jpeg,image/gif,image/png,image/x-eps,application/pdf">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-reply-form-tools justify-content-center">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                            <button class="ml-1 btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {

            $('.datatable').DataTable({
                dom: 'rftirp',
                pageLength: 50,
                order: [],
                scrollY: '800px',
                "scrollCollapse": true,
            });

            $('body').on('show.bs.modal', '#new-ticket', function() {
                let $$ = $(this);
                $$.find('#wrapper-vin').hide();
                $$.find('form')[0].reset();
                $$.find('.form-select').val('').change();
            })

            $('body').on('change', 'select[name=subject]', function() {
                let $$ = $(this);
                if ($.inArray(parseInt($$.val()), [4, 5]) != -1) {
                    $$.closest('div.form-group').next().slideDown('fast', function() {
                        $(this).find('input').val('');
                    });
                } else {
                    $$.closest('div.form-group').next().slideUp('fast');
                }
            })
        });
    </script>

@endsection
