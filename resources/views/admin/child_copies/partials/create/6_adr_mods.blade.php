<table class="table table-bordered border-outer-none">
    <thead>
    <tr>
        <th class="text-center" style="width: 150px">ADR No.</th>
        <th class="text-center">Description of Modification</th>
        <th class="text-center">Part No</th>
        <th class="text-center" style="width: 110px">Sort Order</th>
        <th class="text-center" style="width: 40px"><button type="button" id="add-adr" class="btn btn-sm btn-success"><em class="icon ni ni-plus-sm"></em></button> </th>
    </tr>
    </thead>
    <tbody>
    <tr style="display: none" data-id="0">
        <td style="width: 100px">
            <select class="form-control w-100 skip adr-mod-number" name="adr_mods[adr_number][0]" style="width: 200px">
                <option></option>
                @foreach ($adr_mods AS $mod)
                    <option value="{{ $mod->adr_number }}">{{ $mod->adr_number }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select class="form-control w-100 skip" name="adr_mods[description][0]" style="width: 200px">
                <option></option>
                @foreach ($adr_mods AS $mod)
                    <option value="{{ $mod->description }}">{{ $mod->description }}</option>
                @endforeach
            </select>
        </td>
        <td style="width: 300px">
            <select class="form-control skip" multiple name="adr_mods[part_number][0][]">
                <option></option>
                <option>TP-ZWE211W</option>
                <option>VIN</option>
                <option>RVSA SVIL</option>
                <option>ABPIC</option>
                <option>73-N</option>
                <option>PB</option>
            </select>
        </td>
        <td class="align-middle">
            <input type="text" class="form-control text-right skip" name="adr_mods[sort_order][0]" value=""/>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger btn-remove-adr"><em class="icon ni ni-cross-sm"></em> </button>
        </td>
    </tr>
    @if (isset($childCopy))
        @foreach($childCopy->data['adr_mods'] AS $adr_mod)
            <tr data-id="{{ $loop->iteration }}">
                <td style="width: 100px">
                    <select class="form-control selectize adr-mod-number skip w-100" name="adr_mods[adr_number][{{ $loop->iteration }}]" style="width: 200px">
                        <option value="{{ $adr_mod['adr_number'] }}" selected="selected">{{ $adr_mod['adr_number'] }}</option>
                        @foreach ($adr_mods AS $mod)
                            <option value="{{ $mod->adr_number }}">{{ $mod->adr_number }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control selectize skip w-100" name="adr_mods[description][{{ $loop->iteration }}]" style="width: 200px">
                        <option value="{{ $adr_mod['description'] }}" selected="selected">{{ $adr_mod['description'] }}</option>
                        @foreach ($adr_mods AS $mod)
                            <option value="{{ $mod->description }}">{{ $mod->description }}</option>
                        @endforeach
                    </select>
                </td>
                <td style="width: 300px">
                    <select class="form-control selectize skip" multiple name="adr_mods[part_number][{{ $loop->iteration }}][]">
                        @foreach($adr_mod['part_numbers'] AS $part_number)
                            <option value="{{ $part_number }}" selected="selected">{{ $part_number }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control text-right skip" name="adr_mods[sort_order][{{ $loop->iteration }}]" value="{{ $adr_mod['sort_order'] }}" />
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger btn-remove-adr"><em class="icon ni ni-cross-sm"></em> </button>
                </td>
            </tr>
        @endforeach
    @else
        <tr data-id="1">
            <td style="width: 100px">
                <select class="form-control selectize adr-mod-number skip w-100" name="adr_mods[adr_number][1]" style="width: 200px">
                    <option></option>
                    @foreach ($adr_mods AS $mod)
                        <option value="{{ $mod->adr_number }}">{{ $mod->adr_number }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control selectize skip w-100" name="adr_mods[description][1]" style="width: 200px">
                    <option></option>
                    @foreach ($adr_mods AS $mod)
                        <option value="{{ $mod->description }}">{{ $mod->description }}</option>
                    @endforeach
                </select>
            </td>
            <td style="width: 300px">
                <select class="form-control selectize skip" multiple name="adr_mods[part_number][1][]">
                    <option></option>
                    <option value="TP">TP-ZWE211W</option>
                    <option value="VIN">VIN</option>
                    <option value="RVSA SVIL">RVSA SVIL</option>
                    <option value="ABPIC">ABPIC</option>
                    <option value="73-N">73-N</option>
                    <option value="PB">PB</option>
                </select>
            </td>
            <td class="align-middle">
                <input type="text" class="form-control text-right skip" name="adr_mods[sort_order][1]" value="1" />
            </td>
            <td></td>
        </tr>
    @endif
    </tbody>
</table>
<script>
    $(function() {
        $('body').on('click', '#add-adr', function() {
            let tbody = $(this).closest('table').find('tbody')
            let elem = tbody.find('tr:first').clone();
            let rowCount = parseFloat(tbody.find('tr:last').attr('data-id')) + 1;
            elem.attr('data-id', rowCount);
            elem.find('select, input').each(function() {
                $(this).attr('name', $(this).attr('name').replace('0', rowCount));
            })
            elem.find('input').each(function() {
                $(this).val(rowCount);
            })
            tbody.append(elem.show())
            let tr = tbody.find('tr:last-child');
            tr.find('select').addClass('selectize');
            activateSelectize(tr)
        });

        $('body').on('click', '.btn-remove-adr', function() {
            $(this).closest('tr').fadeOut(function(){
                $(this).remove()
            })
        });
    });
</script>
