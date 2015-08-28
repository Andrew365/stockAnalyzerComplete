<?php
session_start();

    function showTickers($algo_name){
$user = $_SESSION['username'];
require 'includes/connect.php';

$table_sql = "CREATE TABLE IF NOT EXISTS {$user}analysis_a (
              ticker VARCHAR(8),
              daysInc INTEGER,
              pctOfDaysInc FLOAT,
              avgIncPct FLOAT,
              daysDec INTEGER,
              pctOfDaysDec FLOAT,
              avgDecPct FLOAT,
              BuyValue FLOAT,
              SellValue FLOAT
               )";
$table = mysqli_query($connect, $table_sql);
if(!$table){
  echo 'cant create table' . mysqli_error($connect);
  return false;
}


  $sql = "SELECT ticker, daysInc, pctOfDaysInc, avgIncPct, daysDec, pctOfDaysDec, avgDecPct, BuyValue, SellValue FROM `{$user}analysis_a` ORDER BY ticker ASC";
  $data = mysqli_query($connect, $sql);

  $check_q = "SELECT * FROM {$user}tickers WHERE ticker IS NOT NULL";
  $check_r = mysqli_query($connect, $check_q);

  $row_c = mysqli_fetch_array($check_r, MYSQLI_ASSOC);

  echo '
  <table class="table">
  <div id="table_header">
      <thead>
        <tr>
          <th>Ticker</th>
          <th>Days Inc</th>
          <th>pctOfDaysInc</th>
          <th>avgIncPct</th>
          <th>daysDec</th>
          <th>pctOfDaysDec</th>
          <th>avgDecPct</th>
          <th>BuyValue</th>
          <th>SellValue</th>
        </tr>
      </thead>
      </div>';
      if(!$data){
        echo mysql_error();
      echo "this";
        return false;
      }

  while($row = mysqli_fetch_array($data)){
    $i = 0;
    $ticker = $row['ticker'];
    $ticker = strtoupper($ticker);
    $daysInc = $row['daysInc'];
    $pctOfDaysInc = $row['pctOfDaysInc'];
    $avgIncPct = $row['avgIncPct'];
    $daysDec = $row['daysDec'];
    $pctOfDaysDec = $row['pctOfDaysDec'];
    $avgDecPct = $row['avgDecPct'];
    $BuyValue = $row['BuyValue'];
    $SellValue = $row['SellValue'];

//Show data in index

      echo '
      <tr>
        <td>' . $ticker .'</td>' .
        '<td>' . $daysInc .'</td>' .
        '<td>' . $pctOfDaysInc .'</td>' .
        '<td>' . $avgIncPct .'</td>' .
        '<td>' . $daysDec .'</td>' .
        '<td>' . $pctOfDaysDec.'</td>' .
        '<td>' . $avgDecPct .'</td>' .
        '<td>' . $BuyValue .'</td>' .
        '<td>' . $SellValue .'</td>
         <td> <form class="" action="functions/deleteStock.php" method="post" id="delete">
              <input class="btn btn-primary" id="tickerk" type="hidden" name="ticker" value="'.$ticker .'">
             <input class="btn btn-danger" type="submit" name="delete" value="Delete">
           </form>
          <td>
          <td>
          <form class="" action="analysis/analysis_a.php" method="post">
            <input class="" type="hidden" name="ticker" value="'.$ticker .'">
            <input class="btn btn-info" type="submit" name="delete" value="Update">
          </form>
          </td>
        </tr>';

      }

echo '</table>';
if(!$row_c){
  echo "No Tickers";
  return false;
}
}