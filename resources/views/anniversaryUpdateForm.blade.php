@extends('master.adminPage')
@section('title')
Update Anniversary - {{ $aInfo->title }}
@endsection
@section('body')

<div class="col-md-offset-3 col-md-6">
                           
        <div class="panel panel-danger">

          <div class="panel-heading">
            <h3 class="panel-title" style="font-size: 25px"><i class="fa fa-pencil-square"></i> Update Anniversary ({{ $aInfo->title }})</h3>
          </div>

          <div class="panel-body">
             <form  method="post" action="/admin/finalize/update/anniversary" enctype="multipart/form-data">
                @csrf
                <input  type="hidden" name="anniv_id" value="{{ $aInfo->id }}"  />
             <input  type="hidden" name="public_id" value="{{ $aInfo->public_id }}"  />
                <div class="col-lg-12">
                    <h3 style="margin-top:0">
                        <img src="/img/anniversary.png" width="40" height="40"/>
                        Update Anniversary
                    </h3>
                </div>
                <div class="col-lg-12">
                    <input type="text" name="title" class="form-control " placeholder="Anniversary name e.g my 21st birthday.. my wedding" value="{{ $aInfo->title }}" />
                <br>
                    <textarea name="description" style="min-height:150px" class="form-control " placeholder="Tell us more about the anniversary..">{{ $aInfo->description }}</textarea>
                <br></div>
               
                    
               
                <div class="col-lg-12">
                <label>Anniversary type</label>
                    <select name="type" class="form-control ">
                    <option value=""></option>
                    <?php
                    $anniv_types = App\Anniversary::types();
                    ?>
                        @foreach ($anniv_types as $aType)
                    <?php
                          $selected = $aInfo->type == $aType->id ? 'selected="selected"' :'';
                    ?>
                    <option {!! $selected !!} value="{{ $aType->id }}">{{ $aType->description }}</option>
                
                        @endforeach;
                    
                    </select><br>
                


                                <button type="submit" class="btn btn-danger  ajax-submit">UPDATE ANNIVERSARY</button>
                                <a href="/admin/dashboard" class="btn btn-default">BACK</a>
                                <br>
                                <p class="ajax-message"></p>
                  </div>
            </form>


          </div>
        </div>

    </div>

@endsection