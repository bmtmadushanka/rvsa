<?php

namespace App\Models;

use App\Traits\AdrTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildCopyAdr extends Model
{
    use HasFactory, SoftDeletes, AdrTrait;
    public $timestamps = FALSE;
    protected $casts = [
        'text' => 'array',
        'html' => 'array',
        'evidence' => 'array'
    ];

    protected $fillable = ['child_copy_id', 'parent_adr_id', 'is_common_adr', 'number', 'name', 'text', 'html', 'evidence', 'pdf'];

    public function child_copy()
    {
        return $this->belongsTo(ChildCopy::class);
    }

    public function parent()
    {
        return $this->belongsTo(Adr::class, 'parent_adr_id');
    }

}
