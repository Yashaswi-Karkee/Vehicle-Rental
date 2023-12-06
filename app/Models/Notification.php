<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notification';
    public static function notify($message, $to, $from)
    {
        $notification = new Notification();
        $notification->message = $message;
        $notification->notification_from = $from;
        $notification->notification_to = $to;
        $notification->save();
    }

    public static function markRead()
    {
        $email = Session::get('loginEmail');
        $notification = Notification::where('notification_to', $email)->where('isRead', 0)->get();
        if ($notification != null) {

            foreach ($notification as $notif) {

                $notif->isRead = 1;
            }
            $notification->update();
        }
    }
}
