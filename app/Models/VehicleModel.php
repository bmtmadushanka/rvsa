<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleModel extends Model
{
    use HasFactory, SoftDeletes, CommonTrait;

    public $timestamps = false;
    protected $fillable = ['is_active', 'make_id', 'name'];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function make()
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function getStatusAttribute()
    {
        return $this->format_catalog_status_attribute($this->attributes['is_active']);
    }
}
