<?php

namespace App\Http\Controllers\Web;

use App\Events\DiscussionRepliedEvent;
use App\Events\DiscussionStartedEvent;
use App\Http\Controllers\Controller;
use App\Models\NotificationTicket;
use App\Models\NotificationTicketMessage;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    use CommonTrait;

    public function index(Request $request)
    {
        return view('layouts.discussions.list', [
            'subjects' => $this->get_discussion_subjects(),
            'discussions' => NotificationTicket::where('created_by', auth()->id())->orWhere('assignee',  auth()->id())->latest()->get(),
            'reports' => auth()->user()->model_reports
        ]);
    }

    public function store(Request $request)
    {
        $this->ajax_verify($request);

        $rules = [
            'subject' => ['required'],
            'message' => ['required', 'string', 'max:6000'],
            'file' => ['nullable', 'mimes:jpg,jpeg,gif,png,pdf', 'max:20000']
        ];

        if ((int)$request->subject && in_array($request->subject, [4, 5])) {
            $rules['vin'] = ['required'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        $subjects = $this->get_discussion_subjects();

        return DB::transaction(function () use($request, $subjects) {

            try {

                $ticket = NotificationTicket::create([
                    'order_report_id' => $request->vin ?? NULL,
                    'subject' => $request->user()->is_admin ? $request->subject : $subjects[$request->subject],
                    'created_by' => $request->user()->is_admin ? $request->assignee : auth()->user()->id,
                    'assignee' => $request->user()->is_admin ? auth()->user()->id : NULL,
                    'is_read_sender' => !$request->user()->is_admin,
                    'is_read_assignee' => $request->user()->is_admin
                ]);

                $file_name = '';

                if ($request->hasFile('file')) {

                    $file = $request->file('file');
                    $file_name = time() . mt_rand() . '.' . $file->getClientOriginalExtension();
                    $file_path = 'uploads/files/discussions/' . $ticket->id;
                    $file->move(public_path($file_path), $file_name);
                }

                $message = $ticket->messages()->create([
                    'message' => $request->message,
                    'token' => $ticket->id . time() . mt_rand(),
                    'created_by' => auth()->user()->id,
                    'file' => $file_name
                ]);

                event(new DiscussionStartedEvent($message));

                return $this->ajax_msg('success', 'New discussion has been created successfully.', null, ((int)$request->subject ? '' : 'admin/') . 'discussions');

            } catch (\Exception $e) {
                report($e->getMessage());
                Log::error($e->getMessage());
                dd('Something went wrong. Please try again in a few minutes');
            }

        });

    }

    public function show(Request $request, NotificationTicket $ticket)
    {
        if ($ticket->created_by != $request->user()->id) {
            abort(404);
        }

        return view('layouts.discussions.view', [
            'user' => auth()->user(),
            'ticket' => $ticket,
        ]);
    }

    public function view(Request $request, $token)
    {
        // if admin, redirect to admin portal
        if ($request->user()->is_admin) {
            $message = NotificationTicketMessage::where('token', $token)->first();
            return redirect('/admin/' . (!empty($message) ? 'discussion/' . $message->ticket->id : 'discussions'));
        }

        // if user, load teh view from token
        $message = NotificationTicketMessage::where('token', $token)->get()->filter(function($message) {
            return $message->ticket->created_by == auth()->id() || $message->ticket->assignee == auth()->id();
        });

        if ($message->isEmpty()) {
            return redirect('/discussions');
        }

        return view('layouts.discussions.view', [
            'user' => auth()->user(),
            'ticket' => $message->first()->ticket,
        ]);
    }

    public function reply(Request $request, NotificationTicket $ticket)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:6000'],
            'file' => ['nullable', 'mimes:jpg,jpeg,gif,png,pdf', 'max:20000']
        ]);

        return DB::transaction(function () use($request, $ticket) {

            try {

                $file_name = '';

                if ($request->hasFile('file')) {

                    $file = $request->file('file');
                    $file_name = time() . mt_rand() . '.' . $file->getClientOriginalExtension();
                    $file_path = 'uploads/files/discussions/' . $ticket->id;
                    $file->move(public_path($file_path), $file_name);
                }

                $message = $ticket->messages()->create([
                    'message' => $request->message,
                    'token' => $ticket->id . time() . mt_rand(),
                    'created_by' => auth()->user()->id,
                    'file' => $file_name
                ]);

                $ticket->is_read_sender = 1;
                $ticket->is_read_assignee = 0;
                $ticket->save();

                event(new DiscussionRepliedEvent($message));

                return redirect('/discussions');

            } catch (\Exception $e) {
                Log::error($e->getMessage());
                dd('Something went wrong. Please try again in a few minutes');
            }

        });

    }

    public function toggle_read(Request $request, NotificationTicket $ticket)
    {
        $this->ajax_verify($request);

        $ticket->is_read_sender = !$ticket->is_read_sender;
        $status = $ticket->is_read_sender ? 'unread' : 'read';
        $ticket->save();

        return $this->ajax_msg('success', '', ['status' => $status]);

    }

    public function delete(Request $request, NotificationTicket $ticket)
    {
        $this->ajax_verify($request);

        if ($ticket->created_by != $request->user()->id) {
            abort(403);
        }

        $ticket->delete();

        return $this->ajax_msg('success', 'The discussion has been deleted successfully');
    }


}
