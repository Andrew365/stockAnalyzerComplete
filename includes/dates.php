<?php

if(!$_GET['since']){
$since = 2000;
}
if($_GET['since'] < 2001){
  $since = 2000;
}else{
  $since = $_GET['since'];
}



$curMonth = date("n");
$rcurMonth = $curMonth;
$curMonth = $curMonth - 1;
$curDay   = date("j");
$curYear  = date("Y");

$fromMonth = 1; //this will be one more than said
$fromDay   = 1;
$fromYear  = $since;

 ?>
