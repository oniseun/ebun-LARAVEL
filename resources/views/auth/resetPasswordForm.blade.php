@extends('master.publicPage')
@section('title','Create New Password')
@section('body')

<div class="col-md-offset-3 col-md-6">
                           
    <div class="panel panel-danger">

      <div class="panel-heading">
        <h3 class="panel-title" style="font-size: 25px"><i class="fa fa-circle"></i>Create New Password</h3>
      </div>

      <div class="panel-body">
         <form  action="/finalize/reset/password" method="post" autocomplete="off">
            @csrf

            <input type="hidden" name="reset_code" value="{{ $reset_code }}" />
            <input placeholder="Email address" 
                            class="form-control"
                            type="email" name="email" value="" autocomplete="off" /><br>

                            <input placeholder="New Password" 
                            class="form-control"
                            type="password" name="new_password" value="" autocomplete="off" /><br>

                            <input placeholder="Re-enter Password" 
                            class="form-control"
                            type="password" name="password_confirmation" value="" autocomplete="off" /><br>



                            <button type="submit" class="btn btn-danger btn-block">CHANGE PASSWORD</button><br>
                            <p class="ajax-message"></p>
        </form>


      </div>
    </div>

</div>

@endsection
