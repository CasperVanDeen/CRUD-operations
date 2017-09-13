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

<body style="background:url(img/bg-blurred.jpg); background-repeat:no-repeat; background-size:cover; background-origin:content-box">
<?php 
if(!empty(filter_input(INPUT_POST, 'submit'))) {
	
	$un = filter_input(INPUT_POST, 'un') 
		or die('Missing/illegal name parameter');
	
	$pw = filter_input(INPUT_POST, 'pw') 
		or die('Missing/illegal name parameter');

	require_once('dbcon.php');
	// hash and salt the password
	


	$pw = password_hash($pw, PASSWORD_DEFAULT); 
	
//	echo 'Creating user: '.$un.' => '.$pw;

//checking if the user exist in the database
			$sqlcheck = 'SELECT username FROM login WHERE username=?';
			$stmtcheck = $link->prepare($sqlcheck);
			$stmtcheck->bind_param('s', $un);
			$stmtcheck->execute();
			$stmtcheck->bind_result($uncheck);
			while($stmtcheck->fetch()){}
			if($un == $uncheck){
				
			}
			else{
			
			//now when everything works fine, it's time to put those infromation to the database
			$sql = 'INSERT INTO login (username, pwhash) VALUES (?,?)';
			$stmt = $link->prepare($sql);
			$stmt->bind_param('ss', $un, $pw);
			$stmt->execute(); }

	


	if ($stmt->affected_rows >0){
	echo '
		<div class="alert alert-success">
  <strong>Success!</strong> user ['.$un.'] is added :-)
</div>';
header('Location: index.php');
		
	}
	else {
		echo '
		<div class="alert alert-danger">
  <strong>Danger!</strong> Error adding user ['.$un.']  this user already exist
</div>
';
	}
}	
		
?>
<div class="container-fluid container">
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

<div class=" center-block col-md-12"><h1 class="logo-font text-center">UploadIT</h1></div>
<div class="col-sm-5"></div>
<div class="col-sm-2">

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
<fieldset>
    	<input class="form-control small-space form-control" name="un" type="text" placeholder="Username" required /><br>
    	<input class="form-control small-space form-control" id="pw" name="pw" type="password" placeholder="Password" required/><br>
    	<input class="btn btn-success center-block" type="submit" name="submit" value="Create user" />
         

<a class="btn-link btn text-center center-block" href="index.php">Already an user ?</a>
   
	</fieldset>


</form>
</div>
</div>

</body>
</html>