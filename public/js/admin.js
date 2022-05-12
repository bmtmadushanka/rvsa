const drawer = {
    position: "right",
    push: !1,
    overlay: !1,
};

const drawerSm = $("#drawerSm").slideReveal($.extend(drawer, { width: "35%" })),
      drawerMd = $("#drawerMd").slideReveal($.extend(drawer, { width: "60%" })),
      drawerLg = $("#drawerLg").slideReveal($.extend(drawer, { width: "75%" })),
      drawerXl = $("#drawerXl").slideReveal($.extend(drawer, { width: "90%"}));

$(function(){

    $('body').on('click', '.nav-item-global', function () {
        showDrawer($(this).data('entity'));
    });

    $('body').on('click', '.btn-refresh-global-entity', function (e) {
        showDrawer($(this).data('target'));
    });

    $('body').on('click', '.btn-add-global-entity', function () {

        let $$ = $(this);
        let entity = $$.data('entity');

        let form = $$.closest('.drawer').find('form.manage-global-entity');
        $$.closest('.drawer').animate({
            scrollTop: form.offset().top + 500
        }, 500);

        $$.closest('.drawer').find('.card').slideDown('fast');
        $$.closest('.drawer').find('.card-header').text('Add a New ' + entity.ucwords());

        form.attr('action', form.data('target'))
            .find('input[name=_method]').val('post').end()
            .find('input[name=name]').val('');

        form.find('div.feedback').html('').removeClass('invalid-feedback');
        form.find('input').removeClass('is-invalid');

        if ($.inArray(entity, ['vehicle-model', 'adr-mod']) !== -1) {
            activateSelect2(form);
        } else {
            form.find('input[name=name]').focus();
        }

    });

    $('body').on('click', '.btn-edit-global-entity', function (e) {

        e.preventDefault();
        let $$ = $(this);
        let entity = $$.data('entity');
        let id = $$.data('id');

        let form = $$.closest('.drawer').find('form.manage-global-entity');

        $$.closest('.drawer').animate({
            scrollTop: form.offset().top + 500
        }, 500);

        $$.closest('.drawer').find('.card').slideDown('fast');
        $$.closest('.drawer').find('.card-header').text('Edit the ' + entity.ucwords());

        form.attr('action', form.data('target') + '/' + id)
            .find('input[name=_method]').val('patch').end()
            .slideDown('fast');

        if (entity === 'adr-mod') {
            form.find('textarea[name=description]').val($$.closest('td').prev().text()).select().focus().end();
            form.find('input[name=adr_number]').val($$.closest('td').prev().prev().text()).select().focus().end();
        } else {
            if (entity === 'vehicle-model') {
                form.find('select').val($$.data('make-id'));
                activateSelect2(form);
            }
            form.find('input[name=name]').val($$.closest('td').prev().text()).select().focus().end();
        }
        form.find('input[name=is_active]').prop('checked', $$.closest('tr').find('input[name=is_active]').val() == 1 ? true : false).change();

        form.find('div.feedback').html('').removeClass('invalid-feedback');
        form.find('input').removeClass('is-invalid');

    });

    $('body').on('click', '.btn-delete-global-entity', function (e) {

        e.preventDefault();
        let $$ = $(this);
        let target = $$.data('target');
        let id = $$.data('id');

        Swal.fire(confirmSwal('Are you sure that you want to delete the record? Once done, the action cannot be undone.')).then((result) => {
            if (result.value) {
                $.ajax({
                    cache: false,
                    method: 'DELETE',
                    type: 'DELETE',
                    url: APP_URL + 'admin/catalog/'+ target + '/' + id,
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
                            showDrawer(target);
                        }
                    } else {
                        notify('error', 'We have encountered an error. Please contact your System Administrator');
                    }
                }).fail(function (xhr, status) {
                    handler(xhr, status)
                })
            }
        });
    });

    $('body').on('change', 'form select.vehicle-make', function (e) {

        e.preventDefault();
        let $$ = $(this);

        let selModel = $$.closest('div.accordion').find('select.vehicle-model');
        if (selModel[0].selectize) {
            selModel[0].selectize.destroy();
        }

        if ($$.val().length == 0) {
            selModel.find('option').remove().end().append($("<option></option>").text('Select the Make'));
            return false;
        }

        selModel.find('option').remove().end().append($("<option></option>").text('Loading...'));

        $.ajax({
            cache: false,
            url: APP_URL + 'catalog/models/' + $(this).val(),
            timeout: 20000
        }).done(function (j) {
            if (typeof j.status !== 'undefined') {
                if (typeof j.msg !== 'undefined') {
                    notify(j.status, j.msg);
                }
                if (typeof j.data != undefined) {
                    selModel.find('option').remove();
                    if (typeof j.data != 'undefined') {

                        $.each(j.data, function (key, value) {
                            selModel.append($("<option></option>").attr('value', value).text(value));
                        });
                    }
                    activateSelectize(selModel.closest('div'));
                }
            } else {
                notify('error', 'We have encountered an error. Please contact your System Administrator');
            }
        }).fail(function (xhr, status) {
            handler(xhr, status)
        });
    });

    $('body').on('click', '.btn-update-user-status', function() {
        let $$ = $(this)
        if (!$$.data('value') == 1) {
            Swal.fire(confirmSwal('Are you sure that you want to suspend the user?, the action cannot be undone.')).then((result) => {
                if (result.value) {
                    toggleUserStatus($$)
                }
            });
        } else {
            toggleUserStatus($$)
        }
    });

    $('body').on('click', '.btn-show-version-changes', function() {
        let $$ = $(this);
        let url = $$.data('type') == 'child' ? 'admin/child-copy/' : 'admin/master-copy/';

        $.ajax({
            cache: false,
            url: url + $$.data('id') + '/version-changes',
            timeout: 20000
        }).done(function (j) {
            if (typeof j.status !== 'undefined') {
                if (typeof j.msg !== 'undefined') {
                    notify(j.status, j.msg);
                }
                if (typeof j.data != undefined) {
                    let myModal = $('#modal-common');
                    myModal.find('.modal-dialog').removeClass('modal-sm modal-lg').addClass('modal-xl');
                    myModal.find('.modal-content').html(j.data);
                    myModal.modal('show');
                }
            } else {
                notify('error', 'We have encountered an error. Please contact your System Administrator');
            }
        }).fail(function (xhr, status) {
            handler(xhr, status)
        });
    });

    $('body').on('click', '.btn-drawer-md-close', function() {
        drawerMd.slideReveal('hide'), $('#drawer-md .content').html('');
    })

    $('body').on('click', '.btn-drawer-sm-close', function() {
        drawerSm.slideReveal('hide'), $('#drawer-sm .content').html('');
    })

    $('body').on('click', 'div.input-group-date-picker', function() {
        $(this).find('input').data("DateTimePicker").show()
    })

});

