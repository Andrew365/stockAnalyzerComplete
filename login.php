<?php require 'templates/master.php';
// session_start();
	error_reporting(0);
if($_SESSION['logged'] == "yes"){
	header("Location: dashboard.php");
}
?>

<html lang="en" class="no-js">
	<head>
		<link rel="stylesheet" type="text/css" href="public/stylesheets/normalize.css" />
		<link rel="stylesheet" type="text/css" href="public/stylesheets/demo.css" />
		<link rel="stylesheet" type="text/css" href="public/stylesheets/component.css" />
		<link rel="stylesheet" type="text/css" href="public/stylesheets/cs-select.css" />
		<link rel="stylesheet" type="text/css" href="public/stylesheets/cs-skin-boxes.css" />
		<script src="public/javascripts/modernizr.custom.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="fs-form-wrap" id="fs-form-wrap">
				<div class="fs-title">
					<h1>Login</h1>
					<div class="codrops-top">
						<a class="codrops-icon codrops-icon-prev" href="http://tympanus.net/Development/NotificationStyles/"><span>Home</span></a>
						<a class="codrops-icon codrops-icon-drop" href="register.php"><span>Dont have an account?</span></a>
					</div>
				</div>
				<form id="myform" class="fs-form fs-form-full" autocomplete="off" action="functions/login.php" method="post">
					<ol class="fs-fields">
						<li>
							<label class="fs-field-label fs-anim-upper" for="username">What's your username?</label>
							<input class="fs-anim-lower" id="q1" name="username" type="text" placeholder="MyUsername" autocomplete="off" required/>
						</li>
						<li>
							<label class="fs-field-label fs-anim-upper" for="password" data-info"">What is your password?</label>
							<input class="fs-anim-lower" id="q2" name="password" type="password" placeholder="example@me.com" autocomplete="off" required/>
						</li>
					</ol><!-- /fs-fields -->
					<button class="fs-submit" name="submit" name="submit">Login</button>
				</form><!-- /fs-form -->
			</div><!-- /fs-form-wrap -->

		</div><!-- /container -->
		<script src="public/javascripts/classie.js"></script>
		<script src="public/javascripts/selectFx.js"></script>
		<script src="public/javascripts/fullscreenForm.js"></script>
		<script>
			(function() {
				var formWrap = document.getElementById( 'fs-form-wrap' );

				[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
					new SelectFx( el, {
						stickyPlaceholder: false,
						onChange: function(val){
							document.querySelector('span.cs-placeholder').style.backgroundColor = val;
						}
					});
				} );

				new FForm( formWrap, {
					onReview : function() {
						classie.add( document.body, 'overview' ); // for demo purposes only
					}
				} );
			})();
		</script>
	</body>
</html>

<!-- OLD PAGE JSUT IN CASE -->
<!-- <html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <form class="form" action="functions/login.php" method="post">
      <table>
        <tr>
          <td>
            Username
          </td>
          <td>
            <input type="text" name="username" value="">
          </td>
        </tr>
        <tr>
          <td>
            Password
          </td>
          <td>
            <input type="password" name="password" value="">
          </td>
        </tr>
        <tr>
          <td>
            <input type="submit" name="submit" value="Submit">
          </td>
        </tr>
      </table>
    </form>
  </body>
</html> -->