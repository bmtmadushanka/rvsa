<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use CommonTrait;

    public function update_status(Request $request, User $user)
    {
        $this->ajax_verify($request);

        $this->ajax_msg($request);
        $data = $request['data'];

        if (!isset($data['value']) || !$request->user()->is_admin) {
            return $this->ajax_msg('error', 'Invalid Request. Please contact your System Administrator');
        }

        if ($user->id == $request->user()->id) {
            return $this->ajax_msg('error', 'Oops! you cannot suspend yourself!');
        }

        try {

            $user->is_suspended = $data['value'] === 'true' ? 1 : 0;
            $user->update();

        } catch (\Exception $e) {
            return $this->ajax_msg('error', 'Cannot updated the user. Please contact your System Administrator');
        }

        return $this->ajax_msg('success', 'User status has been updated', '', '/admin/' . $data['module']);
    }
}
