<?php

namespace App\Http\Controllers\Admin;

use App\Events\PasswordResetByAdminEvent;
use App\Events\ProfileChangedByAdminEvent;
use App\Http\Controllers\Controller;
use App\Models\NotificationApproval;
use App\Models\User;
use App\Traits\CommonTrait;
use App\Traits\NotificationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    use CommonTrait, NotificationTrait;

    public function index()
    {
        return view('admin.clients.list', [
            'users' => User::notAdmin()->with(['client', 'model_reports', 'tickets'])->latest()->get()
        ]);
    }

    public function show(Request $request, User $user)
    {
        $tabs = $this->get_tabs($user);

        $active_tab = $request->exists('tab') ? $request->tab : 'updates';

        if (!in_array($active_tab, array_keys($tabs))) {
            $active_tab = 'updates';
        }

        return view('admin.clients.view', [
            //'users' => User::with(['client', 'model_reports'])->latest()->get()
            'user' => $user,
            'orders' => $user->orders()->get(),
            'reports' => $user->model_reports,
            'tab_groups' => collect($tabs)->groupBy('group'),
            'active_tab' => $active_tab,
            'selected_tab' => in_array($request->tab, ['downloads', 'payments', 'updates', 'approvals', 'account', 'activities']) ? 'notifications' : ($request->tab ?? ''),
            'tab_data' => $this->get_tab_data($active_tab, $user),
        ]);
    }

    public function update(Request $request, User $user)
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
            'email' => ['required', 'string', 'email', 'max:191', "unique:users,email,$user->id,id"],
            'mobile_no' => ['required', 'numeric', 'digits:9', "unique:users,mobile_no,$user->id,id"],
            'office_no' => ['nullable', 'numeric', 'digits:9'],
        ]);

        $changes = [];
        foreach ($request->only(['first_name', 'last_name', 'email', 'mobile_no', 'office_no']) AS $key => $value) {
            if ($user->$key != $value) {
                $changes[$key] = [
                    'old' => $user->$key,
                    'new' => $value
                ];
                $user->$key = $value;
            }
        }

        if ($user->mobile_no !== $request->mobile_no) {
            $user->is_verified = 0;
        }

        foreach ($request->only(['raw_id', 'raw_company_name', 'raw_trading_name', 'abn', 'pin']) AS $key => $value) {
            if ($user->client->$key != $value) {
                $changes[$key] = [
                    'old' => $user->client->$key,
                    'new' => $value
                ];
                $user->client->$key = $value;
            }
        }

        foreach ($request->only(['address_line_1', 'address_line_2', 'suburb', 'post_code', 'state']) AS $key => $value) {
            if ($user->client->address->$key != $value) {
                $changes[$key] = [
                    'old' => $user->client->address->$key,
                    'new' => $value
                ];
                $user->client->address->$key = $value;
            }
        }

        DB::transaction(function() use($request, $user, $changes) {

           $user->save();
           $user->client->save();
           $user->client->address->save();

           if ($changes) {

               $approval = NotificationApproval::create([
                   'is_approved' => 1,
                   'is_read_user' => 0,
                   'created_by' => $user->id,
                   'reviewed_by' => auth()->user()->id,
                   'fields' => $changes
               ]);

               event(new ProfileChangedByAdminEvent($approval));

           }

        });

        $request->session()->flash('alert', [
            'type' => 'success',
            'message' => 'The profile data has been updated successfully'
        ]);

        return redirect('/admin/client/' . $user->id . '?tab=profile');

    }

    public function reset_password(Request $request, User $user)
    {
        $this->ajax_verify($request);

        $user->password = mt_rand();
        $user->update();

        $request->session()->flash('alert', [
            'type' => 'success',
            'message' => 'A password reset link to set a new password has been e-mailed successfully'
        ]);

        event(new PasswordResetByAdminEvent($user));

        return $this->ajax_msg('success', '', '', 'admin/client/' . $user->id . '?tab=profile');

    }

}
