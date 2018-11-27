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





    "Add New Incentive": {
    	ch: "添加新目标",
        en: "Add New Incentive"
    },
    "Add New Reward": {
        ch: "添加新奖励",
        en: "Add New Reward"
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
    "Hours": {
        ch: "小时",
        en: "Hours"
    },
    "Days": {
        ch: "天",
        en: "Days"
    },
    "Space": {
        ch: "空间",
        en: "Space"
    },
    "Description": {
        ch: "描述",
        en: "Description"
    },
    "Employee discount": {
        ch: "员工折扣",
        en: "Employee discount"
    },
    "Senior discount": {
        ch: "老年人折扣",
        en: "Senior discount"
    },
    "Set": {
        ch: "定",
        en: "Set"
    },
    "Cancel": {
        ch: "取消",
        en: "Cancel"
    }

};

$( function() {
    getLanguage(dict);
});
$( function() {
	getSales();
	OwnerStatistics();
	SalesFromRegisteredCustomer();
});

function getSales() {
	$.ajax({
		url: '../../dashboard/get-sales',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
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

			$('#weekly_sale').html(data.weekly_sale);
			$('#start_date').html(data.start_date);
			$('#end_date').html(data.end_date);
		}
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Sales Chart: '+errorThrown,textStatus);
	});
	
}

function OwnerStatistics() {
	$.ajax({
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

function SalesFromRegisteredCustomer() {
	$.ajax({
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
        // ordering: false,
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