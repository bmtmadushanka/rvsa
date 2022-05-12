$(function() {
    $('body').on('click', '.btn-update-cart', function (e) {
        let $$ = $(this);
        let qty = 1;

        if ($.inArray($$.data('method'), ['update', 'buy_now']) !== -1) {
            loadingButton($$);

            qty = parseFloat($$.closest('table').find('input.qty[data-id="'+  $$.attr('data-id') +'"]').val());

            if (isNaN(qty) || qty < 1) {
                notify('error', 'Invalid Report Qty. Please enter a valid Qty value');
                loadingButton($$, false);
                return false;
            } else if (qty > 500) {
                notify('error', 'The report qty is too large. Maximum allowed qty is 500 reports per order');
                loadingButton($$, false);
                return false;
            }

        } else {
            loadingButton($$, true, false);
            e.stopPropagation();
        }

        let method = $.inArray($$.data('method'), ['update', 'buy_now']) !== -1 ? 'update' : 'delete';
        let url = APP_URL + 'cart/' + method + '/' + $(this).data('id')


        if ($$.data('method') === 'buy_now' || $$.data('refresh') === true) {
            url+= '?redirect=cart';
        }

        $.ajax({
            cache: false,
            method: 'POST',
            url: url,
            timeout: 20000,
            data: {
                'qty' : qty,
                '_token': $('meta[name=csrf-token]').attr('content'),
            },
        }).done(function (j) {
            if (typeof j.status !== 'undefined') {
                if (typeof j.msg !== 'undefined') {
                    notify(j.status, j.msg);
                }
                if (typeof j.data !== 'undefined') {
                    if ($$.data('method') === 'update') {
                        NioApp.Toast('The report was added to your cart successfully!', 'info', {
                            position: 'top-center'
                        });
                    }
                    $('div#mini-cart').html(j.data.cart);
                }
                if (typeof j.redirect !== 'undefined') {
                    redirect(j.redirect);
                }
            } else {
                notify('error', 'We have encountered an error. Please contact your IT Department');
            }
        }).fail(function (xhr, status) {
            handler(xhr, status)
        }).always(function () {
            loadingButton($$, false);
        })
    });
})
