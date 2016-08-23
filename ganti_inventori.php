<?php
	include_once 'nav.php';
	
?>

	<head>
		<title>Ganti Inventori</title>
		<script src="js/Script.js"></script>
		<script src="js/gantiInventori.js"></script>
	</head>

	<body>
		<div class="col-md-3"></div>
		<form class="form-horizontal">
			<div class="well col-md-6" >
				<h1 class="text-center">Ganti Inventori</h1>
				<div class="form-group">
					<label >Nama Inventori</label>
					<select id="namabrg" class="form-control">
					<?php 
                        $query = "select distinct nama from inventori";
    
                        $result = pg_query($db,$query) or die("I couldn't connect to database");
                        
                        while ($row = pg_fetch_assoc($result)) {
                              echo "<option>".$row['nama']."</option>";
                        }
                    ?>
					</select>
				</div>
				<div class="form-group">
					<label >Merk</label>
					<div id="merk">
					
						
					
					</div>
				</div>
				<div class="form-group">
					<label class="control-label">Jumlah</label>
					<input id="jumlah" type="email" class="form-control" placeholder="Jumlah">
				</div>
				<div class="form-group">
					<label class="control-label">Alasan</label>
					<textarea id="alasan" class="form-control" style="resize:vertical;" type="text" rows="6"></textarea>
					
				</div>
				<div class="col-md-5"></div>
				<div class="col-md-5">
					<button type="button" onclick="gantiInventori()" class="btn btn-success">Submit</button>
				</div>
			</div>
		</form>
				
		<div class="col-md-3"></div>
	</body>

<?php
	include_once 'footer.php';
?>