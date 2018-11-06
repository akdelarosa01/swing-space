var items = [{
	id: 1,
	item_code: 'BC10001',
	item_name: 'Brewed Coffee',
	quantity: 50,
},{
    id: 2,
    item_code: 'CM10001',
    item_name: 'Chocolate Mix',
    quantity: 10,
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
            {data: function(x) {
                return '<button type="button" class="btn btn-sm btn-danger">'+
                            'Delete'+
                        '</button>';
            }},
        ],
        // fnInitComplete: function() {
        //     $('.dataTables_scrollBody').slimscroll();
        // },
    });
}