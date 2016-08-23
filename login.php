<!DOCTYPE html>

<?php
	session_start();
	include('utils/db.php');

	if(isset($_SESSION['login'])){
		header("Location: index.php");
		die();
	}

	$logged_in = isset($_SESSION['login']);


	if(isset($_POST['username'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		$result = pg_prepare($db, "login", 'SELECT * FROM silutel.user WHERE email=$1 AND password=$2 LIMIT 1');
		$result = pg_execute($db, "login", array($username, $password));

		$resp = pg_num_rows($result);

		if($resp == 1) {
			$_SESSION['login'] = $username;
			header("Location: index.php");
			die();
		}
	}
?>

<html>
	<head>
		<title>SILUTEL - Login</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="js/jquery-2.1.4.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/jquery-ui.min.css">
		<link rel="stylesheet" href="css/custom/login.css">
	</head>

	<body>
		<div class="page-content container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="login-wrapper well">
				        <h1 class="text-center">SILUTEL - Sign In</h1>
				        <form role="form" id ="login-form" method="POST" action="">
							<div class="form-group">
								<label for="username"><span class="glyphicon glyphicon-user"></span> Email</label>
								<input type="username" class="form-control" name="username" placeholder="Enter email">
							</div>
							<div class="form-group">
								<label for="password"><span class="glyphicon glyphicon-lock"></span> Password</label>
								<input type="password" class="form-control" name="password" placeholder="Enter password">
							</div>
							<div style="font-weight:bold; color:red; text-align:center; width:100%; margin-bottom: 10px"> <?php 
									if(isset($resp) && $resp == 0) echo "Wrong username or password!";
								?> </div>
							<button type="submit" name="submit" id="login-btn" class="btn btn-block btn-primary">Login</button>
						</form>
				    </div>
				</div>
			</div>
		</div>
	</body>
</html>