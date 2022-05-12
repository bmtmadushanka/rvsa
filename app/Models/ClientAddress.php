<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $fillable = ['address_line_1', 'address_line_2', 'suburb', 'post_code', 'state'];

    public function getAddressFormattedInlineAttribute()
    {
        $address = rtrim($this->attributes['address_line_1'], ',');
        $address.= ', ' . rtrim($this->attributes['address_line_2'], ',');
        $address.= ', ' . rtrim($this->attributes['suburb']);
        $address.= '(' . rtrim($this->attributes['post_code'] . ')', ',');
        $address.= ', ' . rtrim($this->attributes['state'], ',');

        return $address;
    }
}
