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



    "Customers Today": {
        ch: "今天的客户",
        en: "Customers Today"
    },
    "Total Registered Customer": {
        ch: "注册客户总数",
        en: "Total Registered Customer"
    },
    "Total sold products today": {
        ch: "今天销售的产品总数",
        en: "Total sold products today"
    },
    "Total earnings today": {
        ch: "今天的总收入",
        en: "Total earnings today"
    },

    "Code": {
        ch: "码",
        en: "Code"
    },
    "Name": {
        ch: "名称",
        en: "Name"
    },
    "Avail. Points": {
        ch: "可用积分",
        en: "Avail. Points"
    },
    "Total Bill": {
        ch: "总账单",
        en: "Total Bill"
    },



    "Add New Incentive": {
    	ch: "添加新目标",
        en: "Add New Incentive"
    },
    "Add New Reward": {
        ch: "添加新奖励",
        en: "Add New Reward"
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
	customersToday();
    employeeStatistic();
});

function customersToday() {
	$.ajax({
		url: '../../dashboard/customers-today',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
        console.log(data);
		customersTodayTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Customers Today: '+ errorThrown,textStatus);
	});
}

function customersTodayTable(arr) {
	$('#tbl_customers').dataTable().fnClearTable();
    $('#tbl_customers').dataTable().fnDestroy();
    $('#tbl_customers').dataTable({
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
            { data: function(x) {
                return '₱ '+ (x.total_bill).toFixed(2);
            }, searchable: false, orderable: false}
        ]
    });
    
}

function employeeStatistic() {
    $.ajax({
        url: '../../dashboard/employee-total-statistic',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token
        },
    }).done(function(data, textStatus, xhr) {
        $('#total_customers').attr('data-count',(data.total_customers == null)? 0 : data.total_customers);
        $('#total_customers').html((data.total_customers == null)? 0 : data.total_customers);

        $('#total_sold_product').attr('data-count',(data.total_sold_product == null)? 0 : data.total_sold_product);
        $('#total_sold_product').html((data.total_sold_product == null)? 0 : data.total_sold_product);

        $('#total_earnings').attr('data-count',(data.total_earnings == null)? 0 : data.total_earnings);
        $('#total_earnings').html((data.total_earnings == null)? 0 : data.total_earnings);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Employee Statistics: '+ errorThrown,textStatus);
    });
}