<?php foreach ($report['data']['adr_mods'] AS $mod) { ?>
<tr>
    <td><?= $mod['adr_number'] ?></td>
    <td><?= $mod['description'] ?></td>
    <td>
        <?php foreach ($mod['part_numbers'] AS $part_number) { ?>
        <?php if ($part_number === 'TP') {
            echo 'TP-' . $report['model_code'];
        } else if (in_array($part_number, ['VIN', 'RVSA SVIL', 'USB'])) {
            echo $part_number . (!empty($vin) ? '-' . $vin : '-[VIN]');
        } else {
            echo $part_number;
        } ?>
        <br />
        <?php } ?>
    </td>
</tr>
<?php } ?>
