<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UploadIT</title>
<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body style="background:url(img/bg-white.jpg); background-repeat:no-repeat; background-size:cover; background-origin:content-box">
<?php require('menu.php'); ?>
<div class=" col-lg-12">
  <?php
	if (!empty($_SESSION['uid'])){
		
		if($cmd = filter_input(INPUT_POST, 'cmd')){
			if($cmd == 'delete_video'){
			// code to delete the video
			
			$vid = filter_input(INPUT_POST, 'videoid', FILTER_VALIDATE_INT)
				or die('Missing/illegal delete video parameter');
			
			require_once('dbcon.php');
			$sql = 'DELETE FROM video WHERE id_video=?';
			$stmt = $link->prepare($sql);
			$stmt->bind_param('i', $vid);
			$stmt->execute();
			
			if($stmt->affected_rows > 0){
				echo '<div class="col-lg-12">
				<div class="alert alert-success alert-dismissable">
  				<a href="videos.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 				 <strong>Success!</strong> Video successfuly deleted !</div></div>';
			}
			
			else{
				echo '<div class="col-lg-12">
				<div class="alert alert-danger alert-dismissable">
  				<a href="videos.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 				<strong>Error!</strong> Video was not deleted !</div></div>';
			}	
		}
	
}			
			
	 echo '<div class="col-lg-12 text-center"><h3 class="logo-font"> Hello '.$_SESSION['un'];
	 
	 echo '<br>
</h3><br>
';
?>


	
	<?php
	error_reporting(0);
	require_once ('dbcon.php');
	// selecting title for specific movie
	$sql = 'SELECT id_video,title,url,description FROM video';
	$stmt = $link->prepare($sql);
	$stmt->bind_param('i', $uvideo);
	$stmt->execute();
	$stmt->bind_result($uID, $vtitle, $vurl, $dscp);
	
	while($stmt->fetch()){
		$url = $vurl;
		// Output: C4kxS1ksqtw from youtube videos
		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		echo '
		<div class="box-white col-sm-4"><br>
		<h4>'.$vtitle.'</h4>
		<iframe width="100%" height="300" src="https://www.youtube.com/embed/'.$my_array_of_vars['v'].'" frameborder="0" allowfullscreen></iframe>
		<p class="text-lowercase">'.$dscp.'</p>
		<br>
		<form action="';?><?= $_SERVER['PHP_SELF'] ?><?php echo'" method="post">
		<input type="hidden" name="videoid" value="'.$uID.'" />
		<button class="btn btn-danger" type="submit" name="cmd" value="delete_video">Delete</button>
		<a class="btn btn-warning" href="renamevideo.php?id_video='.$uID.'">Edit</a>
		<br><br>

		</div>
	
		
		
		';
			
		}
		
		
}	
	
	
	
				
		
		
	
	else {
		echo'
		Please log in
		';
		
}
	
	
?>
</div>
</body>
</html>