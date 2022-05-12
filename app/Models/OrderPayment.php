<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $fillable = ['gross_amount', 'paypal_fee', 'net_amount', 'status', 'token', 'response'];

    public $dates = [
        'updated_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class)->with('user');
    }

}
