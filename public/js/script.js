function redirect(e) {
    document.location.href = e
}

function loadingButton(e, t = !0, n = !0) {
    if (!0 === t) {
        let m = '<em class="icon ni ni-reload"></em>' + (!0 === n ? '&nbsp; Loading' : '');
        e.html() !== m && (e.attr('disabled', 'disabled'), e.data('original-text', e.html()), e.html(m))
    } else {
        e.removeAttr('disabled');
        e.html(e.data('original-text'));
    }
}

function handler(e, t) {
    "timeout" === t ? notify("error", "Error 408 - Oops! The request timeout") : 0 == e.readyState ? notify("error", "Error 0 - The request cannot be initialized. Please refresh the page") : 401 == e.status ? notify("error", "Error 401 - Your session has expired. Please refresh the page") : 403 == e.status ? notify("error", "Error 403 - Oops! You don't have permission to access this page or modify the content. Please contact your System Administrator for more information") : 404 == e.status ? notify("error", "Error 404 - The requested page is not found") : 405 == e.status ? notify("error", "Error 405 - Method is not allowed. Please refresh the page") : 419 == e.status ? notify("error", "Error 419 - Unknown Status. Please refresh the page") : 500 == e.status ? notify("error", "Error 500 - Internal Server Error. Please try again in a few minutes") : notify("error", "Unknown error occurred. Please contact your System Administrator")
}

function notify(e, t) {
    NioApp.Toast(t, e, {
        position: 'top-center'
    });
}


$(function () {

    $("body").on("submit", "form.ajax", function(e) {
        e.preventDefault();
        let t = $(this);
        t.find(".invalid-feedback").removeClass("invalid-feedback").text(""), t.find(".is-invalid").removeClass("is-invalid");
        let n = t.children(".loading"),
            i = t.attr("action"),
            r = t.attr("method"),
            a = t.find('[type="submit"]'),
            o = t.data("callback"),
            c = t.data("callfront");
        void 0 !== c && window[c](t), loadingButton(a), n.show(), $.ajax({
            cache: !1,
            method: r,
            url: APP_URL + i,
            contentType: !1,
            processData: !1,
            data: "GET" === r ? t.serialize() : new FormData(this),
            timeout: 2e4
        }).done(function(e) {
            let j = 0;
            void 0 !== e.status ? "validation" === e.status ? $.each(e.data, function(e, n) {
                t.find('[name*="' + e + '"]').addClass("is-invalid").closest("div.form-group").find("div.feedback").addClass("invalid-feedback").text(n).show();
                if (0 === j) {
                    t.find('[name*="' + e + '"]').focus();
                    j=1;
                }
            }) : (void 0 !== e.msg && notify(e.status, e.msg, "'undefined'" !== e.redirect ? "false" : "true"), void 0 !== e.redirect && setTimeout(function() {
                redirect(APP_URL + e.redirect)
            }, 500), void 0 !== o && window[o](e), globalChangesCount = 0) : notify("error", "We have encountered an error. Please contact your System Administrator")
        }).fail(function(e, t) {
            handler(e, t)
        }).always(function() {
            a.removeAttr("disabled"), a.html(a.data("original-text")), n.hide(), t.closest(".drawer").animate({
                scrollTop: t.offset().top
            }, 2e3);
        })
    })

    $('body').on('click', '.btn-delete-entity', function() {
        let $$ = $(this);
        loadingButton($$, true,false);
        Swal.fire(confirmSwal('Are you sure that you want to delete '+ $$.data('entity').ucfirst() +'? Once done, the action cannot be undone.')).then((result) => {
            if (result.value) {
                $.ajax({
                    cache: false,
                    method: 'DELETE',
                    type: 'DELETE',
                    url: $$.data('url') + '/' + $$.data('id'),
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
                        if (typeof j.redirect !== 'undefined') {
                            redirect(j.redirect);
                        }
                    } else {
                        notify('error', 'We have encountered an error. Please contact your System Administrator');
                    }
                }).fail(function (xhr, status) {
                    handler(xhr, status)
                }).always(function() {
                    loadingButton($$, false);
                });
            }
        });
    });

    $('body').on('paste change keydown', 'input.floats', function(e) {
        formatNumberClass(e, !0, !0)
    })
    $('body').on('paste change keydown', 'input.currency', function(e) {
        formatNumberClass(e, !1, !0)
    })
    $('body').on('paste change keydown', 'input.unsigned-integer', function(e) {
        formatNumberClass(e)
    })
    $('body').on('paste change keyup', 'input.currency', function(e) {
        $(this).val(function(e, t) {
            return t.replace(/[^\d.-]|(?!^)/g, "").replace(/^(\d*\.)(.*)\.(.*)$/, "$1$2$3").replace(/\.(\d{2})\d+/, ".$1").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        })
    })

});

let swalConfirm = {
    title: 'Beware!',
    icon: 'warning',
    allowOutsideClick: false,
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'Cancel',
    denyButtonText: 'No',
    cancelButtonColor: '#243142',
    confirmButtonColor: '#d9534f',
    denyButtonColor: '#5469ea',
    focusCancel: true,
};

function confirmSwal(text, showDenyButton = false) {

    if (showDenyButton) {
        swalConfirm.showDenyButton = true;
    }

    swalConfirm.text = text;
    return swalConfirm;
}

String.prototype.ucfirst = function() {
    return this.charAt(0).toUpperCase() + this.substr(1)
}
String.prototype.ucwords = function() {
    return this.replace(/(?:-| |\b)(\w)/g, function(e, t) {
        return " " + t.toUpperCase()
    })
};

function formatNumberClass(e, t = !1, n = !1) {
    let i = [46, 8, 9, 27, 13];
    t && i.push(109, 189), n && i.push(110, 190), -1 !== $.inArray(e.which, i) || (65 == e.which || 67 == e.which || 88 == e.which || 86 == e.which || 90 == e.which) && !0 === e.ctrlKey || e.which >= 35 && e.which <= 39 || (e.shiftKey || e.which < 48 || e.which > 57) && (e.which < 96 || e.which > 105) && e.preventDefault()
}

