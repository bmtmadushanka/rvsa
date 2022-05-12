<?php foreach ($mods['vehicle']['dimensions'] AS $type => $dimension) { ?>
<?php if ($type !== 'GC') { ?>
<span class="label ml-4"><?= $type ?>:</span> <?= $dimension ?> mm
<?php }} ?>
<br />
<span style="display: inline-block; margin-top: 10px">
    <span class="label ml-4">Running Clearance: </span> <?= $mods['vehicle']['dimensions']['GC'] ?> mm
</span>
