<?php

namespace App\Http\Controllers\Admin;

use App\Events\DiscussionRepliedEvent;
use App\Http\Controllers\Controller;
use App\Models\NotificationTicket;
use App\Models\User;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    use CommonTrait;

    public function index($active_tab = 'discussions')
    {
        $discussions = NotificationTicket::orderBy('created_at', 'desc')->get();

        $tabs = collect([
            'discussions' => [
                'key' => 'discussions',
                'name' => 'All Conversations',
                'icon' => 'inbox',
                'group' => 1,
                'badge_color' => 'secondary',
                'count' => $discussions->count()
            ],
            'assigned' => [
                'key' => 'assigned',
                'name' => 'Assigned to me',
                'icon' => 'user-check',
                'group' => 2,
                'badge_color' => 'light',
                'count' => $discussions->where('assignee', auth()->user()->id)->count()
            ],
            'unassigned' => [
                'key' => 'unassigned',
                'name' => 'unassigned',
                'icon' => 'user-cross',
                'group' => 1,
                'badge_color' => 'light',
                'count' => $discussions->whereNull('assignee')->count()
            ],
            'unread' => [
                'key' => 'unread',
                'name' => 'unread',
                'icon' => 'mail-fill',
                'group' => 2,
                'badge_color' => 'danger',
                'count' => $discussions->where('assignee', auth()->user()->id)->where('is_read_assignee', 0)->count()
            ],
        ]);

        if (!in_array($active_tab, $tabs->keys()->toArray())) {
            return abort(404);
        }

        return view('layouts.discussions.list', [
            'tab_groups' => $tabs->groupBy('group'),
            'active_tab' => $active_tab,
            'discussions' => $this->get_tab_data($discussions, $active_tab),
            'admins' => User::admin()->get(),
            'users' => User::with('client')->get()->except(auth()->id())->sortBy('first_name')
        ]);
    }

    private function get_tab_data($discussions, $tab)
    {
        switch ($tab) {
            case 'discussions': {
                return $discussions;
                break;
            }
            case 'unread': {
                return $discussions->where('assignee', auth()->user()->id)->where('is_read_assignee', 0);
                break;
            }
            case 'assigned': {
                return $discussions->where('assignee', auth()->user()->id);
                break;
            }
            case 'unassigned': {
                return $discussions->whereNull('assignee');
                break;
            }
            case '': {
                break;
            }
        }
    }

    public function show(Request $request, NotificationTicket $ticket)
    {
        return view('layouts.discussions.view', [
            'user' => auth()->user(),
            'ticket' => $ticket,
        ]);
    }

    public function reply(Request $request, NotificationTicket $ticket)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:6000'],
            'token' => $ticket->id . time() . mt_rand(),
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

                $ticket->update([
                   'assignee' => is_null($ticket->assignee) ? auth()->user()->id : $ticket->assignee,
                   'is_read_assignee' => 1,
                   'is_read_sender' => 0
                ]);

                $message = $ticket->messages()->create([
                    'message' => $request->message,
                    'token' => $ticket->id . time() . mt_rand(),
                    'created_by' => auth()->user()->id,
                    'file' => $file_name
                ]);

                event(new DiscussionRepliedEvent($message));

                return redirect('/admin/discussions/assigned');

            } catch (\Exception $e) {

                Log::error($e->getMessage());
                dd('Something went wrong. Please try again in a few minutes');

            }

        });

    }

    public function toggle_read(Request $request, NotificationTicket $ticket)
    {
        $this->ajax_verify($request);

        $ticket->is_read_assignee = !$ticket->is_read_assignee;
        $ticket->assignee = $request->user()->id;
        $ticket->save();

        return $this->ajax_msg('success', '', '', url()->previous());

    }

    public function toggle_assign(Request $request, NotificationTicket $ticket)
    {
        $this->ajax_verify($request);

        if ($ticket->assignee != auth()->user()->id) {
            $ticket->assignee = auth()->user()->id;
            $ticket->is_read_assignee = 0;
        } else {
            $ticket->assignee = NULL;
            $ticket->is_read_assignee = 0;
        }

        $ticket->save();

        return $this->ajax_msg('success', '', '', '/admin/discussions/assigned');
    }

    public function bulk_assign(Request $request, NotificationTicket $ticket)
    {
        $this->ajax_verify($request);

        $tickets = NotificationTicket::find($request->ids);
        if (empty($request->assignee) || empty($tickets)) {
            return $this->ajax_msg('error', 'Invalid Request. Please contact your System Administrator');
        }

        $tickets->each(function($ticket) use($request) {
            $ticket->update([
                'assignee' => $request->assignee,
                'is_read_assignee' => 0
            ]);
        });

        if (auth()->user()->id != $request->assignee) {
            return $this->ajax_msg('success', '', '', '/admin/discussions');
        } else {
            return $this->ajax_msg('success', '', '', '/admin/discussions/assigned');
        }

    }


}
