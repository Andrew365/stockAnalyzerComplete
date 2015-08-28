<?php
session_start();
require'../includes/connect.php';
$us = $_SESSION['username'];
$sql = "DELETE FROM users WHERE username = '$us'";
$res = mysqli_query($connect, $sql);

$sql2 = "DROP TABLES {$us}analysis_a, {$us}tickers";
$res2 = mysqli_query($connect, $sql2);

if($res && $res){
  setcookie(session_name(), '', 100);
  session_unset();
  session_destroy();
  $_SESSION = array();
  header("Location: ../index.php");
}else{
  echo mysqli_query($connect);
}

 ?>