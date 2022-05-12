<?php

namespace App\Traits;

trait VersionChangeTrait
{
    public function change_version_child_copy($child_copy, $new_child_copy, $new_adr_numbers = [], $deleted_adr_numbers = [])
    {
        // create a version history record
        $child_copy->refresh();
        $new_child_copy->refresh();

        $new_array = $this->flatten(collect($new_child_copy)->only(['data'])->toArray());
        $old_array = $this->flatten(collect($child_copy)->only(['data'])->toArray());

        $changes = $this->find_changes($old_array, $new_array);

        // Check ADRs
        $changes['adr_list']['added'] = [];
        $changes['adr_list']['removed'] = [];
        if ($new_adr_numbers) {
            $changes['adr_list']['added'] = $new_adr_numbers;
        }
        if ($deleted_adr_numbers) {
            $changes['adr_list']['removed'] = $deleted_adr_numbers;
        }

        if (empty($new_adr_numbers) && empty($deleted_adr_numbers)) {
            unset($changes['adr_list']);
        }

        $this->store_version_changes($new_child_copy, $changes, 'main', $child_copy->id);

    }

    public function change_version_adr($child_copy, $new_child_copy, $old_adr, $new_adr)
    {
        $old_adr->refresh();
        $new_adr->refresh();

        $new_array = $this->flatten(collect($new_adr)->only(['number', 'name', 'text', 'pdf', 'evidence'])->toArray());
        $old_array = $this->flatten(collect($old_adr)->only(['number', 'name', 'text', 'pdf', 'evidence'])->toArray());

        $new_array['content'] =  json_decode($new_array['text']);
        $old_array['content'] =  json_decode($old_array['text']);

        unset($new_array['text'], $old_array['text']);

        $changes = $this->find_changes($old_array, $new_array);
        $changes_new = $this->find_changes($new_array, $old_array);

        if ($changes_new) {
            foreach ($changes_new as $key => $change_new) {
                $changes[$key] = [
                    'old' => NULL,
                    'new' => $change_new['old']
                ];
            }
        }

        $this->store_version_changes($new_child_copy, $changes, 'adr', $old_adr->id);
    }

    public function change_version_master_copy($old_array, $new_array)
    {
        $changes = $this->find_changes($old_array, $new_array);
        $changes_new = $this->find_changes($new_array, $old_array);

        if ($changes_new) {
            foreach ($changes_new as $key => $change_new) {
                $changes[$key] = [
                    'old' => NULL,
                    'new' => $change_new['old']
                ];
            }
        }

        return $changes;
    }

    private function store_version_changes($model, $changes, $reference_type = NULL, $parent_id = NULL)
    {
        $model->versionChanges()->create([
            'reference_type' => $reference_type,
            'parent_id' => $parent_id ?? $model->id,
            'data' => $changes
        ]);
    }

    private function find_changes($old_array, &$new_array)
    {
        $changes = [];

        foreach ($old_array AS $key => $value) {

            if (preg_match('/adrs.\d+/', $key, $output_array)) {
                continue;
            }

            $new_key = preg_replace('/^(data.)/', '', $key);
            $changes[$new_key]['old'] = $value;
            $changes[$new_key]['new'] = NULL;

            if (isset($new_array[$key])) {
                if ($new_array[$key] == $value) {
                    unset($changes[$new_key]);
                } else if (empty($new_array[$key]) && empty($value)) {
                    unset($changes[$new_key]);
                } else {
                    $changes[$new_key]['new'] = $new_array[$key];
                }
                unset($new_array[$key]);
            } else if(is_null($changes[$new_key]['old'])) {
                unset($changes[$new_key]);
            }
        }

        return $changes;
    }

    private function flatten($array, $prefix = '') {
        $result = array();
        foreach($array as $key=>$value) {
            if(is_array($value)) {
                $result = $result + $this->flatten($value, $prefix . $key . '.');
            }
            else {
                $result[$prefix . $key] = $value;
            }
        }

        return $result;
    }

}
