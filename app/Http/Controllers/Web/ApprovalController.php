<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\NotificationApproval;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    use CommonTrait;

    public function show(NotificationApproval $approval)
    {
        if ($approval->created_by != auth()->id()) {
            abort(404);
        }

        if (!is_null($approval->reviewed_at) && !$approval->is_read_user) {
            $approval->is_read_user = 1;
            $approval->save();
        }

        return view('layouts.approvals.view', compact('approval'));
    }

    public function delete(Request $request, NotificationApproval $approval)
    {
        $this->ajax_verify($request);
        $approval->delete();
        return $this->ajax_msg('success', '', '', '/user/notifications/profile');
    }
}
