<?php

$userInfo = Auth::currentUser();

?>
<nav class="navbar navbar-default navbar-fixed-top"  id="top" role="banner">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand font-and_black" href="/admin/dashboard"><b><img style="display:inline" src="/img/logo.png" alt="Ebun" height="25" width="25"> EBUN </b></a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
        <li role="separator" class="divider"></li>
          <li  class="<?=mark_link('admin/dashboard')?>"><a href="/admin/dashboard"><i class="fa fa-gift"></i> Dashboard</a></li>
          <li class="<?=mark_link('admin/profile')?>"><a href="/admin/profile"><i class="fa fa-user-secret"></i> Edit Profile Info</a></li>
          <li  class="<?=mark_link('admin/change/picture')?>"><a href="/admin/change/picture"><i class="fa fa-camera"></i> Change Picture</a></li>
          <li  class="<?=mark_link('admin/change/password')?>"><a href="/admin/change/password"><i class="fa fa-circle"></i> Change Password</a></li>
          <li class="<?=mark_link('admin/logout')?>"><a href="/admin/logout"><i class="fa fa-power-off"></i> Logout</a></li>

          
          
        </ul>
        <span class="navbar-form navbar-left" >
       
          </span>
                   

          
          <!--/.profile -->
        <ul class="nav navbar-nav navbar-right">
         <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i> Create Anniversary
              </button> -->


            <li class="<?=mark_link('admin/profile')?>"><a href="/admin/profile"><i class="fa fa-user-secret"></i> {{ $userInfo->fullname }}</a></li>
         
        </ul>

      </div><!--/.nav-collapse -->
    </div>
  </nav>