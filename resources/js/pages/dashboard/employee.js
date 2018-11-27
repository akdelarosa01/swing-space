$( function() {
	customersToday();
    employeeStatistic();
});

function customersToday() {
	$.ajax({
		url: '../../dashboard/customers-today',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
        console.log(data);
		customersTodayTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Customers Today: '+ errorThrown,textStatus);
	});
}

function customersTodayTable(arr) {
	$('#tbl_customers').dataTable().fnClearTable();
    $('#tbl_customers').dataTable().fnDestroy();
    $('#tbl_customers').dataTable({
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
            { data: function(x) {
                return '₱ '+ (x.total_bill).toFixed(2);
            }, searchable: false, orderable: false}
        ]
    });
    
}

function employeeStatistic() {
    $.ajax({
        url: '../../dashboard/employee-total-statistic',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token
        },
    }).done(function(data, textStatus, xhr) {
        $('#total_customers').attr('data-count',data.total_customers);
        $('#total_customers').html(data.total_customers);

        $('#total_sold_product').attr('data-count',data.total_sold_product);
        $('#total_sold_product').html(data.total_sold_product);

        $('#total_earnings').attr('data-count',data.total_earnings);
        $('#total_earnings').html(data.total_earnings);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Employee Statistics: '+ errorThrown,textStatus);
    });
}