<?php
$itemTypes = App\Items::types();

?>
<html>
    <head>
        <title>@yield('title') | EBUN Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        @yield('meta')
    <!--Core CSS -->
   <link rel="stylesheet" href="/css/bootstrap.min.css"/>  
   <link rel="stylesheet" href="/css/font-awesome.css"/> 
      <link rel="stylesheet" href="/css/font-kit.css"/>    
        <link rel="stylesheet" href="/css/main.css"/>    
        <meta name="theme-color" content="#C61250" />
        <link rel="icon" href="/img/logo.png">
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
                background-image: url(/img/anniv-tile.jpg); 
                background-position: fixed; 
                background-origin: center; 
            }

            .container-bg
            {
                
                background-image: url(/img/anniv-tile.jpg);
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
            background:#fff url(/img/calendar.png)  97% 50% no-repeat ;
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


            

                <div class="container container-bg" style="margin-top:100px" >
                    <div class="row">
@yield('body')
</div>

 </div>



            
        
   <!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->

<script src="/js/jquery.js"></script>
<script src="/js/bootstrap.min.js"></script>

<script src="/js/formdata.js"></script>
<script src="/js/main.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
/* on click of ajax button*/
$(function(){
  $('body').on('click','.ajax-submit',
  function (e)
  {
    var $loading_circle = '<div class="spinning-circle">  </div>';
    
    send_form_data($(this).parents('form'), '.ajax-message', $loading_circle);

    
    e.preventDefault();
  });



  


  $( "#datepicker" ).datepicker();
  $( "#datepicker" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );

        <?php
        $item_options = NULL;


          foreach ($itemTypes as $type):
              
                 $item_options.="<option value=\"{$type->id}\">{$type->description}</option>";
              
        endforeach;
                                        

        ?>


            $('body').on('click','.append-item-button ', function(e){

                e.preventDefault();

                var item_count =  $('.item-list select').length ;

                var item_key = item_count + 1;

                 //alert(item_key);

                if (item_key > 50)
                {
                     $(this).remove();
                }
                else
                {
                    
                    var string = 

                    '<div class="item-input-list">'+

                     '<div class="col-md-6 ">' +

                      '<div class="input-group">'+
                            '<span class="input-group-addon" id="basic-addon4"><b style="color:crimson">'+
                            item_key +'.)</b> GIFT TYPE'+
                            '</span>'+

                            '<select name="anniv_items[' + item_key + '][item_type]" class="form-control "  aria-describedby="basic-addon4">' +
                            '<option value=""> </option>'+
                            '{!! $item_options !!}'+
                            '</select>'+

                      '</div>'+


                     '</div>' +

                     '<div class="col-md-6">' +

                            '<div class="input-group">'+
                            '<span class="input-group-addon" id="basic-addon3">'+
                            '<i class="fa fa-globe" aria-hidden="true"></i> weblink'+
                            '</span>'+
                            '<input type="text" class="form-control"  name="anniv_items[' + item_key + '][item_link]" '+ 
                            ' placeholder="Web Link to gift  (optional) "  aria-describedby="basic-addon3">'+
                          '</div>'+

                       '</div> ' +

                        '<div class="col-md-12">' +

                          '<br><input type="text" name="anniv_items[' + item_key + '][item_description]" '+
                          ' class="form-control item-input"  placeholder="Describe your gift" /><br>'+


                       '</div> ' +

                     '</div> <div class="col-md-12"><hr></div>';

                    $('.item-list').append($(string));

                    
                    
                    if (item_key == 50)
                    {
                         $(this).remove();
                    }
                   
                }

                //alert(numItems);


            });





        });


        </script>
    </body>
</html>