<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait AdrTrait
{
    public function update_adr($adr, $data)
    {
        $image_path = 'uploads/images/adr/' . ($adr->parent_adr_id ?? $adr->id);

        $data['content']['evidence'] = array_map(function($evidence) {
            return trim($evidence);
        }, array_filter($data['content']['evidence']));

        /*if (empty($data['content']['evidence'])) {
            return $this->ajax_msg('error', 'At least one evidence type is required');
        }*/

        $data['content']['description'] = trim(str_replace('<div>&nbsp;</div>', '', $data['content']['description']));
        $adr->update($data);

        $images = [];

        // sync images
        if (!empty($data['images']['url'])) {
            foreach ($data['images']['url'] AS $k => $url) {
                if ($k === 0) {
                    continue;
                }

                if (!empty($data['images']['files'][$k])) {
                    $file = $data['images']['files'][$k];
                    $images[$k]['url'] = $k . '_' . time().'.'. $file->extension();
                    $images[$k]['description'] = trim($data['images']['description'][$k]);
                    $file->move(public_path($image_path), $images[$k]['url']);
                    continue;
                }

                if ($data['images']['is_delete'][$k] == 0) {
                    $images[$k]['url'] = $url;
                    $images[$k]['description'] = trim($data['images']['description'][$k]);
                }

            }
        }

        $adr->update(['images' => $images]);

        return $adr;
    }

    public function format_adr_data(&$data)
    {
        $data['evidence'] = array_map(function ($evidence) {
            return trim($evidence);
        }, array_filter($data['content']['evidence']));

        $data['text'] = json_encode($data['content']['description']);
        $data['html'] = json_encode(htmlentities($this->replace_variables($data['content']['description'])));
        unset($data['content']);
    }

    private function replace_variables($html)
    {
        if (empty($html)) {
            return;
        }

        $html = trim(str_replace('<div>&nbsp;</div>', '', $html));
        $html = str_replace('<span class="checkbox">&nbsp;</span>&nbsp;','<input type="checkbox" class="checkbox checkbox-inline avvcheck">&nbsp;',$html);
        $html = str_replace('<span class="checkbox">&nbsp;</span></span></span>','<input type="checkbox" class="checkbox avvcheck">&nbsp;</span></span>',$html);
        $html = str_replace('<span class="checkbox">&nbsp;</span>','<input type="checkbox" class="checkbox rawcheck">',$html);
        $html = str_replace('<span class="checkbox checkbox-inline">&nbsp;</span>','<input type="checkbox" class="checkbox checkbox-inline rawcheck">&nbsp;',$html);
        $doc = new \DOMDocument();
        $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($doc);

        foreach (['h1', 'h2'] AS $tag)
        {
            $elements = $doc->getElementsByTagName($tag);
            foreach ($elements AS $element)
            {
                $element->setAttribute('id', Str::slug($element->nodeValue));
                $doc->saveHTML();
            }
        }

        $tags = $xpath->query("//*[@class='placeholder']");

        foreach ($tags as $tag) {
            $id = $tag->getAttribute('data-id');
            if ($id == 1) {
                $tag->nodeValue = '<?php echo $adr_reference ?>';
            }
            if ($id == 2) {
                $tag->nodeValue = '<?php echo $_vin ?? "[VIN]" ?>';
            }
        }

        return $doc->saveHTML();

    }

    private function is_common_adr($number)
    {
        if ((float)(str_replace('/', '.', $number) > 1000)) {
            return true;
        } else {
            return false;
        }
    }
}
