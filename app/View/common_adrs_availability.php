<?php if(empty($report->adrs->where('is_common_adr', 1)->count())) { ?>
    <p>Note> There are no National Standards used in this Model Report. </p>
<?php } ?>
