@extends('master.adminPage')
@section('title')
{{ $userInfo->fullname }} 
@endsection
@section('body')

<div class="col-md-offset-3 col-md-6">
                           
    <div class="panel panel-danger">

      <div class="panel-heading">
        <h3 class="panel-title" style="font-size: 25px"><i class="fa fa-user-secret"></i> Update basic Info ({{ $userInfo->fullname }})</h3>
      </div>

      <div class="panel-body">
         <form  action="/admin/finalize/update/profile/info" method="post" autocomplete="off">
            @csrf
                            <input placeholder="Fullname" type="text" 
                            class="form-control"
                            name="fullname" value="{{ $userInfo->fullname }}" autocomplete="off" /><br>

                            <input placeholder="Email address" 
                            class="form-control"
                            type="email" name="email" value="{{ $userInfo->email }}" autocomplete="off" /><br>

                            <input placeholder="Phone Number" 
                            class="form-control"
                            type="tel" name="phone" value="{{ $userInfo->phone }}" autocomplete="off" /><br>


                            <button type="submit" class="btn btn-danger btn-block ajax-submit">UPDATE INFO</button><br>
                            <p class="ajax-message"></p>
        </form>


      </div>
    </div>

</div>

@endsection