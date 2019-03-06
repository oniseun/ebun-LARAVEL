@extends('master.adminPage')
@section('title')
Hey there, {{ $creatorInfo->fullname }}'s {{ ucfirst($aInfo->title) }} 
is coming up on {{ date("D d, F Y ",strtotime($aInfo->anniversary_date)) }}, buy them gifts on EBUN
@endsection

@section('meta')
<?php
  $permalink = url("anniversary/{$aInfo->public_id}");
?>
<meta name="description" content="{{ ucfirst($aInfo->title) }} - EBUN" />

<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="{{ $permalink }}" />
<meta name="twitter:title" content=" Hey there, {{ $creatorInfo->fullname }}'s {{ ucfirst($aInfo->title) }} is coming up on {{ date("D d, F Y ",strtotime($aInfo->anniversary_date)) }} , 
buy them gifts on EBUN" />
<meta name="twitter:description" content="{{ Illuminate\Support\Str::limit($aInfo->description,200) }}" />
<meta name="twitter:image" content="{{ url("icons/anniv-type/$aIcon") }}" />
<meta name="twitter:site" content="{{ $permalink }}" />
<meta name="twitter:creator" content="" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ $permalink }}" />
<meta property="og:image" content="{{ url("icons/anniv-type/$aIcon") }}" />
<meta property="og:title" content=" Hey there, {{ $creatorInfo->fullname }}'s {{ ucfirst($aInfo->title) }} is coming up on {{ date("D d, F Y ",strtotime($aInfo->anniversary_date)) }} , 
buy them gifts on EBUN" />
<meta property="og:description" content="{{ Illuminate\Support\Str::limit($aInfo->description,200) }}" />

@endsection


@section('body')

<div class="col-md-8">
 <div class="page-header white-box">
<div class="media">
                    <div class="media-body">
                        <h1 style="color:#666"><i style="color:skyblue" class="fa fa-hand-o-right" aria-hidden="true"></i> {{ ucfirst($aInfo->title) }}  
                        </h1>
                        <h3>
                        <p>
                            <span class="label label-info"><i class="fa fa-clock-o"></i>
                              {{ date("D d, F Y ",strtotime($aInfo->anniversary_date)) }}</span>
                      </p> <span style="display:block;margin-top: 20px;"> </span>

                      <p>
                      @if(strtotime($aInfo->anniversary_date) > time())
                      <span class="label label-warning"> {{ timeago_upfront(strtotime($aInfo->anniversary_date)) }}</span>
                      @else
                      <span class="label label-warning"> {{ timeago(strtotime($aInfo->anniversary_date)) }}</span>
                      @endif
                      </p>
                      
                      </h3>

                    </div>
                    <div class="media-right media-middle">
                      <a href="#">
                        <img class="media-object" src="{{ "/icons/anniv-type/$aIcon" }}" alt="..." height="64" width="64">
                      </a>
                    </div>

                  </div>





</div>
</div>

  <div class="col-lg-8" >

      <div class="media  white-box">
              <div class="media-left">
                <a href="#">
                  <img class="media-object" src="/{{ $creatorInfo->display_picture }}" alt="profile picture" width="50" height="50">
                </a>
              </div>

              <div class="media-body ">
              <h4>{{ $creatorInfo->fullname }}</h4>
              </div>
      </div>

  <br>



  <p class="white-box">

  {!! nl2br(e($aInfo->description)) !!}
  </p>
      <br>
      <h3 class="white-color"><i style="color:gray" class="fa fa-gift"></i>  My wishlist</h3>



          <div class="list-group xloader" data-url="/ajax/item/list/{{ $aInfo->public_id }}">
        

  @if(count($giftItems) < 1)

  {!! ajax_alert('warning','No Item on list yet') !!}

  @endif


  @foreach($giftItems as $gift):

  <?php
    $item_icon = App\Items::get_icon($gift->type);
  ?>


    <li href="#" class="list-group-item">
      <div class="media">
            <div class="media-left media-middle">
              <a href="#">
                <img class="media-object" src="/icons/item-type/{{ $item_icon }}" alt="..." height="64" width="64">
              </a>
            </div>
            <div class="media-body">
              <h3 class="media-heading">{{ $gift->description }}</h3>

            
              @if(strlen($gift->link) > 5 )
              

              <a target="_blank" href="{{ $gift->link }}" type="button" class="btn btn-default" aria-label="Left Align">
                <i class="fa fa-globe" aria-hidden="true"></i> Open link
              </a>

              @endif


              @if($gift->deactivated == 'yes')

              {!! '<h4>'.ajax_alert('success','Gift Purchased').'</h4>' !!}
              
              @else

                <?php
                $remaining_days = ceil((strtotime($aInfo->anniversary_date) - time())/86400);
                ?>
                      @if(!App\Items::has_deactivated($gift->id) && $remaining_days > 2 )
              
                              @if(App\Auth::id() !== $aInfo->creator_id)                                      

                                  <button type="button" href="#anniv-item-{{ $gift->id }}"                                        
                                    class="btn btn-danger" data-toggle="modal" data-target="#anniv-item-{{ $gift->id }}">
                                  <i class="fa fa-check-circle"></i> 
                                Buy for {{ $aInfo->fullname }}
                                </button>

                                @endif

                      @elseif(!App\Items::has_deactivated($gift->id) && $remaining_days <= 2 )
                      
                        {!! '<h4><span class="label label-default"><i class="fa fa-info circle"></i> 
                        Its already too late to purchase this item</span></h4>' !!}
                      
                      @else
                      {!! '<h4><span class="label label-default"><i class="fa fa-info circle"></i> 
                        You already bought more than 3 items on the list</span></h4>' !!}
                      
                      @endif


              @endif
                
              


            </div>
          </div>
    </li>

    @if($gift->deactivated == 'no')

@include('components.deactivationForm')

@endif

@endforeach





      </div>
     
@if(!App\Anniversary::expired($aInfo->id) && App\Auth::id() == $aInfo->creator_id && App\Items::data_count($aInfo->id) < 50)


      <button  class=" btn btn-default btn-block" href="#add-item-form"  class="btn btn-danger" data-toggle="modal" data-target="#add-item-form"> <i class="fa fa-gift" aria-hidden="true"></i> Add more gifts </button>

      @include('components.addNewItemForm')
@endif



      <br>
      
      @include('components.anniversaryShareButtons')

      </div> 

      
@endsection