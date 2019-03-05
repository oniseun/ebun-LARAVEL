<?php
include_once 'init.php';
enable_cache_control();
$guest = new Guest ;

if(!isset_get('anniv_id') || !$guest->anniversary_exist($_GET['anniv_id']))
{
  include '404.php';
  exit;
}

extract($guest->anniversary_info($_GET['anniv_id']));

$anniv_id = $id;

$anniv_icon = $guest->get_anniv_icon($type);

$list = $guest->anniversary_items($id);

                $url = main_url("anniversary.php?anniv_id=$public_id");

$country_list = $guest->country_list();
$country_options = NULL;


foreach ($country_list as $CL):
extract($CL);
$selected = $phonecode == 234 ? 'selected="selected"' :'';
$country_options.="<option $selected value=\"$phonecode\">$nicename (+$phonecode)</option>";
  
endforeach;
                                        

             
?>
<html>
    <head>
        <title>Hey there, <?=htmlentities($guest->get_user_info($creator_id)['fullname'])?>'s <?=htmlentities(ucfirst($title))?> is coming up on <?=date("D d, F Y ",strtotime($anniversary_date))?>, buy them gifts on EBUN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        < <?php
      include 'inc/home-styles.php';
     ?>
<meta name="description" content="<?=htmlentities(ucfirst($title))?> - EBUN" />

<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="<?=$url?>" />
<meta name="twitter:title" content=" Hey there, <?=htmlentities($guest->get_user_info($creator_id)['fullname'])?>'s <?=htmlentities(ucfirst($title))?> is coming up on <?=date("D d, F Y ",strtotime($anniversary_date))?> , buy them gifts on EBUN" />
<meta name="twitter:description" content="<?=htmlentities(limitchar($description,200))?>" />
<meta name="twitter:image" content="<?=main_url("icons/anniv-type/$anniv_icon")?>" />
<meta name="twitter:site" content="<?=$url?>" />
<meta name="twitter:creator" content="" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?=$url?>" />
<meta property="og:image" content="<?=main_url("icons/anniv-type/$anniv_icon")?>" />
<meta property="og:title" content=" Hey there, <?=htmlentities($guest->get_user_info($creator_id)['fullname'])?>'s <?=htmlentities(ucfirst($title))?> is coming up on <?=date("D d, F Y ",strtotime($anniversary_date))?> , buy them gifts on EBUN" />
<meta property="og:description" content="<?=htmlentities(limitchar($description,200))?>" />

</head>
<body>

<?php

    if($guest->is_logged_in())
    {
        include 'inc/header-nav-profile.php';
    }
    else
    {
        include 'inc/header-nav.php';
    }



?>
     
           


            

                <div class="container container-bg" >
                    <div class="row">

<div class="col-md-8">
                    <br><br>
 <div class="page-header white-box">
<div class="media">
                    <div class="media-body">
                        <h1 style="color:#666"><i style="color:skyblue" class="fa fa-hand-o-right" aria-hidden="true"></i> <?=htmlentities(ucfirst($title))?>  
                        </h1>
                        <h3>
                        <p>
                            <span class="label label-info"><i class="fa fa-clock-o"></i>
                          <?=date("D d, F Y ",strtotime($anniversary_date))?></span>
                      </p> <span style="display:block;margin-top: 20px;"> </span>

                      <p>

                      <span class="label label-warning">
                      <?=timeago_upfront(strtotime($anniversary_date))?></span>
                      </p>
                      
                      </h3>



                    </div>
                    <div class="media-right media-middle">
                      <a href="#">
                        <img class="media-object" src="<?=main_url("icons/anniv-type/$anniv_icon")?>" alt="..." height="64" width="64">
                      </a>
                    </div>

                  </div>





