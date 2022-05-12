<?php

namespace App\Http\Controllers\Auth;

use App\Events\VerifyMobileEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifyMobileController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(function ($request, $next) {
           return $request->user()->is_verified ? redirect('/') : $next($request);
        });
    }

    public function prompt(Request $request)
    {
        if (!$request->session()->has('auth_token')) {
            event(new VerifyMobileEvent($request->user()));
        }

        return view('auth.verify-mobile', [
            'mobile' => $request->user()->mobile_no
        ]);

    }

    public function verify(Request $request)
    {
        $token = $request->session()->get('auth_token');
        $user = $request->user();

        if (!$token) {
            event(new VerifyMobileEvent($user));
            return redirect()->back()->withErrors(['The code has expired. Please enter the new code that we recently sent you.']);
        }

        $request->validate([
            'code' => ['required', 'string', 'max:50'],
        ]);

        if ($request->user()->id != $token['user_id'] || $request->mobile_no != $user->mobile_no || $request->code != $token['code']) {

            return redirect()->back()->withErrors(['Invalid code. Please check the code again']);

        } else {

            $user->is_verified = 1;
            $user->update();
            $request->session()->forget('auth_token');

            $user->activities()->create(['activity_id' => 17]);

            $request->session()->flash('alert', [
                'type' => 'success',
                'message' => 'Your account has been verified successfully'
            ]);

            return redirect()->route('web_dashboard');
        }

    }
}
