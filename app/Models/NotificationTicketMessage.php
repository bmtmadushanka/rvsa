<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationTicketMessage extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = FALSE;
    protected $guarded = [];
    protected $dates = ['created_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ticket()
    {
        return $this->belongsTo(NotificationTicket::class, 'notification_ticket_id');
    }

}
