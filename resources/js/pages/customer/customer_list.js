var customers = [];

$( function() {
	getCustomers();
});

function getCustomers() {
    customers = [];
    $.ajax({
        url: 'customer-list/show',
        type: 'GET',
        dataType: 'JSON',
        data: {_token: token},
    }).done(function(data, textStatus, xhr) {
        customers = data;
        customerTable(customers);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg(errorThrown,textStatus);
    }).always(function() {
        console.log("complete");
    });
    
}

function customerTable(arr) {
	$('#tbl_customers').dataTable().fnClearTable();
    $('#tbl_customers').dataTable().fnDestroy();
    $('#tbl_customers').dataTable({
        data: arr,
        bLengthChange : false,
        searching: false,
        ordering: false,
	    paging: false,
	    scrollY: "250px",
        columns: [
        	{data: function(x) {
            	return '<img src="'+x.photo+'" class="w-35 rounded-circle" alt="'+x.firstname+' '+x.lastname+'">';
            }},
            {data:'customer_code'},
            {data: function(x) {
                return x.firstname+' '+x.lastname;
            }},
            {data:'gender'},
            {data: function(x) {
            	return '<div class="btn-group">'+
                            '<a href="/membership/'+x.id+'/edit" class="btn btn-sm btn-info">Edit</a>'+
                            '<button class="btn btn-sm btn-danger">Delete</button>'+
                        '</button>';
            }},
        ]
    });
}