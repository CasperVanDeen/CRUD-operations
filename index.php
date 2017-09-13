<?php session_start();


 ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UploadIT</title>
<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>

<body style="background:url(img/bg-blurred.jpg); background-repeat:no-repeat; background-size:cover; background-origin:content-box" >
<?php

if(!empty(filter_input(INPUT_POST, 'submit'))) {

	require_once('dbcon.php');
	
	$un = filter_input(INPUT_POST, 'un') 
		or die('Missing/illegal name parameter');
	$pw = filter_input(INPUT_POST, 'pw') 
		or die('Missing/illegal password parameter');

	$sql = 'SELECT id_login, pwhash FROM login WHERE username=?';
	$stmt = $link->prepare($sql);
	$stmt->bind_param('s', $un);
	$stmt->execute();
	$stmt->bind_result($uid, $pwhash);

	while ($stmt->fetch()) {} // fill result variables
	
	if (password_verify($pw, $pwhash)){
		$_SESSION['uid'] = $uid;
		$_SESSION['un'] = $un;
		echo'<div class="alert alert-success">Hello '.$un.'</div>
		
		';
		header('Location:videos.php');
		exit;
	}
	else {
		echo '<div class="alert alert-danger alert-dismissable">
  <a href="index.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Warning!</strong> illegal username/password combination.
</div>';
	}
}
?>

<div class="col-md-12">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div class=" center-block col-md-12"><h1 class="text-center logo-font">UploadIT</h1><br></div>
<div class="col-md-5"></div>
<div class="col-sm-2 center-block">

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
<fieldset>
    	<input class="form-control small-space form-control" name="un" type="text" placeholder="Username" required /><br>
    	<input class="form-control small-space form-control" id="pw" name="pw" type="password" placeholder="Password" required/><br>
    	<input class="btn btn-default" type="submit" name="submit" value="Login" />
         <a class="btn btn-success" href="register.php"><span class="glyphicon-user glyphicon"></span> Create Account</a>

	</fieldset>


</form>
</div>
<div class="col-md-5"></div>
</div>

</body>
</html>