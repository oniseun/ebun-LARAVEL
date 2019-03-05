<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home(){

        return view('home');

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
        return back()->with('failure', "Error in your form fields, please check, make corrections and submit again");
        exit;
        }
        if (Index::submit_contact_form()) {
            return back()->with('success', "Your message has been sent!!");
        } 
        else {
            return back()->with('failure', "Error in your form fields, please check, make corrections and submit again");
        }
    }
}
