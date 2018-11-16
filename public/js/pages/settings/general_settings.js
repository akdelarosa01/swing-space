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
	get_dropdown_options(6,'#inc_space');
    get_dropdown_options(6,'#rwd_space');

    incentives();
    rewards();

	$('#btn_add_itcentive').on('click', function() {
		$('#incentive_modal').modal('show');
	});

	$('#btn_add_reward').on('click', function() {
		$('#rewards_modal').modal('show');
	});

	$('#frm_incentive').on('submit', function(e) {
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
                incentives();
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON.errors;

            if (errors == undefined) {
                msg('Incentive Settings: '+errorThrown,textStatus);
            } else {
                showErrors(errors);
            }
        }).always( function() {
            $('.loading').hide();
            clear();
        });
    });

    $('#frm_reward').on('submit', function(e) {
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
                rewards();
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON.errors;

            if (errors == undefined) {
                msg('Reward Settings: '+errorThrown,textStatus);
            } else {
                showErrors(errors);
            }
        }).always( function() {
            $('.loading').hide();
            clear();
        });
    });

    $('#tbl_incentive').on('click', '.edit_incentive', function() {
    	$('#inc_id').val($(this).attr('data-inc_id'));
    	$('#inc_code').val($(this).attr('data-inc_code'));
    	$('#inc_name').val($(this).attr('data-inc_name'));
    	$('#inc_points').val($(this).attr('data-inc_points'));
    	$('#inc_hrs').val($(this).attr('data-inc_hrs'));
    	$('#inc_days').val($(this).attr('data-inc_days'));
    	$('#inc_space').val($(this).attr('data-inc_space'));
    	$('#inc_description').val($(this).attr('data-inc_description'));
    	$('#inc_token').val(token);

    	$('#incentive_modal').modal('show');
    });

    $('#tbl_reward').on('click', '.edit_reward', function() {
    	$('#rwd_id').val($(this).attr('data-rwd_id'));
    	$('#rwd_code').val($(this).attr('data-rwd_code'));
    	$('#rwd_name').val($(this).attr('data-rwd_name'));
    	$('#rwd_points').val($(this).attr('data-rwd_points'));
    	$('#rwd_hrs').val($(this).attr('data-rwd_hrs'));
    	$('#rwd_days').val($(this).attr('data-rwd_days'));
    	$('#rwd_space').val($(this).attr('data-rwd_space'));
    	$('#rwd_description').val($(this).attr('data-rwd_description'));
    	$('#rwd_token').val(token);

    	$('#rewards_modal').modal('show');
    });
});

function clear() {
	$('.clear').val('');
}

function incentives() {
    $.ajax({
        url: '../../general-settings/incentives',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
        },
    }).done(function(data, textStatus, xhr) {
        makeIncentiveDataTable(data);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Incentive Settings: '+errorThrown,textStatus);
    });
}

function makeIncentiveDataTable(arr) {
    $('#tbl_incentive').dataTable().fnClearTable();
    $('#tbl_incentive').dataTable().fnDestroy();
    $('#tbl_incentive').dataTable({
        data: arr,
        searching: false,
        ordering: false,
        columns: [
        	{data: 'inc_code' },
            {data: 'inc_name' },
            {data: 'inc_points' },
            {data: 'inc_hrs' },
            {data: 'inc_days' },
            {data: 'inc_space' },
            {data: 'inc_description' },
            {data: function(x) {
                return '<button class="btn btn-sm btn-info edit_incentive" data-inc_id="'+x.id+'" '+
	                        ' data-inc_code="'+x.inc_code+'" '+
	                        ' data-inc_name="'+x.inc_name+'" '+
	                        ' data-inc_points="'+x.inc_points+'" '+
	                        ' data-inc_hrs="'+x.inc_hrs+'" '+
	                        ' data-inc_days="'+x.inc_days+'" '+
	                        ' data-inc_space="'+x.inc_space+'" '+
	                        ' data-inc_description="'+x.inc_description+'">'+
                            '<i class="fa fa-edit"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
}

function rewards() {
    $.ajax({
        url: '../../general-settings/rewards',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
        },
    }).done(function(data, textStatus, xhr) {
        makeRewardDataTable(data);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Reward Settings: '+errorThrown,textStatus);
    });
}

function makeRewardDataTable(arr) {
    $('#tbl_reward').dataTable().fnClearTable();
    $('#tbl_reward').dataTable().fnDestroy();
    $('#tbl_reward').dataTable({
        data: arr,
        searching: false,
        ordering: false,
        columns: [
        	{data: 'rwd_code' },
            {data: 'rwd_name' },
            {data: 'rwd_points' },
            {data: 'rwd_hrs' },
            {data: 'rwd_days' },
            {data: 'rwd_space' },
            {data: 'rwd_description' },
            {data: function(x) {
                return '<button class="btn btn-sm btn-info edit_reward" data-rwd_id="'+x.id+'" '+
	                        ' data-rwd_code="'+x.rwd_code+'" '+
	                        ' data-rwd_name="'+x.rwd_name+'" '+
	                        ' data-rwd_points="'+x.rwd_points+'" '+
	                        ' data-rwd_hrs="'+x.rwd_hrs+'" '+
	                        ' data-rwd_days="'+x.rwd_days+'" '+
	                        ' data-rwd_space="'+x.rwd_space+'" '+
	                        ' data-rwd_description="'+x.rwd_description+'">'+
                            '<i class="fa fa-edit"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
}