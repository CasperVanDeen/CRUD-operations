<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UploadIT</title>
<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

</head>

<body style="background:url(img/bg-blurred.jpg); background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;">
<?php 
require ('menu.php');
 if($cmd = filter_input(INPUT_POST, 'cmd')){
	
	if($cmd == 'add_video'){
		// code to add a new category
		
		$vtitle = filter_input(INPUT_POST, 'videotitle')
			or die('Missing/illegal categroyname parameter');
			
		$vurl = filter_input(INPUT_POST, 'videourl')
			or die('Missing/illegal categroyname parameter');
			
		$vdscp = filter_input(INPUT_POST, 'videodesc')
			or die('Missing/illegal categroyname parameter');
		
		require_once('dbcon.php');
		
		$sql = 'INSERT INTO video (title, url, description) VALUES (?, ?, ?)';
		
		    
  		
		
		$stmt = $link->prepare($sql);
		$stmt->bind_param('sss', $vtitle, $vurl, $vdscp);
		$stmt->execute();
		if($stmt->affected_rows > 0){
			echo '<div class="col-lg-12 alert alert-success">Video "'.$vtitle.'" added</div>';
		}
		else{
			echo '<div class="col-lg-12 alert alert-danger">Could not add the video</div>';
			}		
		}
 	}
 
?>
  <?php
	if (!empty($_SESSION['uid'])){
	 
	 echo '<br><br><br><br><br><br><br>
<h2 class="logo-text text-center">Dear '.$_SESSION['un'];
	echo '<br> here you can upload videos from youtube</h2><br>';
	echo '
	<div class="col-sm-5"></div>
	<div class="col-sm-2">
	<form action="'.$_SERVER['PHP_SELF'].'" method="post">
	<fieldset>
		<input class="form-control small-space form-control" name="videotitle" type="text" placeholder="Title" required /><br>
		<input class="form-control small-space form-control" name="videourl" type="text" placeholder="Video url" required /><br>
    	<textarea class="form-control small-space form-control" name="videodesc" type="text" placeholder="Description" required></textarea><br>
		<button class="btn btn-success center-block" name="cmd" value="add_video" type="submit">Upload it!!!</button>
  	</fieldset>
</form>
	<br>
	<a href="videos.php" class="btn center-block">Go to videos to see your videos</a>
	</div>
	';?>
	<?php
	
		
		
	}
	else {
		echo'
		<h1 class="logo-font text-center">Please log in</h1>
		';
		
}
	
?>




</body>
</html>