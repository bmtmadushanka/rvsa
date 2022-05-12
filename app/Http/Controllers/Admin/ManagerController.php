<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class ManagerController extends Controller
{

    use CommonTrait;

    public function index()
    {
        return view('admin.managers.list', [
            'users' => User::admin()->get()
        ]);
    }

    public function create(Request $request)
    {
        $this->ajax_verify($request);

        $html = view('admin.managers.create')->render();
        return $this->ajax_msg('success', '', $html);

    }

    public function store(Request $request)
    {
        $this->ajax_verify($request);

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email:rfc,dns', 'max:150', 'unique:users'],
            'mobile_no' => ['required', 'numeric', 'digits:9', 'unique:users'],
            'role' => ['nullable', 'string', 'max:191'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        try {
            User::create(
                array_merge($request->only(['first_name', 'last_name', 'email', 'mobile_no', 'role']),
                ['password' => Hash::make($request->password), 'is_admin' => 1]));
        } catch (\Exception $e) {
            report($e);
        }

        return $this->ajax_msg('success', 'Admin has been created successfully', '', 'admin/manager');

    }

    public function edit(Request $request, $id)
    {
        $this->ajax_verify($request);
        $user = User::findOrFail($id);

        $html = view('admin.managers.create', compact('user'))->render();
        return $this->ajax_msg('success', '', $html);
    }

    public function update (Request $request, $id)
    {
        $this->ajax_verify($request);
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email:rfc,dns', 'max:191', "unique:users,email,$user->id,id"],
            'mobile_no' => ['required', 'numeric', 'digits:9', "unique:users,mobile_no,$user->id,id"],
            'role' => ['nullable', 'string', 'max:191'],
        ]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        $is_verified = $user->is_verified && $user->mobile_no == $request->mobile_no;

        try {
            $user->update(array_merge(['is_verified' => $is_verified], $request->only(['first_name', 'last_name', 'email', 'mobile_no', 'role'])));
        } catch (\Exception $e) {
            report($e);
        }

        return $this->ajax_msg('success', 'Admin has been updated successfully', '', 'admin/manager');

    }

}
