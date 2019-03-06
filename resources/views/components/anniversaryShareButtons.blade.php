<div class="well"><b><i>{{ $permalink }}</i></b></div>

<h3 class="white-color"><i style="color:cornflowerblue" class="fa fa-share-alt-square"></i>  Share </h3>

<a href="#" onclick=" window.open( 'https://www.facebook.com/sharer/sharer.php?u='+'{{ $permalink }}', 'facebook-share-dialog', 'width=626,height=436'); return false;" title="Share on Facebook" 
class="btn btn-primary btn-lg"><i class="fa fa-facebook"></i> </a>

<a href="#" onclick=" window.open('http://twitter.com/share?text={{ urlencode($aInfo->title) }};url={{ $permalink }}', 'twitterShare', 'width=626,height=436'); return false;" title="Tweet This Post" 
class="btn btn-info btn-lg"><i class="fa fa-twitter"></i>  </a>

<a href="#" onclick=" window.open( 'https://plus.google.com/share?url='+'{{ $permalink }}', 'google-plus-share-dialog',  return false;" 

class="btn btn-danger btn-lg"><i class="fa fa-google-plus"></i>  </a>



<a href="whatsapp://send?text={{ $permalink }}" 
class="btn btn-success btn-lg"><i class="fa fa-whatsapp"></i></a> <!-- mail to --> 

<a href="mailto:?subject={{ urlencode($aInfo->title) }}&body={{ urlencode($aInfo->title) }} {{ $permalink }}" 
class="btn btn-default btn-lg"><i class="fa fa-envelope"></i></a>
<br><br>