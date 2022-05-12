<?php

namespace App\Services;

use App\Facades\Company;
use App\Libs\WebsRus;
use Illuminate\Support\Facades\App;

class SendSMSService
{
    public function send($message, $to)
    {
        $to =  ($to === '771772279' ? '+94' : '+61') . $to;

        if (App::environment() === 'local') {
            (new WebsRus)->sendSms($message, '+94771772279', Company::get('code'));
        } else {
            (new WebsRus)->sendSms($message, $to, Company::get('code'));
        }
    }
}
