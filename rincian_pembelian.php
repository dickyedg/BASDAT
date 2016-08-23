<?php
	include_once 'nav.php';

	$nota = '';
	$total = 0;
	$waktu = '';
	$staf = '';
	$supplier = '';

	$nama_inv = array();
	$merk_inv = array();
	$jumlah_inv = array();
	$harga_inv = array();
	$total_inv = array();

	if( isset($_GET['nota']) ) {
		$nota = $_GET['nota'];

		// Get pembelian
		$query_str = "SELECT * FROM silutel.pembelian JOIN silutel.user ON emailstaff=email WHERE nomornota=$1 LIMIT 1;";
		pg_prepare($db, "pembelian", $query_str);
		$result = pg_execute($db, "pembelian", array($nota));

		if($result) {
			$row = pg_fetch_assoc($result);

			$waktu = $row['waktu'];
			$staf = $row['nama'];
			$supplier = $row['namasupplier'];

			// Get inventories bought
			$query_str = "SELECT * FROM silutel.pembelian_inventori WHERE nomornota=$1;";
			pg_prepare($db, "pembelian_inventori", $query_str);
			$result2 = pg_execute($db, "pembelian_inventori", array($nota));

			
			while($row2 = pg_fetch_assoc($result2)) {
				$nama_inv[] = $row2['nama'];
				$merk_inv[] = $row2['merk'];
				$jumlah_inv[] = $row2['jumlah'];
				$harga_inv[] = $row2['hargasatuan'];

				$total += $row2['jumlah'] * $row2['hargasatuan'];
			}
		}
	}
?>

	<head>
		<title>Lihat Pembelian Inventory</title>
		<script src="js/Script.js"></script>
	</head>

	<body>
		<div>
			<div class="details">
				<table style="width:100%">
					<tr>
						<th>Nomor Nota: </th>
						<td><?php echo $nota ?></td>
						<th>Total: </th>
						<td><?php echo number_format($total) ?></td>
					<tr>
					<tr>
						<th>Waktu: </th>
						<td><?php echo $waktu ?></td>
						<th>Staf: </th>
						<td><?php echo $staf ?></td>
					<tr>
					<tr>
						<th>Supplier: </th>
						<td><?php echo $supplier ?></td>
					<tr>
				<table>
				<br>
			<div>

			<div class ="tablee">
				<table class= 'table table-hover'>
					<thead>
					<tr>
						<th >Nama Inventori</th>
						<th >Merk</th>		
						<th >Harga</th>
						<th >Jumlah</th>
						<th >Total</th>
					</tr>
					</thead>
					<?php
						for ($i=0; $i < count($nama_inv); $i++) { 
							echo '<tr>';
							echo '<td> ' .$nama_inv[$i]. '</td>';
							echo '<td> ' .$merk_inv[$i]. '</td>';
							echo '<td> ' .number_format($harga_inv[$i]). '</td>';
							echo '<td> ' .$jumlah_inv[$i]. '</td>';
							echo '<td> ' .number_format($harga_inv[$i] * $jumlah_inv[$i]). '</td>';
							echo '</tr>';
						}
					?>
					
				</table>
			</div>
		</div>

	</body>

<?php
	include_once 'footer.php';
?>
