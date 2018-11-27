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
	CustomerStatictic();
	getCustomerBill();
});

function getCustomerBill() {
	$.ajax({
		url: '../../dashboard/customer-bill',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
        console.log(data);
		getCustomerBillTable(data);

		var total_amount = 0;
		$.each(data, function(i, x) {
			total_amount += x.price;
		});

		$('#total_bill').html('₱'+(total_amount).toFixed(2));
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Customers Bill: '+ errorThrown,textStatus);
	});
}

function getCustomerBillTable(arr) {
	$('#tbl_bill').dataTable().fnClearTable();
    $('#tbl_bill').dataTable().fnDestroy();
    $('#tbl_bill').dataTable({
        data: arr,
        bLengthChange : false,
        ordering: false,
        searching: false,
        paging: false,
        info: false,
        columns: [
            { data:'prod_name', searchable: false, orderable: false},
            { data: 'quantity', searchable: false, orderable: false},
            { data: function(x) {
            	return (x.price).toFixed(2);
            }, searchable: false, orderable: false}
        ]
    });
}

function CustomerStatictic() {
	$.ajax({
		url: '../../dashboard/customer-statistic',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		$('#cust_code').html(data.customer_code);
		$('#available_points').html(data.available_points);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Customers Bill: '+ errorThrown,textStatus);
	});
}