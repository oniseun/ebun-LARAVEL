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
        $info = Anniversary::info($aID);
        $giftItems = Items::data_list($aID);
        return view('anniversaryInfo',compact('info','giftItems'));
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
