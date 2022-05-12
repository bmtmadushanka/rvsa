<?php

namespace App\Models;

use App\Traits\UserActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory, UserActivityTrait;

    public $timestamps = FALSE;
    protected $guarded = [];
    protected $appends = ['heading', 'description'];

    public function getHeadingAttribute()
    {
        return $this->getActivities()[$this->attributes['activity_id']];
    }

    public function getDescriptionAttribute()
    {
        switch ($this->attributes['activity_id']) {
            case 2: {
                //return $this->
            }
        }
    }

}
