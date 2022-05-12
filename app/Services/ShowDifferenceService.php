<?php

namespace App\Services;


use cogpowered\FineDiff\Diff;
use cogpowered\FineDiff\Granularity\Word;
use cogpowered\FineDiff\Render\Html;
use cogpowered\FineDiff\Render\Text;

class ShowDifferenceService
{
    public function show($from, $to)
    {
        $granularity = new Word();
        $diff = new Diff($granularity);
        $opcodes = $diff->getOpcodes(strip_tags($from), strip_tags($to));

        $render = new Html();
        return html_entity_decode($render->process(strip_tags($from), $opcodes));

    }
}
