<?php
	include_once 'nav.php';
	include_once 'utils/db.php';
	include_once 'utils/user_util.php';

	if($role === 'Manager') {
		header("Location: lihat_booking.php?rows=10&date=all");
		die();
	}

	if($role === 'Staf Inventori Kamar') {
		header("Location: lihat_pembelian_inventori.php?rows=10&by=waktu&order=DESC&date=all");
		die();
	}

	if($role === 'Staf Laundry') {
		header("Location: lihat_laundry_summary.php?rows=10");
		die();
	}
?>

	<head>
		<title>SILUTEL</title>
		<link rel="stylesheet" href="css/custom/index.css">
	</head>

	<body>
		<div class="page-content">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="well main">
						<div class="text-center">Welcome to SILUTEL</div>
					</div>
				</div>
			</div>
		</div>
	</body>

<?php
	include_once 'footer.php';
?>