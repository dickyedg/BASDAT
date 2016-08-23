<?php
	$host = "localhost";
	$dbname = "postgres";
	$user = "postgres";
	$password = "gameofthrones1996";

	$db = pg_connect("host=" .$host. " dbname=" .$dbname. " user=" .$user. " password=" .$password)
		or die("pg_connect() failed");

	$result = pg_query($db, "SET search_path TO silutel");
	if (!$result) {
		echo "Failed to set schema.\n";
		exit;
	}
?>