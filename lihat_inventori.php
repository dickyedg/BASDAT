<?php
	include_once 'nav.php';
	
	if(isset($_GET['by'])){
		$by = $_GET['by'];
		
		switch ($by) {	
			case 'Nama':
				$_by = "Nama";
				break;
			case 'merk':
				$_by = "Merk";
				break;
			default:
				$_by = "Nama";
				break;
		}
	} else {
		$by = 'Nama';
		$_by = "Nama";
	}

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
	
	if(isset($_GET['order'])){
		$order = $_GET['order'];
	} else $order = 'ASC';
	
?>

	<head>
		<title>Lihat Inventori</title>
		<script src="js/Script.js"></script>
	</head>

	<body>
		<div>
			<h2>Lihat Inventori</h2>
			<div class="row">
				<div class="col-md-10 control-group" id="choice" style="margin-bottom:14px;">
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
									echo '<li value="Nama"><a href="?by=nama&order='.$order.'">Nama </a></li>';
									echo '<li value="Merk"><a href="?by=merk&order='.$order.'">Merk </a></li>';
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
					$query_str = "SELECT * FROM silutel.inventori ORDER BY $by $order LIMIT $1 OFFSET $2;";
					pg_prepare($db, "inventori_query", $query_str);
					$result = pg_execute($db, "inventori_query", array($rows, $rows * $page));

					if (!$result) {
						echo "An error occurred.\n";
						exit;
					}
					
					echo "<table class= 'table table-hover'>";

					echo "<thead>";
					echo "<tr>";
					echo "<th >Nama</th>";
					echo "<th >Merk</th>";		
					echo "<th >Stok</th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";

					while($row=pg_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td >" . $row['nama'] . "</td>";
						echo "<td >" . $row['merk'] . "</td>";
						echo "<td >" . $row['stok'] . "</td>";
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

							$nextURL = basename(__FILE__) . "?by=$by&order=$order&rows=$rows&page=$nextPage";
							$prevURL = basename(__FILE__) . "?by=$by&order=$order&rows=$rows&page=$prevPage";

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