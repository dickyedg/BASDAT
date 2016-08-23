<?php
	include_once 'nav.php';
	
	if(isset($_GET['by'])){
		$by = $_GET['by'];
		
		switch ($by) {	
			case 'nama':
				$_by = "Nama";
				break;
			case 'merk':
				$_by = "Merk";
				break;
			case 'emailstaf':
				$_by = "Staf";
				break;
			case 'waktu':
				$_by = "Waktu";
				break;
			default:
				$_by = "Nama";
				break;
		}
	} else {
		$by = 'nama';
		$_by = "Nama";
	}
	
	if(isset($_GET['order'])){
		$order = $_GET['order'];
	} else $order = 'ASC';

	if(!isset($_GET['page'])) {
		$page = 0;
	} else {
		$page = $_GET['page'];
	}

	if (isset($_GET['date']) && $_GET['date']!='') {
		$date = $_GET['date'];
	} else {
		$date = date('m/d/Y');
	}

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
			<h2>Lihat Laundry</h2>
			<div class="row">
				<div class="col-md-4">
					<form class="date-form" action="" method="GET">
						<div class="control-group">
							<label for="date-picker-2" class="control-label">Tanggal Laundry</label>
							<div class="row">
								<div class="controls col-md-10">
									<div class="input-group">
											<input name="date" 
													id="date-picker-2" 
													type="text" 
													class="date-picker form-control" 
													<?php
														echo "value=$date";
													?>
											/>
											<label for="date-picker-2" class="input-group-addon btn">
												<span class="glyphicon glyphicon-calendar"></span>
											</label>
									</div>
								</div>
								<input class="btn btn-primary col-md-2" type="submit" value="Filter" />
							</div>
						</div>
					</form>
				</div>
				
				<script>
					$(".date-picker").datepicker();
				</script>

				<div class="col-md-4" id= "choice">
					<label class="control-label">Urutkan Berdasarkan : </label>
					<div class="controls">
						<div class="dropdown" style="display:inline">
							<button class="btn btn-primary dropdown-toggle" 
									type="button" 
									data-toggle="dropdown">
									<?php echo $_by;?><span class="caret"></span>
							</button>
							<ul name="orderby" class="dropdown-menu">
								<?php
									echo '<li value="Nama"><a href="?by=nama&order='.$order.'&date='.$date.'">Nama </a></li>';
									echo '<li value="Merk"><a href="?by=merk&order='.$order.'&date='.$date.'">Merk </a></li>';
									echo '<li value="Staf"><a href="?by=emailstaf&order='.$order.'&date='.$date.'">Staf </a></li>';
									echo '<li value="Waktu"><a href="?by=waktu&order='.$order.'&date='.$date.'">Waktu </a></li>';
								?>
							</ul>
						  
						</div>
						  
						<div class="dropdown" style="display:inline-block">
							<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
									<?php echo $order;?>
									<span class="caret"></span>
							</button>
							<ul name="order" class="dropdown-menu">
								<?php
									echo '<li value="ASC"><a href="?by='.$by.'&order=ASC">ASC </a></li>';
									echo '<li value="DESC"><a href="?by='.$by.'&order=DESC">DESC </a></li>';
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class ="tablee well">
				<?php 
					echo "<table class= 'table table-hover'>";

					echo "<thead>";
					echo "<tr>";
					echo "<th >Nama</th>";
					echo "<th >Merk</th>";		
					echo "<th >Staf</th>";
					echo "<th >Waktu</th>";
					echo "<th >Jumlah</th>";
					echo "<th >Harga Satuan</th>";
					echo "<th >Total</th>";
					echo "<th >Tanggal Ambil</th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
					
					$query_date = "WHERE to_char(waktu, 'MM/DD/YYYY')='".$date."'";
					$query_str = "SELECT LI.nama AS nama_inv, LI.merk, LI.emailstaf, LI.waktu, LI.jumlah, LI.hargasatuan, LI.tanggalambil, U.nama AS nama_staf FROM silutel.laundry_inventori LI JOIN silutel.user U ON LI.emailstaf=U.email " 
							 	 . $query_date . " ORDER BY LI.$by $order LIMIT $1 OFFSET $2;";
					
					pg_prepare($db, "laundry_query", $query_str);
					$result = pg_execute($db, "laundry_query", array($rows, $page * $rows));
					
					while($row=pg_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td >" . $row['nama_inv'] . "</td>";
						echo "<td >" . $row['merk'] . "</td>";
						echo "<td >" . $row['nama_staf'] . "</td>";
						echo "<td >" . $row['waktu'] . "</td>";
						echo "<td >" . $row['jumlah'] . "</td>";
						echo "<td >" . $row['hargasatuan'] . "</td>";
						echo "<td >" . $row['hargasatuan'] * $row['jumlah'] . "</td>";
						echo "<td >" . $row['tanggalambil'] . "</td>";
						echo "</tr>";
					}

					echo "</tbody>";
					echo "</table>";
				?>

				<nav>
					<ul class="pager">
						<?php
							$nextPage = $page + 1;
							$prevPage = ($page == 0) ? 0 : $page - 1;
							$date = ($date =='') ? '' : "&date=$date";

							$nextURL = basename(__FILE__) . "?by=$by&order=$order&rows=$rows&page=$nextPage" . $date;
							$prevURL = basename(__FILE__) . "?by=$by&order=$order&rows=$rows&page=$prevPage" . $date;

							echo '<li><a href="' .$prevURL. '">Previous</a></li>';
							echo '<li><a href="' .$nextURL. '">Next</a></li>';
						?>
					</ul>
				</nav>
			</div>	
		</div>
	
	</body>

<?php
	include_once 'footer.php';
?>

