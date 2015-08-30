<?php

/*
deryption key
0 == signed in or registered succesfully
1 == wild card didnt signin or register succesfully//not used rn
2 == username found but password doesnt match
3 == tried to register with taken username
4 == tried to login but username not found
5 == tried to register with bad registerKey
*/


//make functions here
$registerKey = "5";

function usernameNotFound(){
  $statusArray = array(
    'status' => 4
  );

  echo json_encode($statusArray);

}
function triedToRegisterWithBadRegisterKey(){
  $statusArray = array(
    'status' => 5
  );
    echo json_encode($statusArray);
}
function registeredSuccesfully(){
  $statusArray = array(
    'status' => 0,
    'registered' => true
  );
  echo json_encode($statusArray);
}
function usernameExistsPassDoesnt(){
  $statusArray = array(
    'status' => 2
  );
  echo json_encode($statusArray);
}

function triedToRegisterWithTakenUsername(){
  $statusArray = array(
    'status' => 3,
    'registered' =>false
  );
  echo json_encode($statusArray);
}
function loggedInSuccesfully(){
  $statusArray = array(
    'status' => 0,
    'loggedIn' => true
  );
  echo json_encode($statusArray);
}


function createUsersTable(){
    require'../includes/connect.php';
  $sql = "
  CREATE TABLE IF NOT EXISTS appUsers(
  `id` INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(30) NOT NULL ,
 `password` VARCHAR(120) NOT NULL
 )";
  $result = mysqli_query($connect, $sql);
  if(!$result){
    echo mysqli_error($connect);
  }
}

function registerUser($registerKey){
  require'../includes/connect.php';

  $requestedUsername = $_GET['username'];
  $requestedPasswordHash = $_GET['password'];
  $registerKeyValue = $_GET['registerKey'];

  $checkSql = "SELECT * FROM appUsers WHERE username = '$requestedUsername'";
  $checkRes = mysqli_query($connect, $checkSql);

  //get the number of people with that username
  $CheckResNum = mysqli_num_rows($checkRes);


  if($CheckResNum < 1){
    if($registerKeyValue == $registerKey){
      $insertsql = "INSERT INTO appUsers (username, password) VALUES('$requestedUsername', '$requestedPasswordHash')";
      $insertsqlres = mysqli_query($connect, $insertsql);

      if(!$insertsqlres){
        echo mysqli_error($connect);
      }
      registeredSuccesfully();
    }else{
      triedToRegisterWithBadRegisterKey();
    }
  }else{
    triedToRegisterWithTakenUsername();
  }




  if(!$checkRes){
    echo mysqli_error($connect);
  }
}
function autheticateUser(){

  require'../includes/connect.php';
  $requestedUsername = $_GET['username'];
  $requestedPasswordHash = $_GET['password'];

  $sql = "SELECT id, username, password FROM appUsers WHERE username = '$requestedUsername'";
  $res = mysqli_query($connect, $sql);

  $resNum = mysqli_num_rows($res);


//username exists
  if($resNum != 0){

    //get info of that user
    $row = mysqli_fetch_row($res);

    $id = $row[0];
    $username = $row[1];
    $password = $row[2];

    //check that passwords match
    if ($password == $requestedPasswordHash) {
          loggedInSuccesfully();
    }else{
      usernameExistsPassDoesnt();
    }
}
//number of rows equals 0
else {
  usernameNotFound();
}



  if(!$res){
    echo mysql_error($connect);
  }
}
function main($registerKey){
  require'../includes/connect.php';

  createUsersTable();

  if(isset($_GET['register']) && $_GET['register'] == true){

    registerUser($registerKey);

  }//end of isset register


  elseif(isset($_GET['username']) && isset($_GET['password'])) {


  autheticateUser();


  }//end of issets
}


main($registerKey);
