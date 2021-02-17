<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Notifications\PushDemo;
use App\Models\User;
use Notification;
use Auth;

class PushController extends AdminController {

    /**
     * Store the PushSubscription.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $this->validate($request, [
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required'
        ]);

        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);
        return response()->json(['success' => true], 200);
    }

    /**
     * Send Push Notifications to all users.
     * 
     * @return \Illuminate\Http\Response
     */
    public function push() {
        Notification::send(User::all(), new PushDemo('تبيه خاص بالكميات في المخزن', '/notification-icon.png', 'وجود منتج نفذ من المخزن', 'عرض المخزن'));
        return redirect()->back();
    }

}
