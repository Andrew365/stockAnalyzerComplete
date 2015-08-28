<?php
require'../includes/connect.php';

// if($env == "prod"){
//   error_reporting(0);
// }
$check  = $_GET['check'];

function refreshTables(){
  $ticker = $_GET['ticker'];
$ticker = strtoupper($ticker);
    require '../includes/connect.php';

  $sql_delete_table = "DROP TABLE IF EXISTS {$ticker}";
  $sql_delete_from_api = "DELETE FROM api";

  $sql_find_api = "SELECT * FROM api";
  $sql_find_ticker_table = "SELECT * FROM {$ticker}";

$companyTextFile = "../TextFiles/" . $companyTicker . ".txt";

if(file_exists($companyTextFile)){
  $handle = fopen ($companyTextFile, "w+");
  fclose($handle);
}

      $res_table = mysqli_query($connect, $sql_delete_table);


      $res_delete_api = mysqli_query($connect, $sql_delete_from_api);


  if(!$res_delete_api){
    echo mysqli_error($connect);
  }

  if(!$res_table){
    echo mysqli_error($connect);
  }
  return true;
}

//checksum matches
if($check == md5(sha1("bruh"))){

$status = refreshTables();

if($status){


  function getRTQoute($ticker){
    $urlTicker = $_GET['ticker'];
    $jsondata = file_get_contents("http://finance.yahoo.com/webservice/v1/symbols/{$ticker}/quote?format=json");
    $file_headers = @get_headers($jsondata);
    if($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.0 404 Not Found' ) {
      $price = 0;
    }
    $json = json_decode($jsondata, true);
    $resoureces=$json['list']['resources'];
    foreach ($resoureces as $value) {
    $price=$value['resource']['fields']['price'];
    }
   return $price;
  }

$ticker = $_GET['ticker'];
$ticker = strtoupper($ticker);

$file = "http://real-chart.finance.yahoo.com/table.csv?s={$ticker}&d={$curMonth}&e={$curDay}&f={$curYear}&g=d&a={$fromMonth}&b={$fromDay}&c={$fromYear}&ignore=.csv";
$file_headers = @get_headers($file);
if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
  $oops = array(
    "ticker" => "notfound"
  );
  echo json_encode($oops);
    return false;
}function createURL($ticker)
{

require '../includes/dates.php';

    $file = "http://real-chart.finance.yahoo.com/table.csv?s={$ticker}&d={$curMonth}&e={$curDay}&f={$curYear}&g=d&a={$fromMonth}&b={$fromDay}&c={$fromYear}&ignore=.csv";
    return $file;
}


function getCsvFile($url, $outputFile)
{

    $content = file_get_contents($url);
    $content = str_replace("Date,Open,High,Low,Close,Volume,Adj Close", "", $content);
    $content = trim($content);

    file_put_contents($outputFile, $content);
}

function fileToDatabase($txtfile, $tablename)
{

    $file = fopen($txtfile, "r");

    while (!feof($file)) {
        $line   = fgets($file);
        $pieces = explode(",", $line);

        $date   = $pieces[0];
        $open   = $pieces[1];
        $high   = $pieces[2];
        $low    = $pieces[3];
        $close  = $pieces[4];
        $volume = $pieces[5];
        // $adj_close = $pieces[6];

        $change         = $close - $open;
        $percent_change = ($change / $open) * 100;

        createTable($tablename);

        $sql     = "SELECT * FROM {$tablename}";
        require '../includes/connect.php';
        $result  = mysqli_query($connect, $sql);


        //creates table if one doesnt exist
        if (!$result) {
            $sql3    = "INSERT INTO {$tablename} (date, open, high, low, close, volume)
        VALUES ('$date','$open','$high','$low','$close','$volume','$change','$percent_change')";
            $result3 = mysqli_query($connect, $sql3);

            ini_set('max_execution_time', 300); //300 seconds = 5 minutes

            if ($result3) {

            } else {
                echo '<br />' . "error with the database " . mysqli_error($connect);
            }
        } else{

            $sql3    = "INSERT IGNORE INTO {$tablename} (date, open, high, low, close, volume)
             VALUES ('$date','$open','$high','$low','$close','$volume')";
            $result3 = mysqli_query($connect, $sql3);

            ini_set('max_execution_time', 300); //300 seconds = 5 minutes

            if ($result3) {

            } else {
                echo '<br />' . "error with the database " . mysqli_error($connect);
            }

        }
    }
    fclose($file);
}



function createTable($tablename){
  require '../includes/connect.php';

      $companyTicker = $_GET['ticker'];
      $companyTicker = strtoupper($companyTicker);



      $sql2    = "CREATE TABLE IF NOT EXISTS {$companyTicker}(date DATE,
          PRIMARY KEY(date),
          open FLOAT, high FLOAT,
           low FLOAT, close FLOAT,
            volume INT)";
      $result2 = mysqli_query($connect, $sql2);
      if($result2){

      }else{
        echo mysqli_error($connect);
          return false;
      }


}

