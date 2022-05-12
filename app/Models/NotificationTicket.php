<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationTicket extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = FALSE;
    protected $guarded = [];
    protected $dates = ['created_at'];
    public $appends = ['vin'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function report()
    {
        return $this->belongsTo(OrderReport::class, 'order_report_id');
    }

    public function messages()
    {
        return $this->hasMany(NotificationTicketMessage::class);
    }

    public function latestMessage()
    {
        return $this->messages()->orderByDesc('created_at')->first();
    }

    public function getVinAttribute()
    {
        return $this->report()->first()->vin ?? '';
    }

    public function scopeOpen($query)
    {
        return $query->where('is_closed', 0);
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assignee');
    }


}
