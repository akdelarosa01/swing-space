$( function() {
	getSales();
	OwnerStatistics();
	SalesFromRegisteredCustomer();
});

function getSales() {
	$.ajax({
		url: '../../dashboard/get-sales',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		if ($('#ct-LineChart1').length > 0) {
			new Chartist.Line('#ct-LineChart1 .ct-chart', {
				labels: data.labels,
				series: [
					data.series
				]
			}, {
					low: 0,
					showArea: true,
					width: '100%',
					height: '300px',
					fullWidth: true,
					chartPadding: {
					bottom: 10,
					right: 20,
					left: 0,
					top: 20
				}
			});

			$('#weekly_sale').html(data.weekly_sale);
			$('#start_date').html(data.start_date);
			$('#end_date').html(data.end_date);
		}
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Sales Chart: '+errorThrown,textStatus);
	});
	
}

function OwnerStatistics() {
	$.ajax({
		url: '../../dashboard/owner-total-statistic',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		$('#total_customers').html(data.total_customers);
		$('#total_customers').attr('data-count',data.total_customers);

		$('#total_employees').html(data.total_employees);
		$('#total_employees').attr('data-count',data.total_employees);

		$('#total_products').html(data.total_products);
		$('#total_products').attr('data-count',data.total_products);

	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Owner Statistics: '+errorThrown,textStatus);
	});
}

function SalesFromRegisteredCustomer() {
	$.ajax({
		url: '../../dashboard/sales-registered',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		SalesFromRegisteredCustomerTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Sales from customers: '+errorThrown,textStatus);
	});
}

function SalesFromRegisteredCustomerTable(arr) {
	$('#tbl_registered').dataTable().fnClearTable();
    $('#tbl_registered').dataTable().fnDestroy();
    $('#tbl_registered').dataTable({
        data: arr,
        // bLengthChange : false,
        // ordering: false,
        columns: [
        	{ data: function(x) {
            	return '<img src="'+x.photo+'" class="w-35 rounded-circle" alt="'+x.firstname+' '+x.lastname+'">';
            }, searchable: false, orderable: false},
            { data:'code', searchable: false, orderable: false},
            { data: function(x) {
                return x.firstname+' '+x.lastname;
            }, searchable: false, orderable: false},
            { data:'points', searchable: false, orderable: false},
            { data: 'total_sale', searchable: false, orderable: false}
        ]
    });
}