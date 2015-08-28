
<div id="link-bar">
  <ul class="list-inline">
    <li>Logged In as: <?php session_start();if(isset($_SESSION['username'])) {echo $_SESSION['username'];} ?></li>
    <li>
    <div id="adder" class="form-inline">
      <form class="" action="functions/addToTextFile.php" method="post">
        <div class="form-group">
            <input class="form-control" id="tickersub" type="text" name="newTicker" value="" autocomplete="off">
        <input class="btn btn-primary" id="tickeradd" type="submit" name="submit" value="Add Ticker">
      </div>
      </form>
    </div>
  </li>
  <li>
<!-- Download the stock data -->
    <div id="downloader">
      <form class="" action="functions/stockDownloader.php" method="post">
          <input class="btn btn-primary"  type="hidden" name="download" value="Download Stock Data">
      </form>
    </div>
  </li>
  <li>
<!-- Analyse with algorithm a -->
    <div id="analyze_a">
      <form class="" action="analysis/analysis_a.php" method="post">
        <input class="btn btn-primary"  name="analyze" type="hidden" value="Analyze data with algorithm A">
      </form>
    </div>
  </li>
<!-- END OF FORMS -->
  </ul>
</div>


  <form class="" action="logout.php" method="post">
    <input class="btn btn-danger" type="submit" name="submit" value="Logout">
  </form>
