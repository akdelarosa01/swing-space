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






    "Code": {
    	ch: "码",
        en: "Code"
    },
    "Name": {
        ch: "全名",
        en: "Name"
    },
    "Gender": {
        ch: "性别",
        en: "Gender"
    },
    "Date of Birth": {
        ch: "出生日期",
        en: "Date of Birth"
    },
    "Occupation": {
        ch: "占用",
        en: "Occupation"
    },
    "Company": {
        ch: "公司",
        en: "Company"
    },
    "School": {
        ch: "学校",
        en: "School"
    },
    "Referrer": {
        ch: "引用",
        en: "Referrer"
    },
    "Points": {
        ch: "点",
        en: "Points"
    },
    "Date Registered": {
        ch: "注册日期",
        en: "Date Registered"
    }

};
var customers = [];

$( function() {
	getCustomers();

    $('#tbl_customers_body').on('click', '.delete-customer', function() {
        confirm('Delete Customer','Do you want to delete this customer?',$(this).attr('data-id'));
    });

    $('#btn_confirm').on('click', function() {
        $('.loading').show();
        $.ajax({
            url: '../../customer-list/delete',
            type: 'POST',
            dataType: 'JSON',
            data: {
                _token: token,
                id: $('#confirm_id').val()
            },
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                $('#confirm_modal').modal('hide');
                msg(data.msg,data.status)
                customerTable(data.customers);
            }
            
        }).fail(function(xhr, textStatus, errorThrown) {
            msg('Delete Customer: '+errorThrown,textStatus);
        }).always(function() {
            $('.loading').hide();
        });
    });
});

function getCustomers() {
    customers = [];
    $.ajax({
        url: 'customer-list/show',
        type: 'GET',
        dataType: 'JSON',
        data: {_token: token},
    }).done(function(data, textStatus, xhr) {
        customers = data;
        customerTable(customers);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg(errorThrown,textStatus);
    }).always(function() {
        console.log("complete");
    });
}

function customerTable(arr) {
	$('#tbl_customers').dataTable().fnClearTable();
    $('#tbl_customers').dataTable().fnDestroy();
    $('#tbl_customers').dataTable({
        data: arr,
     //    bLengthChange : false,
     //    searching: false,
     //    ordering: false,
	    // paging: false,
	    // scrollY: "250px",
        columns: [
        	{data: function(x) {
            	return '<img src="'+x.photo+'" class="w-35 rounded-circle" alt="'+x.firstname+' '+x.lastname+'">';
            }, searchable: false, orderable: false},
            {data:'customer_code'},
            {data: function(x) {
                return x.firstname+' '+x.lastname;
            }},
            {data:'gender'},
            {data:'date_of_birth'},
            {data:'occupation'},
            {data:'company'},
            {data:'school'},
            {data:'referrer'},
            {data:'points'},
            {data:'date_registered'},
            {data: function(x) {
            	return '<div class="btn-group">'+
                            '<a href="/membership/'+x.id+'/edit" class="btn btn-sm btn-info">'+
                                '<i class="fa fa-edit"></i>'+
                            '</a>'+
                            '<button class="btn btn-sm btn-danger delete-customer" data-id="'+x.id+'">'+
                                '<i class="fa fa-trash"></i>'+
                            '</button>'+
                        '</div>';
            }, searchable: false, orderable: false},
        ]
    });

    getLanguage(dict);
}