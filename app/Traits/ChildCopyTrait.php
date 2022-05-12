<?php

namespace App\Traits;

use App\Models\EngineCapacity;
use App\Models\EngineConfiguration;
use App\Models\EngineInduction;
use App\Models\EngineMotivePower;
use App\Models\TransmissionDriveTrainConfig;
use App\Models\TransmissionModel;
use App\Models\VehicleBodyType;
use App\Models\VehicleCategory;
use App\Models\VehicleMake;
use App\Models\VehicleRecallCheckLink;
use App\Models\VehicleSteeringLocation;
use App\Models\VehicleVinLocation;

trait ChildCopyTrait
{
    private $photo_headings = [
        1 => 'A - Front Right View',
        2 => 'A - Left Rear View',
        3 => 'C - Interior Front',
        4 => 'C - Interior Rear',
        5 => 'C - Interior Dash',
        6 => 'C - Odometer',
        7 => 'D - Under the bonnet',
        8 => 'E - Under the body full',
        9 => 'E - Under the body front',
        10 => 'E - Under the body rear',
    ];

    private $other_variants = [
        1 => 'Mobility Criterion',
        2 => 'Performance Criterion',
        3 => 'Rarity Criterion',
        4 => 'Campervans & Motorhome Criterion',
        5 => 'Left-hand Criterion',
        6 => 'Environmental Criterion',
    ];

    public function get_photo_headings()
    {
        return $this->photo_headings;
    }

    public function get_other_variants()
    {
        return $this->other_variants;
    }

    private function get_common_data()
    {
        return [
            'vin_locations' => VehicleVinLocation::active()->orderBy('name')->pluck('name'),
            'makes' => VehicleMake::active()->orderBy('name')->pluck('name'),
            'categories' => VehicleCategory::active()->orderBy('name')->pluck('name'),
            'body_types' => VehicleBodyType::active()->orderBy('name')->pluck('name'),
            'check_links'=> VehicleRecallCheckLink::active()->orderBy('name')->pluck('name'),
            'steering_locations' => VehicleSteeringLocation::active()->orderBy('name')->pluck('name'),

            'engine_capacity' => EngineCapacity::active()->orderBy('name')->pluck('name'),
            'engine_configs' => EngineConfiguration::active()->orderBy('name')->pluck('name'),
            'motive_power' => EngineMotivePower::active()->orderBy('name')->pluck('name'),
            'induction_types' => EngineInduction::active()->orderBy('name')->pluck('name'),

            'transmission_models' => TransmissionModel::active()->orderBy('name')->pluck('name'),
            'transmission_configs' => TransmissionDriveTrainConfig::active()->orderBy('name')->pluck('name'),
            'other_variants' => $this->get_other_variants()
        ];
    }


    public function duplicate_child_copy($child_copy, $duplicate_ards = FALSE,  $master_copy_id = NULL)
    {
        // duplicate child copy
        $new_child_copy = $child_copy->replicate();
        $new_child_copy->is_active = 0;
        $new_child_copy->version = date('dmY-Hi');
        $new_child_copy->approval_code = NULL;
        $new_child_copy->created_by = auth()->user()->id;

        if ($master_copy_id) {
            $new_child_copy->master_copy_id = $master_copy_id;
        }

        $new_child_copy->save();

        // duplicate ADRs
        if ($duplicate_ards) {
            $new_child_copy->adrs()->createMany($child_copy->adrs->toArray());
        }

        // duplicate mods
        $new_child_copy->mods()->createMany($child_copy->mods->toArray());

        return $new_child_copy;
    }

}
