<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildCopyMod extends Model
{
    use HasFactory, SoftDeletes, CommonTrait;

    public $timestamps = FALSE;
    protected $fillable = ['variant_id', 'pre', 'post', 'post_visible_columns', 'sort_order', 'created_by'];
    protected $casts = ['pre' => 'array', 'post' => 'array', 'post_visible_columns' => 'array'];

    public function getStatusAttribute()
    {
        return $this->format_catalog_status_attribute($this->attributes['is_active']);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function getVisibleColumnsAttribute()
    {
        if (!is_null($this->attributes['post_visible_columns'])) {
            if (is_object($this->attributes['post_visible_columns'])) {
                return [];
            } else {
                return array_keys(json_decode(json_decode($this->attributes['post_visible_columns'], true), true));
            }
        } else {
            return [];
        }
    }
}
