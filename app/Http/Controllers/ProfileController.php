<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auth;
use App\Profile;

class ProfileController extends Controller
{
    public function dashboard(){

        return view('dashboard');

    }
    
    public function profileInfo(){
    
        $userInfo = Auth::currentUser();
        return view('user.changeInfoForm',compact('userInfo'));
    }


    public function profilePassword(){
    
        $userInfo = Auth::currentUser();
        return view('user.changePasswordForm',compact('userInfo'));
    }

    public function profilePhoto(){
    
        $userInfo = Auth::currentUser();
        return view('user.changePhotoForm',compact('userInfo'));
    }

    public function updateInfo(){

        if(!Profile::update_info_validate(Auth::id()))
        {
            echo ajax_alert('warning',Profile::$errors);
            exit;
            
        }

        $former_email = Auth::currentUser()->email;

        

        if (\Request::has(Profile::$updateInfoFillable) && Profile::update_info(Auth::id())) {


            if($former_email !== \Request::only(Profile::$updateInfoFillable)['email'] )
            {
                Auth::resend_verify_link();
                Auth::send_verification_mail(Auth::currentUser()->email);
            }

            echo ajax_alert('success',' Profile Updated Successfully');
        }
        else {
            echo ajax_alert('warning',' -- Error updating profile -- ');
        }
    
    
    }
    
    public function updatePassword(){
        if (\Request::has(Profile::$updatePasswordFillable) ) {

            if(!Profile::update_password_validate())
            {
                echo ajax_alert('warning',Profile::$errors);
                exit;
                
            }
            $email = Auth::currentUser()->email;
            extract(\Request::only(Profile::$updatePasswordFillable));
           
            Profile::change_password(Auth::id())   ;   
            Auth::create_session($email); // relogin with new access token
        
            echo ajax_alert('success',' Password Updated Successfully');
            
        }
        else {
            echo ajax_alert('warning',' -- Error updating password  -- ');
        }
    
    
    }
    
    public function updatePhoto(){
        if(!Profile::update_photo_validate())
        {
            return back()->with('failure',Profile::$errors);
            exit;
            
        }

        if (\Request::has(Profile::$updatePhotoFillable) && Profile::change_photo(Auth::id())) {

            
            return back()->with('success',' Photo Updated Successfully');
        }
        else {
            return back()->with('failure',' -- Error updating photo -- ');
        }
    
    }
}
