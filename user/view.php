<?php
session_start();
require_once '../script/class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('../index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

include 'addbucket.php';
include 'addPost.php';
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $row['userName']; ?> - Hostel Life</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		 <!-- Compiled and minified CSS -->
  		<link rel="stylesheet" href="materialize/css/materialize.min.css">
  		 <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

 <style type="text/css">
    	#nav{
    		height: initial;
    		line-height: inherit;
    		background: inherit;
    		box-shadow: none;
    	}
    	#nav > ul > li {
    		float: none;
    	}
    	.card{
    		/*height: 120px;*/
    		background-color: transparent;
    	}
    	.card-content > p > a{
    		color: #e40046;
    	}

    	.card .card-content .card-title {
			     line-height: normal; 
			     
			}
		.cat-down{
			margin-left: 20px;
		}
		.cat-down li{
			list-style: initial;
		}
    </style>
	</head>
	<body>

		<!-- Header -->
			<section id="header">
				<header>
					<span class="image avatar"><img src="images/male.png" alt="" style="box-shadow: -1px 1px 10px black;" /></span>
					<h1 id="logo"><a href="#" style="color:#fff;"><?php echo $row['userName']; ?></a></h1>
					<p><?php echo $row['userEmail']; ?></p>     
        
				</header>
				<nav id="nav" style="overflow: auto;">
					<ul>
						<li><a href="index.php" class="active">MY FEED</a></li>
						<?php 
						$showBucketQuery = "SELECT * FROM bucketList WHERE userID='".trim($row['userID'])."'";
						$connn = mysqli_connect('localhost','root','','hostellife') or die("ERR_NETWORK");
	

						$showBucketResult = mysqli_query($connn,$showBucketQuery);

						
						while ($BucketName = mysqli_fetch_array($showBucketResult)) {
							echo '<li><a href="bucket.php?bn='.$BucketName["bucket_name"].'">'.$BucketName["bucket_name"].'</a></li>';
						}
						mysqli_close($connn);
						?>
					</ul>
				</nav>
				<footer>
					<form action="index.php" method="post">
						<div class="row uniform">
						
							<div class="8u 12u(xsmall)"><input type="text" name="addbucket" id="addbucket" placeholder="Add Bucket" style="background-color: #fff; color:black; padding: 0 24px 1px 5px;" required /></div>
							<div class="4u 12u(xsmall)" style="padding: 2em 0 0 0"><input type="submit" name="submitBucket" value="Add" style="padding: 0 10px; border-radius: 0px" /></div>
						
						</div>
					</form>
					<small><a href="../script/logout.php" style="padding: 0 2px">Logout </a> &copy; Hostellife.co</small>
				</footer>
			</section>

<!-- Wrapper -->
<div id="wrapper">
<!-- Main -->
	<div id="main">
	<!-- One -->
		<section id="">
			<div class="" style="padding: 0px;">
				<div class="features">
					<div class="col s12 m12">
<?php

$selectQueryView="SELECT * FROM bucketPost WHERE post_id='".$_GET['pi']."'";
$resultView = mysqli_query($conn,$selectQueryView) or die("ERR_QUERY_BUG");
$rowView = mysqli_fetch_array($resultView);
$selectUser = "SELECT * FROM tbl_users where userID='".$rowView['userID']."'";
$resultUser = mysqli_query($conn,$selectUser) or die("ERR_QUERY_BUG_USER");
$rowUser = mysqli_fetch_array($resultUser);
  echo '
  <!-- Start Card -->
		<div class="">
		 <div class="card" style="margin: 0px;">
			<div class="card-image" style="background: rgba(13, 14, 14, 0.28);">
              <img src="uploads/'.$rowView['post_image'].'" style="height: 600px;">
              <span class="card-title" style="margin: 0 100px;background: rgba(16, 16, 16, 0.75);">'.$rowView['post_title'].'

              <a href="view.php?pi='.$rowView['post_id'].'&addInterest=true"><i class="material-icons tooltipped" id="intrested" data-position="top" data-delay="50" data-tooltip="Already mission accomplished!" style="position: absolute;top:1px; left: 745px;background: rgba(16, 16, 16, 0.75);border-radius:50%;padding:20px;">attach_file</i>
              </a>
              </span>

            </div>
            <div class="card-content container">
            <div class="row" style="margin-bottom: -10px">
			 	<div class="col s6 m8">
			 		 <img src="images/male.png" style="width: 10%;">
			 		 <span style="position: absolute; padding: 10px">'.$rowUser['userName'].'</span>
			 	</div>
			 	<div class="col s6 m4" style="text-align: right;">
			 		<small>'.$user_home->formatDateAgo($rowView['post_date']).'</small>
			 	</div>
			 </div><br>	
              <p>'.$rowView['post_description'].'</p>
              
	             <div class="card-content">
			         <hr style="margin:-20px 0 10px 0;">
			          	<div style="cursor: auto;">
			          	<i class="material-icons" style="padding:10px 0;">queue_play_next</i> <span style="position: absolute;left: 220px;bottom:47px;">Url : <span class="copyUrl" >http://hostellife.co/user/view.php?pi='.$rowView['post_id'].'</span></span>
			          	<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//hostellife.co/user/view.php?pi='.$rowView['post_id'].'"><img src="images/facebook.png" style="padding:10px;width: 7%;float: right;"></a>
			          	<a target="_blank" href="https://twitter.com/home?status=http%3A//hostellife.co/user/view.php?pi=1"><img src="images/twitter.png" style="padding:10px;width: 7%;float: right;"></a>
			          	<a target="_blank" href="https://plus.google.com/share?url=http://hostellife.co/user/view.php?pi='.$rowView['post_id'].'" onclick="javascript:window.open(this.href,"", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;"><img src="images/googleplus.png" style="padding:10px;width: 7%;float: right;"></a>
			          	
			          	</div>
			        </div>
	            </div>
          </div>
	</div>
	<!-- End Card -->
	';
 function runMyFunction($conn,$post_id,$user_id) {

 	$selectAcc = "SELECT user_id FROM accomplished where post_id='".$post_id."'";
	$resultAcc = mysqli_query($conn,$selectAcc) or die("ERR_SELECT");
	while ($rowAcc = mysqli_fetch_array($resultAcc)) {
		if ($rowAcc['post_id'] != $post_id || $rowAcc['user_id'] != $user_id) {
			$queryAccomplished = "INSERT INTO accomplished(post_id,user_id) VALUES ('".$post_id."','".$user_id."')";

    		$resultAccomplished = mysqli_query($conn,$queryAccomplished) or die("ERR");
		}else{
			$msg = '<div class="chip" style="position:absolute; right:0;top:20px;">
					Already you accomplished it before. :)
					<i class="close material-icons">close</i>
				</div>';
		}
   
	}
  }

  if (isset($_GET['addInterest']) && isset($_GET['pi'])) {
    runMyFunction($conn, $_GET['pi'], $row['userID']);
  }