function main()
{



  $refresh = false;

        $companyTicker = $_GET['ticker'];
        $companyTicker = strtoupper($companyTicker);

        $fileURL         = createURL($companyTicker);
        $companyTextFile = "../TextFiles/" . $companyTicker . ".txt";

      $file =  getCsvFile($fileURL, $companyTextFile);

        fileToDatabase($companyTextFile, $companyTicker);



}
main();//download data and put it into its own ticker table

//ALL GOOD HERE//







//analyze data with analsis a
function masterLoop(){
    require '../includes/connect.php';

    $table_sql = "CREATE TABLE IF NOT EXISTS api (
                  ticker VARCHAR(8),
                  avgPrice FLOAT,
                  lavgPrice FLOAT,
                  l1avgPrice FLOAT,
                  l6avgPrice FLOAT,
                  predPrice FLOAT,
                  BuyValue FLOAT,
                  SellValue FLOAT
                   )";
      $table = mysqli_query($connect, $table_sql);
      if(!$table){
        echo 'cant create table' . mysqli_error($connect);
      }

      $ticker = $_GET['ticker'];
      $ticker = strtoupper($ticker);


        $nextDayIncrease = 0;
        $nextDayDecrease = 0;
        $nextDayNoChange = 0;

        $sumOfIncreases = 0;
        $sumOfDecreases = 0;

        $total = 0;
        $ltotal =0;



        $sql = "SELECT date, open, close, high, low  FROM {$ticker}"; //WHERE percent_change < '0' ORDER BY date AS ASC";
        $data = mysqli_query($connect, $sql);


        if($data){



                //get formated current date
                        require '../includes/dates.php';
                $lastYear = $curYear -1;
                $sixmonthsAgo = $rcurMonth - 6;
                $oneMonthAgo = $rcurMonth -1;
                $elevenMonths = $rcurMonth + 11;
                if($rcurMonth > 6){
                  $sixmonthsAgo = $rcurMonth -6;
                if($rcurMonth < 10){
                    if($curDay <10){
                        $curDate = "{$curYear}-0{$rcurMonth}-0{$curDay}";
                        $lastYearD = "{$lastYear}-0{$rcurMonth}-0{$curDay}";

                        $last6YearD = "{$lastYear}-0{$sixmonthsAgo}-0{$curDay}";
                        if($rcurMonth > 1){
                          $last1YearD = "{$curYear}-0{$oneMonthAgo}-0{$curDay}";
                        }else{
                          $last1YearD = "{$lastYear}-0{$elevenMonths}-0{$curDay}";
                        }
                    }else{
                        $curDate = "{$curYear}-0{$rcurMonth}-{$curDay}";
                        $lastYearD = "{$lastYear}-0{$rcurMonth}-{$curDay}";
                        $last6YearD = "{$lastYear}-0{$sixmonthsAgo}-{$curDay}";
                        if($rcurMonth > 1){
                          $last1YearD = "{$curYear}-0{$oneMonthAgo}-{$curDay}";
                        }else{
                          $last1YearD = "{$lastYear}-0{$elevenMonths}-{$curDay}";
                        }
                    }
                }else{
                    if($curDay <10){
                        $curDate = "{$curYear}-{$rcurMonth}-0{$curDay}";
                        $lastYearD = "{$lastYear}-{$rcurMonth}-0{$curDay}";
                        $last6YearD = "{$lastYear}-{$sixmonthsAgo}-0{$curDay}";
                        if($rcurMonth > 1){
                          $last1YearD = "{$curYear}-{$oneMonthAgo}-0{$curDay}";
                        }else{
                          $last1YearD = "{$lastYear}-{$elevenMonths}-0{$curDay}";
                        }
                    }else{
                        $curDate = "{$curYear}-{$rcurMonth}-{$curDay}";
                        $lastYearD = "{$lastYear}-{$rcurMonth}-{$curDay}";
                        $last6YearD = "{$lastYear}-{$sixmonthsAgo}-{$curDay}";
                        if($rcurMonth > 1){
                          $last1YearD = "{$curYear}-{$oneMonthAgo}-{$curDay}";
                        }else{
                          $last1YearD = "{$lastYear}-{$elevenMonths}-{$curDay}";
                        }
                    }
                }
              }else{
                $sixmonthsAgo = $rcurMonth +6;
                $lastYear = $lastYear -1;
              if($rcurMonth < 10){
                  if($curDay <10){
                      $curDate = "{$curYear}-0{$rcurMonth}-0{$curDay}";
                      $lastYearD = "{$lastYear}-0{$rcurMonth}-0{$curDay}";

                      $last6YearD = "{$lastYear}-0{$sixmonthsAgo}-0{$curDay}";
                      if($rcurMonth > 1){
                        $last1YearD = "{$curYear}-0{$oneMonthAgo}-0{$curDay}";
                      }else{
                        $last1YearD = "{$lastYear}-0{$elevenMonths}-0{$curDay}";
                      }
                  }else{
                      $curDate = "{$curYear}-0{$rcurMonth}-{$curDay}";
                      $lastYearD = "{$lastYear}-0{$rcurMonth}-{$curDay}";
                      $last6YearD = "{$lastYear}-0{$sixmonthsAgo}-{$curDay}";
                      if($rcurMonth > 1){
                        $last1YearD = "{$curYear}-0{$oneMonthAgo}-{$curDay}";
                      }else{
                        $last1YearD = "{$lastYear}-0{$elevenMonths}-{$curDay}";
                      }
                  }
              }else{
                  if($curDay <10){
                      $curDate = "{$curYear}-{$rcurMonth}-0{$curDay}";
                      $lastYearD = "{$lastYear}-{$rcurMonth}-0{$curDay}";
                      $last6YearD = "{$lastYear}-{$sixmonthsAgo}-0{$curDay}";
                      if($rcurMonth > 1){
                        $last1YearD = "{$curYear}-{$oneMonthAgo}-0{$curDay}";
                      }else{
                        $last1YearD = "{$lastYear}-{$elevenMonths}-0{$curDay}";
                      }
                  }else{
                      $curDate = "{$curYear}-{$rcurMonth}-{$curDay}";
                      $lastYearD = "{$lastYear}-{$rcurMonth}-{$curDay}";
                      $last6YearD = "{$lastYear}-{$sixmonthsAgo}-{$curDay}";
                      if($rcurMonth > 1){
                        $last1YearD = "{$curYear}-{$oneMonthAgo}-{$curDay}";
                      }else{
                        $last1YearD = "{$lastYear}-{$elevenMonths}-{$curDay}";
                      }
                  }
              }
            }
                //end of get formatted date

                $l_sql = "SELECT SUM(open), SUM(close), SUM(high), SUM(low) FROM {$ticker} WHERE date > '$lastYearD'";
                $l_res = mysqli_query($connect, $l_sql);
                if(!$l_res){
                 echo "this prolem";
                }

                $row3 = mysqli_fetch_row($l_res);


                $all_sql = "SELECT * FROM {$ticker} WHERE date > '$lastYearD'";
                $row_q = mysqli_query($connect, $all_sql);
                $numRows1 = mysqli_num_rows($row_q);


                    $lopen = $row3[0];
                    $lclose = $row3[1];
                    $lhigh = $row3[2];
                    $llow = $row3[3];
                    $lavgPriceLow = $llow/$numRows1;

                    $lavgPrice = ($lhigh + $llow)/($numRows1 * 2);


      //get last 6 month info
                      $l6_sql = "SELECT SUM(open), SUM(close), SUM(high), SUM(low) FROM {$ticker} WHERE date >= (now() - interval 6 month)";
                      $l6_res = mysqli_query($connect, $l6_sql);
                      if(!$l_res){
                       echo "this prolem";
                      }

                      $row6 = mysqli_fetch_row($l6_res);


                      $all_sql6 = "SELECT * FROM {$ticker} WHERE date >= (now() - interval 6 month)";
                      $row_q6 = mysqli_query($connect, $all_sql6);
                      $numRows161 = mysqli_num_rows($row_q6);


                          $lopen6 = $row6[0];
                          $lclose6 = $row6[1];
                          $lhigh6 = $row6[2];
                          $llow6 = $row6[3];
                          $l6avgPriceLow = $llow6/$numRows161;

                          $l6avgPrice = ($lhigh6 + $llow6)/($numRows161 * 2);


//get last year info

$l1_sql = "SELECT SUM(open), SUM(close), SUM(high), SUM(low) FROM {$ticker} WHERE date >= '$last1YearD'";
$l1_res = mysqli_query($connect, $l1_sql);
if(!$l1_res){
 echo "this prolem";
}

$row1 = mysqli_fetch_row($l1_res);


$all_sql1 = "SELECT * FROM {$ticker} WHERE date > '$last1YearD'";
$row_q1 = mysqli_query($connect, $all_sql1);
$numRows11 = mysqli_num_rows($row_q1);


    $l1open = $row1[0];
    $l1close = $row1[1];
    $l1high = $row1[2];
    $l1low = $row1[3];

    $l1avgPriceLow = $l1low/$numRows11;
    $l1avgPrice = ($l1high + $l1low)/($numRows11 * 2);




                    $a_sql = "SELECT SUM(open), SUM(close), SUM(high), SUM(low) FROM {$ticker}";
                    $a_res = mysqli_query($connect, $a_sql);
                    if(!$a_res){
                     echo "this prolem";
                    }

                    $rowa = mysqli_fetch_row($a_res);

                    $all_sqla = "SELECT * FROM {$ticker}";
                    $row_qa = mysqli_query($connect, $all_sqla);
                    $numRowsa= mysqli_num_rows($row_qa);


                        $aopen = $rowa[0];
                        $aclose = $rowa[1];
                        $a1high = $rowa[2];
                        $a1low = $rowa[3];
                        $avgPriceLow = $alow/$numRowsa;

                        $avgPrice = ($a1high + $a1low)/($numRowsa * 2);



            //loop through data
            while($row = mysqli_fetch_array($data)){

                   //all analytics in here
                    //deep buy analysis



                $date = $row['date'];








                    $open = $row[2];
                    $close = $row[3];
                    $high = $row[4];
                    $low = $row[5];




















                $percent_change = $row['percent_change'];
                $sql2 = "SELECT date FROM {$ticker} WHERE date > {$date} ORDER BY date ASC LIMIT 1";

                $data2 = mysqli_query($connect, $sql2);
                $numberOfRows = mysqli_num_rows($data2);

                if($numberOfRows == 1) {
                    //all analytics in here
                    //deep buy analysis

                    $row2 = mysqli_fetch_row($data2);

                    $Buy = 1;
                    $Sell = 0;




                    $tom_date = $row2[0];
                    $tom_percent_change = $row[1];

                    if ($tom_percent_change > 0) {
                        $nextDayIncrease ++;
                        $sumOfIncreases += $tom_percent_change;

                        $total++;
                    } elseif ($tom_percent_change < 0) {
                        $total++;
                        $nextDayDecrease++;
                        $sumOfDecreases += $tom_percent_change;

                        $total++;
                    } else {
                        $nextDayNoChange++;
                        $total = 0;
                        $total++;
                    }

                }elseif($numberOfRows==0){
                    //no more data after today
                }else{
                    echo "you have an error in api";
                }

                //if buy = 1 buy = yes and so on
            }//end of loop

        }
        else{
            echo "unable to select blah {$ticker} <br />" .  mysqli_error($connect);
            //we are ending up here
        }
        $predPrice = ($l6avgPriceLow+ $l1avgPriceLow)/2;

          $currPrice = getRTQoute($ticker);
        if($avgPrice < $currPrice && $avgPrice < $l1avgPrice){
          if($currPrice > $avgPrice && $predPrice> $currPrice){
              $BuyValue = 1;
          }

        if($predPrice > $currPrice){
          $BuyValue = 1;
        }else{
          $BuyValue = 0;
        }

      }
      else{
        $BuyValue = 0;
      }
        $SellValue = $predPrice/$currPrice;

        $test = 237872;
        insertIntoResultTable($ticker, $avgPrice, $lavgPrice, $l1avgPrice, $l6avgPrice, $BuyValue, $SellValue, $predPrice);
    }




