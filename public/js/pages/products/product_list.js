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
    "Product Name": {
        ch: "产品名称",
        en: "Product Name"
    },
    "Description": {
        ch: "描述",
        en: "Description"
    },
    "Product Type": {
        ch: "产品类别",
        en: "Product Type"
    },
    "Price": {
        ch: "价钱",
        en: "Price"
    },
    "Variants": {
        ch: "变种",
        en: "Variants"
    },
    "Target Qty.": {
        ch: "目标数量",
        en: "Target Qty."
    },
    "Update Date": {
        ch: "更新日期",
        en: "Update Date"
    },
    "Avail. Qty.": {
        ch: "可用数量",
        en: "Avail. Qty."
    },
    "Export Files": {
        ch: "导出文件",
        en: "Export Files"
    },

    "File Type": {
        ch: "文件类型",
        en: "File Type"
    },
    "Export": {
        ch: "输出",
        en: "Export"
    },
    "Cancel": {
        ch: "撤消",
        en: "Cancel"
    }

};

$( function() {
    getLanguage(dict);
});
var products = [];

$( function() {
    check_permission('PRD_LST');
    get_dropdown_options(3,'#prod_type_export');
	getProducts();

    $('#btn_export').on('click', function() {
        $('#export_modal').modal('show');
    });

    $('#btn_export_files').on('click', function() {
        var ExportFileURL = '../../product-files?_token='+token+
            '&&prod_type_export='+$('#prod_type_export').val()+
            '&&file_type='+$('#file_type').val();

        if ($('#file_type').val() == 'PDF') {
            window.open(ExportFileURL,'_tab');
        } else {
            window.location.href = ExportFileURL;
        }
        
    });
});

function getProducts() {
    $('.loading').show();
    $.ajax({
        url: '../../product-list/show',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token
        },
    }).done(function(data, textStatus, xhr) {
        products = data;
        makeProductsDataTable(products);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Products : '+errorThrown,textStatus);
    }).always(function() {
        $('.loading').hide();
    }); 
}

function makeProductsDataTable(arr) {
    $('#tbl_products').dataTable().fnClearTable();
    $('#tbl_products').dataTable().fnDestroy();
    $('#tbl_products').dataTable({
        data: arr,
        columns: [
            { data: 'prod_code' },
            { data: 'prod_name' },
            { data: 'description' },
            { data: 'prod_type' },
            { data: 'price' },
            { data: 'variants' },
            { data: 'quantity' },
            { data: 'updated_at' },
        ]
    });
}