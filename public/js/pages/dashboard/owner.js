var dict = {
	"Profile": {
        ch: "轮廓",
        en: "Profile"
    },

    "Sign Out": {
        ch: "登出",
        en: "Sign Out"
    },
	
	"Dashboard": {
        ch: "仪表盘",
        en: "Dashboard"
    },

    "POS Control": {
        ch: "POS控制",
        en: "POS Control"
    },

    "Customers": {
        ch: "顾客",
        en: "Customers"
    },

    "Customer List": {
        ch: "客户名单",
        en: "Customer List"
    },

    "Membership": {
        ch: "会籍",
        en: "Membership"
    },

    "Inventories": {
        ch: "存货",
        en: "Inventories"
    },

    "Inventory List": {
        ch: "库存清单",
        en: "Inventory List"
    },

    "Summary List": {
        ch: "摘要清单",
        en: "Summary List"
    },

    "Receive Item": {
        ch: "收到物品",
        en: "Receive Item"
    },

    "Update Inventory": {
        ch: "更新库存",
        en: "Update Inventory"
    },

    "Item Output": {
        ch: "项目输出",
        en: "Item Output"
    },

    "Employees": {
        ch: "雇员",
        en: "Employees"
    },

    "Employee List": {
        ch: "员工名单",
        en: "Employee List"
    },

    "Employee Registration": {
        ch: "员工注册",
        en: "Employee Registration"
    },

    "Products": {
        ch: "制品",
        en: "Products"
    },

    "Product List": {
        ch: "产品列表",
        en: "Product List"
    },

    "Product Registration": {
        ch: "产品注册",
        en: "Product Registration"
    },

    "Settings": {
        ch: "组态",
        en: "Settings"
    },

    "General Settings": {
        ch: "常规设置",
        en: "General Settings"
    },

    "Dropdown Settings": {
        ch: "下拉设置",
        en: "Dropdown Settings"
    },

    "Reports": {
        ch: "报告",
        en: "Reports"
    },

    "Sales Report": {
        ch: "销售报告",
        en: "Sales Report"
    },



    "Total registered customers" : {
        ch: "注册客户总数",
        en: "Total registered customers"
    },

    "Total employees" : {
        ch: "员工总数",
        en: "Total employees"
    },

    "Total registered products" : {
        ch: "总注册产品",
        en: "Total registered products"
    },

    "Monthly Sales per Registered Customers" : {
        ch: "每位注册客户的月销售额",
        en: "Monthly Sales per Registered Customers"
    },

    "Week of": {
        ch: "周",
        en: "Week of"
    },


    "Code": {
        ch: "码",
        en: "Code"
    },
    "Name": {
        ch: "名称",
        en: "Name"
    },
    "Points": {
        ch: "奖励分数",
        en: "Points"
    },
    "Sales": {
        ch: "销售",
        en: "Sales"
    },

    "Monday": {
        ch: "星期一",
        en: "Monday"
    },
    "Tuesday": {
        ch: "星期二",
        en: "Tuesday"
    },
    "Wednesday": {
        ch: "星期三",
        en: "Wednesday"
    },
    "Thursday": {
        ch: "星期四",
        en: "Thursday"
    },
    "Friday": {
        ch: "星期五",
        en: "Friday"
    },
    "Saturday": {
        ch: "星期六",
        en: "Saturday"
    },
    "Sunday": {
        ch: "星期日",
        en: "Sunday"
    }

};

$( function() {
    getLanguage(dict);
});
$( function() {
	getSales();
	OwnerStatistics();
	DailySalesFromRegisteredCustomer();
	DailysoldProducts();
	SalesFromRegisteredCustomer();
	soldProducts();

	$('#btn_month_report').on('click', function() {
		window.location.href = '../../dashboard/month-sales-report?_token='+token;
	});
});

async function getSales() {
	await $.ajax({
		url: '../../dashboard/get-sales',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		//console.log(data.labels);
		if ($('#ct-LineChart1').length > 0) {
			new Chartist.Line('#ct-LineChart1 .ct-chart', {
				labels: data.labels,
				series: [
					data.series
				]
			}, {
					low: 0,
					showArea: true,
					width: '100%',
					height: '300px',
					fullWidth: true,
					chartPadding: {
					bottom: 10,
					right: 20,
					left: 0,
					top: 20
				}
			});

			$('#monthly_sale').html(data.monthly_sale);
			$('#start_date').html(data.start_date);
			$('#end_date').html(data.end_date);
		}
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Sales Chart: '+errorThrown,textStatus);
	});
	
}

