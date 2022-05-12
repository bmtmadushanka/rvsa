<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = FALSE;
    protected $fillable = ['is_active', 'type', 'code', 'discount', 'valid_from', 'valid_to', 'created_by'];
    protected $dates = ['created_at', 'redeemed_at'];
    protected $appends = ['status_formatted'];

    use HasFactory;

    public function order()
    {
        return $this->belongsToMany(Order::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function getStatusFormattedAttribute()
    {
        $status = [];

        if (!$this->attributes['is_active']) {

            $status['color'] = 'secondary';
            $status['text'] = 'inactive';

        } else if ($this->attributes['is_redeemed']) {

            $status['color'] = 'danger';
            $status['text'] = 'redeemed';

        } else if (!is_null($this->attributes['valid_to']) && $this->attributes['valid_to'] < date('Y-m-d')) {

            $status['color'] = 'secondary';
            $status['text'] = 'expired';

        } else {

            $status['color'] = 'success';
            $status['text'] = 'active';

        }

        return $status;
    }

}
