@extends('master.publicPage')
@section('title','Forgot password')

@section('body')
<div class="col-md-offset-3 col-md-6">
                           
    <div class="panel panel-danger">

      <div class="panel-heading">
        <h3 class="panel-title" style="font-size: 25px"><i class="fa fa-user-circle"></i> Forgot Password</h3>
      </div>

      <div class="panel-body"  style="padding: 20px ; background: white; border-radius: 10px; ">
         <form  action="/finalize/reset" class="reset-on-success" method="post" autocomplete="off" >
        @csrf
         <div class="ajax-message">
         <p>
         Please type in the email address you registered with, a link will be sent to you to reset your password.
         </p>
                            
        <input placeholder="Type in Email address" class="form-control" type="email" name="email" value="" autocomplete="off" /><br>

        <button type="submit" class="btn btn-danger btn-block ajax-submit">SEND RESET LINK</button><br>
          </div>
                            
        </form>


      </div>
    </div>

</div>

@endsection