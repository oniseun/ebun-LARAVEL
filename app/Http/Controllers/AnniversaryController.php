<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auth;
use App\Anniversary;
use App\Items;
class AnniversaryController extends Controller
{
    public function listView()
    {
        $list = Anniversary::_list(Auth::id());
        $annivCount = Anniversary::profile_anniv_count(Auth::id());
        return view('myAnniversaries',compact('list','annivCount'));
    }

    public function info($aID)
    {
        $aInfo = Anniversary::info($aID);
        $giftItems = Items::data_list($aInfo->id);
        $itemTypes = Items::types();
        $creatorInfo = \App\Profile::user_info($aInfo->creator_id);
        $countries = \App\Site::country_list();
        $aIcon = \App\Anniversary::get_icon($aInfo->type);
        if(Auth::check())
        {
            return view('anniversaryInfoAdmin',compact('aInfo','giftItems','countries','aIcon','creatorInfo','itemTypes'));
        }
        else
        {
            return view('anniversaryInfo',compact('aInfo','giftItems','countries','aIcon','creatorInfo','itemTypes'));
        }
    }

    public function updateForm($aID)
    {
        $aInfo = Anniversary::info($aID);
        return view('anniversaryUpdateForm',compact('aInfo'));
    }

    public function confirmDelete($aID)
    {
        $aInfo = Anniversary::info($aID);
        return view('confirmDeleteAnniversary',compact('aInfo'));
    }

    public function remove()
    {
        if (\Request::has(Anniversary::$removeAnniversaryFillable) ) {

            extract(\Request::only(Anniversary::$removeAnniversaryFillable));

            if(!Anniversary::remove(Auth::id()))
            {

                echo ajax_alert('warning',' -- you cant delete what you didnt create -- ');
            }
            else
             {  
                    echo ajax_alert('success',' Anniversary Deleted Successfully');
                    echo js_redirect('/admin/dashboard');
            }
        }
        else {
            echo ajax_alert('warning',' -- Error Deleting anniversary  -- ');
        }
    }


    public function update()
    {
        if (\Request::has(Anniversary::$updateAnniversaryFillable) ) {

            extract(\Request::only(Anniversary::$updateAnniversaryFillable));

            if(!Anniversary::modify(Auth::id()))
            {

                echo ajax_alert('warning',' -- you cant update what you didnt create -- ');
            }
            else
             {  
                    echo ajax_alert('success',' Anniversary Updated Successfully');
            }
        }
        else {
            echo ajax_alert('warning',' -- Error updating anniversary  -- ');
        }
    }

    public function add()
    {
        if (\Request::has(Anniversary::$addAnniversaryFillable) ) {

            extract(\Request::only(Anniversary::$addAnniversaryFillable));

            if(!Anniversary::add(Auth::id()))
            {

                echo ajax_alert('warning',' -- An error occured -- ');
            }
            else
             {  
                    echo ajax_alert('success',' Anniversary Added Successfully.. redirecting..');
                    $url = Anniversary::$public_id;
                    echo js_redirect("/anniversary/$url");
            }
        }
        else {
            echo ajax_alert('warning',' -- Error adding anniversary, please make sure you add gif items before submit  -- ');
        }
    }

}
