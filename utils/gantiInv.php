<?php 

	include_once 'db.php';
    session_start();
	
    $namaStaf=$_SESSION['login'];
	
	$namaInv="";
	$merk="";
    $alasan="";
    $jumlah="";
    
	if(isset($_GET['namabrg'])) {
		$namaInv=$_GET['namabrg'];
	}
		
	if(isset($_GET['merk'])) {
		$merk=$_GET['merk'];
	}
	
	if(isset($_GET['alasan'])) {
		$alasan=$_GET['alasan'];
	}
	
	if(isset($_GET['jumlah'])) {
		$jumlah=$_GET['jumlah'];
	}
	
    $query = "INSERT INTO Staf_Mengganti_inventori Values ('$namaInv','$merk','$namaStaf',CURRENT_TIMESTAMP,'$jumlah','$alasan')";
    
	$sql = pg_query($db,$query) or die("I couldn't connect to database");
    
   
    
?>