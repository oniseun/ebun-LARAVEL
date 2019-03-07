<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    public static $errors = [];
    public static $addItemFillable  = [ 'anniv_id', 'link','description', 'type','public_id'];
    public static $deactivateItemFillable =   [  'activator_name' ,  'activator_email' ,'activator_phone',
                                                'country_code','alert_type', 'id','anniv_id','public_id'];

    
	public static function info($anniv_id,$item_id)
	{
        return \DB::table('eb_items')->where('id',$item_id)->where('anniv_id',$anniv_id)->first();
    }
    

	public static function types()
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
    
    public static function add($userID)
	{
		
        $data = \Request::only(self::$addItemFillable) ;
        unset($data['public_id']);
        $data['creator_id'] = $userID ;
		return  \DB::table('eb_items' )->insert($data);

    }
    
    public static function remove($userID,$annivID,$itemID)
	{
         
        return \DB::table('eb_items')->where('creator_id',$userID)->where('anniv_id',$annivID)->where('id',$itemID)->delete();

    }

    public static function deactivate()
	{
            $data = \Request::only(self::$deactivateItemFillable);
          
        
            $data['deactivated'] = 'yes';
            $data['date_deactivated'] = now();
            $data['activator_ip'] = \Request::ip();
            $data['activator_ua_hash'] = md5(\Request::header('User-Agent') );
            
            $itemID = $data['id']; 
            $annivID = $data['anniv_id']; 
            unset($data['id'],$data['anniv_id'],$data['public_id']);

            return \DB::table('eb_items')->where('id',$itemID)->where('anniv_id',$annivID)->update($data);

		    
    }
    
    public static function has_deactivated($annivID)
	{
        return \DB::table('eb_items')->where('activator_ip', \Request::ip())->where('anniv_id',$annivID)->exists();

    }
    
    

    public static function deactivate_item_validate()
    {

        $input = \Request::only(self::$deactivateItemFillable);
        $validate_rules = [
            'activator_name' =>'required|min:5|max:20',
            'activator_email' =>'required|email',
            'activator_phone' =>'nullable|digits_between:5,12',
            'country_code' =>'required|integer|exists:eb_countries,phonecode',
    		'alert_type' => 'required|in:email,sms',
            'anniv_id' =>'required|integer|exists:eb_anniversaries,id',
            'id' =>'required|integer|exists:eb_items,id'

    	];

        $validate_messages =[];
	    $validator = \Validator::make($input,$validate_rules,$validate_messages);

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

    
    public static function add_item_validate()
    {
        $input = \Request::only(self::$addItemFillable);

        $validate_rules = [
    		'description' =>'required|min:5',
    		'anniv_id' => 'required|integer|exists:eb_anniversaries,id',
    		'type' =>'required|integer|exists:eb_item_types,id'

    	];

		$validate_messages =[];

	    $validator = \Validator::make($input,$validate_rules,$validate_messages);

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
