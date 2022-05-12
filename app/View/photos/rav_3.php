<tr>
<?php foreach(array_slice($report['data']['rav'], 6, 4) AS $image) { ?>
    <td class="p-0 align-top" style="width: 25%">
        <div class="text-center fw-bold pt-1 fs-13"><span class="placeholder-empty"><?= $image['heading'] ?></span></div>
        <div class="text-center p-2 align-top">
            <?php if ($image['image']) { ?>
            <img class="mt-0" src="<?= (config('app.url') . config('app.asset_url') . 'images/child/' . $report['id'] . '/rav/' . $image['image']) ?>" alt="" style="object-fit: contain; width: 100%; max-height: 225px">
            <?php } ?>
        </div>
    </td>
<?php } ?>
</tr>
