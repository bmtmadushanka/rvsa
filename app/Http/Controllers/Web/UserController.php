<?php

namespace App\Http\Controllers\Web;

use App\Events\PasswordChangedByClientEvent;
use App\Events\ProfileChangedEvent;
use App\Events\ProfileChangeRequestedEvent;
use App\Http\Controllers\Controller;
use App\Models\NotificationApproval;
use App\Models\User;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use PDF;

class UserController extends Controller
{
    use CommonTrait;

    public function profile()
    {
        return view('web.user.profile', [
            'user' => auth()->user()
        ]);
    }

    public function update_profile(Request $request, User $user)
    {
        $request->validate([
            'raw_id' => ['required', 'string', 'max:191'],
            'raw_company_name' => ['required', 'string', 'max:191'],
            'raw_trading_name' => ['nullable', 'string', 'max:191'],
            'abn' => ['required', 'numeric', 'digits:11'],
            'address_line_1' => ['required', 'string', 'max:191'],
            'address_line_2' => ['nullable', 'string', 'max:191'],
            'suburb' => ['required', 'string', 'max:191'],
            'post_code' => ['required', 'numeric', 'digits:4'],
            'state' => ['required', 'string'],
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email:rfc,dns', 'max:191', "unique:users,email,$user->id,id"],
            'mobile_no' => ['required', 'numeric', 'digits:9', "unique:users,mobile_no,$user->id,id"],
            'office_no' => ['nullable', 'numeric', 'digits:9'],
            'password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('Incorrect password. Please check your password'));
                }
            }],
        ]);

        $user_data = ['first_name', 'last_name', 'email', 'mobile_no', 'office_no'];
        $address_data = ['address_line_1', 'address_line_2', 'suburb', 'post_code', 'state'];
        $client_data = ['raw_id', 'raw_company_name', 'raw_trading_name', 'abn'];

        $changes['user_data'] = [];
        $changes['client_data'] = [];

        // check the other data changes
        foreach (array_merge($user_data, $address_data, $client_data) AS $key) {
            if (in_array($key, $client_data)) {
                if ($user->client->$key != $request->$key) {
                    $changes['client_data'][$key] = [
                        'old' => $user->client->$key,
                        'new' => $request->$key
                    ];
                }
            } else if (in_array($key, $user_data)) {
                if ($user->$key != $request->$key) {
                    $changes['user_data'][$key] = [
                        'old' => $user->$key,
                        'new' => $request->$key
                    ];
                }
            } else {
                if ($user->client->address->$key != $request->$key) {
                    $changes['user_data'][$key] = [
                        'old' => $user->client->address->$key,
                        'new' => $request->$key
                    ];
                }
            }
        }

        DB::transaction(function() use($request, $user, $changes) {

            if (!empty($changes['user_data'])) {

                if ($user->mobile_no !== $request->mobile_no) {
                    $user->update(array_merge(['is_verified' => 0], $request->only(['first_name', 'last_name', 'email', 'mobile_no', 'office_no'])));
                } else {
                    $user->update($request->only(['first_name', 'last_name', 'email', 'office_no']));
                }

                $user->client->address()->update($request->only(['address_line_1', 'address_line_2', 'suburb', 'post_code', 'state']));

                $approval = NotificationApproval::create([
                    'is_approved' => 1,
                    'is_read_user' => 1,
                    'is_read_admin' => 1,
                    'created_by' => auth()->user()->id,
                    'reviewed_by' => auth()->user()->id,
                    'fields' => $changes['user_data']
                ]);

                $user->activities()->create(['activity_id' => 6, 'reference' => $approval->id]);

            }

            if (!empty($changes['client_data'])) {

                $approval = NotificationApproval::create([
                    'created_by' => auth()->user()->id,
                    'fields' => $changes['client_data']
                ]);

                event(new ProfileChangeRequestedEvent($approval));
            }

        });

        $message = !empty($changes['client_data']) ?
            'You profile was partially updated. Some of your changes will be updated after the Admin\'s approval process.' :
            'Your profile has been updated successfully';

        $request->session()->flash('alert', [
            'type' => 'success',
            'message' => $message
        ]);

        return redirect()->route('web_user_profile');

    }

    public function update_password(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'current_credentials' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('Incorrect password. Please check your password'));
                }
            }],
        ]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }


        try {
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            dd('Something went wrong! Please contact your System Administrator');
        }

        event(new PasswordChangedByClientEvent($user));

        $request->session()->flash('alert', [
            'type' => 'success',
            'message' => 'The password has been updated successfully'
        ]);

        return $this->ajax_msg('success', '', '', 'user/profile');

    }

    public function reports()
    {
        return view('web.user.reports',[
            'reports' => auth()->user()->model_reports
        ]);
    }

    public function orders()
    {
        return view('web.user.orders', [
            'orders' => auth()->user()->orders()->get()
        ]);
    }

}
