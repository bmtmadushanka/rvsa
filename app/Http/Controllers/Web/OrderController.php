<?php

namespace App\Http\Controllers\Web;

use App\Facades\IPG;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $rules = ['vin_numbers.*' => 'required|string|min:17|max:17'];
        if (!$request->exists('is_agreed')) {

            if ($request->input('is_remove_coupon')) {
                $request->session()->forget('cart_coupon');
                return redirect()->back()->withInput();
            }

            $coupon = Coupon::active()->where('code', $request->coupon_code)->where(function($query) {
                $query->whereNull('valid_from')->orWhere('valid_from', '<=', date('Y-m-d'));
            })->first();

            $rules['coupon_code'] = ['required', 'max:10'];

            $validator = Validator::make($request->all(), $rules);
            $validator->after(
                function ($validator) use ($coupon) {
                    if (!$coupon) {
                        $validator->errors()->add('coupon_code', 'Invalid coupon Code. Please enter a valid code');
                    } else if ($coupon->is_redeemed) {
                        $validator->errors()->add('coupon_code', 'Oops! The coupon code entered has already been used');
                    } else if (!is_null($coupon->valid_to) && $coupon->valid_to < date('Y-m-d')) {
                        $validator->errors()->add('coupon_code', 'Oops! The coupon code has expired');
                    }
                }
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }

            if (!$request->exists('is_agreed')) {
                $request->session()->put(['cart_coupon' => $coupon->only('id', 'discount')]);
                return redirect()->back()->withInput();
            }

        } else {
            $request->validate($rules);

            $cart = $request->session()->get('cart');
            if (empty($cart)) {
                $request->session()->flash('message', 'The cart is empty.');
                return redirect('/cart');
            }

            if (count($cart) !== count($request->vin_numbers)) {
                $request->session()->flash('message', 'Please try again');
                return redirect('/cart');
            }

            $cart_coupon = $request->session()->get('cart_coupon');
            $coupon = [];
            if ($cart_coupon) {
                $coupon = Coupon::find($cart_coupon['id'])->toArray();
                $this->validate_coupon($request, $coupon);
            }

            $model_reports = [];
            foreach ($cart AS $k => $cart_item) {
                $model_reports[] = [
                    'child_copy_id' => $cart_item['id'],
                    'vin' => $request->vin_numbers[$k],
                    'price' => $cart_item['price']
                ];
            }

            $order = DB::transaction(function() use($model_reports, $coupon) {

                $sub_total = array_sum(array_column($model_reports, 'price'));

                $order = Order::create([
                    'sub_total' => $sub_total,
                    'discount' => round($sub_total * ($coupon['discount'] ?? 0) / 100, 2),
                    'total'=> $sub_total - round($sub_total * ($coupon['discount'] ?? 0) / 100, 2),
                    'ordered_by' => Auth::user()->id,
                ]);

                if ($coupon) {
                    $order->couponOrder()->create(['coupon_id' => $coupon['id']]);
                }
                $order->reports()->createMany($model_reports);
                return $order;

            });

            $request->session()->forget(['cart', 'cart_coupon']);

            // send use to IPG
            $this->send_to_ipg($order);


        }

    }

    public function pay(Request $request, Order $order)
    {
        // check whether the coupon is still active
        if (!is_null($order->coupon_id)) {
            $this->validate_coupon($request, $order->coupon);
        }

        if ($order->status === 'pending') {
            $this->send_to_ipg($order);
        } else {
            $request->session()->flash('message', 'Invalid Request. The order is already paid');
            return Redirect::to('web-user-orders');
        }

    }

    private function send_to_ipg($order)
    {
        IPG::charge($order);
    }

    private function validate_coupon($request, $coupon)
    {
        if (empty($coupon)
            || $coupon['status_formatted']['text'] !== 'active'
            || (!is_null($coupon['valid_from']) && date('Y-m-d') < $coupon['valid_from'])
            || (!is_null($coupon['valid_to']) && $coupon['valid_to'] < date('Y-m-d'))
        ) {
            $request->session()->flash('message', 'Invalid Coupon. Please try again with a valid coupon code');
            $request->session()->forget('cart_coupon');
            return redirect('/cart');
        }

    }
}
