function fetch_inventory_names() {
	return $.ajax({
		url: "utils/get_inventories.php?cmd=list_nama", 
		method: "GET",
		dataType: "json",
		success: function(json) { },
		error: function(xhr){
			console.log("ERROR " + xhr.status);
		}
	});
}

function fetch_inventory_brand(name) {
	return $.ajax({
		url: "utils/get_inventories.php?cmd=list_merk&nama=" + name, 
		method: "GET",
		dataType: "json",
		success: function(json) { },
		error: function(xhr){
			console.log("ERROR " + xhr.status);
		}
	});
}

function adjust_merk_dropdown(row_id) {
	var current_row_id = "inv-row-" + row_id;
	var selected = $('#' + current_row_id + ' #nama-inv-' + row_id).find(':selected').attr('value');

	$.when(fetch_inventory_brand(selected)).done( function(a1, a2, a3, a4) {
		var brands = a1;

		$('#' + current_row_id + ' #merk-inv-' + row_id).empty();

		for(var i = 0; i < brands.length; i++) {
			$('#' + current_row_id + ' #merk-inv-' + row_id)
				.append( $('<option>', {
					'text':  brands[i].merk,
					'value': brands[i].merk
				}))
		}
	})
}

function adjust_dropdown(row_id, inv_names) {
	var current_row_id = "inv-row-" + row_id;

	for(var i = 0; i < inv_names.length; i++) {
		$('#' + current_row_id + ' #nama-inv-' + row_id)
			.append( $('<option>', {
				'text':  inv_names[i].nama,
				'value': inv_names[i].nama
			}))
	}

	adjust_merk_dropdown(row_id);

	$('#' + current_row_id + ' #nama-inv-' + row_id)
		.on("change", function() {
			adjust_merk_dropdown(row_id);
		})
}

function adjust_total(row_id) {
	var current_row_id = "inv-row-" + row_id;
	var price  = $('#' + current_row_id + ' #harga-' + row_id).val();
	var amount = $('#' + current_row_id + ' #jumlah-' + row_id).val();

	$('#' + current_row_id + ' #total-' + row_id).val(price * amount);
}

function add_row(row_id, with_delete) {
	var current_row_id = "inv-row-" + row_id;

	$('#buy-inv-template').clone()
		.removeClass('hide')
		.attr('id', current_row_id)
		.appendTo('#inv-rows');

	if(!with_delete) {
		$('#' + current_row_id).find('.delRowBtn').remove();
	}

	$('#' + current_row_id + ' #nama-inv')
		.attr('id', "nama-inv-" + row_id);

	$('#' + current_row_id + ' #merk-inv')
		.attr('id', "merk-inv-" + row_id);

	$('#' + current_row_id + ' #harga')
		.attr('id', "harga-" + row_id);

	$('#' + current_row_id + ' #jumlah')
		.attr('id', "jumlah-" + row_id);

	$('#' + current_row_id + ' #total')
		.attr('id', "total-" + row_id);

	$("#harga-" + row_id).on("change paste keyup", function() {
		adjust_total(row_id);
	});

	$("#jumlah-" + row_id).on("change paste keyup", function() {
		adjust_total(row_id);
	});
}

$(document).ready(function() {
	var row_id = 0;
	var inventories;

	$.when(fetch_inventory_names()).done( function(a1, a2, a3, a4) {
		inventories = a1;

		add_row(row_id, false);
		adjust_dropdown(row_id++, inventories);

		$('#buy-inv-form')
			.on('click', '.addRowBtn', function() {
				add_row(row_id, true);
				adjust_dropdown(row_id++, inventories);
			})

			.on('click', '.delRowBtn', function() {
				var $row = $(this).parent().parent();
				$row.remove();
			})
		;
	});
});