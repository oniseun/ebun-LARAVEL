@if(session('failure'))
<p>
{!! ajax_alert('danger',session('failure')) !!}
</p>

@endif

@if(session('success'))
<p>
{!! ajax_alert('success',session('success')) !!}
</p>
@endif