<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionChange extends Model
{
    use HasFactory;
    public $timestamps = FALSE;
    protected $fillable = ['data', 'reference_type', 'parent_id'];

    protected $casts = ['data' => 'array'];

    public function reference()
    {
        if ($this->attributes['reference_type'] === 'main') {
            return $this->belongsTo(ChildCopy::class, 'parent_id');
        } else {
            return $this->belongsTo(ChildCopyAdr::class, 'parent_id');
        }
    }

}
