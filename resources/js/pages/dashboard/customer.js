$( function() {
	CustomerStatictic();
	getCustomerBill();
	referredCustomers();
	qr_code();
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

function getCustomerBill() {
	$.ajax({
		url: '../../dashboard/customer-bill',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
        console.log(data);
		getCustomerBillTable(data);

		var total_amount = 0;
		$.each(data, function(i, x) {
			total_amount += x.price;
		});

		$('#total_bill').html('₱'+(total_amount).toFixed(2));
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Customers Bill: '+ errorThrown,textStatus);
	});
}

function getCustomerBillTable(arr) {
	$('#tbl_bill').dataTable().fnClearTable();
    $('#tbl_bill').dataTable().fnDestroy();
    $('#tbl_bill').dataTable({
        data: arr,
        bLengthChange : false,
        ordering: false,
        searching: false,
        paging: false,
        info: false,
        columns: [
            { data:'prod_name', searchable: false, orderable: false},
            { data: 'quantity', searchable: false, orderable: false},
            { data: function(x) {
            	return (x.price).toFixed(2);
            }, searchable: false, orderable: false}
        ]
    });
}

function CustomerStatictic() {
	$.ajax({
		url: '../../dashboard/customer-statistic',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		$('#cust_code').html(data.customer_code);
		$('#available_points').html(data.available_points);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Customers Bill: '+ errorThrown,textStatus);
	});
}

function referredCustomers() {
	$.ajax({
		url: '../../dashboard/referred-customers',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		referredCustomersTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Referred Customers: '+ errorThrown,textStatus);
	});
}

function referredCustomersTable(arr) {
	$('#tbl_referred').dataTable().fnClearTable();
    $('#tbl_referred').dataTable().fnDestroy();
    $('#tbl_referred').dataTable({
        data: arr,
        bLengthChange : false,
        ordering: false,
        searching: false,
        paging: false,
        info: false,
        columns: [
        	{ data: function(x) {
            	return '<img src="'+x.photo+'" class="w-35 rounded-circle" alt="'+x.firstname+' '+x.lastname+'">';
            }, searchable: false, orderable: false},
            { data:'code', searchable: false, orderable: false},
            { data: 'firstname', searchable: false, orderable: false},
            { data: 'lastname', searchable: false, orderable: false}
        ]
    });
}