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





    "Dropdown Name": {
    	ch: "下拉名称",
        en: "Dropdown Name"
    },
    "Dropdowns": {
        ch: "下拉菜单",
        en: "Dropdowns"
    },
    "Dropdown Option": {
        ch: "下拉选项",
        en: "Dropdown Option"
    },
    "Option": {
        ch: "选项",
        en: "Option"
    },
    "Save": {
        ch: "储集",
        en: "Save"
    }

};

$( function() {
    getLanguage(dict);
});
let options = [];

$( function() {
	getName('');
	getOption(0);

	checkAllCheckboxesInTable('.check_all_name','.check_item_name');
	checkAllCheckboxesInTable('.check_all_options','.check_option');

	$('#frm_name').on('submit', function(e) {
		e.preventDefault();
		$('.loading').show();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize(),
		}).done(function(data, textStatus, xhr) {
			if (textStatus == 'success') {
				msg(data.msg,data.status);
				clear();
				DropdownNameDataTable(data.name);
			}
		}).fail(function(xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;
			showErrors(errors);
		}).always(function() {
			$('.loading').hide();
		});
	});

	$('#tbl_name_body').on('click', '.btn_add_option', function() {
		$('#dropdown_name').html($(this).attr('data-description'));
		$('#dropdown_id').val($(this).attr('data-id'));
		$('#option_description').prop('readonly', false);
		getOption($(this).attr('data-id'));
	});

	$('#tbl_name_body').on('click', '.btn_edit_name', function() {
		$('#id').val($(this).attr('data-id'));
		$('#description').val($(this).attr('data-description'));
	});

	$('#frm_options').on('submit', function(e) {
		e.preventDefault();
		$('.loading').show();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize(),
		}).done(function(data, textStatus, xhr) {
			if (textStatus == 'success') {
				msg(data.msg,data.status);
				clear();
				DropdownOptionDataTable(data.option);
			}
		}).fail(function(xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;
			showErrors(errors);
		}).always(function() {
			$('.loading').hide();
		});
	});

	$('#tbl_option_body').on('click', '.btn_edit_option', function() {
		$('#dropdown_id').val($(this).attr('data-dropdown_id'));
		$('#option_id').val($(this).attr('data-id'));
		$('#option_description').val($(this).attr('data-option_description'));
	});

	$('#btn_delete').on('click', function() {
        var chkArray = [];
        $(".check_option:checked").each(function() {
            chkArray.push($(this).val());
        });

        if (chkArray.length > 0) {
            confirm('Delete Option','Do you want to delete this Option/s?',chkArray);
        } else {
            msg("Please select at least 1 item.",'failed');
        }

        $('.check_all_options').prop('checked',false);
    });

    $('#btn_confirm').on('click', function() {
    	$('#loading').show();
        $.ajax({
            url: '../../dropdown/delete-option',
            type: 'POST',
            dataType: 'JSON',
            data: {
                _token: token,
                id: $('#confirm_id').val(),
                dropdown_id: $('#dropdown_id').val()
            },
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                $('#confirm_modal').modal('hide');
                msg(data.msg,data.status);
                DropdownOptionDataTable(data.option);
            }
            
        }).fail(function(xhr, textStatus, errorThrown) {
            msg('Dropdown Option: '+errorThrown,textStatus);
        }).always(function() {
            $('#loading').hide();
        });
    });
});

function clear() {
	$('.clear').val('');
}

function getName(data) {
	if (data.length > 0) {
		DropdownNameDataTable(data);
	} else {
		$.ajax({
			url: '../../dropdown/show-name',
			type: 'GET',
			dataType: 'JSON',
			data: {_token: token},
		}).done(function(data, textStatus, xhr) {
			DropdownNameDataTable(data);
		}).fail(function(xhr, textStatus, errorThrown) {
			console.log("error");
		}).always(function() {
			$('.loading').hide();
		});
	}
}

function getOption(id) {
	$.ajax({
		url: '../../dropdown/show-option',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token,
			dropdown_id: id
		},
	}).done(function(data, textStatus, xhr) {
		options = data;
		DropdownOptionDataTable(options);
	}).fail(function(xhr, textStatus, errorThrown) {
		console.log("error");
	}).always(function() {
		$('.loading').hide();
	});
}

function DropdownNameDataTable(arr) {

	$('#tbl_name').dataTable().fnClearTable();
    $('#tbl_name').dataTable().fnDestroy();
    $('#tbl_name').dataTable({
        data: arr,
        sorting: false,
        searching: false,
        paging: false,
	    deferRender: true,
        columns: [
        	// {data: function(x) {
        	// 	return '<input type="checkbox" class="check_item_name">';
        	// }},
            {data:'description', searchable: false, orderable: false},
            {data: function(x) {
            	let edit = '';
            	if (user_type == 'Administrator') {
            		edit = '<button class="btn btn-sm btn-info btn_edit_name" data-id="'+x.id+'" '+
            				' data-description="'+x.description+'">'+
            					'<i class="fa fa-edit"></i>'+
            				'</button>';
            	}

            	return '<div class="btn-group">'+
            				'<button class="btn btn-sm btn-success btn_add_option" data-id="'+x.id+'" '+
            				' data-description="'+x.description+'">'+
            					'<i class="fa fa-plus"></i>'+
            				'</button>'+edit+
            			'</div>';
            }, searchable: false, orderable: false},
        ]
    });
}

function DropdownOptionDataTable(arr) {
	$('#tbl_option').dataTable().fnClearTable();
    $('#tbl_option').dataTable().fnDestroy();
    $('#tbl_option').dataTable({
        data: arr,
        sorting: false,
        searching: false,
        paging: false,
	    deferRender: true,
        columns: [
        	{data: function(x) {
            	return '<input type="checkbox" class="check_option" value="'+x.id+'">';
            }, searchable: false, orderable: false},
            {data: function(x) {
            	return x.option_description+'<input type="hidden" name="option_description[]" value="'+x.option_description+'">';
            }},
            {data: function(x) {
            	return '<div class="btn-group">'+
            				'<button class="btn btn-sm btn-info btn_edit_option" data-id="'+x.id+'" '+
            				' data-dropdown_id="'+x.dropdown_id+'" '+
            				' data-option_description="'+x.option_description+'">'+
            					'<i class="fa fa-edit"></i>'+
            				'</button>'+
            			'</div>';
            }, searchable: false, orderable: false},
        ]
    });
}