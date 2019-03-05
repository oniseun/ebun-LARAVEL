<html>
    <head>
        <title>@yield('title') | EBUN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="manifest" href="manifest.json">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
     <!--Core CSS -->
   <link rel="stylesheet" href="/css/bootstrap.min.css"/>  
   <link rel="stylesheet" href="/css/font-awesome.css"/>   
      <link rel="stylesheet" href="/css/font-kit.css"/>  
        <link rel="stylesheet" href="/css/main.css"/>    
        <meta name="theme-color" content="#C61250" />
        <link rel="icon" href="/img/logo.png">

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
                
            }
            .page-background
{
    background: url("/img/home-bg.jpg");
    background-repeat: no-repeat;
    background-position: center ; 
    opacity: 1;  
}

</style>

    </head>
    <body class="page-background">
@include('components.headerPublic')
                <div class="container">
                        <div class="row" style="margin-top:100px;">

                    @yield('body')
                        </div>
                </div>
<br><br>
        
<!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->
<script src="/js/jquery.js"></script>
<script src="/js/bootstrap.min.js"></script>

<script src="/js/formdata.js"></script>
<script src="/js/main.js"></script>
<script>
/* on click of ajax button*/
$(function(){
  $('body').on('click','.ajax-submit',
  function (e)
  {
    var $loading_circle = '<div class="spinning-circle">  </div>';
    e.preventDefault();
    send_form_data($(this).parents('form'), '.ajax-message', $loading_circle);

  });


});

</script>
  </body>
</html>