//insert data into the result table
function  insertIntoResultTable($ticker, $avgPrice, $lavgPrice, $l1avgPrice, $l6avgPrice, $BuyValue, $SellValue, $predPrice){
    $ticker = $_GET['ticker'];
    $ticker = strtoupper($ticker);
    require '../includes/connect.php';
    $table_sql = "CREATE TABLE IF NOT EXISTS api (
                  ticker VARCHAR(8),
                  avgPrice FLOAT,
                  lavgPrice FLOAT,
                  l1avgPrice FLOAT,
                  l6avgPrice FLOAT,
                  predPrice FLOAT,
                  BuyValue FLOAT,
                  SellValue FLOAT
                   )";
    $table = mysqli_query($connect, $table_sql);
    if(!$table){
      echo 'cant create table api because:' . mysqli_error($connect);
    }


      // $if_api = "SELECT ticker FROM api WHERE ticker = '$ticker'";
      // if($if_api){
      //   $sql="UPDATE api SET (ticker,avgPrice,lavgPrice, l1avgPrice, l6avgPrice,predPrice,BuyValue,SellValue) VALUES ('$ticker', '$avgPrice', '$lavgPrice','$l1avgPrice','$l6avgPrice','$predPrice', '$BuyValue', '$SellValue')";
      //   $sql_res = mysqli_query($connect, $sql);
      // }
      // else{
      $deletefromapi = "TRUNCATE TABLE api";
      $deleteres = mysqli_query($connect, $deletefromapi);
      if(!$deleteres){
        echo mysqli_error($connect);
      }
        $sql="INSERT INTO api (ticker,avgPrice,lavgPrice, l1avgPrice, l6avgPrice,predPrice,BuyValue,SellValue) VALUES ('$ticker', '$avgPrice', '$lavgPrice','$l1avgPrice','$l6avgPrice','$predPrice', '$BuyValue', '$SellValue')";
        $sql_res = mysqli_query($connect, $sql);

        if(!$sql_res){
            echo "error here" . mysqli_error($connect);
        }



}
//call your function
masterLoop();
//END OF ANALYSIS A






