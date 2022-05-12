<div class="mt-3 mb-4 pb-1">
    <div class="row gx-5">
        <div class="col-sm-12 col-md-6">
            <div class="form-group mb-4 pb-1">
                <label class="form-label required" for="input-model-report-number">Master Model Report Number</label>
                <div class="form-control-wrap">
                    <div class="input-group" style="max-width:300px">
                        <div class="input-group-prepend">
                            <span class="input-group-text">MR</span>
                        </div>
                        <input type="text" class="form-control text-right" id="input-model-report-number" name="model_report_number" value="{{ $childCopy->name ?? '' }}" maxlength="17" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gx-5">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label class="form-label required" for="input-report-price">Report Price</label>
                <div class="form-control-wrap">
                    <div class="input-group" style="max-width:300px">
                        <div class="input-group-prepend">
                            <span class="input-group-text">AUD</span>
                        </div>
                        <input type="text" class="form-control text-right" id="input-report-price" name="price" value="{{ $childCopy->price ?? '' }}" maxlength="150" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
