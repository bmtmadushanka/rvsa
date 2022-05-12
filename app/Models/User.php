<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['is_verified', 'is_admin', 'first_name', 'last_name', 'email', 'mobile_no', 'office_no', 'password', 'role'];
    protected $appends = ['acronym'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activities()
    {
        return $this->hasMany(UserLog::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class)->with(['address']);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'ordered_by')->with('reports');
    }

    public function model_reports()
    {
        return $this->hasManyThrough(OrderReport::class, Order::class, 'ordered_by')->where('is_paid', 1);
    }

    public function payments()
    {
        return $this->hasManyThrough(OrderPayment::class, Order::class, 'ordered_by');
    }

    public function downloads()
    {
        return $this->hasMany(NotificationDownload::class);
    }

    public function approvals()
    {
        return $this->hasMany(NotificationApproval::class, 'created_by');
    }

    public function versionChanges()
    {
        return $this->hasMany(NotificationVersionChanges::class, 'user_id');
    }

    public function tickets()
    {
        return $this->hasMany(NotificationTicket::class, 'created_by');
    }

    public function scopeSuspended($query)
    {
        return $query->where('is_suspended', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('is_suspended', 0);
    }

    public function scopeAdmin($query)
    {
        return $query->where('is_admin', 1);
    }

    public function scopeNotAdmin($query)
    {
        return $query->where('is_admin', 0);
    }

    public function getAcronymAttribute()
    {
        $last_name = explode(' ', $this->attributes['last_name']);
        return substr($this->attributes['first_name'],0, 1) . substr(end($last_name),0, 1);
    }

}
