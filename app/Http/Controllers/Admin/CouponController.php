<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    use CommonTrait;

    public function index()
    {
        return view('admin.coupons.list', [
            'coupons' => Coupon::latest()->get()
        ]);
    }

    public function create(Request $request)
    {
        $this->ajax_verify($request);

        $html = view('admin.coupons.create')->render();
        return $this->ajax_msg('success', '', $html);
    }

    public function store(Request $request)
    {
        $this->ajax_verify($request);

        $validator = Validator::make($request->all(), [
            'type' => ['required'],
            'discount' => ['required', 'numeric', 'between:0.00,99.99'],
            'valid_from' => ['nullable', 'date'],
            'valid_to' => ['nullable', 'date']
        ]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        if (! $request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        }

        $codes = Coupon::pluck('code')->toArray();

        do {
            $token = strtoupper(Str::random(6));
        } while(in_array($token, $codes));

        try {
            Coupon::create(array_merge($request->toArray(), [
                'code' => $token,
                'created_by' => auth()->user()->id
            ]));
        } catch (\Exception $e) {
            report($e);
        }

        return $this->ajax_msg('success', 'Coupon has been created successfully', ['url' => 'admin/coupon']);
    }

    public function edit(Request $request, Coupon $coupon)
    {
        $this->ajax_verify($request);

        $html = view('admin.coupons.create', compact('coupon'))->render();
        return $this->ajax_msg('success', '', $html);

    }

    public function update(Request $request, Coupon $coupon)
    {
        $this->ajax_verify($request);

        $validator = Validator::make($request->all(), [
            'discount' => ['required', 'numeric', 'between:0.00,99.99'],
            'valid_from' => ['nullable', 'date'],
            'valid_to' => ['nullable', 'date']
        ]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        if (! $request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        }

        try {
            $coupon->update($request->all());
        } catch (\Exception $e) {
            report($e);
        }

        return $this->ajax_msg('success', 'Coupon has been updated successfully', ['url' => 'admin/coupon']);

    }

    public function destroy(Request $request, Coupon $coupon)
    {
        $this->ajax_verify($request);
        $coupon->delete();
        return $this->ajax_msg('success', 'Coupon has been deleted successfully', '', 'admin/coupon');
    }

}
