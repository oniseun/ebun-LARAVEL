@extends('master.adminPage')
@section('title','Logout Profile')
@section('body')

<div class="col-md-offset-3 col-md-6">
                           
    <div class="panel panel-danger">

      <div class="panel-heading">
        <h3 class="panel-title" style="font-size: 18px"><i class="fa fa-power-off"></i> Logout Profile ({{ $userInfo->fullname }})</h3>
      </div>

       <div class="panel-body">
         <form  action="/admin/finalize/logout" method="post" autocomplete="off">
            @csrf
                <center>
                      <img class="img-circle" src="/{{ $userInfo->display_picture }}" alt="profile picture">
                    
                    <h4 >Are you sure you want to Logout of Ebun ?</h4><br>
                    
                    <button type="submit" class="btn btn-danger btn-lg">
                    <i class="fa fa-power-off"></i> 
                    Logout Now ({{ $userInfo->fullname }})</button><br>
                            
                    </center>
                    <br>
                    <p class="ajax-message"></p>
                  
        </form>


      </div>

    
    </div>

</div>

@endsection