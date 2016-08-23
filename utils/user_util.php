<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include 'db.php';

	function get_email() {
		global $db;
		$user_row = pg_prepare($db, "login", 'SELECT * FROM silutel.user WHERE email=$1');
		$user_row = pg_fetch_array(pg_execute($db, "login", array($_SESSION['login'])), 0);
		
		return $user_row[0];
	}

	function get_name() {
		global $db;
		$user_row = pg_prepare($db, "login", 'SELECT * FROM silutel.user WHERE email=$1');
		$user_row = pg_fetch_array(pg_execute($db, "login", array($_SESSION['login'])), 0);
		
		return $user_row[1];
	}

	function get_address() {
		global $db;
		$user_row = pg_prepare($db, "login", 'SELECT * FROM silutel.user WHERE email=$1');
		$user_row = pg_fetch_array(pg_execute($db, "login", array($_SESSION['login'])), 0);
		
		return $user_row[2];
	}

	function get_role() {
		global $db;
		$user_row = pg_prepare($db, "login", 'SELECT * FROM silutel.user WHERE email=$1');
		$user_row = pg_fetch_array(pg_execute($db, "login", array($_SESSION['login'])), 0);
		
		switch ($user_row[4]) {
			case 'DA':
				$role = "Dadu";
				break;

			case 'MG':
				$role = "Manager";
				break;

			case 'IN':
				$role = "Staf Inventori Kamar";
				break;

			case 'LA':
				$role = "Staf Laundry";
				break;
			
			default:
				$role = "Unknown";
				break;
		}

		return $role;
	}
	
?>