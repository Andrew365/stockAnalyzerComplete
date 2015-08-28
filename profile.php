<?php  session_start();
 error_reporting(0);
require'templates/master.php';
if($_SESSION['logged'] != "yes"){
 error_reporting(0);
  require 'Oops.php';
  return false;
} ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $_SESSION['username'];?>'s Profile</title>
  </head>
  <body>
    <div class="container">
      <div class="" id="usname">
        <h1>Profile</h1>
      </div>
      <div class="data">
        <ul>


      <li>  Username: <?php echo $_SESSION['username']; ?></li>
      <li>  Email: <?php
          require 'includes/connect.php';
          $username = $_SESSION['username'];
          $sql = "SELECT email FROM users WHERE username = '$username'";
          $res = mysqli_query($connect, $sql);
          $row = mysqli_fetch_row($res);
          $email = $row[0];
          echo $email;
         ?></li>
         <li>
         <div class="change-pass">
           <form class="form" action="profile.php" method="post">
             <input type="submit" class="btn btn-danger" name="submit" value="Change Password">
             <input class="input-sm" type="password" class="form-control" name="pass" autocomplete="off" value="">
           </form>
         </div>
         <div class="">
           <form class="" action="profile.php" method="post">
             <input type="submit" class="btn btn-danger" name="del" value="Delete Account">
           </form>
         </div>
       </li>
        </ul>
      </div>
    </div>
  </body>
</html>
<?php
if(isset($_POST['pass']) && isset($_POST['submit']) && $_POST['pass'] != "" && $_POST['pass'] !=null){
  $password = $_POST['pass'];
  $password = sha1($password);
  $password = md5($password);
  $username = $_SESSION['username'];
  $sql2 = "UPDATE users SET password='$password' WHERE username='$username'";
  $res2 = mysqli_query($connect, $sql2);
  if(!$res2){
    echo mysqli_error($connect);
  }else{
    if($res2){
    echo '<div class="container">' . "Password Changed" . '</div>';
  }
  }

}
if(isset($_POST['del'])){
  $us = $_SESSION['username'];
  $sql = "DELETE FROM users WHERE username = '$username'";
  $res = mysqli_query($connect, $sql);
  if($res){
    echo '<script type="text/javascript">
          confirm("Are you sure you want to delete your account?");
          window.location.href="functions/delAccount.php";
    </script>';
  }
  if(!$res){
    echo mysqli_error($connect);
  }
}
 ?>