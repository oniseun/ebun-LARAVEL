<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auth;

class AuthController extends Controller
{

    public function logoutForm(){
        $userInfo = Auth::currentUser();
        return view('auth.logoutForm',compact('userInfo'));
    
    }

    

    public function forgotPasswordForm(){
        
           return view('auth.forgotPasswordForm');
       
    
    }

    public function resendVerification()
    {
        
            Auth::resend_verify_link();
            Auth::send_verification_mail(Auth::currentUser()->email);
            return view('auth.verifyResendForm');

         
    }


    public function verifyEmail($verify_code)
    {
        if(Auth::verify_code_exist($verify_code))
        {
            Auth::verify_email($verify_code);
            Auth::expire_verify_code($verify_code);

            if(!Auth::check())
            {
                return view('auth.verifySuccess'); 
            }
            else {
                return view('auth.verifySuccessAdmin');
            }
            
        }
        else {
            

                    if(!Auth::check())
                    {
                        return view('404');
                    }
                    else {
                        return view('404Admin');
                    }
        }
    }

    
    public function resetPasswordForm($reset_code){

        
        if(!Auth::reset_code_expired($reset_code))
        {
            return view('auth.resetPasswordForm',['reset_code' => $reset_code]);
        }
        else {
            if(!Auth::check())
                    {
                        return view('404');
                    }
                    else {
                        return view('404Admin');
                    }
        }
    
    }

    public function login(){
        
        if (!\Request::has(Auth::$loginFormFillable)) {
            return back()->with('failure', "Error in your form fields, please check, make corrections and submit again");
            exit;
        }

        if(!Auth::login_user_validate())
            {
                echo ajax_alert('warning',Auth::$errors);
                exit;
                
            }

        if(Auth::login_user())
        {
            $redirect_url = \Request::has('redirect_url') ? \Request::input('redirect_url') : '/admin/dashboard';

            return redirect($redirect_url);;
        }
        else {
            return back()->with('failure', "Email or password Incorrect!!");
        }
    
    }
    

    
    public function register(){
    
        if (!\Request::has(Auth::$registerFormFillable)) {
            return back()->with('failure', "Error in your form fields, please check, make corrections and submit again");
            exit;
        }

        if(!Auth::register_user_validate())
        {
            return back()->with('failure',Auth::$errors);
            exit;
            
        }

        extract(\Request::only(Auth::$registerFormFillable));
        if(Auth::register_user())
        {
            
            $redirect_url = isset($redirect_url) ? $redirect_url : '/admin/dashboard';

            Auth::send_verification_mail($email);
            Auth::create_session($email);

            return redirect($redirect_url);
        }
        else {
            return back()->with('failure', "Email already exist or some fields are empty or passwords do not match...");
        }
    
    }
        
    public function logout(){
    
        Auth::logout();
        return redirect('/home');
    
    }

    public function reset(){
    
        if (!\Request::has(Auth::$resetLinkFillable)) {
            echo  ajax_alert('warning',  "Error in your form fields, please check, make corrections and submit again");
            exit;
        }

        if(Auth::send_reset_link())
        {
            $email = \Request::only(Auth::$resetLinkFillable)['email'];
            Auth::send_reset_mail($email);

            echo  ajax_alert('success', 'Reset link sent.. Check your mail!! <a href="/home">go home</a>');
        }
        else {
            echo  ajax_alert('warning',  "Email does not exist");
        }
    
    }


    public function resetPassword(){
    
        if (!\Request::has(Auth::$resetPasswordFillable)) {
            return back()->with('failure', "Error in your form fields, please check, make corrections and submit again");
            exit;
        }

        if(!Auth::reset_password_validate())
        {
            return back()->with('failure',Auth::$errors);
            exit;
            
        }

        extract(\Request::only(Auth::$resetPasswordFillable));

        if(!Auth::reset_code_expired($reset_code) && Auth::reset_email_match($email,$reset_code) && Auth::reset_password())
        {
            Auth::expire_reset_code($email);
            Auth::create_session($email);
             return redirect('/admin/dashboard');
        }
        else {
            return back()->with('failure', "-- Error could not reset password -- !!");
        }
    
    }


    
}
