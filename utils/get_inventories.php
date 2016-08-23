<?php
	include_once 'db.php';

	if(isset($_GET['cmd'])) {
		$cmd = $_GET['cmd'];
		$inventories = array();

		if($cmd === 'list_nama') {
			$query_str = 'SELECT DISTINCT nama FROM silutel.inventori';
			$result = pg_prepare($db, "inventori", $query_str);
			$result = pg_execute($db, "inventori", array());
		} else if($cmd === 'list_merk') {
			$nama = $_GET['nama'];

			$query_str = 'SELECT * FROM silutel.inventori WHERE nama=$1';
			$result = pg_prepare($db, "inventori", $query_str);
			$result = pg_execute($db, "inventori", array($nama));
		}

		while ($row = pg_fetch_assoc($result)) {
			$inventories[] = $row;
		}

		echo json_encode($inventories);
	}
?>