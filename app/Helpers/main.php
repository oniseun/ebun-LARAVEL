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