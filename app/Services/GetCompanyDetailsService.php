<?php

namespace App\Services;

use App\Models\AdminSetting;

class GetCompanyDetailsService
{
    public function get($field = NULL)
    {
        $company = AdminSetting::first();
        if ($field) {
            $field = preg_match('/default_/i', $field) ? $field :  ('company_' .$field);
            return $company->$field;
        } else {
            return $company;
        }

    }
}
