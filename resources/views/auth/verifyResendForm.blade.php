@extends('master.adminPage')
@section('title','Email Verification')
@section('body')
<div class="col-md-offset-3 col-md-6">
                           
  <div class="panel panel-danger">

    <div class="panel-heading">
      <h3 class="panel-title" style="font-size: 18px"><b> Verification Link Resent </b></h3>
    </div>

     <div class="panel-body">
      <center>
        <h1> Verification Link resent </h1>
        <p> <strong>Check your mail</strong> </p>
            <a href="/admin/dashboard" type="button" class="btn btn-default btn-round btn-lg">Back to dashboard</a>
    </center>


    </div>

  
  </div>

</div>


     
 @endsection
