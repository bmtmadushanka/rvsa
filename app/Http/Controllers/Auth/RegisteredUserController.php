<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'raw_id' => ['required', 'string', 'max:150'],
            'raw_company_name' => ['required', 'string', 'max:150'],
            'raw_trading_name' => ['nullable', 'string', 'max:150'],
            'abn' => ['required', 'numeric', 'digits:11'],
            'address_line_1' => ['required', 'string', 'max:150'],
            'address_line_2' => ['nullable', 'string', 'max:150'],
            'suburb' => ['required', 'string', 'max:150'],
            'post_code' => ['required', 'numeric', 'digits:4'],
            'state' => ['required', 'string'],
            'first_name' => ['required', 'string', 'max:150'],
            'last_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email:rfc,dns', 'max:150', 'unique:users'],
            'mobile_no' => ['required', 'numeric', 'digits:9', 'unique:users'],
            'office_no' => ['nullable', 'numeric', 'digits:9'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], ['mobile_no.digits' => 'Enter your mobile number without leading zero']);

        $user = DB::transaction(function() use($request) {

            try {

                $user = User::create(
                    array_merge($request->only(['first_name', 'last_name', 'email', 'mobile_no', 'office_no']),
                        ['password' => Hash::make($request->password)])
                );

                $client = $user->client()->create($request->only(['raw_id', 'raw_company_name', 'raw_trading_name', 'abn', 'pin']));
                $client->address()->create($request->only(['address_line_1', 'address_line_2', 'suburb', 'post_code', 'state']));

                return $user;

            } catch (\Exception $e) {
                Log::error($e->getMessage());
                dd('Something Went Wrong! Please contact your System Administrator');
            }

        });

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verify_mobile.prompt');

    }
}
