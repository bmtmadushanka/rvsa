<?php

namespace App\Http\Controllers\Web;

use App\Facades\Company;
use App\Http\Controllers\Controller;
use App\Mail\PaymentFailedMail;
use App\Mail\PaymentSucceededMail;
use App\Mail\ProfileChangesRequestedMail;
use App\Models\ChildCopy;
use App\Models\NotificationApproval;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function dashboard(Request $request)
    {
        $approvals = $request->user()->approvals->where('is_read_user', 0)->count();
        $version_changes = $request->user()->versionChanges()->where('is_read', 0)->count();

        return view('web.dashboard', [
            'notifications' => [
                'pending_notifications' => $approvals + $version_changes,
                'pending_discussions' => $request->user()->tickets()->open()->where('is_read_sender', 0)->count()
            ]
        ]);
    }

    public function reports()
    {
        return view('web.reports',[
            'reports' => ChildCopy::active()->approved()->get()
        ]);
    }
}
