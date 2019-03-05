<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mail\Fastmail;

class Auth extends Model
{
    public static $loginFormFillable = ['email','password'];
    public static $registerFormFillable = ['email', 'fullname', 'phone','confirm_password','password', 'gender', 'date_of_birth' ];
    public static $resetPasswordFillable = ['email','reset_code','new_password','confirm_password'];
    public static $resetLinkFillable = ['email'];
    // login_id
    
        public static function check()
        {
    
            if (\Request::session()->has('eb_user_id') && \Request::session()->has('eb_access_token')) {
    
                $db_check = \DB::table('cl_members')->where('id', session('eb_user_id'))
                    ->where('access_token', session('eb_access_token'))
                    ->exists();
    
                if ($db_check) // check if session data is in database
                {
                    return true;
                } else {
                    self::logout(); // logout false session
                    return false;
                }
            } else
            {
                
                return false;
            }
    
        }
        public static function attempt($email, $password)
        {
    
            if (self::email_exist($email)) {
                $user_password = self::get_password($email);
                return \Hash::check($password, $user_password) ? true : false;
            } else
                return false;
    
        }
    
        public static function login_user()
        {
            $data = \Request::only(self::$loginFormFillable);
    
            if(self::attempt($data['email'],$data['password']))
            {
                self::create_session($data['email']);
                return true;
                
            }
            else {
                return false;
            }
        }
    
        public static function id()
        {
            return session('eb_user_id');
        }

        // logout
  
    public static function currentUser()
    {
       return  \DB::table('cl_members')->where('id', self::id())->first();
    }

    public static function getInfoByEmail($email)
    {
        return \DB::table('cl_members')->where('email', $email)->first();
    }
   

    public static function create_session($email)
    {

        $user_info = self::getInfoByEmail($email);

        session([
            'eb_user_id' => $user_info->id,
            'eb_access_token' => $user_info->access_token
        ]);

    }

    public static function get_password($email)
    {

        return \DB::table('cl_members')->where('email', $email)->value('password');

    }

    public static function email_exist($email)
    {

        return \DB::table('cl_members')->where('email', $email)->exists();

    }

    public static function logout()
    {

        \Request::session()->forget('eb_user_id');
        \Request::session()->forget('eb_access_token');

    }



// verify_email
public static function verify_email($verify_code)
{
    return \DB::table('cl_members')->where('verify_code',$verify_code)->update(['email_verified' => 'yes','verify_code_expiry' => now()]) ;

}


// register_user
public static function register_user()
{
    
    $data = \Request::only(self::$registerFormFillable);

        
      $data['loginid'] = str_slug($data['fullname']);
      $data['password'] = bcrypt($data['confirm_password']);
      $data['date_of_birth'] = mysql_timestamp($data['date_of_birth']);
      $data['access_token'] = md5(uniqid().microtime().strrev(uniqid()));
      $data['verify_code'] = md5($data['fullname'].$data['email'].time().uniqid().microtime());
      $data['verify_code_expiry'] = date("Y-m-d H:i:s",(time() + (86400 * 30)));

      unset($data['confirm_password']);

      return \DB::table('cl_members')->insert($data);

     
    
}

// send_reset_link
public static function resend_verify_link()
{
$data['verify_code'] = md5(self::currentuser()->fullname.self::currentuser()->email.time().uniqid().microtime());
$data['verify_code_expiry'] = date("Y-m-d H:i:s",(time() + (86400 * 30)));
$data['email_verified'] ='no';

return  \DB::table('cl_members' )->where('email',self::currentuser()->email)->update($data);

// controller --> self::send_reset_mail($data['email']);

}


// send_reset_link
public static function send_reset_link()
{
$data = \Request::only(self::$resetLinkFillable);
$data['reset_code'] = md5($data['email'].strrev(uniqid()).str_shuffle(uniqid()));
$data['reset_code_expiry'] = date("Y-m-d H:i:s",(time() + 86400));

return  \DB::table('cl_members' )->where('email',$data['email'])->update($data);

// controller --> self::send_reset_mail($data['email']);

}


// reset_password
public static function reset_password()
{
    $data = \Request::only(self::$resetPasswordFillable);

  return \DB::table('cl_members')
  ->where('email',$data['email'])
  ->where('reset_code',$data['reset_code'])
  ->where('reset_code_expiry','>',now())
  ->update(['password' => bcrypt($data['confirm_password'])]);
    


}



public static function send_reset_mail($email)
{
	
   		$userInfo = self::getInfoByEmail($email);
   		$subject = 'Reset your password - Connect Lagos';

   		self::send_fast_mail($subject,$email,compact('userInfo'),'email.reset-code','email.reset-code');
}

public static function send_verification_mail($email)
{
		
        $userInfo = self::getInfoByEmail($email);
   		$subject = 'Verify your Email';

   		self::send_fast_mail($subject,$email,compact('userInfo'),'email.verify','email.verify');
}



public static function send_fast_mail($subject,$to,$data,$view ,$plain_view = NULL)
{

	return \Mail::to($to)->send(new \App\Mail\FastMail($subject,$data,$view,$plain_view));

}



public static function reset_email_match($email,$reset_code) 
{

	return \DB::table('cl_members')->where('email',$email)
							->where('reset_code',$reset_code)
							->where('reset_code_expiry','>',now())
							->exists();

}

public static function verify_code_exist($verify_code) 
{

	return \DB::table('cl_members')->where('verify_code',$verify_code)
                                    ->where('verify_code_expiry','>',now())
                                    ->exists();

}

public static function is_verified() 
{

	return \DB::table('cl_members')->where('id',self::id())
                                    ->where('email_verified','yes')
                                    ->exists();

}

public static function expire_verify_code($verify_code) 
{

	return \DB::table('cl_members')
            ->where('verify_code',$verify_code)
            ->update(['verify_code_expiry' => now()]);

}

public static function reset_code_expired($reset_code) 
{

	return \DB::table('cl_members')
							->where('reset_code',$reset_code)
							->where('reset_code_expiry','<',now())
							->exists();

}

public static function expire_reset_code($email) 
{

	return \DB::table('cl_members')
            ->where('email',$email)
            ->update(['reset_code_expiry' => now()]);

}


}
