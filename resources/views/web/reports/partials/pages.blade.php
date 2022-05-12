@if (!empty($report->indexes) && $page->sort_order == 2)
    <?php eval("?>" . html_entity_decode(str_replace('&nbsp;', ' ', json_decode($report->indexes[2]['html']))) . "<?php ") ?>
@elseif(!empty($report->indexes) && $page->blueprint_id == 29)
    <?php eval("?>" . html_entity_decode(str_replace('&nbsp;', ' ', json_decode($report->indexes[29]['html']))) . "<?php ") ?>
@else
    <?php eval("?>" . html_entity_decode(str_replace('&nbsp;', ' ', json_decode($page->html))) . "<?php ") ?>
@endif
