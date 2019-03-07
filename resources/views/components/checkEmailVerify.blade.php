<?php
$verifyMsg =  'Please verify your email (check your email <strong>'.e(\App\Auth::currentUser()->email).
        '</strong>) or click <a href="/admin/finalize/resend/verification" target="_blank" class="btn btn-info"> Resend Link </a> to resend verification link';

?>

@if(!\App\Auth::is_verified())
            <div class="col-md-12">
                    <div class="well">
            <p>
            {!! ajax_alert('warning',$verifyMsg) !!}
            <br>
            </p>
                    </div>
            </div>
            
@endif
