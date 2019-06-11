<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Index;

class IndexController extends Controller
{
    public function home(){
        if(!\App\Auth::check())
        {
            return view('home');
        }
        else {
            return redirect('/admin/dashboard');
        }
        

    }
    
    public function about(){
    
        return view('about');
    
    }
    
    public function contactForm(){
    
        return view('contactForm');
    
    }
    
    public function contact()
    {
        if(!\Request::has(Index::$contactFormFillable))
        {
            echo ajax_alert('danger',  "Error in your form fields, please check, make corrections and submit again");
        exit;
        }
        if (Index::submit_contact_form()) {
            $data = \Request::only(Index::$contactFormFillable);
           $formData = json_decode(json_encode($data), FALSE); // convert array form data to object
           $subject = "New Message from EbunGift Feedback Form ";
            \App\Auth::send_fast_mail($subject,env('CONTACT_FORM_MAIL_RECEIVER'),compact('formData'),'email.feedbackForm','email.feedbackForm');

            echo ajax_alert('success', "Your message has been sent!!");
        } 
        else {
            echo ajax_alert('danger', "Error in your form fields, please check, make corrections and submit again");
        }
    }
}
