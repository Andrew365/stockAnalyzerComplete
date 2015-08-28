<?php
require '../includes/connect.php';
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

$tablemake = "CREATE TABLE IF NOT EXISTS users(
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(120) NOT NULL,
  email VARCHAR(60) NOT NULL,
  password VARCHAR(120) NOT NULL,
  reg_date TIMESTAMP,
  activated ENUM('0','1') DEFAULT '0',
  user_level ENUM('1', '2') DEFAULT '1'
)";
$table_create = mysqli_query($connect, $tablemake);
if(!$table_create){
  echo mysqli_error($connect);
}
  if(!empty($username) && !empty($password2) && !empty($password) && !empty($email)){
    $sql2 = "SELECT * FROM users WHERE username = '$username'";
    $sql_res = mysqli_query($connect, $sql2);

    $email = $_POST['email'];

    $sql9 = "SELECT * FROM users WHERE email = '$email'";
    $res9 = mysqli_query($connect, $sql9);


    if(!$sql_res){
      echo mysqli_error($connect);
    }
    if(mysqli_fetch_array($sql_res)> 0){
      echo '<script type="text/javascript">
        confirm("That username is taken");
        window.location.href = "../register.php";
      </script>';
      return false;
    }elseif (mysqli_fetch_array($res9) > 0) {
      echo '<script type="text/javascript">
        confirm("That email is taken");
        window.location.href = "../register.php";
      </script>';
      return false;
    }
    else{
      if($password == $password2){

        $password = sha1($password);
        $password = md5($password);

        $sql3 = "INSERT INTO users (username, email, password, activated)  VALUES ('$username', '$email', '$password', '1')";
        $sql_res = mysqli_query($connect, $sql3);
        if(!$sql_res){
          echo mysqli_error($connect);
        }
          if($sql_res){
            session_start();
            $_SESSION['logged'] = "yes";
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            require 'authController.php';
          }

        }
      else{
        echo "passwords dont match";
      }
    }
  }