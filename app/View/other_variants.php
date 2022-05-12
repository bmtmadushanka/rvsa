<ul style="list-style: none; padding-left: 0; margin-top: -5px">
    <?php foreach ($other_variants AS $id => $other_variant) { ?>
        <li class="mt-2"><b><?= $other_variant ?>:</b> <?= $report['data']['other_variant'] == $id ? ' Yes' : ' No' ?>
        <?= $report['data']['other_variant'] == $id && !empty($report['data']['other_variant_value']) ? ' - ' . $report['data']['other_variant_value'] : '' ?>
    </li>
    <?php } ?>
</ul>
