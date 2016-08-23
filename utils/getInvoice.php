<?php
	include_once 'db.php';
	
	$offset="";
	$limit="";
	$tanggal="";
	$sortby="";
	$typesort="";
	
	if(isset($_GET['offset'])) {
		$offset=$_GET['offset'];
	}

	if(isset($_GET['limit'])) {
		$limit=$_GET['limit'];
	}

	if(isset($_GET['tanggal'])) {
		$tanggal=$_GET['tanggal'];
		$date = new DateTime($tanggal);
		$tanggal= $date->format('Y-m-d'); 
	}

	if(isset($_GET['sortby'])) {
		$sortby=$_GET['sortby'];
		if($sortby=="Invoice"){
			$sortby = "nomorinvoice";
		}else if ($sortby=="Tanggal Datang"){
			$sortby = "tanggaldatang";
		}else{
			$sortby = "tanggalpergi";
		}
	}
	
	if(isset($_GET['typesort'])) {
		$typesort=$_GET['typesort'];
		if($typesort=="Ascending"){
			$typesort = "ASC";
		}else{
			$typesort = "DESC";
		}
	}
	
	
	$query = "select I.nomorinvoice,I.tanggaldatang,I.tanggalpergi,I.jumlah,I.discount,I.total,T.nama from invoice I, tamu T where tanggaldatang='$tanggal' and T.id=I.idtamu order by I.$sortby $typesort limit $limit offset $offset";
    
	$result = pg_query($db,$query) or die("I couldn't connect to database");
	
	$jumlahData = pg_num_rows($result);
	
	while ($row = pg_fetch_assoc($result)) {
			$booking[] = $row;
	}
	
	if($jumlahData!=0)
	echo json_encode($booking);
	else
	echo json_encode("");
?>