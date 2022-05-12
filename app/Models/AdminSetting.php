<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;
    public $timestamps = FALSE;

    protected $fillable = ['company_name', 'company_code', 'company_acn', 'company_test_facility_id', 'company_address', 'company_contact_no', 'company_email','company_web', 'company_logo', 'default_raw_company_name', 'default_raw_id', 'default_abn', 'default_address'];

}
