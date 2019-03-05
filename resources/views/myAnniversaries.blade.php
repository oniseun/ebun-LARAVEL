

@extends('master.adminPage')
@section('title','My dashboard')
@section('body')

<!-- page header -->
<div class="col-md-8 col-md-offset-2">
    <br><br>
    <div style="border-bottom:0" class="page-header">
    <div class="well">
    <center>
        <h4><i class="fa fa-gift" style="color: crimson" aria-hidden="true"></i> My Anniversary list <small>
          {{ $annivCount }} active</small>
        <p>
        <br>
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i> Create Anniversary
          </button>

          </p>
        

        </h4>
                    
    </center>
    </div>
    </div>
    </div>
    
    

<div class="col-md-6 col-md-offset-3">


  <div class="list-group">

  @if(count($list) < 1)
  
{!! ajax_alert('warning','No Anniversary added yet') !!}
  
@endif
  @foreach($list as $aInfo)

  <?php
    $anniv_icon = \App\Anniversary::get_icon($aInfo->type);
  ?>
    <li href="#" class="list-group-item">
      <div class="media">
            <div class="media-left media-middle">
              <a href="#">
              <img class="media-object" src="/icons/anniv-type/{{ $anniv_icon }}" alt="{{ $aInfo->title }}" height="64" width="64">
              </a>
            </div>
            <div class="media-body">
            <p>
              <h4 class="media-heading">{{ $aInfo->title }} </h4>
              </p>
              <p>
              <span class="label label-default ">
              <i class="fa fa-clock-o"></i>
              <?=date("D d, F Y ",strtotime($aInfo->anniversary_date))?></span>
              </p>
              <p>
              <?=nl2br(e(Illuminate\Support\Str::limit($aInfo->description,200)))?>
              </p>

                
              <a href="/anniversary/{{ $aInfo->public_id }}" type="button" class="btn btn-default" >
                <i class="fa fa-eye"></i>
                View anniversary
              </a>
              <a href="/admin/update/anniversary/{{ $aInfo->public_id }}" type="button" class="btn btn-info" >
                <i class="fa fa-pencil-square"></i>
                Modify
              </a>
              <a href="/admin/remove/anniversary/{{ $aInfo->public_id }}" type="button" class="btn btn-danger" >
                <i class="fa fa-trash"></i>
                Delete
              </a>
            </div>
          </div>
    </li>
   @endforeach




</div>