<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anniversary extends Model
{
    public static  $addAnniversaryFillable = [ 'title',  'description' ,'type','anniv_items'];
    public static $updateAnniversaryFillable =  ['title' ,'description' ,'type' ,'anniv_id'];
    public static $removeAnniversaryFillable =  ['public_id'];
    public static $deactivateItemFillable =   [  'activator_name' ,  'activator_email' ,'activator_phone', 'id','anniv_id'];

	public static function info($anniv_id)
	{
        return  \DB::table('eb_anniversaries')->where('public_id',$anniv_id)->orWhere('id',$anniv_id)->first();

	}

	public static function data_exist($userID,$anniv_id)
	{
        self::$anniv_id = $anniv_id;

        return \DB::table('eb_anniversaries')
                ->where(function ($query) {
                    $anniv_id = self::$anniv_id;
                    unset(self::$anniv_id);
                    $query->where('public_id',$anniv_id)->orWhere('id',$anniv_id);
                })
                ->where('creator_id',$userID)->exists();
    }

	public static function profile_anniv_count($userID)
	{
       return  \DB::table('eb_anniversaries')->where('creator_id',$userID)->count();
	}

	

	public static function types()
	{
        return \DB::table('eb_anniversary_types')->get();
	}


	

	public static function get_icon($anniv_type)
	{
        return \DB::table('eb_anniversary_types')->where('id',$anniv_type)->value('icon');
	}




	public static function _list($userID,$limit = 5)
	{
        return  \DB::table('eb_anniversaries')->where('creator_id',$userID)->orderBy('anniversary_date','DESC')->limit($limit)->get();

	}

	public static function add($userID)
	{

        $data = \Request::only(self::$addAnniversaryFillable) ;

        

        $data['public_id'] = uniqid(time());
        $data['anniversary_date'] = mysql_timestamp($data['anniversary_date']);
        $data['creator_id'] = $userID;

		$annivID = \DB::table('eb_anniversaries' )->insertGetId($data);

        if($annivID !== false)
        {
            foreach($data['anniv_items'] as $itemInfo):
                                  
                    self::add_items($userID,$annivID, $itemInfo['item_type'],$itemInfo['item_description'],$itemInfo['item_link']);
                
            endforeach;
        
           return true;

        }
        else 
        {
           return false;
        }




    }
    
    
	public static function add_items($userID,$anniv_id,$item_type,$item_description,$item_link)
	{
		
		if(strlen($item_description) > 4 && !empty($item_type) && is_numeric($item_type))
		{
            $data =
            [
		      'creator_id' => $userID,
		        'anniv_id' => $anniv_id,
		        'link' =>$item_link,
		        'description'=> $item_description,
		        'type' => $item_type

            ];

            return \DB::table('eb_items')->insert($data);
			
		}


	}

	


	public static function modify($userID)
	{
                   
          $data = \Request::only(self::$updateAnniversaryFillable);

          $annivID = $data['anniv_id'];
          unset($data['anniv_id']);


          return \DB::table('eb_anniversaries')->where('creator_id',$userID)->where('id',$annivID)->update($data);

	}

	public static function remove($userID)
	{
        $data = \Request::only(self::$removeAnniversaryFillable);
        

        $anniv_id = self::info($data['public_id']);
        $delete = \DB::table('eb_anniversaries')->where('public_id',$data['public_id'])->where('creator_id',$userID)->delete();
        

		 if($delete)
		 {
             \DB::table('eb_items')->where('anniv_id',$anniv_id)->where('creator_id',$userID)->delete();
             \DB::table('eb_reminder')->where('anniv_id',$anniv_id)->delete();

		 }

		 return $delete ;
	}

	

	
	public function expired($annivID)
	{

        return \DB::table('eb_anniversaries')->whereRaw('UNIX_TIMESTAMP(anniversary_date) < '.time())->where('id',$annivID)->exists();
		
	}


	public static function has_deactivated($annivID)
	{
        return \DB::table('eb_items')->where('activator_ip', \Request::ip())->where('anniv_id',$annivID)->exists();

	}
}
