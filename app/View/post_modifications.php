<div class="page-content">
<div class="mb-3">
    <?php include(app_path() . "/View/variant_heading.php") ?>
</div>
<?php if (!empty($visible_columns)) { ?>
    <h2>Vehicle Details</h2>
    <?php if (in_array('sev_no', $visible_columns)) { ?>
    <div class="mb-3">
        <b>SEVs Entry No:</b> SEV-<?= $mods['vehicle']['sev_no'] ?>
    </div>
    <?php } ?>
    <?php if (in_array('vin_location', $visible_columns)) { ?>
    <div class="mb-3" style="position: relative">
        <span class="label">OEM VIN No:</span>
        <span style="position: absolute">
            <div style="position: relative; bottom: 10px;">
                <span class="placeholder-box"></span>
            </div>
        </span>
        <span class="label" style="margin-left: 180px">Location:</span><?= $mods['vehicle']['vin_location'] ?>
    </div>
    <?php } ?>
    <?php if (in_array('make', $visible_columns) || in_array('model', $visible_columns) || in_array('model_code', $visible_columns)) { ?>
    <div class="mb-3">
        <?php if (in_array('make', $visible_columns)) { ?>
        <span class="label">Make:</span><?= $mods['vehicle']['make'] ?>
        <?php } ?>
        <?php if (in_array('model', $visible_columns)) { ?>
        <span class="label <?= in_array('make', $visible_columns) ? 'ml-4 pl-4' : ''?>">Model:</span><?= $mods['vehicle']['model'] ?>
        <?php } ?>
        <?php if (in_array('model_code', $visible_columns)) { ?>
        <span class="label <?= in_array('make', $visible_columns) || in_array('model', $visible_columns) ? 'ml-4' : ''?>">Model Code:</span><?= $mods['vehicle']['model_code'] ?>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if (in_array('category', $visible_columns) || in_array('body_type', $visible_columns) || in_array('build_range', $visible_columns)) { ?>
    <div class="mb-3">
        <?php if (in_array('body_type', $visible_columns)) { ?>
        <span class="label">Body Shape:</span><?= $mods['vehicle']['body_type'] ?>
        <?php } ?>
        <?php if (in_array('category', $visible_columns)) { ?>
        <span class="label <?= in_array('body_type', $visible_columns) ? 'ml-4' : ''?>">Category:</span><?= $mods['vehicle']['category'] ?>
        <?php } ?>
        <?php if (in_array('build_range', $visible_columns)) { ?>
        <span class="label <?= in_array('body_type', $visible_columns) || in_array('category', $visible_columns) ? 'ml-4' : ''?>">Build Range:</span><?= $mods['vehicle']['build_range_starts'] ?> to <?= $mods['vehicle']['vin_location'] ?? 'Current' ?>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if (in_array('mass', $visible_columns)) { ?>
    <div class="mb-3">
        <span class="label">Unladened Mass <span style="font-weight: normal">(Tare + fuel):</span></span> <?= $mods['vehicle']['mass'] ?>
    </div>
    <?php } ?>
    <?php if (in_array('steering_location', $visible_columns)) { ?>
    <div>
        <span class="label">Steering Location</span> <?= $mods['vehicle']['steering_location'] ?>
    </div>
    <?php } ?>
    <?php if (in_array('seats', $visible_columns) || in_array('doors', $visible_columns) || in_array('tyres', $visible_columns) || in_array('rims', $visible_columns)  || in_array('dimensions', $visible_columns)) { ?>
    <div style="margin-top: 5px">
        <h3>VARIANTS:</h3>
        <?php if (in_array('seats', $visible_columns)) { ?>
        <div class="mb-3">
            <span class="label float-left" style="margin-top: 2px; margin-right: 20px !important;">Seats:</span>
            <?php include(app_path() . "/View/seats.php") ?>
        </div>
        <?php } ?>
        <?php if (in_array('doors', $visible_columns)) { ?>
        <div class="mb-3">
            <span class="label">Side Doors:</span><?= $mods['vehicle']['doors']['side'] ?>
            <span class="label ml-4">Rear Doors/Hatch:</span><?= $mods['vehicle']['doors']['rear'] ?>
        </div>
        <?php } ?>
        <?php if (in_array('tyres', $visible_columns) || in_array('rims', $visible_columns)) { ?>
        <div class="mb-3">
            <?php if (in_array('tyres', $visible_columns)) { ?>
            <span class="label">Tyres:</span><?= $mods['vehicle']['tyre_code'] ?>
            <span class="label ml-4">Inflation pressures (kPa):</span>><?= $mods['vehicle']['tyre_pressure']['front'] ?> Rear <?= $mods['vehicle']['tyre_pressure']['rear'] ?>
            <?php } ?>
            <?php if (in_array('rims', $visible_columns)) { ?>
            <span class="label <?= in_array('tyres', $visible_columns) ? 'ml-4' : ''?>">Rim size & profile:</span><?= $mods['vehicle']['rim_size'] ?>
            <span class="label ml-4">Rim Offset:</span> +<?= $mods['vehicle']['rim_offset'] ?>mm
            <?php } ?>
        </div>
        <div class="mb-3">NOTE> Refer to ADR 42/05 (Vehicle Scope Work Instruction section) for other approved tire & rim options</div>
        <?php } ?>
        <?php if (in_array('dimensions', $visible_columns)) { ?>
        <div class="mb-3 clearfix">
            <span class="label float-left" style=" height: 50px">Major Dimensions:</span>
            <div class="float-left">
                <?php include(app_path() . "/View/dimensions.php") ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>
<div class="page-content">
    <?php if (in_array('engine', $visible_columns)) { ?>
    <div class="mb-3">
        <span class="label fs-14"><u>ENGINE MODEL: </u></span><span class="ml-2"> <?= $mods['engine']['model'] ?></span>
    </div>
    <div class="mb-3">
        <span class="label">Capacity:</span><?= $mods['engine']['capacity'] ?><strong>&nbsp;CC</strong>
        <span class="label ml-4">Configuration:</span><?= $mods['engine']['config'] ?>
        <span class="label ml-4">Motive Power:</span><?= $mods['engine']['motive_power'] ?>
        <span class="label ml-4">Induction:</span><?= $mods['engine']['induction_type'] ?>
    </div>
    <?php } ?>
    <?php if (in_array('transmission', $visible_columns)) { ?>
    <div class="mb-3" style="margin-top: 60px">
        <span class="label fs-14"><u>TRANSMISSION MODEL: </u></span><span class="ml-2"> <?= $mods['transmission']['model'] ?></span>
    </div>
    <div class="mb-3">
        <span class="label">Transmission Type:</span><?= $mods['transmission']['type'] ?>
        <span class="label ml-4">Drive Train Configuration:</span><?= $mods['transmission']['drive_train_config'] ?>
    </div>
    <?php } ?>
    <?php if (in_array('variant', $visible_columns)) { ?>
    <div style="margin-top: 60px">
        <span class="label fs-14"><u>OTHER VARIANTS</u></span>
        <div class="mt-4">
            <?php include(app_path() . "/View/other_variants.php") ?>
        </div>
    </div>
    <?php } ?>
<?php } else { ?>
    <div class="mt-1">
        <h2>Vehicle Details:</h2>
        <span class="mt-2">The vehicles scope for the pre-modification & post modification are identical in this instance.</span>
    </div>
<?php } ?>
</div>
