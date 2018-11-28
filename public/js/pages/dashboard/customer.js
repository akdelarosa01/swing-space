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




    "Code": {
        ch: "码",
        en: "Code"
    },
    "First Name": {
        ch: "名字",
        en: "First Name"
    },
    "Last Name": {
        ch: "姓",
        en: "Last Name"
    },
    "Product": {
        ch: "制品",
        en: "Product"
    },
    "Qty/Hrs": {
        ch: "数量 / 小时",
        en: "Qty/Hrs"
    },
    "Price": {
        ch: "价钱",
        en: "Price"
    },
    "My Bill for Today": {
        ch: "我的今日法案",
        en: "My Bill for Today"
    },
    "Available Refund Points": {
        ch: "可用退款积分",
        en: "Available Refund Points"
    },
    "Referred Customers": {
        ch: "推荐的客户",
        en: "Referred Customers"
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
	referredCustomers();
	qr_code();
});

function qr_code() {
	$.ajax({
		url: '../../profile/qr_code',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		$('#qr_code').attr('src','/qr_codes/'+data.customer_code+'.png');
		$('#qr_code').attr('alt',data.customer_code);
		$('#cust_code').html(data.customer_code);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Referred Customers: '+ errorThrown,textStatus);
	});
}

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

function referredCustomers() {
	$.ajax({
		url: '../../dashboard/referred-customers',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		referredCustomersTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Referred Customers: '+ errorThrown,textStatus);
	});
}

function referredCustomersTable(arr) {
	$('#tbl_referred').dataTable().fnClearTable();
    $('#tbl_referred').dataTable().fnDestroy();
    $('#tbl_referred').dataTable({
        data: arr,
        bLengthChange : false,
        ordering: false,
        searching: false,
        paging: false,
        info: false,
        columns: [
        	{ data: function(x) {
            	return '<img src="'+x.photo+'" class="w-35 rounded-circle" alt="'+x.firstname+' '+x.lastname+'">';
            }, searchable: false, orderable: false},
            { data:'code', searchable: false, orderable: false},
            { data: 'firstname', searchable: false, orderable: false},
            { data: 'lastname', searchable: false, orderable: false}
        ]
    });
}