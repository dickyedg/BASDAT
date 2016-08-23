<?php
	include_once 'nav.php';
	include_once 'db.php';

	$page="";
	$rows="";
	$tanggal="";
	$sortby="";
	$typesort="";
	
	if(!isset($_GET['page'])) {
		$page = 0;
	} else {
		$page = $_GET['page'];
	}

	if(!isset($_GET['rows'])) {
		$rows = 15;
	} else {
		$rows = $_GET['rows'];
	}

	if(isset($_GET['date']) && $_GET['date'] != 'all') {
		$tanggal=$_GET['date'];
		$date = new DateTime($tanggal);
		$tanggal= $date->format('Y-m-d'); 
	} else if(isset($_GET['date']) && $_GET['date'] == 'all') {
		$tanggal = 'all';
	} else {
        $tanggal = date("Y/m/d"); 
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
	} else {
		$sortby = "nomorinvoice";
	}
	
	if(isset($_GET['typesort'])) {
		$typesort=$_GET['typesort'];
		if($typesort=="Ascending"){
			$typesort = "ASC";
		}else{
			$typesort = "DESC";
		}
	} else {
		$typesort = "DESC";
	}
?>

	<head>
		<title>Lihat Booking</title>
		<script src="js/Script.js"></script>
	</head>

	<body>
		<h2>Lihat Booking</h2>
		<form role="form" action="" method="GET">
			<div class="col-md-3">
				<div class="date-form">
					<div class="control-group">
						<label for="date-picker-2" class="control-label">Tanggal Booking</label>
						<div class="controls">
							<div class="input-group">
								<input 	id="date-picker-2" 
										name="date" 
										type="text" 
										class="date-picker form-control" 
										<?php
											echo "value=$tanggal";
										?>
								/>
								<label for="date-picker-2" class="input-group-addon btn">
									<span class="glyphicon glyphicon-calendar"></span>
								</label>
							</div>
						</div>
					</div>
				</div>
		    </div>
			
			<div class="col-md-3">
				<div class="form-group">
				  	<label for="sel1">Sort By:</label>
					<select name="sortby" id="sortby" class="form-control" id="sel1">
						<option>Invoice</option>
						<option>Tanggal Datang</option>
						<option>Tanggal Pergi</option>
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="sel1">Type Sort:</label>
					<select name="typesort" id="typesort" class="form-control" id="sel1">
						<option>Ascending</option>
						<option>Descending</option>
					</select>
				</div>
			</div>
			<input class="btn btn-primary col-md-1" type="submit" value="Filter" style="margin-top:25px" />
		</form>
		
		<div class="col-md-10 well" style="margin-left:90px; ">
			<div id="data" class="table-responsive">
				<table class="table table-hover">
					<thead>
						<th>Invoice</th>
						<th>Nama Tamu</th>
						<th>Tanggal Datang</th>
						<th>Tanggal Pergi</th>
						<th>Jumlah</th>
						<th>Discount</th>
						<th>Total</th>
					</thead>

					<?php
						if($tanggal !== 'all') {
							$query_date = "tanggaldatang='$tanggal' and";
						} else {
							$query_date = "";
						}

						$query = "select I.nomorinvoice,I.tanggaldatang,I.tanggalpergi,I.jumlah,I.discount,I.total,T.nama from invoice I, tamu T where $query_date T.id=I.idtamu order by I.$sortby $typesort limit $1 offset $2;";

						pg_prepare($db, "booking_query", $query);
						$result = pg_execute($db, "booking_query", array($rows, $page * $rows));

						while($row = pg_fetch_assoc($result)){
							echo '<tr>';
								echo '<td >'. $row['nomorinvoice'] .'</td>';
								echo '<td >'. $row['nama'] .'</td>';
								echo '<td >'. $row['tanggaldatang'] .'</td>';
								echo '<td >'. $row['tanggalpergi'] .'</td>';
								echo '<td >'. $row['jumlah'] .'</td>';
								echo '<td >'. $row['discount'] .'</td>';
								echo '<td >'. $row['total'] .'</td>';
							echo '</tr>';
						}
					?>
				</table>
			</div>
			<nav>
				<ul class="pager">
					<?php
						$nextPage = $page + 1;
						$prevPage = ($page == 0) ? 0 : $page - 1;
						$date = ($tanggal =='') ? '' : "&date=$tanggal";

						$nextURL = basename(__FILE__) . "?sortby=$sortby&typesort=$typesort&rows=$rows&page=$nextPage" . $date;
						$prevURL = basename(__FILE__) . "?sortby=$sortby&typesort=$typesort&rows=$rows&page=$prevPage" . $date;

						echo '<li><a href="' .$prevURL. '">Previous</a></li>';
						echo '<li><a href="' .$nextURL. '">Next</a></li>';
					?>
				</ul>
			</nav>
		 </div>
	</body>

<?php
	include_once 'footer.php';
?>