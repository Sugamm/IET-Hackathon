<?php 

if (isset($_POST['submitBucket']) == true) {
	$bucketname = trim(strtoupper($_POST['addbucket']));
	$userId = $row['userID'];
	$email = $row['userEmail'];
	$uname = $row['userName'];
	$conn = mysqli_connect('localhost','root','password','hostellife') or die("ERR_NETWORK");
	
	$checkDuplicate = "SELECT bucket_name FROM bucketList WHERE bucket_name='".$bucketname."'";
	$checkDuplicateBucket = mysqli_query($conn,$checkDuplicate) or die("SELECT_ERR");
	$checkDuplicateBucketRow = mysqli_fetch_array($checkDuplicateBucket);
	if ($checkDuplicateBucketRow['bucket_name'] == $bucketname) {
		$msg = '<div class="chip" style="position:absolute; right:0;top:20px;">
					     Sorry, '. $bucketname.' bucket is already exists.
					    <i class="close material-icons">close</i>
					  </div>';
	}
	else
	{

	$query = "INSERT INTO bucketList(bucket_name, userID) VALUES ('".$bucketname."','".$userId."')";
	$result = mysqli_query($conn,$query);
	if($result)
		{			
			$message = "					
						Hello $uname,
						<br /><br />
						You have created new bucket!<br/>
						<br /><br />
						<a href='http://localhost/iet/'>Click HERE to see the bucket :)</a>
						<br /><br />
						Thanks,";
						
			$subject = "Successfully created bucket.";
						
			// $user_home->send_mail($email,$message,$subject);	
			$msg = '<div class="chip" style="position:absolute; right:0;top:20px;">
					     '.$bucketname.'  Successfully  created bucket
					    <i class="close material-icons">close</i>
					  </div>
        ';
		}
		else
		{
			echo '	<div class="chip" style="position:absolute; right:0;top:20px;">
					     Sorry , Query could no execute...
					    <i class="close material-icons">close</i>
					</div>';
		}
	}
}

mysqli_close($conn);

?>