<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Traits\NotificationTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use NotificationTrait;

    private $data = [];

    public function index(Request $request, $active_tab)
    {
        $tabs = $this->get_tabs($request->user());

        if (!in_array($active_tab, array_keys($tabs))) {
            return abort(404);
        }

        return view('web.user.notifications', [
            'tab_groups' => collect($tabs)->groupBy('group'),
            'active_tab' => $active_tab,
            'tab_data' => $this->get_tab_data($active_tab, auth()->user()),
        ]);
    }

}
