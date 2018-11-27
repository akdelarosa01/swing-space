$( function() {
	CustomerStatictic();
	getCustomerBill();
});

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