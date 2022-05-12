<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderReport;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NoiseTestController extends Controller
{
    use CommonTrait;


    public function edit(Request $request, OrderReport $report)
    {
        $this->ajax_verify($request);
        $html = view('admin.noise_test_reports.create', [
            'report' => $report,
        ])->render();

        return $this->ajax_msg('success','', $html);

    }

    public function update(Request $request, OrderReport $report)
    {
        $this->ajax_verify($request);

        $validator = Validator::make($request->all(), [
            'date_test' => ['required', 'date'],
            'wind_direction' => ['required', 'string', 'max:150'],
            'engine_speed_nep' => ['required', 'numeric'],
            'engine_speed_starts' => ['required', 'numeric'],
            'sound_intensity' => ['required', 'numeric'],
            'noise_level' => ['required', 'numeric'],
            'height_of_mic' => ['required', 'numeric'],
            'temperature' => ['required', 'numeric'],
            'test_1' => ['required', 'numeric'],
            'test_2' => ['required', 'numeric'],
            'test_3' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        $data = $request->only(['date_test', 'wind_direction', 'engine_speed_nep', 'engine_speed_starts', 'sound_intensity', 'noise_level', 'height_of_mic', 'temperature',
            'test_1', 'test_2', 'test_3']);

        try {
            $report->noise_test()->updateOrCreate(['order_report_id' => $report->id],[
                'data' => $data,
                'created_by' => auth()->user()->id
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            dd('Something went wrong!. Please contact your system Administrator');
        }

        return $this->ajax_msg('success', 'Noise test report has been updated', ['report_id' => $report->id, 'download' => $request->exists('download'), 'redirect' => '/admin/client/' . $report->order->user->id]);
    }
}
