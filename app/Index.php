<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    public static $contactFormFillable = ['full_name','email','comment'];
    public static function submit_contact_form()
    {
        $data = \Request::only(self::$contactFormFillable);
        $data['date_created'] = now();

        return \DB::table('contact_form')->insert($data);
    }
}
