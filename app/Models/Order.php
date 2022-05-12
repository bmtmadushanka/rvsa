<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['ordered_by', 'coupon_id', 'sub_total', 'discount', 'total', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'ordered_by');
    }

    public function reports()
    {
        return $this->hasMany(OrderReport::class);
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function payment()
    {
        return $this->payments()->where('status', 'paid');
    }

    public function notifications()
    {
        return $this->hasMany(NotificationPayment::class);
    }

    public function couponOrder()
    {
        return $this->hasOne(CouponOrder::class, 'order_id');
    }

}
