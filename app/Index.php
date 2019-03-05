<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    public static $contactFormFillable = ['fullname','email','feedback'];
    public static function submit_contact_form()
    {
        $data = \Request::only(self::$contactFormFillable);
        $data['date_created'] = now();

        return \DB::table('eb_feedbacks')->insert($data);
    }
}