//read data

  $sql = "SELECT ticker, avgPrice, lavgPrice, l1avgPrice, l6avgPrice, predPrice, BuyValue, SellValue FROM `api` WHERE ticker = '$ticker'";

    require '../includes/connect.php';
  $data = mysqli_query($connect, $sql);
     $row = mysqli_fetch_array($data);


    $i = 0;
    $ticker = $row['ticker'];
    $ticker = strtoupper($ticker);
    //get data from query
    $avgPrice = $row['avgPrice'];
    $lavgPrice = $row['lavgPrice'];
    $l1avgPrice = $row['l1avgPrice'];
    $l6avgPrice = $row['l6avgPrice'];
    $predPrice = $row['predPrice'];
    $BuyValue = $row['BuyValue'];
    $SellValue = $row['SellValue'];


    //translate from binary to yes/no
    if($BuyValue == 1){
     $BuyValue = "yes";
    }elseif($BuyValue == 0){
     $BuyValue = "no";
    }
    $since_query = "SELECT DATE
    FROM {$ticker}
    ORDER BY DATE ASC
    LIMIT 1";
    require '../includes/connect.php';
    $since = mysqli_query($connect, $since_query);
    if(!$since){
      echo mysqli_error($connect);
    }
    $since1 = mysqli_fetch_row($since);
    $since1 = $since1[0];


    $since1 = substr($since1, 0, 4);
    if($since1 > $_GET['since']){
      $since = $since1;
    }else{
      $since = $_GET['since'];
    }


//get the current price via return of getRTQoute
$currPrice = getRTQoute($ticker);





//Show data in json
//this needs to be at the end
$json = array(
    'ticker' => $ticker,
    'since'=> $since,
    'avgPrice' => $avgPrice,
    'lastYearsAvgPrice' => $lavgPrice,
    'lastSixMonthsAvgPrice' => $l6avgPrice,
    'lastMonthsAvgPrice'=> $l1avgPrice,
    'currentPrice' => $currPrice,
    'predPrice' => $predPrice,
    'buy' => $BuyValue,
    'sellValue' => $SellValue
    );
echo json_encode($json);
}//end of status check
}
//api key doesnt match
else{
 echo "you cant see this";
}
