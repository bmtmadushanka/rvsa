<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\False_;

class NotificationApproval extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = FALSE;
    protected $guarded = [];
    public $dates = ['created_at', 'reviewed_at'];

    protected $casts = ['fields' => 'array'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', 0);
    }

    public function getStatusAttribute()
    {
        $status = [];
        if (is_null($this->attributes['reviewed_at'])) {
            if ($this->attributes['created_by'] === $this->attributes['reviewed_by']) {
                // profile changed by the profile owner
                $status = [
                    'badge_text' => 'Updated',
                    'badge_color' => 'success',
                    'text' => 'The profile was updated at ' . date('Y-M-d G:i:s A', strtotime($this->attributes['created_at']))
                ];
            } else {
                if ($this->attributes['is_approved']) {
                    // profile changed by the admin
                    $status = [
                        'badge_text' => 'Changed',
                        'badge_color' => 'success',
                        'text' => 'The profile was changed by the admin at ' . date('Y-M-d G:i:s A', strtotime($this->attributes['created_at']))
                    ];
                } else {
                    // profile changes sent to admin to approval process
                    $status = [
                        'badge_text' => 'Pending',
                        'badge_color' => 'secondary',
                        'text' => '  The changes of your profile data have been listed for the approval process at ' . date('Y-M-d G:i:s A', strtotime($this->attributes['created_at']))
                    ];
                }
            }
        } else {
            // profile changed requested reviewed
            if ($this->attributes['is_approved']) {
                $status = [
                    'badge_text' => 'Updated',
                    'badge_color' => 'success',
                    'text' => 'The requested changes were approved and the profile was updated at ' . date('Y-M-d G:i:s A', strtotime($this->attributes['created_at']))
                ];
            } else {
                $status = [
                    'badge_text' => 'Rejected',
                    'badge_color' => 'danger',
                    'text' => 'The requested changes were rejected at ' . date('Y-M-d G:i:s A', strtotime($this->attributes['created_at']))
                ];
            }
        }

        return $status;
    }

}
