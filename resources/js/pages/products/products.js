var products = [{
	id: 1,
    prod_code: 'BV10001',
	prod_name: 'Brewed Coffee',
	prod_type: 'Beverage',
	price: 'Php 70.00'
}];

$( function() {
	productTable(products);
});

function productTable(arr) {
	$('#tbl_products').dataTable().fnClearTable();
    $('#tbl_products').dataTable().fnDestroy();
    $('#tbl_products').dataTable({
        data: arr,
        bLengthChange : false,
        searching: false,
        ordering: false,
	    paging: false,
	    scrollY: "250px",
        columns: [
            {data:'prod_code'},
            {data:'prod_name'},
            {data:'prod_type'},
            {data:'price'},
            {data: function(x) {
            	return '<div class="btn-group">'+
                            '<button class="btn btn-sm btn-info">Edit</button>'+
                            '<button class="btn btn-sm btn-danger">Delete</button>'+
                        '</button>';
            }},
        ],
        // fnInitComplete: function() {
        //     $('.dataTables_scrollBody').slimscroll();
        // },
    });
}