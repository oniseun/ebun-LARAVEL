<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public function country_list()
	{
        return \DB::table('eb_countries')->select('nicename','phonecode')->orderBy('nicename','ASC')->get();
    }



// update activity time
public function update_activity_time($userID)
{

    return DB::table('eb_profiles')->where('user_id',$userID)->update(['last_activity' => now()]);

}

    
}
