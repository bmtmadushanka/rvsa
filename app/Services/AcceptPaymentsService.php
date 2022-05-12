<?php

namespace App\Services;

use App\Libs\Paypal;

class AcceptPaymentsService
{
    public function charge($order)
    {
        (new Paypal())->charge($order);
    }
}