</div>
</div>
<?php
$creator_info =$guest->get_user_info($creator_id);
?>


  <div class="col-lg-8" >

      <div class="media  white-box">
              <div class="media-left">
                <a href="#">
                  <img class="media-object" src="uploads/<?=$creator_info['display_picture']?>" alt="profile picture" width="50" height="50">
                </a>
              </div>

              <div class="media-body ">
              <h4><?=htmlentities($creator_info['fullname'])?></h4>
              </div>
      </div>

  <br>



  <p class="white-box">
  <?=nl2br(htmlentities($description))?>
  </p>
      <br>
      <h3 class="white-color"><i style="color:gray" class="fa fa-gift"></i>  My wishlist</h3>



          <div class="list-group xloader" data-url="<?=main_url("ajax/anniv-item-list.php?anniv_id=$public_id")?>">
        <?php

          if(count($list) < 1)
          {

              echo '<div class="alert alert-warning"><span class="close" data-dismiss="alert">&times;</span> <i class="fa fa-exclamation-circle"></i> No Item on list yet</div>';
          }
          foreach($list as $details):
            $item_icon = $guest->get_item_icon($details['type']);
          ?>


            <li href="#" class="list-group-item">
              <div class="media">
                    <div class="media-left media-middle">
                      <a href="#">
                        <img class="media-object" src="<?=main_url("icons/item-type/$item_icon")?>" alt="..." height="64" width="64">
                      </a>
                    </div>
                    <div class="media-body">
                      <h3 class="media-heading"><?=htmlentities($details['description'])?></h3>

                      <?php
                      if(strlen($details['link']) > 5 )
                      {
                      ?>

                      <a target="_blank" href="<?=htmlentities($details['link'])?>" type="button" class="btn btn-default" aria-label="Left Align">
                        <i class="fa fa-globe" aria-hidden="true"></i> Open link
                      </a>

                      <?php
                      }
                      ?>


                      <?php
                      if($details['deactivated'] == 'yes')
                      {
                          echo '<h4><span class="label label-success "><i class="fa fa-check-square"></i> Gift Purchased </span></h4>';
                      }
                      else
                      {
                        $remaining_days = ceil((strtotime($anniversary_date) - time())/86400);
                        if(!$guest->has_deactivated($id) && $remaining_days > 2 )
                        {
                          ?>

                            <?php
                                if($guest->is_logged_in())
                                {
                                  if(!$guest->user_created($anniv_id))
                                  {
                                    ?>

                                    <button type="button" href="#anniv-item-<?=$details['id']?>"  class="btn btn-danger" data-toggle="modal" data-target="#anniv-item-<?=$details['id']?>">
                                    <i class="fa fa-check-circle"></i> 
                                  Buy for <?=htmlentities($creator_info['fullname'])?>
                                  </button>

                                    <?php
                                  } 
                                }
                                else
                                {
                                  ?>

                                  <button type="button" href="#anniv-item-<?=$details['id']?>"  class="btn btn-danger" data-toggle="modal" data-target="#anniv-item-<?=$details['id']?>">
                                    <i class="fa fa-check-circle"></i> 
                                  Buy for <?=htmlentities($creator_info['fullname'])?>
                                  </button>

                                  <?php
                                }
                              ?>

                            
                        <?php
                        }
                        elseif(!$guest->has_deactivated($id) && $remaining_days <= 2 )
                        {
                          echo '<h4><span class="label label-default"><i class="fa fa-info circle"></i>  Its already too late to purchase this item</span></h4>';
                        }
                        else
                        {
                          echo '<h4><span class="label label-default"><i class="fa fa-info circle"></i>  You already bought more than 3 items on the list</span></h4>';
                        }
                        
                      }
                      ?>

                      <!-- <a href="#" type="button" class="btn btn-default" aria-label="Left Align">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                      Delete
                      </a> -->

                    </div>
                  </div>
            </li>

