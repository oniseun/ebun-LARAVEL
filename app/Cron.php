<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cron extends Model
{
    public static function get_email_reminders($limit = 1000)
    {
        return \DB::table('eb_reminder')->whereRaw('UNIX_TIMESTAMP(reminder_date) <= '.time())
                                        ->where('alert_type','email')
                                        ->where('sent','no')->limit($limit)->get();
    }

    public static function get_sms_reminders($limit = 1000)
    {
        return \DB::table('eb_reminder')->whereRaw('UNIX_TIMESTAMP(reminder_date) <= '.time())
                                        ->where('alert_type','sms')
                                        ->where('sent','no')->limit($limit)->get();
    }
 
    public static function mark_as_sent($reminder_id)
    {
       return  \DB::table('eb_reminder')->where('id',$reminder_id)->update(['sent' => 'yes']);
    }
}
