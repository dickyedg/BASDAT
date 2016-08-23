<?php
	include_once 'nav.php';

	if(!isset($_GET['rows'])) {
		$rows = 15;
	} else {
		$rows = $_GET['rows'];
	}
?>

	<head>
		<title>Lihat Laundry</title>
		<script src="js/Script.js"></script>
	</head>

	<body>
		<div>
			<h2>Histori Laundry</h2>
			<div class ="tablee well">
				<table class= 'table table-hover'>
					<thead>
						<tr>
							<th >Staf</th>
							<th >Waktu</th>		
							<th >Total</th>
						</tr>
					</thead>
					
					<?php
						$query_str = "SELECT * FROM silutel.laundry_staf_laundry LSL JOIN silutel.user U ON LSL.emailstaf=U.email " .
									 "LIMIT $1";

						pg_prepare($db, "laundry_summary_query", $query_str);
						$result = pg_execute($db, "laundry_summary_query", array($rows));
						
						while($row = pg_fetch_assoc($result)){
							echo '<tr>';
								echo '<td >'. $row['nama'] .'</td>';
								echo '<td >'. $row['waktu'] .'</td>';
								echo '<td >'. $row['total'] .'</td>';
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

