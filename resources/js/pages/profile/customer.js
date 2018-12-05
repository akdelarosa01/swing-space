$( function() {
	qr_code();
	purchaseHistory();

	$('#frm_upload').on('submit', function(e) {
		e.preventDefault();

		if ($('#photo').val() == '') {
			msg('Please choose an image file.','failed');
		} else {
			$('.loading').show();

			var data = new FormData(this);
	   		$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				dataType: 'JSON',
				data: data,
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
			}).done(function(data, textStatus, xhr) {
	            if (textStatus == 'success') {
					msg(data.msg,data.status);
					$('#profile_photo').attr('src','../../'+data.photo);
				}
			}).fail(function(xhr, textStatus, errorThrown) {
				var errors = xhr.responseJSON.errors;
				showErrors(errors);

				if(errorThrown == "Internal Server Error"){
	                msg('Upload Photo: '+errorThrown,textStatus);
	            }
			}).always(function() {
				$('.loading').hide();
			});
		}
			
	});
});

function qr_code() {
	$.ajax({
		url: '../../profile/qr_code',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		$('#qr_code').attr('src','/qr_codes/'+data.customer_code+'.png');
		$('#qr_code').attr('alt',data.customer_code);
		$('#cust_code').html(data.customer_code);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Referred Customers: '+ errorThrown,textStatus);
	});
}

function purchaseHistory(argument) {
	$.ajax({
		url: '../../profile/purchase-history',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		purchaseHistoryTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Referred Customers: '+ errorThrown,textStatus);
	});
}

function purchaseHistoryTable(arr) {
	$('#tbl_history').dataTable().fnClearTable();
    $('#tbl_history').dataTable().fnDestroy();
    $('#tbl_history').dataTable({
        data: arr,
        bLengthChange : false,
        ordering: false,
        searching: false,
        columns: [
        	{ data: 'prod_code', searchable: false, orderable: false },
			{ data: 'prod_name', searchable: false, orderable: false },
			{ data: 'variants', searchable: false, orderable: false },
			{ data: 'quantity', searchable: false, orderable: false },
			{ data: 'cost', searchable: false, orderable: false },
			{ data: 'created_at', searchable: false, orderable: false }
        ]
    });
}