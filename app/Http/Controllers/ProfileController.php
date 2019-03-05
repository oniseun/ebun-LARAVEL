<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $former_email = Auth::currentUser()->email;

        if (\Request::has(Profile::$updateInfoFillable) && Profile::update_info(Auth::id())) {

            $successMsg = 'Updated profile information  on '.date("d/m/Y h:i:s");

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

            extract(\Request::only(Profile::$updatePasswordFillable));
            if($new_password !== $confirm_password)
            {
                echo ajax_alert('warning',' -- new and confirm password do not match-- ');
            }
            else
             {  
                 Profile::change_password(Auth::id())   ;     
                
                echo ajax_alert('success',' Password Updated Successfully');
            }
        }
        else {
            echo ajax_alert('warning',' -- Error updating password  -- ');
        }
    
    
    }
    
    public function updatePhoto(){
    
        if (\Request::has(Profile::$updatePhotoFillable) && Profile::change_photo(Auth::id())) {

            
            echo ajax_alert('success',' Photo Updated Successfully');
        }
        else {
            echo ajax_alert('warning',' -- Error updating photo -- ');
        }
    
    }
}
