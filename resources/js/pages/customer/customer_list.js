var customers = [];

$( function() {
	getCustomers();

    $('#tbl_customers_body').on('click', '.delete-customer', function() {
        confirm('Delete Customer','Do you want to delete this customer?',$(this).attr('data-id'));
    });

    $('#btn_confirm').on('click', function() {
        $('.loading').show();
        $.ajax({
            url: '../../customer-list/delete',
            type: 'POST',
            dataType: 'JSON',
            data: {
                _token: token,
                id: $('#confirm_id').val()
            },
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                $('#confirm_modal').modal('hide');
                msg(data.msg,data.status)
                customerTable(data.customers);
            }
            
        }).fail(function(xhr, textStatus, errorThrown) {
            msg('Delete Customer: '+errorThrown,textStatus);
        }).always(function() {
            $('.loading').hide();
        });
    });

    $('#btn_customer_xl').on('click', function() {
        var ExportURL = '../../customer-list/customer-list-excel?_token='+token;
        window.location.href=ExportURL;
    });
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
     //    bLengthChange : false,
     //    searching: false,
     //    ordering: false,
	    // paging: false,
	    // scrollY: "250px",
        columns: [
        	{data: function(x) {
            	return '<img src="'+x.photo+'" class="w-35 rounded-circle" alt="'+x.firstname+' '+x.lastname+'">';
            }, searchable: false, orderable: false},
            {data:'customer_code'},
            {data: function(x) {
                return x.firstname+' '+x.lastname;
            }},
            {data:'gender'},
            {data:'date_of_birth'},
            {data:'occupation'},
            {data:'company'},
            {data:'school'},
            {data:'referrer'},
            {data:'points'},
            {data:'date_registered'},
            {data: function(x) {
            	return '<div class="btn-group">'+
                            '<a href="/membership/'+x.id+'/edit" class="btn btn-sm btn-info btn-permission">'+
                                '<i class="fa fa-edit"></i>'+
                            '</a>'+
                            '<button class="btn btn-sm btn-danger delete-customer btn-permission" data-id="'+x.id+'">'+
                                '<i class="fa fa-trash"></i>'+
                            '</button>'+
                        '</div>';
            }, searchable: false, orderable: false},
        ]
    });
    
    check_permission('CUS_LST');

    getLanguage(dict);
}