<?php

namespace App\Libs;

class Paypal
{
    private $provider = '';

    public function __construct()
    {
       $this->init();
    }

    public function charge($order)
    {
        $response = $this->provider->createOrder([
            'intent'=> 'CAPTURE',
            'purchase_units'=> [[
                'reference_id' => $order->id,
                'amount'=> [
                    'currency_code'=> config('paypal')['currency'] ?? 'USD',
                    'value'=> $order->total
                ]
            ]],
            'application_context' => [
                'cancel_url' => route('payment_cancel'),
                'return_url' => route('payment_success')
            ]
        ]);

        if (isset($response['type']) && $response['type'] === 'error') {
            dd('Cannot Connect to the Paypal');
        } else {

            $order->payments()->create([
                'gross_amount' => $order->total,
                'token' => $response['id']
            ]);

            return redirect($response['links'][1]['href'])->send();
        }
    }

    public function capture($token)
    {
        return $this->provider->capturePaymentOrder($token);;
    }

    public function init(): void
    {
        $this->provider = \Srmklive\PayPal\Facades\PayPal::setProvider();

        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->setAccessToken($this->provider->getAccessToken());
    }
}
