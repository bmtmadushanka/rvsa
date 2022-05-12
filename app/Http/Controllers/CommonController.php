<?php

namespace App\Http\Controllers;

use App\Models\VehicleMake;
use App\Traits\CommonTrait;

class CommonController
{
    use CommonTrait;

    public function get_models($name)
    {
        $make = VehicleMake::firstWhere('name', $name);

        if ($make) {
            $models = $make->models()->orderBy('name')->pluck('name', 'id')->toArray();
            array_unshift($models, []);
        } else {
            $models = [];
        }
        return $this->ajax_msg('success', '', $models);

    }

}
