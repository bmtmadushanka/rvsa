<div class="nk-footer-copyright"> &copy; {{ date('Y') }} Road Vehicle Standards Australia</div>
@unless ($isBackEnd || auth()->guest() || Route::is('verify_mobile.prompt'))
<script>
    $(document).ready(function() {
        $.ajax({
            cache: false,
            url: APP_URL + 'refresh-mini-cart',
            timeout: 20000
        }).done(function (j) {
            if (typeof j.status !== 'undefined') {
                if (typeof j.msg !== 'undefined') {
                    announce(j.status, j.msg);
                }
                if (typeof j.data !== 'undefined') {
                    $('div#mini-cart').html(j.data.cart);
                }
            } else {
                notify('error', 'We have encountered an error. Please contact your IT Department');
            }
        }).fail(function (xhr, status) {
            handler(xhr, status)
        })
    });
</script>
@endunless
@ifBackEnd
<div class="modal fade" tabindex="-1" id="modal-common">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<!-- Modal Content Code -->
<div class="modal fade" tabindex="-1" id="modalFormErrors">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Validation Failed</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-icon">
                    <em class="icon ni ni-cross-circle"></em> Please fix the following errors to save the Child Copy.
                </div>
                <ul class="list-unstyled mt-3" id="form-errors"></ul>
                <div class="nk-modal-action mt-4 text-center">
                    <a href="#" class="btn btn-lg btn-mw btn-light" data-dismiss="modal">Return</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endIfBackEnd
