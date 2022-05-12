<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function edit(Request $request)
    {
        $settings = AdminSetting::first();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:150'],
            'company_code' => ['required', 'string', 'max:150'],
            'company_acn' => ['required', 'string', 'max:150'],
            'company_test_facility_id' => ['required', 'string', 'max:150'],
            'company_address' => ['required', 'string', 'max:150'],
            'company_contact_no' => ['required', 'string', 'max:15'],
            'company_email' => ['required', 'string', 'max:150'],
            'company_web' => ['required', 'string', 'max:150'],
            /*'default_raw_company_name' => ['required', 'string', 'max:150'],
            'default_raw_id' => ['required', 'string', 'max:150'],
            'default_abn' => ['required', 'numeric', 'digits:11'],
            'default_address' => ['required', 'string', 'max:300'],*/
        ]);

        $data = $request->except('_token');
        $request['company_contact_no'] = trim(0, $request['company_contact_no']);


        if (!empty($data['logo'])) {
            $data['company_logo'] = time() . mt_rand() . '.'. $data['logo']->extension();
            $data['logo']->move(public_path('/uploads/images/logos/'), $data['company_logo']);
        }

        try {

            AdminSetting::find(1)->update($data);

        } catch (\Exception $e) {
            report($e);
        }

        $request->session()->flash('alert', [
            'type' => 'success',
            'message' => 'The company settings have been updated successfully'
        ]);

        return redirect()->route('admin_settings.edit');

    }
}
