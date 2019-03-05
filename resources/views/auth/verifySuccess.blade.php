@extends('master.publicPage')
@section('title','Email Verified!!')
@section('body')


<div class="col-md-offset-3 col-md-6">
                           
   {!! echo success_alert( "Email verified successfully !! ".'<a href="/home">go home</a>') !!}
         
   </div>

@endsection