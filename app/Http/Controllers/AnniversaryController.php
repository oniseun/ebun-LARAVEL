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

    }


    public function update()
    {

    }

    public function add()
    {

    }

}
