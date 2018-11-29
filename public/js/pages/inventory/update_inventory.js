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
    "Minimum Stock": {
        ch: "最低库存",
        en: "Minimum Stock"
    },
    "New Qty": {
        ch: "新数量",
        en: "New Qty"
    },
    "Save": {
        ch: "储集",
        en: "Save"
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
    get_dropdown_options(2,'#item_type');
	inventoryTable(items);

    $('#btn_search_type').on('click', function() {
        if ($('#item_type').val() == '') {
            msg('please select an item type.','failed');
        } else {
            searchItems($('#item_type').val());
        }
    });

    $('#frm_update').on('submit', function(e) {
        e.preventDefault();

        if (items.length > 0) {
            $('.loading').show();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: $(this).serialize(),
            }).done(function(data, textStatus, xhr) {
                if (textStatus == 'success') {
                    msg(data.msg,data.status)
                    searchItems(data.item_type);
                }
            }).fail(function(xhr, textStatus, errorThrown) {
                var errors = xhr.responseJSON.errors;

                if (errors == undefined) {
                    msg('Received Items: '+errorThrown,textStatus);
                } else {
                    showErrors(errors);
                }
            }).always( function() {
                $('.loading').hide();
            });
        } else {
            msg('Please search an item type first.','failed');
        }
    });
});

function searchItems(item_type) {
    $('.loading').show();
    $.ajax({
        url: '../../update-inventory/search-items',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            item_type: item_type
        },
    }).done(function(data, textStatus, xhr) {
        items = data;
        inventoryTable(data);
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
            { data: 'item_code' },
            { data: 'item_name' },
            { data: 'item_type' },
            { data: 'quantity' },
            { data: 'minimum_stock' },
            { data: 'uom' },
            { data: function(x) {
                return '<input type="number" class="form-control form-control-sm" name="new_qty[]" maxlength="3" min="1" required>'+
                        '<input type="hidden" name="id[]" value="'+x.id+'">'+
                        '<input type="hidden" name="item_code[]" value="'+x.item_code+'">'+
                        '<input type="hidden" name="item_name[]" value="'+x.item_name+'">'+
                        '<input type="hidden" name="item_type[]" value="'+x.item_type+'">'+
                        '<input type="hidden" name="quantity[]" value="'+x.quantity+'">'+
                        '<input type="hidden" name="minimum_stock[]" value="'+x.minimum_stock+'">'+
                        '<input type="hidden" name="uom[]" value="'+x.uom+'">';
            }}
        ],
        createdRow: function (row, data, dataIndex) {
            if (data.quantity <= data.minimum_stock) {
                $(row).css('background-color', '#ff6266');
                $(row).css('color', '#fff');
            }
        }
    });
}