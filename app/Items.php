<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    public static $addItemFillable  = [ 'anniv_id', 'link','description', 'type'];
    
	public static function info($anniv_id,$item_id)
	{
        return \DB::table('eb_items')->where('id',$item_id)->where('anniv_id',$anniv_id)->first();
    }
    

	public static function item_types()
	{
        return \DB::table('eb_item_types')->get();
	}

    public static function get_icon($item_type)
	{
        return \DB::table('eb_item_types')->where('id',$item_type)->value('icon');
    }
    
    public static function data_count($anniv_id)
	{
        return  \DB::table('eb_items')->where('anniv_id',$anniv_id)->count();

    }
    
    public static function data_list($anniv_id,$limit = 50)
	{
        return \DB::table('eb_items')->where('anniv_id',$anniv_id)->limit($limit)->get();
    }
    
    public static function add_new($userID)
	{
		
        $data = \Request::only(self::$addItemFillable) ;

        $data['creator_id'] = $userID ;
		return  \DB::table('eb_items' )->insert($data);

    }
    
    public static function remove($userID,$annivID,$itemID)
	{
         
        return \DB::table('eb_items')->where('creator_id',$userID)->where('anniv_id',$annivID)->where('id',$itemID)->delete();

    }

    public static function deactivate($data)
	{
            $data = \Request::only(self::$deactivateItemFillable);
          
        
            $data['deactivated'] = 'yes';
            $data['date_deactivated'] = now();
            $data['activator_ip'] = \Request::ip();
            $data['activator_ua_hash'] = md5(\Request::header('User-Agent') );
            
            $itemID = $data['id']; unset($data['id']);
            $annivID = $data['anniv_id']; unset($data['anniv_id']);

            return \DB::table('eb_items')->where('id',$itemID)->where('anniv_id',$annivID)->update($data);

		    
	}
    
}
