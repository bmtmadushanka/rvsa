<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $fillable = ['raw_id', 'raw_company_name', 'raw_trading_name', 'abn', 'pin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->hasOne(ClientAddress::class, 'client_id');
    }
}