?>
						
					
						<div class="container">
					    <h5 class="header" style="padding: 10px 0;">Now Look who visited already.</h5>
					    <?php 
$selectAcc = "SELECT user_id FROM accomplished where post_id='".$_GET['pi']."'";
$resultAcc = mysqli_query($conn,$selectAcc) or die("ERR_SELECT");

while ($rowAcc = mysqli_fetch_array($resultAcc)) {
	$selectAccUser = "SELECT * FROM tbl_users where userID='".$rowAcc['user_id']."'";
	$resultAccUser = mysqli_query($conn,$selectAccUser) or die("ERR_SELECT_USER");
	$rowAccUser = mysqli_fetch_array($resultAccUser);
	echo '				<div class="card horizontal">
					      <div class="card-image">
					        <img src="images/'.$rowAccUser['profilePic'].'" style="width: 200px; border-right: 1px solid #ccc;">
					      </div>
					      <div class="card-stacked">
					        <div class="card-content">
					          <p>'.$rowAccUser['userName'].'</p>
					          <p>'.$rowAccUser['userEmail'].'</p>
					        </div>
					      </div>
					    </div>';
}
					    ?>
					    
					  </div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="fab-add">
	<a class="btn-floating btn-large waves-effect waves-light modal-trigger"  data-target="award1" ><i class="material-icons">add</i></a>
</div>	
<!-- Modal Structure -->
<div id="award1" class="modal">
 <form method="post" action=""  enctype="multipart/form-data">
 <div style="margin:20px 20px;">
    <div class="card-content">
      <div class="row" style="margin-bottom: -10px">
		 	<div class="col s2 m2">
		 		 <img src="images/male.png" style="border-radius: 50%; border: 1px solid #ccc;   width: 90%;">
		 	</div>
		 	<div class="col s10 m10">
		 		<h6 style="font-size: 24px; padding: 0 10px;">Fill Your Bucket.</h6>
		 		<div class="input-field col s12">
		          <input id="title" type="text" name="title" class="materialize-textarea" required>
		          <label for="title">Title</label>
		        </div>
		 		<div class="input-field col s12">
		          <textarea id="textarea1" name="description" class="materialize-textarea" required></textarea>
		          <label for="textarea1">Description</label>
		        </div>
		        <!-- Dropdown Trigger -->
		        <div class="col s12 m5">
				  <select class="browser-default" name="bucketname" required>
				    <option value="" disabled selected>Choose your option</option>

				    
				    <?php 
						$showBucketQuery = "SELECT * FROM bucketList WHERE userID='".trim($row['userID'])."'";
						$connn = mysqli_connect('localhost','root','','hostellife') or die("ERR_NETWORK");
	

						$showBucketResult = mysqli_query($connn,$showBucketQuery);

						
						while ($BucketName = mysqli_fetch_array($showBucketResult)) {
							echo '<option value="'.$BucketName["bucket_name"].'">'.$BucketName["bucket_name"].'</option>';
						}
						mysqli_close($connn);
						?>
				  </select>
				 </div>
				 <div class="col s12 m5">
				  	<input type="file" name="fileToUpload" id="fileToUpload" required>
				 </div>
				
		 	</div>
		 </div>
    </div>
    <hr>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
  	<button class="btn waves-effect waves-light" type="submit" name="addPostSubmit">Post</button>
  	<p>
      <input type="checkbox" class="filled-in" id="filled-in-box" />
      <label for="filled-in-box">Make it private</label>
    </p>
  </div>
 </div>
</form>
</div>

		<!-- Scripts -->
		<!-- Compiled and minified JavaScript -->
			<script>

				$(document).ready(function() {
				  // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
				   $(".button-collapse").sideNav();
				  $('.modal-trigger').leanModal();
				});
				  $(document).ready(function(){
				      $('.slider').slider({full_width: true});
				    });
			</script>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollzer.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
			<script src="materialize/js/materialize.min.js"></script>

	</body>
</html>