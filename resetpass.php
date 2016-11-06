<?php
require_once 'script/class.user.php';
$user = new USER();

if(empty($_GET['id']) && empty($_GET['code']))
{
	$user->redirect('user/');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	
	$stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userID=:uid AND tokenCode=:token");
	$stmt->execute(array(":uid"=>$id,":token"=>$code));
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() == 1)
	{
		if(isset($_POST['btn-reset-pass']))
		{
			$pass = $_POST['pass'];
			$cpass = $_POST['confirm-pass'];
			
			if($cpass!==$pass)
			{
				$msg = "
						<strong>Sorry!</strong>  Password Doesn't match. 
						";
			}
			else
			{
				$password = md5($cpass);
				$stmt = $user->runQuery("UPDATE tbl_users SET userPass=:upass WHERE userID=:uid");
				$stmt->execute(array(":upass"=>$password,":uid"=>$rows['userID']));
				
				$msg = "
						Password Changed.
						";
				header("refresh:5;index.php");
			}
		}	
	}
	else
	{
		$msg = "
				No Account Found, Try again
				";
				
	}
	
	
}

?>


<!DOCTYPE HTML>
<html>
	<head>
		<title>Hostel Life | Password Reset</title>
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
			<form id="signup-form" style="display: block;" method="post">
			<strong>Hello !</strong>  <?php echo $rows['userName'] ?> you are here to reset your forgetton password.
			<h6>Password Reset.</h6>
		        <?php
		        if(isset($msg))
				{
					echo $msg;
				}
				?>
				<input type="password" name="pass" id="password" placeholder="New Password" /><br>
				<input type="password" placeholder="Confirm New Password" name="confirm-pass" required  /><br>
				<input type="submit"  name="btn-reset-pass" value="Reset Your Password " />
				<a href="signup.php"><input type="button" value="Sign Up!" style="background-color: #e40046;" /></a>

			</form>

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