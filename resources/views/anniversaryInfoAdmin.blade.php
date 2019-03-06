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
                      @if(!App\Items::has_deactivated($aInfo->id) && $remaining_days > 2 )
              
                              @if(App\Auth::id() !== $aInfo->creator_id)                                      

                                  <button type="button" href="#anniv-item-{{ $aInfo->id }}"                                        
                                    class="btn btn-danger" data-toggle="modal" data-target="#anniv-item-{{ $aInfo->id }}">
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

<!-- start modal for item #myModalitem{{ $gift->id }} -->
<div class="modal fade" id="anniv-item-{{ $gift->id }}" tabindex="-1" role="dialog" aria-labelledby="anniv-item-label-{{ $gift->id }}">
<div class="modal-dialog modal-md" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="anniv-item-label-{{ $gift->id }}">Buy <small>({{ $gift->description }}) for {{ $creatorInfo->fullname }}</small></h4>
    </div>

    <div class="modal-body">
      <div class="row">
          <form  method="post" action="/finalize/deactivate/item">
            @csrf
              <div class="col-lg-12">
                  <h3 style="margin-top:0">
                      Please fill in your details 
                  </h3>
              </div>
              <div class="col-lg-12">
              <input  type="hidden" name="anniv_id" value="{{ $aInfo->id }}"  />
              <input  type="hidden" name="item_id" value="{{ $gift->id }}"  />
              <input  type="hidden" name="public_id" value="{{ $aInfo->public_id }}"  />

                <input placeholder="Your Fullname" type="text" 
                              class="form-control"
                              name="fullname" value="" autocomplete="off" /><br>

                              <input placeholder="Your Email address" 
                              class="form-control"
                              type="email" name="email" value="" autocomplete="off" /><br>

                              
                            
                                

              </div>
              <div class="col-lg-4">
                  <select name="country_code" class="form-control ">
                      @foreach($countries as $country)
                      <?php
                        $selected = $country->phonecode == 234 ? 'selected="selected"' :'';
                      ?>
                      <option {!! $selected !!}
                       value="{{ $country->phonecode }}">{{ $country->nicename }} (+{{ $country->phonecode }})</option>";
                        
                      @endforeach
                  </select>
              </div>

                <div class="col-lg-8">
                <input placeholder="Your Phone Number" 
                              class="form-control"
                              type="tel" name="phone" value="" autocomplete="off" /><br>
              </div>

              <div class="col-lg-12">
                  <br>
                    <label>Notification type <small>How should we notify you?</small></label>
                        <select name="alert_type" class="form-control ">
                            <option value="email">By Email</option>
                            <option value="sms">By SMS</option>
                        </select><br>
              </div>

              <div class="col-lg-12">
                <p class="ajax-message"></p>
                <br>
                  <button class="btn btn-success ajax-submit">Buy  ({{ $gift->description }})</button>                               
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
              
          </form>
      </div>
</div>
</div>
</div>
</div>
<!-- end modal for item #myModalitem-{{ $gift->id }} -->

@endif

@endforeach





      </div>
     
      @if(!App\Anniversary::expired($aInfo->id) && App\Auth::id() == $aInfo->creator_id && App\Items::data_count($aInfo->id) < 50)


      <button  class=" btn btn-default btn-block" href="#add-item-form"  class="btn btn-danger" data-toggle="modal" data-target="#add-item-form"> <i class="fa fa-gift" aria-hidden="true"></i> Add more gifts </button>

            <!-- start modal for item #myModalitem{{ $aInfo->id }} -->
<div class="modal fade" id="add-item-form" tabindex="-1" role="dialog" aria-labelledby="add-item-form-label">
<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="add-item-form-label">Add Gift Item</small></h4>
    </div>

    <div class="modal-body">
      <div class="row">
          <form  method="post" action="/admin/finalize/add/item">
            @csrf
              <input  type="hidden" name="anniv_id" value="{{ $aInfo->id }}"  />

              <div class="col-lg-12">

              <div class="input-group">
                <span class="input-group-addon" id="basic-addon4">
                Gift type
                </span>
                  <select name="item_type" class="form-control " aria-describedby="basic-addon4">
                  <option value=""></option>
                  @foreach ($itemTypes as $iTypes)

                      <option value="{{ $iTypes->id }}">{{ $iTypes->description }}</option>";
                  
                  @endforeach
                  </select> <br>
              </div><br>

                <input placeholder="Brief description of the gift" type="text" 
                              class="form-control"
                              name="item_description" value="" autocomplete="off" /><br>

                <div class="input-group">
                <span class="input-group-addon" id="basic-addon3">
                <i class="fa fa-globe" aria-hidden="true"></i> Link
                </span>
                <input type="text" class="form-control" placeholder="Web Link to gift  (optional) "
                name="item_link" aria-describedby="basic-addon3">
              </div>
                            
              </div>


              <div class="col-lg-12">
                <p class="ajax-message"></p>
                <br>
                  <button class="btn btn-success ajax-submit">Add Gift</button>                               
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                
              </div>
              
          </form>
      </div>
</div>
</div>
</div>
</div>

@endif



      <br>
      
      <div class="well"><b><i>{{ $permalink }}</i></b></div>

      <h3 class="white-color"><i style="color:cornflowerblue" class="fa fa-share-alt-square"></i>  Share </h3>

      <a href="#" onclick=" window.open( 'https://www.facebook.com/sharer/sharer.php?u='+'{{ $permalink }}', 'facebook-share-dialog', 'width=626,height=436'); return false;" title="Share on Facebook" 
      class="btn btn-primary btn-lg"><i class="fa fa-facebook"></i> </a>

      <a href="#" onclick=" window.open('http://twitter.com/share?text={{ urlencode($aInfo->title) }};url={{ $permalink }}', 'twitterShare', 'width=626,height=436'); return false;" title="Tweet This Post" 
      class="btn btn-info btn-lg"><i class="fa fa-twitter"></i>  </a>

      <a href="#" onclick=" window.open( 'https://plus.google.com/share?url='+'{{ $permalink }}', 'google-plus-share-dialog', D return false;" 

      class="btn btn-danger btn-lg"><i class="fa fa-google-plus"></i>  </a>


    
      <a href="whatsapp://send?text={{ $permalink }}" 
      class="btn btn-success btn-lg"><i class="fa fa-whatsapp"></i></a> <!-- mail to --> 

      <a href="mailto:?subject={{ urlencode($aInfo->title) }}&body={{ urlencode($aInfo->title) }} {{ $permalink }}" 
      class="btn btn-default btn-lg"><i class="fa fa-envelope"></i></a>
      <br><br>

      </div> 

      
@endsection