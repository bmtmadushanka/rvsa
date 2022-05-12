<a href="#" class="close" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
<div class="modal-header">
    <h5 class="modal-title">{{ empty($report->noise_test) ? 'Create' : 'Edit' }} Noise Test Report</h5>
</div>
<div class="modal-body">
    <form class="form ajax" method="POST" action="" data-action="admin/report/{{ $report->id }}/noise-test" id="form-manage-noise-test-report" data-callback="callback_noise_test_report" onsubmit="return false;">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="form-group mb-4 pb-1">
                    <label class="form-label required" for="input-test-date">Test Date</label>
                    <div class="form-control-wrap">
                        <div class="input-group input-group-date-picker">
                            <input type="text" class="form-control date-picker" name="date_test" value="{{ $report->noise_test->data['date_test'] ?? '' }}" id="input-test-date" required aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                            <span class="input-group-text px-2">
                                <span class="input-group-addon p-0 bg-transparent border-0">
                                    <em class="icon ni ni-calendar-check fs-18px"></em>
                                </span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-md-8">
                <div class="form-group mb-4 pb-1">
                    <label class="form-label required" for="input-wind-direction">Wind Direction / Strength</label>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" name="wind_direction" value="{{ $report->noise_test->data['wind_direction'] ?? '' }}" id="input-wind-direction" required maxlength="150" aria-describedby="img-addon" autocomplete="off"/>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group mb-4 pb-1">
                    <label class="form-label required" for="input-height-of-mic">Height of the Mic</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" class="form-control unsigned-integer" name="height_of_mic" value="{{ $report->noise_test->data['height_of_mic'] ?? '' }}" id="input-height-of-mic" maxlength="5" required aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                                <span class="input-group-text">
                                    <span class="input-group-addon p-0 bg-transparent border-0">mm</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group mb-4 pb-1">
                    <label class="form-label required" for="input-temperature">Temperature</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" class="form-control floats" name="temperature" value="{{ $report->noise_test->data['temperature'] ?? '' }}" id="input-temperature" maxlength="4"  required  aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                                <span class="input-group-text">
                                    <span class="input-group-addon p-0 bg-transparent border-0">
                                        &#176;C
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="feedback"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group mb-4 pb-1">
                    <label class="form-label required" for="input-noise-level">Ambient Noise Level</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" class="form-control floats" name="noise_level" value="{{ $report->noise_test->data['noise_level'] ?? '' }}" id="input-noise-level" required maxlength="6" aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                            <span class="input-group-text">
                                <span class="input-group-addon p-0 bg-transparent border-0">
                                    dB(A)
                                </span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="form-group mb-4 pb-1">
                    <label class="form-label required" for="input-engine-speed-nep">NEP Engine Speed</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" class="form-control unsigned-integer" name="engine_speed_nep" value="{{ $report->noise_test->data['engine_speed_nep'] ?? '' }}" id="input-engine-speed-nep" required maxlength="5" aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                                <span class="input-group-text">
                                    <span class="input-group-addon p-0 bg-transparent border-0">
                                        RPM
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-md-5">
                <div class="form-group mb-4 pb-1">
                    <label class="form-label required" for="input-engine-speed-starts">Engine speed at the start of test cycle</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" class="form-control unsigned-integer" name="engine_speed_starts" value="{{ $report->noise_test->data['engine_speed_starts'] ?? '' }}" id="input-engine-speed-starts" required maxlength="5" aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                                <span class="input-group-text">
                                    <span class="input-group-addon p-0 bg-transparent border-0">
                                        RPM
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
        <div class="content-separator mt-2 mb-4">Test Results</div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="form-group pb-1">
                    <label class="form-label required" for="input-test-1">Test 1</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" class="form-control floats" name="test_1" value="{{ $report->noise_test->data['test_1'] ?? '' }}" id="input-test-1" required maxlength="6" aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                            <span class="input-group-text">
                                <span class="input-group-addon p-0 bg-transparent border-0">db(A)</span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group pb-1">
                    <label class="form-label required" for="input-test-2">Test 2</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" class="form-control floats" name="test_2" value="{{ $report->noise_test->data['test_2'] ?? '' }}" id="input-test-2" required maxlength="6"  aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                            <span class="input-group-text">
                                <span class="input-group-addon p-0 bg-transparent border-0">dB(A)</span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="form-group pb-1">
                    <label class="form-label required" for="input-test-3">Test 3</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" class="form-control floats" name="test_3" value="{{ $report->noise_test->data['test_3'] ?? '' }}" id="input-test-3" required maxlength="6" aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                            <span class="input-group-text">
                                <span class="input-group-addon p-0 bg-transparent border-0">mm</span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-12 col-md-6">
                <div class="form-group mb-4 pb-1">
                    <label class="form-label required" for="input-sound-intensity">Max Allowed sound intensity for category {{ $report->child->data['vehicle']['category'] }}</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <input type="text" class="form-control floats" name="sound_intensity" value="{{ $report->noise_test->data['sound_intensity'] ?? '' }}" id="input-sound-intensity" required maxlength="6" aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                                    <span class="input-group-text">
                                        <span class="input-group-addon p-0 bg-transparent border-0">
                                            dB(A)
                                        </span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
        <div class="nk-modal-action text-center mt-5 mb-4">
            <a href="#" class="btn btn-mw btn-outline-secondary" data-dismiss="modal">Return</a>
            <button type="button" class="btn btn-mw btn-primary btn-update-noise-test-report">Save</button>
            <button type="button" class="btn btn-mw btn-outline-danger btn-update-noise-test-report" data-download="true">Save & Download</button>
            <button type="submit" style="display: none"></button>
        </div>
    </form>
</div>
<script>

    $(function() {

        $('.date-picker').each(function() {
            activateDatePicker($(this).closest('.input-group'))
        })


        $('body').on('click', '.btn-update-noise-test-report', function() {

            let $$ = $(this);
            loadingButton($$);

            let form = $$.closest('form');
            let action = form.data('action');

            if ($$.data('download')) {
                action += '?download=true';
            }

            form.attr('action', action);
            form.find('button:submit').click();
            loadingButton($$, false);
        })
    })

    function callback_noise_test_report(j)
    {
        if (j.status === 'success') {
            if (j.data.download) {
                window.open('/report/' + j.data.report_id + '/download/noise-test', '_blank');
            }
            redirect(j.data.redirect);
        }
    }
</script>






