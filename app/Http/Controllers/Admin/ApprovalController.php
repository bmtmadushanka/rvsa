<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationApproval;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApprovalController extends Controller
{
    use CommonTrait;

    public function index()
    {
        return view('admin.approvals.list', [
           'tab_data' => NotificationApproval::pending()->whereNull('reviewed_at')->orderBy('created_at', 'DESC')->get()
        ]);
    }

    public function show(NotificationApproval $approval)
    {
        return view('layouts.approvals.view', compact('approval'));
    }

    public function update(Request $request, NotificationApproval $approval)
    {
        $this->ajax_verify($request);

        if ($request->status === 'approve') {
            foreach ($approval->fields AS $column => $value) {
                $approval->creator->client->$column = $value['new'];
            }
            $approval->creator->client->save();
        }

        $approval->is_read_admin = 1;
        $approval->reviewed_by = auth()->user()->id;
        $approval->is_approved = $request->status === 'approve' ? 1 : 0;
        $approval->reviewed_at = date('Y-m-d H:i:s');

        try {
            $approval->save();
            $approval->creator->activities()->create([
                'activity_id' => $request->status === 'approve' ? 8 : 9,
                'reference' => $approval->id
            ]);
        } catch (\Exception $e) {
            report($e->getMessage());
            Log::error($e->getMessage());
            dd('Something Went Wrong! Please try again in a few minutes');
        }

        return $this->ajax_msg('success', 'The approval has been updated successfully', '', '/admin/approval');

    }
}
