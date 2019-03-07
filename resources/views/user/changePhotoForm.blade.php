@extends('master.adminPage')
@section('title','Change Display Picture')
@section('body')

<div class="col-md-offset-3 col-md-6">
                           
    <div class="panel panel-danger">

      <div class="panel-heading">
        <h3 class="panel-title" style="font-size: 25px"><i class="fa fa-camera"></i> Display Picture({{ $userInfo->fullname }})</h3>
      </div>

      <div class="panel-body">
         <form  action="/admin/finalize/update/profile/photo" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
                <center>
                <img class="img-circle" src="/{{ $userInfo->display_picture}}" width="150" height="150" alt="profile picture">
                    
                    <h4 >Select new picture</h4><br>
                    
                    <input type="file" id="picture" name="photo" accept="image/png,image/jpg,image/jpeg"  /><br>
                    <button type="submit" class="btn btn-danger btn-lg"><i class="fa fa-upload"></i> Upload</button><br>
                  </center>
                  
                  <p class="ajax-message">@include('components.flashMessage')</p>
                  
        </form>


      </div>
    </div>

</div>

@endsection