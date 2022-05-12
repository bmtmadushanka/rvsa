<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCopyPage extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = FALSE;
    protected $fillable = ['blueprint_id', 'text', 'html', 'sort_order'];

    protected $casts = ['html' => 'array', 'text' => 'array'];

}
