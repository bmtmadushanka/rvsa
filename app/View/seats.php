<table style="font-weight: bold; margin-left: 50px">
    <tbody>
    <tr>
        <?php foreach($mods['vehicle']['seats'] AS $k => $count) { ?>
        <td class="text-center" style="width: 60px">Row <?= $k ?></td>
        <td></td>
        <?php } ?>
        <td style="width: 200px"></td>
    </tr>
    <tr>
        <?php foreach($mods['vehicle']['seats'] AS $k => $count) { ?>
        <td class="text-center"><?= $count ?></td>
        <?php if ($k !== array_key_last($mods['vehicle']['seats'])) { ?>
        <td>+</td>
        <?php }} ?>
        <td>=</td>
        <td class="text-center pl-3">Seating Capacity: <?= array_sum($mods['vehicle']['seats']) ?></td>
    </tr>
    </tbody>
</table>