function callback_manage_global_entity(j) {
    if (j.status === 'success') {
        $('#drawerSm').slideReveal('hide');
        showDrawer(j.data)
    }
}

function showDrawer(entity) {
    let drawerSize = 'sm';
    if ($.inArray(entity, ['vehicle/model', 'vehicle/recall-check-link', 'adr/mod']) !== -1) {
        drawerSize = 'md';
    }
    revealDrawer(drawerSize, 'admin/catalog/' + entity);
}

function revealDrawer(e, t, n = [], m=[]) {
    if (m.length > 0) {
        loadingButton(m)
    }
    let i = "#drawer" + e.ucfirst(),
        r = $(i);
    r.find(".content").html('<div class="loading">Loading</div>'), r.slideReveal("show"), $.ajax({
        cache: !1,
        url: APP_URL + t,
        timeout: 2e4
    }).done(function(e) {
        if (void 0 !== e.status)
            if ("success" === e.status) {
                r.find(".content").html(e.data);
            } else notify("error", e.msg), r.slideReveal("hide");
        else notify("error", "We have encountered an error. Please contact your System Administrator")
    }).fail(function(e, t) {
        handler(e, t)
    }).always(function() {
        if (m.length > 0) {
            loadingButton(m, false)
        }
    });

    $('body').on('focusout', 'input.currency', function () {
        if ($(this).val().length === 0 || $(this).val() === '.') {
            $(this).val('0.00');
        }
    });
}

