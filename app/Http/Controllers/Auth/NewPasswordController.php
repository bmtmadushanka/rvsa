<?php

namespace App\Http\Controllers\Auth;

use App\Events\PasswordChangedByClientEvent;
use App\Http\Controllers\Controller;
use App\Libs\WebsRus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $token = $request->session()->get('auth_token');
        $user = User::firstWhere('mobile_no', $request->mobile_no);

        if (!$token || !$user || $user->id != $token['user_id'] || $user->mobile_no != $token['mobile_no']) {

            $request->session()->forget('auth_token');
            (new WebsRus())->sendCode($user);
            return redirect()->back()->withErrors(['The code has expired. Please enter the new code that we sent you recently.']);

        }

        if ($request->code != $token['code']) {
            return redirect()->back()->withErrors(['Invalid code. Please check the code again'])->withInput(['code' => $request->code]);
        }

        try {

            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordChangedByClientEvent($user));

            $request->session()->forget('auth_token');
            $request->session()->flash('alert', [
                'type' => 'success',
                'message' => 'The password has been updated successfully. Please sign in to continue'
            ]);

            return redirect()->route('login');

        } catch (\Exception $e) {

           return redirect()->back()->withInput($request->only('code'))
               ->withErrors(['Unable to update your password. Please contact the site owner']);

        }
    }
}
