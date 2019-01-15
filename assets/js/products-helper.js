jQuery(document).ready(function($) {
	// var ajaxurl = '/wp-admin/admin-ajax.php';

	$('.lennox-category .lennox-cat-vm-button').click(function() {
		var lennoxCatID = $(this).attr('lennox-category-id');

		window.location.assign('?cat='+lennoxCatID);

	// 	$.ajax({
	// 		type:'POST',
	// 		url: ajaxurl,
	// 		data: {
	// 			action: 'lennox_products_ajaxhandler',
	// 			'lnxType' : 'category',
	// 			'lnxCatID' : lennoxCatID,

	// 		},
	// 		success: function(response) {
	// 			// alert(response);
	// 			$('.lennox-container').html(response);
	// 		},
	// 		error: function(errorThrown) {
	// 			alert(errorThrown);
	// 		}
	// 	});
	});
	$('.lennox-product-vm').click(function() {
		var lennoxProductID = $(this).attr('lennox-product-id');
		// if (lennoxProductIDarray.length > 4) {
		// 	var lennoxProductID = lennoxProductIDarray[2] + '-' + lennoxProductIDarray[3];
		// } else {
		// 	var lennoxProductID = lennoxProductIDarray[2];
		// }
		window.location.assign('?product='+lennoxProductID);
	});
});