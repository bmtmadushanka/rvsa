<div class="mt-5 pt-5 border-top">
    <div class="row">
        <div class="col-md-6">
            <div class="p-2 text-center border bg-gray-100 font-weight-bold mb-4">
                RESET CLIENT'S PASSWORD
            </div>
            <div class="help-block text-muted">An email with password reset link will be sent to client's personal email.</div>
            <div class="text-center">
                <form class="form ajax" method="post" action="admin/client/{{ $user->id }}/reset-password">
                    @csrf
                    <button type="button" class="mt-3 btn btn-lg btn-outline-danger" id="btn-reset-password">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('body').on('click', '#btn-reset-password', function() {
            let $$ = $(this);
            Swal.fire(confirmSwal('Are you sure that you want to reset the password?')).then((result) => {
                if (result.value) {
                    $$.closest('form').submit();
                }
            });
        })
    });
</script>
