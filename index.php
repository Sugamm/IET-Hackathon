<?php
session_start();
require_once 'script/class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
	$user_login->redirect('user/');
}

if(isset($_POST['btn-login']))
{
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);
	
	if($user_login->login($email,$upass))
	{
		$user_login->redirect('user/');
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Hostel Life</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
	<body>

		<!-- Header -->
			<header id="header">
				<h1>Hostel Life</h1>
				<p>Together we can fulfill each other's dreams.</p>
			</header>

		<!-- Signup Form -->
			<form id="signup-form" style="display: block;" method="post" action="#">
				<input type="email" name="txtemail" id="email" placeholder="Email Address" /><br>
				<input type="password" name="txtupass" id="password" placeholder="Password" /><br>
				<input type="submit" name="btn-login" value="Log In" />
				<a href="signup.php"><input type="button" value="Sign Up!" style="background-color: #e40046;" /></a>

			</form>
			<a href="fpass.php" style="margin-top: -10px; ">Lost your Password ? </a>

		<!-- Footer -->
			<footer id="footer">
				<ul class="icons">
					<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
					<li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
					<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
				</ul>
				<ul class="copyright">
					<li>&copy; Untitled.</li><li>Credits: <a href="http://hostellife.co">Hostellife</a></li>
				</ul>
			</footer>

		<!-- Scripts -->
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>