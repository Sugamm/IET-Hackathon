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
    	.card a{
    		color: #656565;
    	}
    	.card a:hover{
    		color: #656565 !important;
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
		.copyUrl{
		    border: 1px solid #ccc;
		    font-size: 13px;
		    padding: 10px 24px 10px 7px;
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
						<li><a href="#">MY FEED</a></li>
						<?php 
						$showBucketQuery = "SELECT * FROM bucketList WHERE userID='".trim($row['userID'])."'";
						$connn = mysqli_connect('localhost','root','password','hostellife') or die("ERR_NETWORK");
	

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
		<section id="one">
			<div class="container" style="padding: 0px;">
				<div class="head-feed">
					<h3 style="color: #fff;"><?php echo $_GET['bn'];?></h3>
					<p>Make Your Life More Interseting.</p>
				</div>
				<?php echo $msg;?>
				<div class="features">
					<div class="row">
						
						
<?php
$selectQueryView="SELECT * FROM bucketPost WHERE userID='".$row['userID']."' AND bucket_name='".$_GET['bn']."'";
$resultView = mysqli_query($conn,$selectQueryView) or die("ERR_QUERY_BUG");

while ($rowView = mysqli_fetch_array($resultView)) {
$selectUser = "SELECT * FROM tbl_users where userID='".$rowView['userID']."'";
$resultUser = mysqli_query($conn,$selectUser) or die("ERR_QUERY_BUG_USER");
$rowUser = mysqli_fetch_array($resultUser);
  echo '
  <!-- Start Card -->
 		<div class="col s12 m4" >
          <div class="card">
          <a href="view.php?pi='.$rowView['post_id'].'">
            <div class="card-image">
              <img src="uploads/'.$rowView['post_image'].'" style="height:200px;" >
              <span class="card-title"></span>
            </div>
            <div class="card-content">
            <h6>'.$rowView['post_title'].'</h6>
             <small>Date :'.$user_home->formatDateAgo($rowView['post_date']).'</small>
            </div>
           </a>
          </div>
        </div>
	<!-- End Card -->
	';
}

?>
							
							
						
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
						$connn = mysqli_connect('localhost','root','password','hostellife') or die("ERR_NETWORK");
	

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
<!-- Footer -->
	<section id="footer">
		<div class="container">
			<ul class="copyright">
				<li>&copy; Hostel Life</li>
			</ul>
		</div>
	</section>

</div>

		<!-- Scripts -->
		<!-- Compiled and minified JavaScript -->
			<script>
				$(document).ready(function() {
				  // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
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