@extends('master.email')

@section('content')
<h3> You have a message from ebungift.com contact form</h3>
    <br>

<p>
From : <strong>{{ $formData->fullname }}</strong>, 
</p>
<br>

<p>
    Email : <strong>{{ $formData->email }}</strong>, 
    </p>
    <br>
<p>
    Message
    </p>
<p>
<blockquote><i><strong>{{ $formData->feedback }}</strong></i> </blockquote>
<p>
 


@endsection