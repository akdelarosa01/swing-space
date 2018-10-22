var customers = [{
	id: 1,
    customer_id: 'SSA-1810-00001',
	name: 'John Doe',
	ocupation: 'Programmer',
    membership: 'Level A',
	date_registered: '10/19/2018'
}, {
    id: 2,
    customer_id: 'SSA-1810-00002',
    name: 'Jane Doe',
    ocupation: 'Web Designer',
    membership: 'Level A',
    date_registered: '10/19/2018'
}, {
    id: 3,
    customer_id: 'SSB-1810-00003',
    name: 'Juan Dela Cruz',
    ocupation: 'Student',
    membership: 'Level B',
    date_registered: '10/19/2018'
}, {
    id: 4,
    customer_id: 'SSA-1810-00004',
    name: 'Sofia So',
    ocupation: 'Instructor',
    membership: 'Level A',
    date_registered: '10/19/2018'
}, {
    id: 5,
    customer_id: 'SSB-1810-00005',
    name: 'Aldrin Bayani',
    ocupation: 'Network Administrator',
    membership: 'Level B',
    date_registered: '10/19/2018'
}, {
    id: 6,
    customer_id: 'SSA-1810-00006',
    name: 'Gordon Ramsey',
    ocupation: 'Chef',
    membership: 'Level A',
    date_registered: '10/19/2018'
}, {
    id: 7,
    customer_id: 'SSB-1810-00007',
    name: 'Jimmy Kimmel',
    ocupation: 'Host',
    membership: 'Level B',
    date_registered: '10/19/2018'
}];

$( function() {
	customerTable(customers);
});

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
            	return '<img src="../../img/default-profile.png" class="w-35 rounded-circle" alt="'+x.name+'">';
            }},
            {data:'customer_id'},
            {data:'name'},
            {data:'ocupation'},
            {data:'membership'},
            {data:'date_registered'},
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