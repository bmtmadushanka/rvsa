<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCopy extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $guarded = [];

    public function pages()
    {
        return $this->hasMany(MasterCopyPage::class);
    }

    public function versionChanges()
    {
        return $this->morphOne(VersionChange::class, 'model');
    }

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

    public function childCopies()
    {
        return $this->hasMany(ChildCopy::class);
    }

}
