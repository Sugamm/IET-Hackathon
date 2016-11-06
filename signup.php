<?php
session_start();
require_once 'script/class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('user/');
}


if(isset($_POST['btn-signup']))
{
	$uname = trim($_POST['txtuname']);
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtpass']);
	$pic = trim($_POST['profilePic']);
	$code = md5(uniqid(rand()));
	
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg = "<div class='chip'>
					<strong>Sorry !</strong>  email allready exists , Please Try another one
			  	</div>
			  ";
	}
	else
	{
		if($reg_user->register($uname,$email,$upass,$code,$pic))
		{			
			$id = $reg_user->lasdID();		
			$key = base64_encode($id);
			$id = $key;
			
			$message = "					
						Hello $uname,
						<br /><br />
						Welcome to Hostel Life!<br/>
						To complete your registration  please , just click following link<br/>
						<br /><br />
						<a href='http://hostellife.co/verify.php?id=$id&code=$code'>Click HERE to Activate :)</a>
						<br /><br />
						Thanks,";
						
			$subject = "Confirm Registration";
						
			$reg_user->send_mail($email,$message,$subject);	
			$msg = "
					<div class='chip'>
						<strong>Success!</strong>  We've sent an email to $email.
                    Please click on the confirmation link in the email to create your account. 
			  		</div>
					";
		}
		else
		{
			$msg = "Sorry , Query could no execute...";
		}		
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
	<body style="text-align: left;">

		<!-- Header -->
			<header id="header">
				<h1>Sign Up</h1>
				<p>Oh! you have not create your bucket yet.</p>
			</header>

		<!-- Signup Form -->
			<?php if(isset($msg)) echo $msg;  ?>
			<form id="signup-form" style="display: block;" method="post" action="signup.php" >
				<input type="text" name="txtuname" id="userName" placeholder="Your Name" required/><br>
				<input type="email" name="txtemail" id="email" placeholder="Email Address" required/><br>
				<input type="password" name="txtpass" id="password" placeholder="Confirm Password" required/><br>
				<input type="hidden" name="profilePic" id="profilePic" value="male.png" /><br>
				<input type="submit" name="btn-signup" value="Sign Up" />
				<a href="index.php"><input type="button" value="Log In" style="background-color: #e40046;" /></a>
			</form>

		<!-- Footer -->
			<footer id="footer">
				<!-- <ul class="icons">
					<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
					<li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
					<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
				</ul> -->
				<ul class="copyright">
					<li>&copy; Untitled.</li><li>Credits: <a href="http://hostellife.co">Hostellife</a></li>
				</ul>
			</footer>

		<!-- Scripts -->
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	</body>
</html>