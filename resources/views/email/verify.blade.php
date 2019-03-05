@extends('master.email')

@section('title','Thank you for signing up on ConnectLagos')
@section('content')
Hi <strong>{{ $userInfo->fullname }}</strong>, thank you for signing up!<br>
<p>
We're really excited for you to join our community!  
</p>
<p>
        <p>
                To begin, we need you to confirm your email address by clicking on this link.<br>
                Copy the code below and paste it in the required box on your browser <br>
                <p>
                  <p><a href="{{ url('/finalize/verify/email/'.$userInfo->verify_code) }}"> {{ url('/finalize/verify/email/'.$userInfo->verify_code) }}</a></p>
                
                {{-- <span style="display: inline-block; padding:15px; margin: 15px 0; border:4px dashed pink; font-size:30px; font-weight: bold; letter-spacing: 10px; text-align:center">
                {{ $userInfo->reset_code }}
                  </span> --}}
                
                </p>
                
                  <p>
                    <i>In case you did not make this request, kindly ignore this message</i>
                  </p>
@endsection