$( function() {
	qr_code();
	purchaseHistory();
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