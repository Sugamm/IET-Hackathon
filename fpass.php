<?php
session_start();
require_once 'script/class.user.php';
$user = new USER();

if($user->is_logged_in()!="")
{
	$user->redirect('user/');
}

if(isset($_POST['btn-submit']))
{
	$email = $_POST['txtemail'];
	
	$stmt = $user->runQuery("SELECT userID FROM tbl_users WHERE userEmail=:email LIMIT 1");
	$stmt->execute(array(":email"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	if($stmt->rowCount() == 1)
	{
		$id = base64_encode($row['userID']);
		$code = md5(uniqid(rand()));
		
		$stmt = $user->runQuery("UPDATE tbl_users SET tokenCode=:token WHERE userEmail=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
		
		$message= "
				   Hello , $email
				   <br /><br />
				   We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore                   this email,
				   <br /><br />
				   Click Following Link To Reset Your Password 
				   <br /><br />
				   <a href='http://localhost/iet/resetpass.php?id=$id&code=$code'>click here to reset your password</a>
				   <br /><br />
				   thank you :)
				   ";
		$subject = "Password Reset";
		
		$user->send_mail($email,$message,$subject);
		
		$msg = "
					We've sent an email to $email.
                    Please click on the password reset link in the email to generate new password. 
			  	";
	}
	else
	{
		$msg = "
					<strong>Sorry!</strong>  this email not found. 
			    ";
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
			<form id="signup-form" style="display: block;" method="post">
			<?php
			if(isset($msg))
			{
				echo $msg;
			}
			else
			{
				?>
              	
				Please enter your email address. You will receive a link to create a new password via email.!
				 
                <?php
			}
			?>
				<input type="email" name="txtemail" id="email" placeholder="Email Address" /><br>
				<input type="submit" name="btn-submit" value="Generate new Password" />
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