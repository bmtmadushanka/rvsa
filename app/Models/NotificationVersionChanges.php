<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationVersionChanges extends Model
{
    use HasFactory;
    public $timestamps = FALSE;
    protected $guarded = [];

    public function childCopy()
    {
        return $this->belongsTo(ChildCopy::class);
    }

}
