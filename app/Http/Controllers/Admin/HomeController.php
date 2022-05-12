<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\ChildCopy;
use App\Models\NotificationApproval;
use App\Models\NotificationTicket;
use App\Models\NotificationTicketMessage;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('admin.dashboard', [
            'notifications' => [
                'pending_approvals' => NotificationApproval::pending()->whereNull('reviewed_at')->count(),
                'pending_discussions' => NotificationTicket::open()->unassigned()->orWhere(function ($q) {
                    $q->where('assignee', auth()->user()->id)->where('is_read_assignee', 0);
                })->count()
            ]
        ]);

    }
}
