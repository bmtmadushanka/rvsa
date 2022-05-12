<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderPayment;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function income(Request $request)
    {
        $data = $request->all();
        $payments = collect([]);

        if (!empty($data['date_from']) || !empty($data['date_to'])) {

            $query = OrderPayment::with(['order'])->where('status', 'paid');

            if (!empty($data['date_from'])) {
                $query->whereDate('updated_at', '>=', ($data['date_from'] . ' 00:00:00'));
            }

            if (!empty($data['date_to'])) {
                $query->whereDate('updated_at', '<=', ($data['date_to'] . ' 23:59:59'));
            }

            $payments = $query->get();

        }

        return view('admin.sales.income', [
            'payments' => $payments,
            'totals' => [
                'gross' => $payments->pluck('gross_amount')->sum(),
                'paypal' => $payments->pluck('paypal_fee')->sum(),
                'net' => $payments->pluck('net_amount')->sum()
            ]
        ]);
    }

    public function index()
    {
        return view('admin.sales.list', [
            'users' => User::notAdmin()->with(['client', 'model_reports', 'payments'])->latest()->get(),
            'payments' => OrderPayment::where('status', 'paid')
        ]);
    }

    public function show(Request $request, $id)
    {
        return view('admin.sales.view', [
            'user' => User::whereId($id)->with(['client', 'model_reports', 'payments'])->first()
        ]);
    }
}
