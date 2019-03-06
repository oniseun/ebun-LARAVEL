@extends('master.adminPage')
@section('title','Change Password')
@section('body')

<div class="col-md-offset-3 col-md-6">
                           
    <div class="panel panel-danger">

      <div class="panel-heading">
        <h3 class="panel-title" style="font-size: 25px"><i class="fa fa-circle"></i> Change Password ({{ $userInfo->fullname }} )</h3>
      </div>

      <div class="panel-body">
         <form  action="/admin/finalize/update/profile/password" class="reset-on-success" method="post" autocomplete="off">
                            @csrf

                            <input placeholder="Current Password" 
                            class="form-control"
                            type="password" name="password" value="" autocomplete="off" /><br>

                            <input placeholder="New Password" 
                            class="form-control"
                            type="password" name="new_password" value="" autocomplete="off" /><br>

                            <input placeholder="Re-enter Password" 
                            class="form-control"
                            type="password" name="password_confirmation" value="" autocomplete="off" /><br>



                            <button type="submit" class="btn btn-danger btn-block ajax-submit">UPDATE PASSSWORD</button><br>
                            <p class="ajax-message"></p>
        </form>


      </div>
    </div>

</div>

@endsection