function activateSelect2(e = "body") {
    $(e).find('.form-select').select2({
        placeholder: "Click to select...",
        allowClear: true
    });
}

function activateSelectize(e = "body") {
    $(e).find('.selectize').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Click to select...',
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    })
}

function activateYearMonthPicker(e) {
    $(e).find('.year-month-picker').datetimepicker({
        format: "MM/Y",
        viewMode: "months"
    })
}

function activateDatePicker(e = 'body') {
    $(e).find('.date-picker').datetimepicker({
        format: "Y-MM-DD",
    })
}

function toggleUserStatus($$)
{
    loadingButton($$);

    $.ajax({
        cache: false,
        method: 'POST',
        url: APP_URL + 'admin/user/'+ $$.data('user') + '/update-status',
        timeout: 20000,
        data: {
            '_token': $('meta[name=csrf-token]').attr('content'),
            'data': {
                'value': !($$.data('value') == 1),
                'module': $$.data('module')
            }
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
            notify('error', 'We have encountered an error. Please contact your IT Department');
        }
    }).fail(function (xhr, status) {
        handler(xhr, status)
    }).always(function () {
        loadingButton($$, false);
    })
}

function validateChildCopyInputs(btn, childCopyId = 0, variantID = -1) {

    let form = btn.closest('form');
    let errors = [];
    let validElements = 'input:text:not(.skip), select:not(.skip)';

    if (!childCopyId) {
        validElements += ', input:file:not(.skip)';
    }

    // validate inputs
    form.find(validElements).each(function () {
        let name = $(this).attr('name');
        if ($.inArray($.trim(name.replace(/[\[|\]_]/g, '')), ['adrmodsnumber', 'adrmodsdescription', 'adrmodspartnumber']) == -1) {
            let value = $.trim($(this).val());
            if (!value.length) {
                let elem = $.trim((name.replace(/[\[|\]_]/g, ' ')).replace(/\s\s+/g, ' ').ucwords()).replace(/Gen/g, '').replace();
                errors.push(elem + ' is required and cannot be empty');
            }
        }
    });

    // validate radios
    form.find('div.radio-group').each(function () {
        let name = $(this).find('input:not(.skip):first').attr('name');
        let value = $('input[name="' + name + '"]:checked').val();
        if (!value) {
            let elem = $.trim((name.replace(/[\[|\]_]/g, ' ')).replace(/\s\s+/g, ' ').ucwords()).replace(/Gen/g, '').replace();
            errors.push(elem + ' is required and cannot be empty');
        }
    });

    if (variantID == -1) {
        // format ADR Related Mods
        //data.adr_mods = [];
        form.find('select.adr-mod-number').each(function (i, v) {
            if (i > 0) {
                let $$ = $(this);
                let value = $.trim($$.val());
                let description = $.trim($$.closest('td').next().find('select').val());
                let partNumbers = $.trim($$.closest('td').next().next().find('select').val());

                if (!value || !description || !partNumbers) {
                    errors.push('Invalid ADR related modifications. All columns are required');
                    return false;
                }
            }
        })

        // validate ADRs
        if (!form.find('input[name="adrs[]"]:checked').length) {
            errors.push('ADRs are not selected. Please select related ARDs from the given list.');
         }
    }

    // report errors
    if (errors.length > 0) {
        let errorList = $('ul#form-errors');
        errorList.html('');
        $.each(errors, function(i, v) {
            errorList.append('<li>'+ v +'</li>')
        });
        $('#modalFormErrors').modal('show');

    } else {

        if (childCopyId) {
            Swal.fire(confirmSwal('Do you want to do save the changes as a new version?', true)).then((result) => {
                if (result.value) {
                    form.find('input[name="is_new_version"]').val(1);
                }
                if (typeof result.value != 'undefined') {
                    form[0].submit();
                }
            });
        } else {
            form[0].submit();
        }
    }

    loadingButton(btn, false);

}
