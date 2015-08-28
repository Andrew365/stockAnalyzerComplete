<?php
require '../includes/connect.php';

    // if($_POST['submit']){
    if(isset($_POST['username']) && isset($_POST['password'])){

  $usname = strip_tags($_POST['username']);
  $password = $_POST['password'];
  $password = sha1($password);
  $password = md5($password);

  $sql = "SELECT id, username, password, user_level FROM users WHERE username = '$usname' AND activated = '1' LIMIT 1";
  $query = mysqli_query($connect, $sql);
  $row = mysqli_fetch_row($query);

  $uid = $row[0];
  $dbUsname = $row[1];
  $dbPassword = $row[2];
  $user_level = $row[3];
  session_start();
  if($usname == $dbUsname && $password == $dbPassword && $user_level == 1){
    $_SESSION['username'] = $dbUsname;
    $_SESSION['logged'] = "yes";

    require 'authController.php';

  }elseif($usname == $dbUsname && $password == $dbPassword && $user_level == 2){

    $_SESSION['username'] = $dbUsname;
    $_SESSION['id'];
    $_SESSION['logged'] = "yes";
    $_SESSION['admin'] = true;

    require 'authController.php';
    }else{
    require 'errors.php';
    $error = new Error();
    $error->comboNotFound();
  }

}else{
  header("Location: ../login.php");
}