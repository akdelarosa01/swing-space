var customers_today = [{
	id: 1,
	name: 'John Doe',
	time_spent: '01:30:25',
	total_bill: '300.00'
},{
	id: 2,
	name: 'Juan Dela Cruz',
	time_spent: '00:33:41',
	total_bill: '200.00'
}];

$( function() {
	customerTable(customers_today);
});

function customerTable(arr) {
	$('#tbl_customer_today').dataTable().fnClearTable();
    $('#tbl_customer_today').dataTable().fnDestroy();
    $('#tbl_customer_today').dataTable({
        data: arr,
        bLengthChange : false,
        searching: false,
        ordering: false,
	    paging: false,
	    scrollY: "250px",
        columns: [
            {data:'name'},
            {data:'time_spent'},
            {data:'total_bill'},
            {data: function(x) {
            	return '<button class="btn btn-sm btn-primary">Check Out</button>';
            }},
        ],
        // fnInitComplete: function() {
        //     $('.dataTables_scrollBody').slimscroll();
        // },
    });
}