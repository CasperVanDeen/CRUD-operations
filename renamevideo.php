<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UploadIT</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body style="background:url(img/bg-blurred.jpg); background-repeat:no-repeat; background-size:cover; background-origin:content-box">
<?php 
	if (!empty($_SESSION['uid'])){
		require ('menu.php');
?>
	
<?php
	
if($cmd = filter_input(INPUT_POST, 'cmd')){
	if($cmd == 'rename_video'){
		
		$vid = filter_input(INPUT_POST, 'id_video', FILTER_VALIDATE_INT)
			or die('Missing/illegal video id parameter');
		$vtit = filter_input(INPUT_POST, 'vid_tit')
			or die('Missing/illegal video title parameter');
		$vurl = filter_input(INPUT_POST, 'vid_url')
			or die('Missing/illegal video url parameter');
		$vdscp = filter_input(INPUT_POST, 'vid_dscp')
			or die('Missing/illegal video description parameter');
		
		require_once('dbcon.php');
		$sql = 'UPDATE video SET title=?,url=?,description=? WHERE id_video=?';
		$stmt = $link->prepare($sql);
		$stmt->bind_param('sssi', $vtit, $vurl, $vdscp, $vid);
		$stmt->execute();
		
		if($stmt->affected_rows > 0){
			echo '<div class="col-lg-12">
				<div class="alert alert-success alert-dismissable">
  				<a href="videos.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 				 <strong>Success!</strong> Video successfuly edited !</div></div>';
		}
		else{
			echo '<div class="col-lg-12">
				<div class="alert alert-danger alert-dismissable">
  				<a href="videos.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 				<strong>Error!</strong> Video can not be edited !</div></div>';
		}
		
	}
	else {
		die('Unknown cmd parameter');
	}
}
?>
<h1 class="logo-text text-center">
<br>
<br>
<br>
<br>
Dear <?php $_SESSION['uid'] ?> <br>here you can edit videos</h1>
<?php
	
	if(empty($vid)){
		$vid = filter_input(INPUT_GET, 'id_video', FILTER_VALIDATE_INT)
			or die('Missing/illegal neviem parameter');
	}
	
	require_once('dbcon.php');
	$sql = 'SELECT title,url,description FROM video WHERE id_video=?';
	$stmt = $link->prepare($sql);
	$stmt->bind_param('i', $vid);
	$stmt->execute();
	$stmt->bind_result($vtit,$vurl,$vdscp);
	while($stmt->fetch()) {}
	
	?>
    <div class="col-sm-5"></div>
<div class="col-sm-2">	
<p>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    	<input  name="id_video" type="hidden" value="<?=$vid?>" />
    	<input class="form-control small-space form-control" name="vid_tit" type="text" value="<?=$vtit?>" placeholder="Change title" required /><br>
        <input class="form-control small-space form-control" name="vid_url" type="text" value="<?=$vurl?>" placeholder="Change url" required /><br>
        <input class="form-control small-space form-control" name="vid_dscp" type="text" value="<?=$vdscp?>" placeholder="Change description" required />
		<br><button class="btn btn-success center-block" name="cmd" value="rename_video" type="submit">Done!</button><br>
	<a href="videos.php" class="btn center-block">Go to videos to see your videos</a>

</form>
</p>
</div>	
<?php 
// If not logged in
}
else {
		echo 'Not logged in...';
	}
?>
</body>
</html>