<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Notification;
use App\User;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Flash;
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
        $this->validate($request, [
            'message' => 'required',
        ]);

        $user = $request->has('user') ? $request->get('user') : null;

        $users = $user ? User::where('id', $user)->get() : User::where('device_token', '<>', '')->get();

        $users = $users->groupBy('device');

        if (isset($users['ios'])) {
            $devices = [];
            foreach($users['ios'] as $device) {
                $devices[] = PushNotification::Device($device['device_token']);
            }
            $devices = PushNotification::DeviceCollection($devices);
            $collection = PushNotification::app('ios')->to($devices)->send($request->get('message'));

            // get response for each device push
            foreach ($collection->pushManager as $push) {
                Notification::create([
                    'message' => $request->get('message'),
                    'response' => serialize($push->getAdapter()->getResponse()),
                ]);
            }
        }

        if (isset($users['android'])) {
            $devices = [];
            foreach($users['android'] as $device) {
                $devices[] = PushNotification::Device($device['device_token']);
            }
            $devices = PushNotification::DeviceCollection($devices);
            $collection = PushNotification::app('android')->to($devices)->send($request->get('message'));

            // get response for each device push
            foreach ($collection->pushManager as $push) {
                Notification::create([
                    'message' => $request->get('message'),
                    'response' => serialize($push->getAdapter()->getResponse()),
                ]);
            }
        }

        Flash::success("Push сообщение отправлено");

        return redirect(route('admin.notification'));
    }
}
