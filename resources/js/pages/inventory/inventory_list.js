var items = [{
	id: 1,
	item_code: 'BC10001',
	item_name: 'Brewed Coffee',
	quantity: 50,
    package: 'Box',
    package_qty: 5,
    remarks: 'No damaged found.',
    date_received: '09/24/2018'
},{
    id: 2,
    item_code: 'CM10001',
    item_name: 'Chocolate Mix',
    quantity: 10,
    package: 'Box',
    package_qty: 2,
    remarks: 'No damaged found.',
    date_received: '09/24/2018'
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
            {data: function(x) {
                return '<input type="checkbox" class="">';
            }},
            { data: 'item_code' },
            { data: 'item_name' },
            { data: 'quantity' },
            { data: 'package' },
            { data: 'package_qty' },
            { data: 'remarks' },
            { data: 'date_received' },
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