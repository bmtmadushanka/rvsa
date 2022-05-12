<style>
    .text-center { text-align: center !important }
    .text-left { text-align: left !important }
    h3 { margin-top: 0; font-size: 1.4em !important }
    h4 { margin-top: 0; font-size: 1.25em !important }
    .ml-75 { margin-left: 100px }
    .m-0 { margin: 0px }
    /*.mt-3 { margin: 15px !important; }
    .mb-0 { margin: 0px }*/
    .mr-3 { margin-right: 15px }
    .d-inline-block { display: inline-block }
    .border-0 { border: 0 }
    .border-bottom-0 { border-bottom: 0}

    @if (!$attach_evidence)
    .adr-content {
        display: none;
    }
    @endif

    .border-0 {
        border: hidden !important;
    }

    table { page-break-inside: auto; max-width: 100%}
    .border-bottom { border-bottom: 1px solid #000 }
    .border-top { border-top: 1px solid #000 }
    .border-left { border-left: 1px solid #000 }
    .border-right { border-right: 1px solid #000 }
    .p-1 { padding: 5px }

    .adr-content {
        padding-left: 10px;
        padding-right: 10px;
        padding-bottom: 10px;
        border-left: 1px solid #333; border-right: 1px solid #555;
        text-align: justify;
        line-height: 1.15;
    }

    #table-adr-default {
        width: 1009px !important;
        max-width: 1009px !important;
    }

    #table-adr-default tbody td {
        padding: 5px;
        vertical-align: top;
    }

    #table-adr-default .w-75px {
        width: 75px !important;
        min-width: 80px !important;
    }

    table tr td img:not(.mt-0) {
        margin-top: 15px !important;
    }

    #table-adr-default tbody td:last-child table, #table-adr-default tbody td:nth-last-child(2) table {
        width: 10px;
    }

    #table-adr-default tbody td:last-child table td span:first-child, #table-adr-default tbody td:nth-last-child(2) table td span:first-child {
        margin-left: 10px !important;
    }

    div.photo-section {
        page-break-before: always
    }

    #table-adr-default img {
        margin-top: 10px !important;
    }

    div.photo-section table {
        margin-top: 10px;
        width: 100% !important;
        max-width: 100% !important;
    }

    div.photo-section img{
        margin: 0px !important;
        padding: 10px !important;
        max-width: 310px;
    }

    div.photo-section td {
        text-align: center !important;
        vertical-align: top !important;
    }

    .page-adr .checkbox {
        top: 5px;
    }

    #table-adr-default table td .checkbox-inline {
        top: -5px
    }

    .page-adr .float-right {
        position: absolute;
        right: 40px !important;
    }

    .section-evidence p {
        margin : 0px
    }

    .section-evidence .page h4:first-child {
        margin-top:0px !important;
    }

    .page-adr p {
        margin: 0 0 0.3em;
    }

</style>
<div class="page-adr page-content {{ !$adr->is_common_adr ? 'border-top' : '' }}  {{ $attach_evidence ? 'border-bottom' : '' }}" {{ !isset($ignore_page_breaks) && $adr->is_common_adr ? 'style="page-break-before: always"' : '' }}>
    @if ($adr->is_common_adr)
    <div>
        <h2>Evidence Details for other National Standards</h2>
    </div>
    @endif<div class="p-1 border-left border-right {{ $adr->is_common_adr ? 'border-top' : '' }}">
        <h3 class="m-0">
            @if (!$adr->is_common_adr)
                <span class="mr-4">ADR {{ $adr['number'] }}</span>
            @endif
            {{ $adr['name'] }}
        </h3>
    </div>
    <?php
        $matches = [
            '@<td[^>]+><br><\/td>@i',
            '@<td[^>]+>&nbsp;<\/td>@i',
        ];
    ?>
    <?php eval("?>" . preg_replace($matches, '<td><span style="color: #fff">X</span></td>', html_entity_decode(json_decode($adr['html']))) . "<?php ") ?>
    @if ($attach_evidence)
        @unless(empty($adr['evidence']))
            @foreach ($adr['evidence'] AS $name => $description)
                <div class="section-evidence border-left border-right {{ Str::snake($name) === 'photograph_section' ? 'photo-section' : '' }}" style="padding: 5px 10px 10px">
                    <h4 class="m-0">{{ $name }}</h4>
                    <div style="margin-bottom: 35px !important">
                        <p>
                            {!! $description !!}
                        </p>
                    </div>
                </div>
            @endforeach
        @endunless
    @endif
</div>
