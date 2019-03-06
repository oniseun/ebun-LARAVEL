<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reminder;
use App\Auth;
class CronController extends Controller
{
    public function dispatchEmail()
    {
        $queue = Reminder::email_queue(100);
        $view = $plain_view = 'email.reminder';

        foreach($queue as $details):

            $data = [ 'content' => $details->message ];

            Auth::send_fast_mail($details->subject, $details->activator_email, $data, $view , $plain_view);
            sleep(5);
            Reminder::mark_as_sent($details->id);

        endforeach;

    }

    public function dispatchSMS()
    {
        $queue = Reminder::sms_queue(100);

        foreach($queue as $details):

            Auth::send_sms($details->activator_phone, $details->country_code, $details->message, env('APP_NAME'));
            sleep(5);
            Reminder::mark_as_sent($details->id);

        endforeach;
    }
}
