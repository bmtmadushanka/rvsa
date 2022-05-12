<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationDownload extends Model
{
    use HasFactory;
    public $timestamps = FALSE;

    protected $fillable = ['order_report_id', 'user_id', 'type'];

    public $dates = [
        'downloaded_at'
    ];

    public function report()
    {
        return $this->belongsTo(OrderReport::class, 'order_report_id');
    }

}
