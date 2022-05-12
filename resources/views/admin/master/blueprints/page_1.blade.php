<div class="text-center page-content mt-3" id="model-report-cover-page">
    <div class="fw-bold" style="font-size: 1.5em">
        <div class="mb-4">MODEL REPORT (SEV)</div>
        <div>MR<span class="placeholder" data-id="1.1">VIN</span></div>
    </div>
    <div style="margin-top: 50px">
        <p>The RAW Work Instruction Identifier:</p>
        <h3 class="mb-2"><span class="placeholder" data-id="1.2">Make</span> <span class="placeholder" data-id="1.3">Model</span> <span class="placeholder" data-id="1.4">Model Code</span></h3>
        <h3 class="mt-0 text-center" style="line-height: 2rem; max-width: 400px; margin: 0 auto"><span class="placeholder" data-id="1.5">Description</span></h3>
    </div>
    <div style="margin-top: 80px">
        <div class="text-center pb-3">
            {{--<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($verify_link)) !!} ">--}}
            <span class="image" style="background: #fff" data-id="1.6"><img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=link"/></span>
        </div>
        <div>
            Model Report Approval Number: <span class="placeholder" data-id="1.7">MR Approval Number</span>
        </div>
    </div>
</div>

