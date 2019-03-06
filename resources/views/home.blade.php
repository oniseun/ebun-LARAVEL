@extends('master.publicPage')
@section('title','Home')

@section('body')
<div class=" col-md-5 col-md-offset-1" style="color:#fff; margin-top: 80px;">
        <center>
                    <h1 ><img src="/img/logo.png" width="60" height="60"/> EBUN</h1>
                    <h2>Share your anniversaries and desired gifts with friends and have them grant your wish</h2>
                    <br/>
                        <a class="btn btn-danger btn-lg " href="/about">ABOUT APP</a>
        </center>                 
        </div>
        <div class="col-md-4 col-md-offset-1" style="  margin-top: 50px;">
            <div style="border-radius: 10px;padding: 10px ; background: white; ">
                @include('components.flashMessage')
                   <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#register" aria-controls="register" role="tab" data-toggle="tab">Register</a></li>
                        <li role="presentation"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">Login</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="register">
                                <form  action="/finalize/register" method="post" autocomplete="off">
                                    @csrf
                                <h3>Register your details</h3>
                                <br>
                                
                                <input placeholder="Fullname" type="text"  class="form-control input-lg" name="fullname" value="" autocomplete="off" />
                                <br>

                                <input placeholder="Email" class="form-control input-lg" type="email" name="email" value="" autocomplete="off" />
                                <br>

                                <input placeholder="Password" class="form-control input-lg" type="password" name="password" value="" autocomplete="off" />
                                <br>

                                <input placeholder="Re-enter Password" class="form-control input-lg"
                                type="password" name="password_confirmation" value="" autocomplete="off" />
                                <br>

                                 <button type="submit" class="btn btn-danger btn-lg btn-block">REGISTER NOW
                                </button><br>

                                <p class="ajax-message"></p>
                                </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="login">
                                <form  method="post" action="/finalize/login" autocomplete="off">
                                    @csrf
                                    <h3>Login to your profile</h3><br>

                                    <input type="email" class="form-control input-lg"
                                    name="email" value="" autocomplete="off" placeholder="Email address"/>
                                    <br>

                                    <input type="password" class="form-control input-lg"
                                    name="password" value="" autocomplete="off" placeholder="Password"/>
                                    <br>

                                    <button type="submit" class="btn btn-success btn-lg btn-block">SIGN IN
                                    </button>
                                    <br>

                                    <p class="ajax-message"></p>
                                    
                                </form>

                        </div>

                </div>

            </div>

        </div>
    </div>
@endsection