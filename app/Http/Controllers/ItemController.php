<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Items;
use App\Auth;
use App\Reminder;

class ItemController extends Controller
{
    public function add()
    {
        if (\Request::has(Items::$addItemFillable) ) {

            if(!Items::add_item_validate())
            {
                echo ajax_alert('warning',items::$errors);
                exit;
                
            }

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

            if(!Items::deactivate_item_validate())
            {
                echo ajax_alert('warning',items::$errors);
                exit;
                
            }

            $data = \Request::only(Items::$deactivateItemFillable);
            extract($data);

            if(Items::has_deactivated($anniv_id) || !Items::deactivate())
            {
                $this->dispatchNotification($data);
                echo ajax_alert('warning',' -- You have already dectivated an item on list -- ');
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

    private function dispatchNotification($data)
    {
                Reminder::setup_confirmation_message($data);
                Reminder::setup_notification_interval($data);
    }

   
}
