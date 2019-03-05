@extends('master.publicPage')
@section('title','Contact Developers')

@section('body')
<div class=" col-md-6 col-md-offset-3">
    <div class="row">
        <div style="width:100% ;text-align:center;"> 
            <h1 style="color:white;"><img src="/img/logo.png" width="60" height="60"/> Contact us</h1>
            <br>  
            <div class="" style="padding: 20px ; background: white; border-radius: 10px; ">
                                <form  method="post" action="/finalize/contact" autocomplete="off">
                                    @csrf
                                    <h3>Send us your feedback or complaint</h3><br>
                                    <input type="email" 
                                    class="form-control input-lg"
                                    name="email" value="" autocomplete="off" placeholder="Email"/><br>

                                     <input type="text" name="fullname" class="form-control input-lg" placeholder="Fullname " />
                        <br>
                            <textarea name="feedback" style="min-height:150px" class="form-control input-lg" placeholder="complaint / request "></textarea><br>

                                                <button type="submit" class="btn btn-success btn-lg btn-block ajax-submit">Send form</button> <br>

                                    <p class="ajax-message"></p>
                                    
                                </form>
                    

</div>
            <div>
            <br>
                <a class="btn btn-danger" href="/home">BACK</a>
            </div>
        </div>
    </div>                   
</div>
@endsection