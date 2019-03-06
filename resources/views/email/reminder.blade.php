@extends('master.email')

@section('title','Reminder')
@section('content')
<p>
    {!! $content !!}

</p>
<p>	<i> Warm regards from the  {{ env('APP_NAME') }} team </i></p>
@endsection