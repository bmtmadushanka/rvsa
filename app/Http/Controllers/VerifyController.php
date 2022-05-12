<?php

namespace App\Http\Controllers;

use App\Models\OrderReport;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verify(Request $request)
    {
        $report = [];

        if ($request->exists('id')) {
            $report = OrderReport::where('vin', $request->id)->paid()->first();
        }

        return view('web.verify', [
           'report' => $report
        ]);

    }
}
