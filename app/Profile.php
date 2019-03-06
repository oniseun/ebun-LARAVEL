<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public static $errors = [];
    public static  $updateInfoFillable = ['fullname','phone','email'];
    public static  $updatePasswordFillable = ['new_password','confirm_password'];
    public static  $updatePhotoFillable = ['photo'];
    
public static function update_info($userID)
{
    
    $data = \Request::only(self::$updateInfoFillable);
    //unset($data['email']); // don't allow changing of email address


    return \DB::table('eb_profiles')->where('user_id',$userID)->update($data);
    
}


// 21.) change_password
public static function change_password($userID)
{

    $data = \Request::only(self::$updatePasswordFillable);
    $new_password = bcrypt($data['confirm_password']);

    $access_token = md5(uniqid().microtime().strrev(uniqid()));

    return \DB::table('eb_profiles')->where('user_id',$userID)->update([ 'password' => $new_password, 'access_token' => $access_token ]);
   

}


// 22.) change_photo
public static function change_photo($userID)
{

    $data = \Request::only(self::$updatePhotoFillable);

    $upload_folder = 'uploads/'.date("Y/m");
    $user_name = $userID;
    $extension = \Request::file('photo')->extension();
    $new_name = str_slug($user_name.microtime().rand(111,666));	
    $full_file_name = "$new_name.$extension";

    $new_photo = \Request::file('photo')->storeAs($upload_folder,$full_file_name,'uploads');
  
    
    return \DB::table('eb_profiles')->where('user_id',$userID)->update([ 'display_picture' => $new_photo ]);


}

public static function user_info($userID)
{
    return \DB::table('eb_profiles')->where('user_id',$userID)->first();

}


public function update_info_validate()
{
    $uid = \App\Auth::id();
    $validate_rules = [
        'fullname' =>'required|min:5|max:30',
        'email' =>'required|email|unique:users,email,'.$uid.',id',
        'phone' => 'nullable|digits_between:5,12|unique:eb_profiles,phone,'.$uid.',id',
    


    ];

    $validate_messages =[];

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

public function update_password_validate()
{

    $validate_rules = [
        'current_password' =>'required|min:5',
        'new_password' => 'required|min:5|confirmed',
    ];

    $validate_messages =[];


    $validator = \Validator::make(\Request::all(),$validate_rules,$validate_messages);

    if($validator->fails())
    {
        self::$errors = '<br>* '.implode('<br>* ',$validator->errors()->all());
        return false;
    }
    elseif(!\Hash::check(\Request::input('current_password'),\App\Auth::password()))
    {
        self::$errors = '<br>* Old password incorrect' ;
        return false;
    }
    else
    {
        return true;
    }

    
    
}


 public function update_picture_validate()
{
    $validate_rules = [
        'photo' => 'required|image|mimes:jpeg,png|max:5000|dimensions:min_width=200,max_width:200,min_height:200,max_height:200',

    ];

    $validate_messages =[];


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
