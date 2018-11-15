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





    "Manage Employee": {
    	ch: "管理员工",
        en: "Manage Employee"
    },
    "Edit": {
        ch: "编",
        en: "Edit"
    },
    "Remove": {
        ch: "清除",
        en: "Remove"
    }

};
$( function() {
	getEmployees();
});

function getEmployees() {
	$('.loading').show();
	$.ajax({
		url: '../../employee-show-list',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		EmployeeList(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Employee List: '+errorThrown,textStatus);
	}).always(function() {
		$('.loading').hide();
	});

	$('#employee_list').on('click', '.delete-employee', function() {
		confirm('Remove Employee','Do you want to remove this employee?',$(this).attr('data-id'));
	});

	$('#btn_confirm').on('click', function() {
		$('.loading').show();
		$.ajax({
			url: '../../employee/delete',
			type: 'POST',
			dataType: 'JSON',
			data: {
				_token: token,
				id: $('#confirm_id').val()
			},
		}).done(function(data, textStatus, xhr) {
			if (textStatus == 'success') {
				$('#confirm_modal').modal('hide');
				msg(data.msg,data.status);
				EmployeeList(data.employee);
			}
			
		}).fail(function(xhr, textStatus, errorThrown) {
			msg('Remove Employee: '+errorThrown,textStatus);
		}).always(function() {
			$('.loading').hide();
		});
	});
}

function EmployeeList(data) {
	let list = '';
	$('#employee_list').html(list);
	$.each(data, function(i, x) {
		list = '<div class="col-md-6 col-lg-4 col-xxl-3">'+
					'<div class="card contact-item">'+
						'<div class="card-header border-none">'+
							'<ul class="actions top-right">'+
								'<li class="dropdown">'+
									'<a href="javascript:void(0)" class="btn btn-sm btn-info" data-toggle="dropdown" aria-expanded="false">'+
										'<i class="fa fa-cog"></i>'+
									'</a>'+
									'<div class="dropdown-menu dropdown-menu-right">'+
										'<div class="dropdown-header">'+
											'<span class="trn">Manage Employee</span>'+
										'</div>'+
										'<a href="../../employee/'+x.id+'/edit" class="dropdown-item">'+
											'<i class="icon dripicons-pencil"></i> <span class="trn">Edit</span>'+
										'</a>'+
										'<a href="javascript:void(0)" class="dropdown-item delete-employee" data-id="'+x.id+'">'+
											'<i class="icon dripicons-trash"></i> <span class="trn">Remove</span>'+
										'</a>'+
									'</div>'+
								'</li>'+
							'</ul>'+
						'</div>'+
						'<div class="card-body">'+
							'<div class="row">'+
								'<div class="col-md-12 text-center">'+
									'<img src="../../'+x.photo+'" alt="user" class="rounded-circle max-w-100 m-t-20">'+
								'</div>'+
								'<div class="col-md-12 text-center">'+
									'<h5 class="card-title">'+x.firstname+' '+x.lastname+'</h5>'+
									'<small class="text-muted d-block">'+x.position+'</small>'+
									'<small class="text-muted d-block">'+x.employee_id+'</small>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>';
		$('#employee_list').append(list);
	});

	getLanguage(dict);
}