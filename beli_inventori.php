<?php
	include_once 'nav.php';

	if( isset($_POST['nota']) ) {
		$nota = $_POST["nota"];
		$transaction_time = date('Y-m-d H:i:s');
		$staff_email = $_SESSION['login'];
		$supplier = $_POST["supplier"];

		$nama_inv = $_POST["nama_inv"];
		$merk_inv = $_POST["merk_inv"];
		$harga = $_POST["harga"];
		$jumlah = $_POST["jumlah"];
		
		$total = $_POST["total"];
		$cnt = count($nama_inv);

		// Insert to PEMBELIAN
		$query_str = "INSERT INTO silutel.pembelian(nomornota, waktu, emailstaff, namasupplier) VALUES($1, $2, $3, $4);";

		pg_prepare($db, "pembelian", $query_str);
		$result = pg_execute($db, "pembelian", array($nota, $transaction_time, $staff_email, $supplier));

		// Insert to PEMBELIAN_INVENTORI
		$query_str = "INSERT INTO silutel.pembelian_inventori(nomornota, nama, merk, jumlah, hargasatuan) VALUES($1, $2, $3, $4, $5);";

		pg_prepare($db, "pembelian_inventori", $query_str);

		for($i = 0; $i < $cnt; $i++) {
			$result = pg_execute($db, "pembelian_inventori", array($nota, $nama_inv[$i], $merk_inv[$i], $jumlah[$i], $harga[$i]));
		}

		header("Location: rincian_pembelian.php?nota=" . $nota);
	}
?>

	<head>
		<title>Beli Inventori</title>
		<link rel="stylesheet" href="css/custom/beli_inventori.css">
		<script type="text/javascript" src="js/beli_inventori.js"></script>
	</head>

	<body>
		<div class="page-content">
			<form class="well" id="buy-inv-form" role="form" method="POST">
				<h2 class="text-center">Beli Inventori</h2>
				<div class="input-group form-group">
					<span class="input-group-addon" id="label-nota">Nomor nota</span>
					<input type="text" class="form-control" name="nota" pattern=".{6,6}" placeholder="GGA021 (6 karakter)" required>
				</div>

				<div class="input-group form-group">
					<span class="input-group-addon" id="basic-addon2">Supplier</span>
					<select class="form-control" name="supplier">
						<?php
							$query_str = 'SELECT * FROM silutel.supplier';
							pg_prepare($db, "supplier", $query_str);
							$result = pg_execute($db, "supplier", array());

							while ($row = pg_fetch_assoc($result)) {
								$temp = '<option value="{name}">{name}</option>';
								echo str_replace("{name}", $row['nama'], $temp);
							}
						?>
					</select>
				</div>

				<hr>

				<div class="form-group" id="inv-rows">
					<div class="row"> 
						<div class="col-md-3 left-pad"><h4>Nama</h4></div>
						<div class="col-md-3 small-pad"><h4>Merk</h4></div>
						<div class="col-md-2 small-pad"><h4>Harga</h4></div>
						<div class="col-md-1 small-pad"><h4>Jumlah</h4></div>
						<div class="col-md-2 small-pad"><h4>Total</h4></div>
					</div>

					<!-- Add new rows here -->
				</div>

				<div class="row row-eq-height form-group buy-inv-row hide" id="buy-inv-template">
					<div class="col-md-3 small-pad left-pad">
						<select id="nama-inv" class="form-control" name="nama_inv[]">
						</select>
					</div>

					<div class="col-md-3 small-pad">
						<select id="merk-inv" class="form-control" name="merk_inv[]">
							<option value="null">-----</option>
						</select>
					</div>

					<div class="col-md-2 small-pad">
						<input id="harga" type="number" value="0" min="0" class="form-control" name="harga[]">
					</div>

					<div class="col-md-1 small-pad">
						<input id="jumlah" type="number" value="0" min="0" class="form-control" name="jumlah[]">
					</div>

					<div class="col-md-2 small-pad">
						<input id="total" type="number" value="0" class="form-control" name="total[]" readonly>
					</div>

					<div class="col-md-1 small-pad right-pad">
						<button type="button" class="btn btn-block btn-danger delRowBtn" style="margin-top: 2px;">
							<span class="glyphicon glyphicon-remove"></span>
						</button>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<button type="button" name="submit" id="add-inv-btn" class="btn btn-block btn-info addRowBtn">
							<span class="glyphicon glyphicon-plus"></span>  Tambah Baris Inventori
						</button>	
					</div>
					<div class="col-md-6">
						<button type="submit" name="submit" id="buy-inv-btn" class="btn btn-block btn-primary">
							<span class="glyphicon glyphicon-ok"></span>  Beli Inventori
						</button>	
					</div>
				</div>
			</form>
		</div>
	</body>

<?php
	include_once 'footer.php';
?>