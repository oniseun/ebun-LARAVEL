@extends('master.email')

@section('title','Reset your password')
@section('content')
<p>
Hi <strong>{{ $userInfo->fullname }}</strong>, 
</p>
<br>

<p>
You recently made a request to reset your password on our website.<br>
Copy the code below and paste it in the required box on your browser <br>
<p>
  <p><a href="{{ url('/reset/password/'.$userInfo->reset_code) }}"> {{ url('/reset/password/'.$userInfo->reset_code) }}</a></p>

{{-- <span style="display: inline-block; padding:15px; margin: 15px 0; border:4px dashed pink; font-size:30px; font-weight: bold; letter-spacing: 10px; text-align:center">
{{ $userInfo->reset_code }}
  </span> --}}

</p>

  <p>
    This code will expire in 24 hours!<br>
    <i>In case you did not make this request, kindly ignore this message</i>
  </p>

</p>
@endsection