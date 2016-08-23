<?php 

	include_once 'db.php';
	$namabrg="";
	
	
	if(isset($_GET['namabrg'])) {
		$namabrg=$_GET['namabrg'];
	}
	
	$query = "select distinct merk from inventori where nama='$namabrg'";
    
	$result = pg_query($db,$query) or die("I couldn't connect to database");
	
	while ($row = pg_fetch_assoc($result)) {
			$inventories[] = $row;
		}

	echo json_encode($inventories);

?>