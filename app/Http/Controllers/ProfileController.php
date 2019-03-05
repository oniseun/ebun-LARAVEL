<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function dashboard(){

        return view('dashboard');

    }
    
    public function ajaxMiniStats(){
    
        $balance = Wallet::balance(Auth::id());
        $userStats = Site::user_stats(Auth::id());
        
        return view('miniStats',compact('balance','userStats'));
    }
    
    public function profileForms(){
    
        $userInfo = Auth::currentUser();
        return view('profileForm',compact('userInfo'));
    }
    
    public function updateInfo(){

        $former_email = Auth::currentUser()->email;

        if (\Request::has(Profile::$updateInfoFillable) && Profile::update_info(Auth::id())) {

            $successMsg = 'Updated profile information  on '.date("d/m/Y h:i:s");
            Activities::create(Auth::id(),$successMsg, 'cl_members');

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
                 Auth::create_session(Auth::currentUser()->email); // recreate session          
                $successMsg = 'Updated password  on '.date("d/m/Y h:i:s");
                
                echo ajax_alert('success',' Password Updated Successfully');
            }
        }
        else {
            echo ajax_alert('warning',' -- Error updating password  -- ');
        }
    
    
    }
    
    public function updatePhoto(){
    
        if (\Request::has(Profile::$updatePhotoFillable) && Profile::change_photo(Auth::id())) {

            $successMsg = 'Updated Photo  on '.date("d/m/Y h:i:s");
            Activities::create(Auth::id(),$successMsg, 'cl_members');
            
            echo ajax_alert('success',' Photo Updated Successfully');
        }
        else {
            echo ajax_alert('warning',' -- Error updating photo -- ');
        }
    
    }
}
