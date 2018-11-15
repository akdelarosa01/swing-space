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
    "Avail. Qty.": {
        ch: "可用数量",
        en: "Avail. Qty."
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
let items = [];
let selected_items = [];

$( function() {
    makeItemsDataTable(items);
    makeSelectedItemsDataTable(selected_items);

    get_dropdown_options(2,'#item_type_srch');
    get_dropdown_options(2,'#item_type');
    get_dropdown_options(4,'#uom');
    $('#btn_add_items').on('click', function() {
        $('#receive_items_modal').modal('show');
    });

    $('#frm_items').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg,data.status)
                clear();
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
            clear();
        });
    });

    $('#btn_search_type').on('click', function() {
        if ($('#item_type_srch').val() !== '') {
            searchItems($('#item_type_srch').val());
        } else {
            msg('please select an item type.','failed');
        }
    });

    $('#tbl_items_body').on('click', '.add_item', function() {
        let index = selected_items.length;

        selected_items.push({
            index: index,
            id: $(this).attr('data-id'),
            item_code: $(this).attr('data-item_code'),
            item_name: $(this).attr('data-item_name'),
            item_type: $(this).attr('data-item_type'),
            uom: $(this).attr('data-uom'),
            quantity: '',
        });

        makeSelectedItemsDataTable(selected_items);
    });

    $('#tbl_selected_body').on('click', '.remove_item', function() {
        selected_items.splice($(this).attr('data-index'), 1);

        count = 0;
        $.each(selected_items, function(i, x) {
            x.index = 
            count++;
        });

        makeSelectedItemsDataTable(selected_items);
    });

    $('#frm_selected').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg,data.status)
                selected_items = []
                makeSelectedItemsDataTable(selected_items);
                searchItems(data.item_type);
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            msg('Received Items: '+errorThrown,textStatus);
        }).always( function() {
            $('.loading').hide();
        });
    });
})

function clear() {
    $('.clear').val('');
}

function searchItems(item_type) {
    $.ajax({
        url: '../../item-output/search-item',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            item_type_srch: item_type
        },
    }).done(function(data, textStatus, xhr) {
        items = data;
        makeItemsDataTable(items);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Search Items: '+errorThrown,textStatus);
    });
}

function makeItemsDataTable(arr) {
    $('#tbl_items').dataTable().fnClearTable();
    $('#tbl_items').dataTable().fnDestroy();
    $('#tbl_items').dataTable({
        data: arr,
        searching: false,
        ordering: false,
        columns: [
            {data: 'item_code'},
            {data: 'item_name'},
            {data: 'quantity'},
            {data: 'uom'},
            {data: function(x) {
                return '<button class="btn btn-sm btn-info add_item" data-id="'+x.id+'" '+
                        ' data-item_code="'+x.item_code+'" '+
                        ' data-item_name="'+x.item_name+'" '+
                        ' data-quantity="'+x.quantity+'" '+
                        ' data-item_type="'+x.item_type+'" '+
                        ' data-uom="'+x.uom+'">'+
                            '<i class="fa fa-plus"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
}

function makeSelectedItemsDataTable(arr) {
    $('#tbl_selected').dataTable().fnClearTable();
    $('#tbl_selected').dataTable().fnDestroy();
    $('#tbl_selected').dataTable({
        data: arr,
        bLengthChange : false,
        scrollY: "300px",
        searching: false,
        paging: false,
        sorting: false,
        columns: [
            {data: 'item_code'},
            {data: 'item_name'},
            {data: 'item_type'},
            {data: function(x) {
                return '<input type="hidden" name="id[]" value="'+x.id+'">'+
                        '<input type="hidden" name="selected_code[]" value="'+x.item_code+'">'+
                        '<input type="hidden" name="selected_name[]" value="'+x.item_name+'">'+
                        '<input type="hidden" name="selected_type[]" value="'+x.item_type+'">'+
                        '<input type="hidden" name="selected_uom[]" value="'+x.uom+'">'+
                        '<input type="text" class="form-control form-control-sm quantity" name="selected_quantity[]">';
            }, searchable: false, orderable: false},
            {data: function(x) {
                return '<button class="btn btn-sm btn-danger remove_item" data-index="'+x.index+'">'+
                            '<i class="fa fa-times"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });

    get_dropdown_options(4,'.uom');
}