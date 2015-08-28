<?php

if(isset($_SESSION['logged'])){
  header("Location: ../dashboard.php");
}else{
  header("Location: ../Oops.php");
}