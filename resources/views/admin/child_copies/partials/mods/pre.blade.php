<div class="mb-5">
    <label class="label fw-500 modification-heading  mb-0 fs-16px">PRE Modification</label>
    <hr/>
    @if (isset($mod) && $mod->variant_id == 1)
        <div class="example-alert">
            <div class="alert alert-info alert-icon">
                <em class="icon ni ni-alert-circle"></em> General Variant has no PRE Modification.
            </div>
        </div>
    @else
    <div id="accordion-pre" class="accordion">
        @include('admin.child_copies.partials.create.vehicle_scope')
    </div>
    @endif
</div>

<script>
    $(function() {

        $('body').on('click', '#btn-add-variant', function() {
            let $$ = $(this);
            let wrapperVariant = $$.closest('div').next('div#wrapper-variant');

            let elemCount = wrapperVariant.find('div.template-variant').length + 1;
            let elem = wrapperVariant.find('div.template-variant').first().clone();

            elem.find('.accordion-head').each(function() {
                let target = $(this).attr('data-target');
                $(this).attr('data-target', target.replace('-0', '-' + elemCount))
            });

            elem.find('.accordion-body').each(function() {
                let id = $(this).attr('id');
                $(this).attr('id', id.replace('-0', '-' + elemCount))
            });

            elem.find('.modification-heading ').text('VARIANT ' + (elemCount-1))

            elem.find('input', 'select').each(function() {
                let name = $(this).attr('name');
                if (typeof name != "undefined") {
                    $(this).attr('name', name.replace('gen[vehicle][0', ('mods[pre][vehicle][' + elemCount)));
                }
            });

            $('div.accordion').hide();
            elem.find('.accordion').show();
            elem.find('.btn-remove-variant').removeClass('d-none');

            wrapperVariant.append(elem.show());

        });

        $('body').on('click', '.modification-heading ', function() {
            $(this).closest('div').find('div.accordion').slideToggle('fast');
        });

    });
</script>
