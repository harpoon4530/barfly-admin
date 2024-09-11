<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Notification;
use Carbon\Carbon;

class NoticationController extends Controller
{

    public function get_notication($user_id) {
        $notifications = Notification::where('user_id', $user_id)
        ->where('updated_at', '>=', Carbon::now()->subDay())
        ->get();

        if ($notifications === null) {
            return response()->json(['error' => 'No record found'], 404);
        }

        foreach ($notifications as $notification) {
            $order = $notification->order;
            $order->items;
            $order->bar;
            $order->status;
        }

        return $notifications;
    }

}