<?php

    if($details['deactivated'] == 'no')

    {
                      
?>

<!-- start modal for item #myModalitem<?=$details['id']?> -->
<div class="modal fade" id="anniv-item-<?=$details['id']?>" tabindex="-1" role="dialog" aria-labelledby="anniv-item-label-<?=$details['id']?>">
<div class="modal-dialog modal-md" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="anniv-item-label-<?=$details['id']?>">Buy <small>(<?=htmlentities($details['description'])?>) for <?=htmlentities($creator_info['fullname'])?></small></h4>
    </div>

    <div class="modal-body">
      <div class="row">
          <form  method="post" action="ajax/deactivate-item.php">
              <div class="col-lg-12">
                  <h3 style="margin-top:0">
                      Please fill in your details 
                  </h3>
              </div>
              <div class="col-lg-12">
              <input  type="hidden" name="anniv_id" value="<?=$id?>"  />
              <input  type="hidden" name="item_id" value="<?=$details['id']?>"  />
              <input  type="hidden" name="public_id" value="<?=$public_id?>"  />

                <input placeholder="Your Fullname" type="text" 
                              class="form-control"
                              name="fullname" value="" autocomplete="off" /><br>

                              <input placeholder="Your Email address" 
                              class="form-control"
                              type="email" name="email" value="" autocomplete="off" /><br>

                              
                            
                                

              </div>
              <div class="col-lg-4">
                  <select name="country_code" class="form-control ">
                                    <?=$country_options?>
                  </select>
              </div>

                <div class="col-lg-8">
                <input placeholder="Your Phone Number" 
                              class="form-control"
                              type="tel" name="phone" value="" autocomplete="off" /><br>
              </div>

              <div class="col-lg-12">
                  <br>
                    <label>Notification type <small>How should we notify you?</small></label>
                        <select name="alert_type" class="form-control ">
                            <option value="email">By Email</option>
                            <option value="sms">By SMS</option>
                        </select><br>
              </div>

              <div class="col-lg-12">
                <p class="ajax-message"></p>
                <br>
                  <button class="btn btn-success ajax-submit">Buy  (<?=htmlentities($details['description'])?>)</button>                               
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
              
          </form>
      </div>
</div>
</div>
</div>
</div>
<!-- end modal for item #myModalitem-<?=$details['id']?> -->

<?php
}
?>
            <?php
            endforeach;
            ?>





      </div>
      <?php
      if($guest->is_logged_in() && !$guest->anniversary_expired($anniv_id) && $guest->user_created($anniv_id) && $guest->anniversary_item_count($anniv_id) < 50)
      {
        $item_types = $guest->item_types();
        $item_options = Null;
        foreach ($item_types as $IT):
            $itm_id = $IT['id'];
            $itm_desc = $IT['description'];
          
              $item_options.="<option value=\"$itm_id\">$itm_desc</option>";
          
          endforeach;
      ?>

      <button  class=" btn btn-default btn-block" href="#add-item-form"  class="btn btn-danger" data-toggle="modal" data-target="#add-item-form"> <i class="fa fa-gift" aria-hidden="true"></i> Add more gifts </button>

            <!-- start modal for item #myModalitem<?=$details['id']?> -->
<div class="modal fade" id="add-item-form" tabindex="-1" role="dialog" aria-labelledby="add-item-form-label">
<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="add-item-form-label">Add Gift Item</small></h4>
    </div>

    <div class="modal-body">
      <div class="row">
          <form  method="post" action="ajax/add-item.php">
              <input  type="hidden" name="anniv_id" value="<?=$id?>"  />

              <div class="col-lg-12">

              <div class="input-group">
                <span class="input-group-addon" id="basic-addon4">
                Gift type
                </span>
                  <select name="item_type" class="form-control " aria-describedby="basic-addon4">
                  <option value=""></option>
                  <?=$item_options?>
                  </select> <br>
              </div><br>

                <input placeholder="Brief description of the gift" type="text" 
                              class="form-control"
                              name="item_description" value="" autocomplete="off" /><br>

                <div class="input-group">
                <span class="input-group-addon" id="basic-addon3">
                <i class="fa fa-globe" aria-hidden="true"></i> Link
                </span>
                <input type="text" class="form-control" placeholder="Web Link to gift  (optional) "
                name="item_link" aria-describedby="basic-addon3">
              </div>
                            
              </div>


              <div class="col-lg-12">
                <p class="ajax-message"></p>
                <br>
                  <button class="btn btn-success ajax-submit">Add Gift</button>                               
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                
              </div>
              
          </form>
      </div>
</div>
</div>
</div>
</div>
      <?php
      }
      ?>



      <br>
      
      <div class="well"><b><i><?=$url?></i></b></div>

      <h3 class="white-color"><i style="color:cornflowerblue" class="fa fa-share-alt-square"></i>  Share </h3>

      <a href="#" onclick=" window.open( 'https://www.facebook.com/sharer/sharer.php?u='+'<?=$url?>', 'facebook-share-dialog', 'width=626,height=436'); return false;" title="Share on Facebook" 
      class="btn btn-primary btn-lg"><i class="fa fa-facebook"></i> </a>

      <a href="#" onclick=" window.open('http://twitter.com/share?text=<?=urlencode($title)?>;url=<?=$url?>', 'twitterShare', 'width=626,height=436'); return false;" title="Tweet This Post" 
      class="btn btn-info btn-lg"><i class="fa fa-twitter"></i>  </a>

      <a href="#" onclick=" window.open( 'https://plus.google.com/share?url='+'<?=$url?>', 'google-plus-share-dialog', D return false;" 

      class="btn btn-danger btn-lg"><i class="fa fa-google-plus"></i>  </a>


    
      <a href="whatsapp://send?text=<?=$url?>" 
      class="btn btn-success btn-lg"><i class="fa fa-whatsapp"></i></a> <!-- mail to --> 

      <a href="mailto:?subject=<?=urlencode($title)?>&body=<?=urlencode($title)?> <?=$url?>" 
      class="btn btn-default btn-lg"><i class="fa fa-envelope"></i></a>
      <br><br>

      </div> 

      
</div>
</div>
<?php
if($guest->is_logged_in())
{
include 'inc/home-javascripts.php';
}
else
{
include 'inc/javascripts.php';
}

?>

    </body>
</html>