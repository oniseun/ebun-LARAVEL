<?php
use App\Auth;
$userInfo = Auth::currentUser();
?>
<html>
    <head>
        <title><?=htmlentities($fullname)?>: EBUN Dashboard</title>
        <link rel="manifest" href="manifest.json">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!--Core CSS -->
   <link rel="stylesheet" href="/css/bootstrap.min.css"/>  
   <link rel="stylesheet" href="/css/font-awesome.css"/> 
      <link rel="stylesheet" href="/css/font-kit.css"/>    
        <link rel="stylesheet" href="/css/main.css"/>    
        <meta name="theme-color" content="#C61250" />
        <link rel="icon" href="img//logo.png">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]>
<script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

        <style>
            body
            {
                margin:0; 
                padding: 0; 
                font-family: 'Roboto',Arial , sans-serif!important; 
                background: crimson; 
                color:#333; 
                background-image: url(anniv-tile.jpg); 
                background-position: fixed; 
                background-origin: center; 
            }

            .container-bg
            {
                
                background-image: url(anniv-tile.jpg);
                padding:15px;
            }

            .white-box
            {
                background: #fff;
                padding:15px;
            }

            .white-color
            {
                color:#fff;
            }

            #datepicker {
            background:#fff url(calendar.png)  97% 50% no-repeat ;
            }
            [type="date"]::-webkit-inner-spin-button {
            display: none;
            }
            [type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            }
            
        </style>
     
    </head>
    <body>

  
@include('components.headerAdmin')
@include('components.addAnniversaryForm')


            

                <div class="container container-bg" >
                    <div class="row">
<!-- page header -->
<div class="col-md-12">
<br><br>
<div style="border-bottom:0" class="page-header">
<div class="well">
<center>
                  <h4><i class="fa fa-gift" style="color: crimson" aria-hidden="true"></i> My Anniversary list <small><?=$anniv->profile_anniv_count()?> active</small>
                  <p>
                  <br>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i> Create Anniversary
                    </button>

                    </p>
                  

                  </h4>
                
</center>
</div>
</div>
</div>



                        <div class="col-lg-8">
                           

                                <div class="list-group">

                                <?php
                                if(count($list) < 1)
                                {

                                    echo '<div class="alert alert-danger"><span class="close" data-dismiss="alert">&times;</span>
                                            <i class="fa fa-exclamation-circle"></i> No Anniversary added yet</div>';
                                }
                                foreach($list as $details):
                                    extract($details);
                                  $anniv_icon = $anniv->get_anniv_icon($type);
                                ?>
                                  <li href="#" class="list-group-item">
                                    <div class="media">
                                          <div class="media-left media-middle">
                                            <a href="#">
                                              <img class="media-object" src="<?=main_url("icons/anniv-type/$anniv_icon")?>" alt="<?=htmlentities($title)?>" height="64" width="64">
                                            </a>
                                          </div>
                                          <div class="media-body">
                                          <p>
                                            <h4 class="media-heading"><?=htmlentities($title)?> </h4>
                                            </p>
                                            <p>
                                            <span class="label label-default ">
                                            <i class="fa fa-clock-o"></i>
                                            <?=date("D d, F Y ",strtotime($anniversary_date))?></span>
                                            </p>
                                            <p>
                                            <?=nl2br(htmlentities(limitchar($description,200)))?>
                                            </p>

                                             
                                            <a href="anniversary.php?anniv_id=<?=$public_id?>" type="button" class="btn btn-default" >
                                              <i class="fa fa-eye"></i>
                                              View anniversary
                                            </a>
                                            <a href="update-anniversary.php?anniv_id=<?=$public_id?>" type="button" class="btn btn-info" >
                                              <i class="fa fa-pencil-square"></i>
                                             Modify
                                            </a>
                                            <a href="delete-anniversary.php?anniv_id=<?=$public_id?>" type="button" class="btn btn-danger" >
                                              <i class="fa fa-trash"></i>
                                             Delete
                                            </a>
                                          </div>
                                        </div>
                                  </li>
                                  <?php
                                endforeach;
                                ?>




</div>

</div>




                <div class="col-lg-6 col-lg-offset-3">
                            
                            <div id="item-list" class="has-shadow">
                                
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        
                    </div>
                </div>

            
        
         <?php
      include 'inc/home-javascripts.php';
     ?>
        
    
    </body>
</html>