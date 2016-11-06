<?php

$conn = mysqli_connect('localhost','root','Sugam0030','hostellife') or die("ERR_NETWORK");
	

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["addPostSubmit"])) {
// variables
	$title = addslashes(trim($_POST['title'])) ;
	$description = addslashes(trim($_POST['description']));
	$filename = $_FILES["fileToUpload"]["name"];
	$bucketname = trim($_POST['bucketname']);
	$userID = trim($row['userID']);
// end variables

// image upload function
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    $fileName = preg_replace('#[^a-z.0-9]#i', '', $filename); 
	$kaboom = explode(".", $filename); // Split file name into an array using the dot
	$fileExt = end($kaboom);
	$fileName = time().rand().".".$fileExt;
	// print_r($fileName);
    if($check !== false) {
        $msg = '<div class="chip" style="position:absolute; right:0;top:20px;">
					File is an image - ' . $check["mime"] . '.
					<i class="close material-icons">close</i>
				</div>';
        $uploadOk = 1;
    } else {
        $msg = '<div class="chip" style="position:absolute; right:0;top:20px;">
					File is not an image.
					<i class="close material-icons">close</i>
				</div>';
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    // $msg = "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $msg = '<div class="chip" style="position:absolute; right:0;top:20px;">
					Sorry, your file is too large.
					<i class="close material-icons">close</i>
				</div>';
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    // $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    // $msg = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        
    	$insertQuery = "INSERT INTO bucketPost (post_title,post_description,post_image,bucket_name,userID) VALUES ('".$title."','".$description."','".$filename."','".$bucketname."','".$userID."')";
    	$result = mysqli_query($conn, $insertQuery) or die("QUERY_ERR");
    	if ($result) {
    		$msg = '<div class="chip" style="position:absolute; right:0;top:20px;">
					Post has been uploaded.
					<i class="close material-icons">close</i>
				</div>';
    	}
    } else {
        $msg = '<div class="chip" style="position:absolute; right:0;top:20px;">
					Sorry, there was an error uploading your file.
					<i class="close material-icons">close</i>
				</div>';
    }
}
//end image upload function
?>