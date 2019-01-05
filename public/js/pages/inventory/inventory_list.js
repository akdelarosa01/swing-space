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
    "Minimum Stock": {
    	ch: "最低库存",
        en: "Minimum Stock"
    },
    "UoM": {
    	ch: "测量单位",
        en: "UoM"
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
var items = [];

$( function() {
    check_permission('INV_LST');
    checkAllCheckboxesInTable('.check_all_items','.check_item');
    get_dropdown_options(2,'#item_type');
    get_dropdown_options(2,'#item_type_export');
	inventoryTable(items);

    $('#btn_search_type').on('click', function() {
        if ($('#item_type').val() == '') {
            msg('please select an item type.','failed');
        } else {
            searchItems($('#item_type').val());
        }
    });

    $('#btn_export').on('click', function() {
        $('#export_modal').modal('show');
    });

    $('#btn_export_files').on('click', function() {
        var ExportFileURL = '../../inventory-files?_token='+token+
            '&&item_type_export='+$('#item_type_export').val()+
            '&&file_type='+$('#file_type').val();

        if ($('#file_type').val() == 'PDF') {
            window.open(ExportFileURL,'_tab');
        } else {
            window.location.href = ExportFileURL;
        }
        
    });

    $('#btn_delete').on('click', function() {
        var chkArray = [];
        $(".check_item:checked").each(function() {
            chkArray.push($(this).val());
        });

        if (chkArray.length > 0) {
            confirm('Delete Item','Do you want to delete this item/s?',chkArray);
        } else {
            msg("Please select at least 1 item.",'failed');
        }

        $('.check_all_items').prop('checked',false);
    });

    $('#btn_confirm').on('click', function() {
        $('#confirm_modal').modal('hide');
        $('.loading').show();
        $.ajax({
            url: '../../inventory-list/delete',
            type: 'POST',
            dataType: 'JSON',
            data: {
                _token: token,
                id: $('#confirm_id').val()
            },
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg,data.status);
                inventoryTable(data.items);
            }
            
        }).fail(function(xhr, textStatus, errorThrown) {
            msg('Inventories: '+errorThrown,textStatus);
        }).always(function() {
            $('.loading').hide();
        });
    });
});

function searchItems(item_type) {
    $('.loading').show();
    $.ajax({
        url: '../../inventory-list/search-items',
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
        columns: [
            { data: function(x) {
                return '<input type="checkbox" class="check_item" value="'+x.id+'">';
            }, searchable: false, orderable: false },
            { data: 'item_code' },
            { data: 'item_name' },
            { data: 'item_type' },
            { data: 'quantity' },
            { data: 'minimum_stock' },
            { data: 'uom' }
        ],
        createdRow: function (row, data, dataIndex) {
            if (data.quantity <= data.minimum_stock) {
                $(row).css('background-color', '#ff6266');
                $(row).css('color', '#fff');
            }
        }
    });
}