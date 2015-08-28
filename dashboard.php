<?php
// require'templates/master.php';
 session_start();
error_reporting(0);
require'templates/master.php';
if($_SESSION['logged'] != "yes"){
 error_reporting(0);
  require 'Oops.php';
  return false;
}
?>

  <head>
    <link rel="stylesheet" href="public/stylesheets/dashboard.css"/>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript">

    </script>
  </head>
  <body>
    <div id="link-bar">
      <nav class="navbar navbar-default navbar-fixed-top" id="top">
        <div id="links" class="container">
          <ul class="list-inline">
      			<?php if(isset($_SESSION['logged'])) :?>
      				<li>Logged in as: <a href="profile.php"> <?php echo $_SESSION['username']; ?></a></li>
      			<?php endif; ?>
            <li><a href="index.php" >Home</a></li>
      		<?php if($_SESSION['logged'] == "yes") :?>
      			<li><a href="functions/logout.php">Log Out</a></li>
                        <li><a href="profile.php">Profile</a></li>
      		<?php endif; ?>
          <!-- Add Ticker -->
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
        <!-- End of AddTicker -->
        <li>  <form class="" action="functions/logout.php" method="post">
            <input class="btn btn-danger" type="submit" name="submit" value="Logout" id="logout">
          </form>
        </li>
            </ul>
        </div>
        </div>
      </nav>
      <!-- <ul class="list-inline">

<li>Logged In as: <?php if(isset($_SESSION['username'])){echo $_SESSION['username'] ;} ?>
</li>
    </ul> -->
    </div>
    <div id="error">

    </div>


        <h1>Dashboard</h1>
      <div class="container">
        <h3>Long-Term Stock Analysis</h3>
        <hr />
        <?php
          require 'functions/showTickers.php';
          showTickers('analysis_a');
          if(isset($_POST['TNF'])){
            echo '<script type="text/javascript">
              $("#error").html("That ticker doesnt exist");
            </script>';
          }
        ?>
      </div>
  </body>
</html>
