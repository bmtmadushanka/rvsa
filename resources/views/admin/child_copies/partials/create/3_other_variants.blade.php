@if ($prefix === 'post')
    <div class="custom-control pt-1 mb-3 ml-3 custom-control-xs custom-checkbox">
        <input type="checkbox" class="custom-control-input skip" name="post_visible_columns[variant]" value="1" {{ in_array('variant', $visible_columns) ? 'checked=checked' : '' }} id="{{ $prefix }}-mods-variants">
        <label class="custom-control-label" for="{{ $prefix }}-mods-variants">Add other variants to post modifications</label>
    </div>
@endif
<table class="table table-bordered border-outer-none">
    <tbody>
    @foreach ($other_variants AS $id => $other_variant)
        <tr>
            <td class="align-middle" style="width: 330px">{{ $other_variant }}</td>
            <td class="align-middle" style="width: 150px">
                <div class="form-check form-check-inline pt-1">
                    <input class="form-check-input radio-other-variant" name="{{ $key }}[other_variant]" type="radio" id="{{ $prefix }}-radio-other-variant-{{ $id }}" value="{{ $id }}" {{ isset($childCopy->data['other_variant']) && $childCopy->data['other_variant'] == $id ? 'checked=checked' : '' }}>
                    <label class="form-check-label" for="{{ $prefix }}-radio-other-variant-{{ $id }}">Yes</label>
                </div>
            </td>
            <td>
                @if (isset($childCopy->data['other_variant']) && $childCopy->data['other_variant'] == $id)
                    <input class="form-control skip input-other-variant" type="text" name="{{ $key }}[other_variant_value]" value="{{ $childCopy->data['other_variant_value'] ?? '' }}" maxlength="150" autocomplete="off"/>
                @else
                    <input class="form-control skip input-other-variant" type="text"  disabled maxlength="150" autocomplete="off"/>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $('body').on('click', '.radio-other-variant', function() {
            let $$ = $(this);
            $('.input-other-variant').each(function() {
                $(this).val('').attr('disabled', 'disabled').removeAttr('name');
            });
            $$.closest('td').next().find('input').removeAttr('disabled').attr('name', "{{ $key }}[other_variant_value]");
        });
    })
</script>
