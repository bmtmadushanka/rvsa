<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RawMark extends Pivot
{
    public $timestamps = FALSE;
    use HasFactory;
    protected $table = 'raw_marks';
    

}
