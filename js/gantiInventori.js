//agni script semua keperluan lihat booking dan ganti inventori
$(document).ready(function(){
	getMerk();
});

$(document).on('change','#namabrg',function(){
	getMerk();
});

function gantiInventori(){
	var user ="";
    var namabrg = $( "#namabrg option:selected" ).text();
    var merk = $( "#merk option:selected" ).text();
	var jumlah = $('#jumlah').val();
	var alasan = $('#alasan').val();
	
	$.ajax({
		url: "utils/gantiInv.php",
		method: "GET",
		data:  {"user":user ,"namabrg" : namabrg, "merk" : merk,"jumlah" : jumlah, "alasan" : alasan },
		dataType: "text",
		success: function(result){
			alert("Sukses");
			$('#jumlah').val() = "";
			$('#alasan').val()="";
		},
		error: function(xhr){
			alert(xhr.status);
			alert("error ganti Inventori");
		}
	})
	
	$('#jumlah').val('');
	$('#alasan').val('');
}

function getMerk(){
	var namabrg = $("#namabrg").val();
	if (namabrg!=null){
        $.ajax({
            url: "utils/getMerk.php",
            method: "GET",
            data:  {"namabrg":namabrg},
            dataType: "json",
            success: function(result){
                tampilkanMerk(result);
            },
            error: function(xhr){
                alert(xhr.status);
                alert("error get Merk");
            }
        })
    }
}

function tampilkanMerk(data){
		var merk = '';
		
		for(var i = 0; i < data.length; i++){
			merk = merk + '<option>' +  data[i].merk + '</option>' ;
		}

		$('#merk').html( '<select class="form-control merk">'+ merk+ '</select>');
}