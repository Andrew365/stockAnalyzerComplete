<?php
session_start();
$user = $_SESSION['username'];
//checks if the data entered into the add ticker box is valid and will return an if if not
$ticker = $_POST['newTicker'];
if(!$ticker){
  echo '<script type="text/javascript">
  window.alert("That ticker doesnt exist");

  document.location.href = "../dashboard.php";
  </script>';
  return false;
}
$file = "http://real-chart.finance.yahoo.com/table.csv?s={$ticker}&d={$curMonth}&e={$curDay}&f={$curYear}&g=d&a={$fromMonth}&b={$fromDay}&c={$fromYear}&ignore=.csv";
$file_headers = @get_headers($file);
if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
echo '<script type="text/javascript">
window.alert("That ticker doesnt exist");

document.location.href = "../dashboard.php";
</script>';
}
else {
//everything went fine
if(isset($_POST['newTicker']) && isset($_POST['submit'])) {
    require '../includes/connect.php';

    $sql = "SELECT * FROM {$user}tickers";
    $result = mysqli_query($connect, $sql);
    if(!$result){
      $sql_table = "CREATE TABLE IF NOT EXISTS {$user}tickers(
        ticker VARCHAR(8)
      )";
      $table_result = mysqli_query($connect, $sql_table);
    }
    $sql2 = "INSERT INTO {$user}tickers (ticker) VALUES ('$ticker')";
    $insert_query = mysqli_query($connect, $sql2);
    if($insert_query){
    header("Location: ../dashboard.php");
    }elseif(!$insert_query){
      echo mysqli_error($connect);
    }
    include '../analysis/analysis_a.php';
}
}
