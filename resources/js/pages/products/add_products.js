var products = [{
	id: 1,
	prod_code: 'PR10001',
	prod_name: 'Brewed Coffee',
	prod_type: 'Beverage',
    price: '70.00',
    description: ''
},{
    id: 2,
    prod_code: 'PR10002',
    prod_name: 'Chocolate Cake Sliced',
    prod_type: 'Cake',
    price: '150.00',
    description: '' 
}];

$( function() {
	productsTable(products);
});

function productsTable(arr) {
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
            { data: 'prod_code' },
            { data: 'prod_name' },
            { data: 'prod_type' },
            { data: 'price' },
            { data: 'description' },
            {data: function(x) {
                return '<div class="btn-group">'+
                            '<button type="button" class="btn btn-sm btn-info">'+
                                'Edit'+
                            '</button>'+
                            '<button type="button" class="btn btn-sm btn-danger">'+
                                'remove'+
                            '</button>'+
                        '</div>';
            }},
        ],
        // fnInitComplete: function() {
        //     $('.dataTables_scrollBody').slimscroll();
        // },
    });
}