async function OwnerStatistics() {
	await $.ajax({
		url: '../../dashboard/owner-total-statistic',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		$('#total_customers').html(data.total_customers);
		$('#total_customers').attr('data-count',data.total_customers);

		$('#total_employees').html(data.total_employees);
		$('#total_employees').attr('data-count',data.total_employees);

		$('#total_products').html(data.total_products);
		$('#total_products').attr('data-count',data.total_products);

	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Owner Statistics: '+errorThrown,textStatus);
	});
}

async function DailySalesFromRegisteredCustomer() {
	await $.ajax({
		url: '../../dashboard/daily-sales-registered',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		DailySalesFromRegisteredCustomerTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Sales from customers: '+errorThrown,textStatus);
	});
}

function DailySalesFromRegisteredCustomerTable(arr) {
	$('#tbl_daily_registered').dataTable().fnClearTable();
    $('#tbl_daily_registered').dataTable().fnDestroy();
    $('#tbl_daily_registered').dataTable({
        data: arr,
        // bLengthChange : false,
        ordering: false,
        searching: false,
        columns: [
        	{ data: function(x) {
            	return '<img src="'+x.photo+'" class="w-35 rounded-circle" alt="'+x.firstname+' '+x.lastname+'">';
            }, searchable: false, orderable: false},
            { data:'code', searchable: false, orderable: false},
            { data: function(x) {
                return x.firstname+' '+x.lastname;
            }, searchable: false, orderable: false},
            { data:'points', searchable: false, orderable: false},
            { data: 'total_sale', searchable: false, orderable: false}
        ]
    });
}

async function DailysoldProducts() {
	await $.ajax({
		url: '../../dashboard/daily-sold-products',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		DailysoldProductsTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Sales from customers: '+errorThrown,textStatus);
	});
}

function DailysoldProductsTable(arr) {
	$('#tbl_daily_sold').dataTable().fnClearTable();
    $('#tbl_daily_sold').dataTable().fnDestroy();
    $('#tbl_daily_sold').dataTable({
        data: arr,
        // bLengthChange : false,
        ordering: false,
        searching: false,
        columns: [
            { data:'prod_code', searchable: false, orderable: false},
            { data: 'prod_name', searchable: false, orderable: false},
            { data:'quantity', searchable: false, orderable: false},
            { data: 'amount', searchable: false, orderable: false}
        ]
    });
}

async function SalesFromRegisteredCustomer() {
	await $.ajax({
		url: '../../dashboard/sales-registered',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		SalesFromRegisteredCustomerTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Sales from customers: '+errorThrown,textStatus);
	});
}

function SalesFromRegisteredCustomerTable(arr) {
	$('#tbl_registered').dataTable().fnClearTable();
    $('#tbl_registered').dataTable().fnDestroy();
    $('#tbl_registered').dataTable({
        data: arr,
        // bLengthChange : false,
        ordering: false,
        searching: false,
        columns: [
        	{ data: function(x) {
            	return '<img src="'+x.photo+'" class="w-35 rounded-circle" alt="'+x.firstname+' '+x.lastname+'">';
            }, searchable: false, orderable: false},
            { data:'code', searchable: false, orderable: false},
            { data: function(x) {
                return x.firstname+' '+x.lastname;
            }, searchable: false, orderable: false},
            { data:'points', searchable: false, orderable: false},
            { data: 'total_sale', searchable: false, orderable: false}
        ]
    });
}

async function soldProducts() {
	await $.ajax({
		url: '../../dashboard/sold-products',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		soldProductsTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Sales from customers: '+errorThrown,textStatus);
	});
}

function soldProductsTable(arr) {
	$('#tbl_sold').dataTable().fnClearTable();
    $('#tbl_sold').dataTable().fnDestroy();
    $('#tbl_sold').dataTable({
        data: arr,
        // bLengthChange : false,
        ordering: false,
        searching: false,
        columns: [
            { data:'prod_code', searchable: false, orderable: false},
            { data: 'prod_name', searchable: false, orderable: false},
            { data:'quantity', searchable: false, orderable: false},
            { data: 'amount', searchable: false, orderable: false}
        ]
    });
}