<?php

namespace App\Http\Controllers\Web;

use App\Events\PaymentFailedEvent;
use App\Events\PaymentSucceededEvent;
use App\Http\Controllers\Controller;
use App\Libs\Paypal;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    private $payments = [];
    private $response = '';

    public function __construct(Request $request)
    {
        if (empty($request->token)) {
            Redirect::to('/')->send();
        }

        $paypal = new Paypal();
        $this->payments = OrderPayment::with('order')->where('token', $request->token)->get()->keyBy('order_id');

        if ($this->payments->isEmpty()) {
            return redirect()->route('web_user_orders');
        }

       $this->response = $paypal->capture($request->token);


    }

    public function success(Request $request)
    {
        if (isset($this->response['status']) && $this->response['status'] === 'COMPLETED' && in_array($this->response['purchase_units'][0]['reference_id'], $this->payments->keys()->toArray())) {
            $order = $this->payments[$this->response['purchase_units'][0]['reference_id']]->order;
            $seller_receivable_breakdown = $this->response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown'] ?? null;
            $order->payments()->where('token', $request->token)->update([
                'gross_amount' => $seller_receivable_breakdown ? $seller_receivable_breakdown['gross_amount']['value'] : $this->response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                'paypal_fee' => $seller_receivable_breakdown ? $seller_receivable_breakdown['paypal_fee']['value'] : null,
                'net_amount' => $seller_receivable_breakdown ? $seller_receivable_breakdown['net_amount']['value'] : null,
                'status' => 'paid'
            ]);

            $order->reports()->each(function($report) {
                $report->update(['is_paid' => 1]);
            });

            $order->update(['status' => 'paid']);

            if ($order->couponOrder && $order->couponOrder->coupon->type === 'one-off') {
               $order->couponOrder->coupon()->update(['is_redeemed' => 1]);
            }

            event(new PaymentSucceededEvent($order));

            $request->session()->flash('alert', [
                'type' => 'success',
                'message' => 'Thank you for the payment. Your reports are ready to be downloaded.'
            ]);

            return redirect()->route('web_user_reports');

        } else if(isset($this->response['status']) && $this->response['status'] === 'COMPLETED') {

            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'Sorry! We\'re unable to verify your payment. Please contact us with the proof of your payment.'
            ]);
            event(new PaymentFailedEvent($this->payments->first()->order, 'Unable to verify the payment.'));
            return redirect()->route('web-user-orders');

        } else {
            return redirect()->route('web_user_orders');
        }
    }

    public function failed(Request $request)
    {
        if (isset($this->response['type']) && $this->response['type'] === 'error') {
            $message = json_decode(str_replace('{}', '', $this->response['message']), true);
            if ($message['details'][0]['issue'] === 'ORDER_NOT_APPROVED') {

                if ($this->payments->count() == 1) {
                    $this->payments->first()->update([
                        'status' => 'failed',
                        'response' => 'Payment was not approved'
                    ]);
                    event(new PaymentFailedEvent($this->payments->first()->order, 'The payment was not not approved'));
                }
            }
        } else {

            $this->payments->first()->update([
                'status' => 'failed',
                'response' => 'Unknown Error'
            ]);

            event(new PaymentFailedEvent($this->payments->first()->order, 'Unknown Error'));
        }

        $request->session()->flash('alert', [
            'type' => 'error',
            'message' => 'The payment was failed. Please try again in a few minutes'
        ]);

        return redirect()->route('web_user_orders');
    }

}
