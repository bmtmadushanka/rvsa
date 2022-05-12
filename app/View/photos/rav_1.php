<tr>
<?php foreach(array_slice($report['data']['rav'], 0, 2) AS $image) { ?>
<td class="p-0 align-top">
    <div class="text-center fw-bold pt-1 pb-2 fs-13"><span class="placeholder-empty"><?= $image['heading'] ?></span></div>
    <div class="text-center pb-3">
        <img class="mt-0" src="<?= (config('app.url') . config('app.asset_url') . 'images/child/' . $report['id'] . '/rav/' . $image['image']) ?>" alt="" style="object-fit: contain; width: 450px; max-height: 225px">
    </div>
</td>
<?php } ?>
</tr>
