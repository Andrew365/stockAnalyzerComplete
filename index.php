
<?php
require'templates/master.php';
 error_reporting(0);
session_start();
?>

	<meta name="viewport" content="initial-scale=1">

<!-- media queries  just for master-->
<link rel="stylesheet" type="text/css" media="only screen and (min-width:980px) and
(max-width: 2000px)" href="public/stylesheets/980/index.css"/>

<link rel="stylesheet" type="text/css" media="only screen and (min-width:768px) and
(max-width: 980px)" href="public/stylesheets/768/index.css"/>

<link rel="stylesheet" type="text/css" media="only screen and (min-width:600px) and
(max-width: 767px)" href="public/stylesheets/600/index.css"/>

<link rel="stylesheet" type="text/css" media="only screen and (min-width:300px) and
(max-width: 599px)" href="public/stylesheets/300/index.css"/>

<link rel="stylesheet" type="text/css" media="only screen and (min-width:100px) and
(max-width: 299px)" href="public/stylesheets/100/index.css"/>
<style media="screen">
</style>
<!-- end of media queries -->
<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script>
$(window).scroll(function(){

  var wScroll = $(this).scrollTop();

    $('#title').css({
      'transform' : 'translate(0px, '+ wScroll /2 +'%)'
    });

});
  </script>


	<script type="text/javascript">
	$(document).ready(function() {
	  $('#delete').submit(function{
			if (confirm('Do you wanna to submit?')) {
           yourformelement.submit();
       } else {
           return false;
       }
		});
	});
	</script>
</head>




<body>
<nav class="navbar navbar-default navbar-fixed-top" id="top">
  <div id="links" class="container">
    <ul class="list-inline">
			<?php if(isset($_SESSION['logged'])) :?>
				<li>Logged in as: <a href="profile.php"> <?php echo $_SESSION['username']; ?></a></li>
			<?php endif; ?>
      <li><a href="dashboard.php" >Dashboard</a></li>
			<?php if(!isset($_SESSION['logged'])) :?>
			<li><a href="register.php">Sign Up</a></li>
			<li><a href="login.php">Login</a></li>
		<?php endif; ?>
		<?php if($_SESSION['logged'] == "yes") :?>
						<li><a href="functions/logout.php">Log Out</a></li>
						<li><a href="profile.php">Profile</a></li>
		<?php endif; ?>
    </ul>
  </div>
  </div>
</nav>

  <div id="splashpage">

    <div id="title">
      Hello Mom
    </div>
  </div>
  <div class="content">
  <!-- <div class="filler">

  </div> -->
  <div class="container" id="info">
     <h1>Stocks</h1>
     <hr/>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          <h1>Tracking</h1>
          <hr/>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    <h1>Analytics</h1>
    <hr/>
  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
  </div>
</div>
  <div class="footer">
    <h1>Footer</h1>
  </div>
</body>
</html>