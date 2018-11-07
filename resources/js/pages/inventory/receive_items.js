var items = [{
	id: 1,
	item_code: 'BC10001',
	item_name: 'Brewed Coffee',
	quantity: 50,
    package: 'Box',
    package_qty: 5,
    remarks: 'No damaged found.'
},{
    id: 2,
    item_code: 'CM10001',
    item_name: 'Chocolate Mix',
    quantity: 10,
    package: 'Box',
    package_qty: 2,
    remarks: 'No damaged found.'
}];

$( function() {
	itemsTable(items);
});

function itemsTable(arr) {
	$('#tbl_items').dataTable().fnClearTable();
    $('#tbl_items').dataTable().fnDestroy();
    $('#tbl_items').dataTable({
        data: arr,
        bLengthChange : false,
        searching: false,
        ordering: false,
	    paging: false,
	    scrollY: "250px",
        columns: [
            { data: 'item_code' },
            { data: 'item_name' },
            { data: 'quantity' },
            { data: 'package' },
            { data: 'package_qty' },
            { data: 'remarks' },
            {data: function(x) {
                return '<div class="btn-group">'+
                            '<button type="button" class="btn btn-sm btn-info btn-sm">'+
                                'Edit'+
                            '</button>'+
                            '<button type="button" class="btn btn-sm btn-danger btn-sm">'+
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