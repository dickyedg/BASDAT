<?php
	include_once 'utils/db.php';
	include_once 'utils/user_util.php';

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if(!isset($_SESSION['login'])){
		header("Location: login.php");
	}

	$user = get_name();
	$role = get_role();
?>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="js/jquery-2.1.4.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/jquery-ui.min.css">
		<link rel="stylesheet" href="css/custom/nav.css">
	</head>

	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="col-md-2">
				<a class="navbar-brand" href="index.php">SILUTEL</a>
			</div>

			<div class="col-md-2 col-md-offset-8">
				<ul class="nav navbar-nav navbar-right">
					<li> <a href="logout.php">Logout</a> </li>
				</ul>
			</div>
		</div>
	</nav>

	<div id="wrapper">
		<div id="sidebar-wrapper">
			<ul class="sidebar-nav">
				<li class="sidebar-brand">
					<div id="current-user">
						Welcome, <?php echo $user ?>
					</div>
					<div id="current-role">
						<?php echo $role ?>
					</div>
				</li>

				<?php
					if($role === 'Dadu' || $role === 'Staf Inventori Kamar')
						echo '<li> <a href="beli_inventori.php">Beli Inventori</a> </li>';

					if($role === 'Dadu' || $role === 'Manager' || $role === 'Staf Inventori Kamar')
						echo '<li> <a href="lihat_inventori.php">Lihat Inventori</a> </li>';

					if($role === 'Dadu' || $role === 'Manager' || $role === 'Staf Laundry')
						echo '<li> <a href="lihat_laundry.php">Lihat Laundry</a> </li>';

					if($role === 'Dadu' || $role === 'Manager')
						echo '<li> <a href="lihat_booking.php">Lihat Booking</a> </li>';

					if($role === 'Dadu' || $role === 'Staf Inventori Kamar')
						echo '<li> <a href="ganti_inventori.php">Ganti Inventori</a> </li>';

					if($role === 'Dadu' || $role === 'Manager' || $role === 'Staf Inventori Kamar')
						echo '<li> <a href="lihat_pembelian_inventori.php">Lihat Pembelian Inventori</a> </li>';
				?>
			</ul>
		</div>

		<div id="page-content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						