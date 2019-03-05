@extends('master.publicPage')
@section('title','Page not found')

@section('body')
<div class="col-md-offset-3 col-md-6">
                           
    <div class="panel panel-danger">

      <div class="panel-heading">
        <h3 class="panel-title" style="font-size: 25px"><i class="fa fa-trash"></i> Page not Found </h3>
      </div>

      <div class="panel-body">
            <div class="col-lg-12">
            <center>
                <h1>
                
                <img  src="/img/404.png" alt="..." height="64" width="64">
                <br>
                    PAGE NOT FOUND <br>
                </h1>
                <h3>
                The page you requested for was not found on this server, It may have been removed or damaged.
                </h3>
                </center>
            </div>
            
           
            <div class="col-lg-12">
            <center>

                              <br>
                            <a class="btn btn-danger btn-lg" href="/home">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> BACK TO HOME PAGE</a>
             </center>
              </div>
        


      </div>
    </div>

</div>

@endsection