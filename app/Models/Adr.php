<?php

namespace App\Models;

use App\Traits\AdrTrait;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adr extends Model
{
    use HasFactory, SoftDeletes, CommonTrait, AdrTrait;
    protected $casts = [
        'text' => 'array',
        'html' => 'array',
        'evidence' => 'array'
    ];

    protected $fillable = ['is_active', 'number', 'name', 'text', 'html', 'evidence', 'created_by'];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function getStatusAttribute()
    {
        return $this->format_catalog_status_attribute($this->attributes['is_active']);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getIsCommonAdrAttribute()
    {
        return $this->is_common_adr($this->attributes['number']);
    }

}
