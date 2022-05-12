<a href="#" class="close" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
<div class="modal-header">
    <h5 class="modal-title">{{ isset($coupon) ? 'Edit' : 'New' }} Coupon</h5>
</div>
<div class="modal-body">
    <form class="form ajax" method="POST" action="admin/coupon{{ isset($coupon) ? '/' . $coupon->id : '' }}" data-callback="callback_manage_coupon">
        @csrf
        @isset($coupon) @method('patch') @endisset
        <div class="row mb-3">
            <div class="col-sm-12 col-md-6">
                <div class="form-group mb-4">
                    <label class="form-label required" for="input-discount">Status</label><br/>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="custom-switch-active" name="is_active" {{ !isset($coupon) || $coupon->is_active ? 'checked=checked' : '' }} value="1">
                        <label class="custom-control-label" for="custom-switch-active">Active</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-group ml-3 mb-4">
                <label class="form-label required" for="radio-coupon-type-one-off">Type</label>
                <div class="form-control-wrap radio-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" {{ !isset($coupon) || $coupon->type == 'one-off' ? 'checked=checked' : '' }} id="radio-coupon-type-one-off" value="one-off" required>
                        <label class="form-check-label" for="radio-coupon-type-one-off">One-off</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" {{ isset($coupon) && $coupon->type == 'indefinite' ? 'checked=checked' : '' }} id="radio-coupon-type-indefinite" value="indefinite" required>
                        <label class="form-check-label" for="radio-coupon-type-indefinite">Indefinite</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label class="form-label required" for="input-discount">Discount</label>
                    <div class="input-group" style="width: 200px">
                        <input type="text" class="form-control" id="input-discount" name="discount" autocomplete="off" value="{{ $coupon->discount ?? '' }}" maxlength="5" required  placeholder="Enter Discount">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-12 col-md-6">
                <div class="form-group mb-4 pb-1">
                    <label class="form-label" for="input-valid-from">Valid From</label>
                    <div class="form-control-wrap">
                        <div class="input-group input-group-date-picker" style="width: 200px">
                            <input type="text" class="form-control date-picker" name="valid_from" value="{{ $coupon->valid_from ?? '' }}" id="input-valid-from" aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                                <span class="input-group-text">
                                    <span class="input-group-addon p-0" id="img-addon">
                                       <em class="icon ni ni-calendar-check fs-18px"></em>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group mb-4 pb-1">
                    <label class="form-label" for="input-valid-to">Valid To</label>
                    <div class="form-control-wrap">
                        <div class="input-group input-group-date-picker" id="input-group-date-build-date" style="width: 200px">
                            <input type="text" class="form-control date-picker" name="valid_to" value="{{ $coupon->valid_to ?? ''}}" id="input-valid-to" aria-describedby="img-addon" autocomplete="off"/>
                            <div class="input-group-append" style="height: 36px">
                                <span class="input-group-text">
                                    <span class="input-group-addon p-0" id="img-addon">
                                       <em class="icon ni ni-calendar-check fs-18px"></em>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-modal-action text-center my-4">
            <a href="#" class="btn btn-outline-secondary" data-dismiss="modal">Return</a>
            <button type="submit" class="btn btn-primary">{{ isset($coupon) ? 'Update' : 'Save' }}</button>
        </div>
    </form>
</div>
<script>

    $(document).ready(function() {
        activateDatePicker();
    });

    function callback_manage_coupon(j) {
        if (j.status) {
            $('#modal-common').modal('hide');
            redirect(j.data.url);
        }
    }
</script>
