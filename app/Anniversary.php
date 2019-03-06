<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anniversary extends Model
{
        public static $errors = [];
        public static $anniv_id,$annivID,$public_id;
    public static  $addAnniversaryFillable = [ 'title',  'description' ,'type','anniv_items','anniversary_date'];
    public static $updateAnniversaryFillable =  ['title' ,'description' ,'type' ,'anniv_id'];
    public static $removeAnniversaryFillable =  ['public_id'];
   
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

        

        $data['public_id'] = md5($userID.uniqid(time()));
        $data['anniversary_date'] = mysql_timestamp($data['anniversary_date']);
        $data['creator_id'] = $userID;

        $annivItems = $data['anniv_items'];
        unset($data['anniv_items']);

        $annivID = \DB::table('eb_anniversaries' )->insertGetId($data);

        self::$annivID = $annivID;
        self::$public_id =$data['public_id'];         

        if($annivID !== false)
        {
            foreach($annivItems as $itemInfo):
                                  
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
        

        $anniv_id = self::info($data['public_id'])->id;
        $delete = \DB::table('eb_anniversaries')->where('public_id',$data['public_id'])->where('creator_id',$userID)->delete();
        

		 if($delete)
		 {
             \DB::table('eb_items')->where('anniv_id',$anniv_id)->where('creator_id',$userID)->delete();
             \DB::table('eb_reminder')->where('anniv_id',$anniv_id)->delete();

		 }

		 return $delete ;
	}

	

	
	public static function expired($annivID)
	{

                return \DB::table('eb_anniversaries')->whereRaw('UNIX_TIMESTAMP(anniversary_date) < '.time())->where('id',$annivID)->exists();
		
        }
        
        public static function is_creator($userID,$annivID)
	{

                return \DB::table('eb_anniversaries')->where('creator_id',$userID)->where('id',$annivID)->exists();
		
        }
        
        
	public function add_anniversary_validate()
	{

        $validate_rules = [
            'title' =>'required|min:5',
            'description' =>'required|min:10',
    		'type' => 'required|integer|exists:eb_anniversary_types,id',
    		'anniversary_date' =>'required|date'

    	];

		$validate_messages =[
								'title.min' => 'Title is too short',
								'description.min' => 'Description is too short',

							];

	    $validator = \Validator::make(\Request::all(),$validate_rules,$validate_messages);

	    if($validator->fails())
	    {
	    	self::$errors = '<br>* '.implode('<br>* ',$validator->errors()->all());
	    	return false;
	    }
	    else
	    {
	    	return true;
        }
        

	}

    public function update_anniversary_validate()
    {

        $validate_rules = [
            'title' =>'required|min:5',
            'description' =>'required|min:10',
    		'type' => 'required|integer|exists:eb_anniversary_types,id',
    		'anniv_id' =>'required|integer|exists:eb_anniversaries,id'

    	];

		$validate_messages =[
								'title.min' => 'Title is too short',
								'description.min' => 'Description is too short',

							];

	    $validator = \Validator::make(\Request::all(),$validate_rules,$validate_messages);

	    if($validator->fails())
	    {
	    	self::$errors = '<br>* '.implode('<br>* ',$validator->errors()->all());
	    	return false;
	    }
	    else
	    {
	    	return true;
        }
        

    }



	
}
