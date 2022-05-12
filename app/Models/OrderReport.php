<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReport extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $fillable = ['is_paid', 'child_copy_id', 'vin', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function child()
    {
        return $this->belongsTo(ChildCopy::class, 'child_copy_id');
    }

    public function scopePaid($query)
    {
        return $query->where('is_paid', 1);
    }

    public function noise_test()
    {
        return $this->hasOne(OrderReportNoiseTest::class, 'order_report_id');
    }

}
