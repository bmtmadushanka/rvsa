<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CouponOrder extends Pivot
{
    public $timestamps = FALSE;
    use HasFactory;

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

}
