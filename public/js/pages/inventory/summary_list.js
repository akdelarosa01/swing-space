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





    "Item Type": {
    	ch: "物品种类",
        en: "Item Type"
    },
    "Search": {
    	ch: "搜索",
        en: "Search"
    },
    "Item Code": {
    	ch: "项目代码",
        en: "Item Code"
    },
    "Item Name": {
    	ch: "项目名称",
        en: "Item Name"
    },
    "Quantity": {
    	ch: "数量",
        en: "Quantity"
    },
    "UoM": {
    	ch: "测量单位",
        en: "UoM"
    },
    "Transaction": {
        ch: "交易",
        en: "Transaction"
    },
    "Transaction Date": {
        ch: "交易日期",
        en: "Transaction Date"
    },
    "Transacted By": {
        ch: "交易者",
        en: "Transacted By"
    }

};

$( function() {
	getLanguage(dict);
});
var items = [];

$( function() {
    get_dropdown_options(2,'#item_type');
    inventoryTable(items);

    $('#btn_search_type').on('click', function() {
        if ($('#item_type').val() == '') {
            msg('please select an item type.','failed');
        } else {
            searchItems($('#item_type').val());
        }
    });
});

function searchItems(item_type) {
    $('.loading').show();
    $.ajax({
        url: '../../summary-list/search-items',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            item_type: item_type
        },
    }).done(function(data, textStatus, xhr) {
        items = data;
        inventoryTable(items);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Inventories: '+errorThrown,textStatus);
    }).always(function() {
        $('.loading').hide();
    });
    
}

function inventoryTable(arr) {
    $('#tbl_items').dataTable().fnClearTable();
    $('#tbl_items').dataTable().fnDestroy();
    $('#tbl_items').dataTable({
        data: arr,
        ordering: false,
        columns: [
            { data: 'transaction_type'},
            { data: 'item_code'},
            { data: 'item_name'},
            { data: 'item_type'},
            { data: 'quantity'},
            { data: 'uom' },
            { data: 'trans_date'},
            { data: 'create_user'}
        ]
    });
}