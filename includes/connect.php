<?php

$env = "prod";



if($env == "dev"){
$connect = mysqli_connect('localhost', 'root', '', 'stocks');
if(!$connect){die('connection failed');}

}




if ($env =="prod") {
  $connect = mysqli_connect('acw.one.mysql', 'acw_one', 'AW34209085', 'acw_one');
  if(!$connect){echo "connection failed";}
}
