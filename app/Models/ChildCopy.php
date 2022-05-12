<?php

namespace App\Models;

use App\Http\Controllers\Admin\ChildCopyModsController;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildCopy extends Model
{
    use HasFactory, SoftDeletes, CommonTrait;

    protected $fillable = ['is_active', 'is_readonly', 'batch_id', 'master_copy_id', 'version', 'name', 'make', 'model', 'model_code', 'description', 'indexes', 'price', 'approval_code', 'data', 'created_by'];
    protected $casts = ['data' => 'array', 'indexes' => 'array'];

    public function master()
    {
        return $this->belongsTo(MasterCopy::class, 'master_copy_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('approval_code');
    }

    public function adrs()
    {
        return $this->hasMany(ChildCopyAdr::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function mods()
    {
        return $this->hasMany(ChildCopyMod::class);
    }

    public function versionChanges()
    {
        return $this->morphOne(VersionChange::class, 'model');
    }

    public function getStatusAttribute()
    {
        return $this->format_catalog_status_attribute($this->attributes['is_active']);
    }
}
