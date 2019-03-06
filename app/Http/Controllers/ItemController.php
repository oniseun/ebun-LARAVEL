<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Items;
use App\Auth;

class ItemController extends Controller
{
    public function add()
    {
        if (\Request::has(Items::$addItemFillable) ) {

            extract(\Request::only(Items::$addItemFillable));

            if(!(\App\Anniversary::is_creator(Auth::id(),$anniv_id)) || !Items::add(Auth::id()))
            {

                echo ajax_alert('warning',' -- An error occured -- ');
            }
            else
             {  
                    echo ajax_alert('success',' Item Added Successfully!!.. redirecting..');
                    $url = $public_id;
                    echo js_redirect("/anniversary/$url");
            }
        }
        else 
        {
            echo ajax_alert('warning',' Invalid Request!!');
        }
    }
    
    public function deactivate()
    {
        if (\Request::has(Items::$deactivateItemFillable) ) {

            extract(\Request::only(Items::$deactivateItemFillable));

            if(Items::has_deactivated($anniv_id) || !Items::deactivate())
            {

                echo ajax_alert('warning',' -- An error occured -- ');
            }
            else
             {  
                    echo ajax_alert('success',' Gift Deactivated Successfully!!.. redirecting..');
                    $url = $public_id;
                    echo js_redirect("/anniversary/$url");
            }
        }
        else 
        {
            echo ajax_alert('warning',' Invalid Request!!');
        }
    }

    public function activate()
    {

    }
}
