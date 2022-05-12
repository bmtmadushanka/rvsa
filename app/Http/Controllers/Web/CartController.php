<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ChildCopy;
use App\Models\Coupon;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use CommonTrait;
    private $cart = [];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->cart = $request->session()->get('cart') ?? [];
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $coupon = $request->session()->get('cart_coupon');
        return $this->load_cart_full([
            'percentage' => $coupon['discount'] ?? 0 + 0
        ]);
    }

    public function refresh_cart_mini()
    {
        return $this->render_cart_mini();
    }

    public function update(Request $request, ChildCopy $child)
    {
        $this->ajax_verify($request);
        $report = $child->only('id', 'make', 'model', 'model_code', 'price');

        for ($i = 1; $i <= $request->qty; $i++) {
            array_push($this->cart, $report);
        }

        $request->session()->put(['cart' => $this->cart]);
        if ($request->exists('redirect')) {
            return $this->ajax_msg('success', '', '', '/cart');
        } else {
            return $this->render_cart_mini();
        }

    }

    public function delete(Request $request, $id)
    {
        $this->ajax_verify($request);
        unset($this->cart[$id]);
        $request->session()->put(['cart' => $this->cart]);

        if ($request->exists('redirect')) {
            return $this->ajax_msg('success', '', '', '/cart');
        } else {
            return $this->render_cart_mini();
        }
    }

    private function load_cart_full($discount) : object
    {
        $total = array_sum(array_column($this->cart, 'price'));
        $discount['amount'] = round($total * $discount['percentage'] / 100, 2) ;

        return view('web.cart.full', [
            'isBackEnd' => request()->segment(1) === 'admin',
            'hideMiniCart' => true,
            'discount' => $discount,
            'cart_data' => $this->cart,
            'total' => $total
        ]);
    }

    private function render_cart_mini(): object
    {
        $cart = view('web.cart.mini', [
            'cart_data' => $this->cart,
            'display_full_cart' => false,
        ])->render();

        return $this->ajax_msg('success', '', ['cart' => $cart, 'item_count' => count($this->cart)]);
    }

}
