<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\User;
use DB;
use Illuminate\Http\Request;

class NotificationsController extends BackendController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function notification(Request $request, $user = null)
    {
        if ($user) {
            $user = User::findOrFail($user);
        }

        return view('admin.notifications.form', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function sendNotification(Request $request)
    {
        $user = $request->has('user') ? $request->get('user') : null;
        $user = User::findOrFail($user);

        $pushSent = false;
        // отправка Push сообщения
        $pushSent = true;

        return view('admin.notifications.form', compact('pushSent'));
    }
}
