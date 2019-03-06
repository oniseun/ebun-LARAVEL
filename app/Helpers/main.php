<?php
function toggle_select($var,$select)
{
  return $var === $select ? 'selected="selected"' : '';
}

function mark_link($link,$classname = 'active')
{
  return preg_match("|$link|",$_SERVER['REQUEST_URI']) ? $classname : '';
}
function mysql_timestamp($date = NULL)
{
  $now = date("Y-m-d H:i:s");
  return $date == NULL ? $now : date("Y-m-d H:i:s", strtotime($date));

}
function ajax_alert($type,$message)
{
  $icon = $type !== 'success' ? '<i class="fa fa-exclamation-circle"></i>' : '<i class="fa fa-check-circle"></i>';
    ?>
    <div class="alert alert-<?=$type?> alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?=$icon?> <?=$message?>
    </div>
    <?php
}
function timeago( $ptime )
{
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $condition = array(
                365 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}

function timeago_upfront( $ptime )
{
    $estimate_time = $ptime - time();

    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $condition = array(
                365 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return 'less than ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' time';
        }
    }


   
}

function js_redirect($url,$sec='5')
{
    
    $time = ($sec * 1000);
    $script ='<script>window.setTimeout(
    function()
        { window.location ="'.$url.'"; },'.$time.');
        </script>';
    return $script;
}