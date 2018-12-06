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





    "Add New Goal": {
    	ch: "添加新目标",
        en: "Add New Goal"
    },
    "Goal Settings": {
        ch: "目标设置",
        en: "Goal Settings"
    },
    "Reward Settings": {
        ch: "奖励设置",
        en: "Reward Settings"
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

    "Discount": {
        ch: "折扣",
        en: "Discount"
    },

    "Percent": {
        ch: "百分",
        en: "Percent"
    },

    "Hours Required": {
        ch: "需要几个小时",
        en: "Hours Required"
    },
    "Days Required": {
        ch: "需要几天",
        en: "Days Required"
    },
    "Space Required": {
        ch: "需要空间",
        en: "Space Required"
    },

    "Discount Settings": {
        ch: "折扣设置",
        en: "Discount Settings"
    },

    "Employee discount": {
        ch: "员工折扣",
        en: "Employee discount"
    },
    "Senior discount": {
        ch: "老年人折扣",
        en: "Senior discount"
    },
    "Save": {
        ch: "储",
        en: "Save"
    },
     "Set": {
        ch: "定",
        en: "Set"
    },
    "Cancel": {
        ch: "取消",
        en: "Cancel"
    },

    "Discount Price": {
        ch: "折扣价",
        en: "Discount Price"
    },

    "Points Equivalent": {
        ch: "点相当于",
        en: "Points Equivalent"
    },

    "Price From": {
        ch: "价格来自",
        en: "Price From"
    },

    "Price To": {
        ch: "价格到",
        en: "Price To"
    }



};

$( function() {
    getLanguage(dict);
});
$( function() {
    get_dropdown_options(7,'#discount');
	get_dropdown_options(6,'#inc_space');
    get_dropdown_options(6,'#rwd_space');

    incentives();
    rewards();
    discounts();
    promos();

	$('#btn_add_itcentive').on('click', function() {
		$('#incentive_modal').modal('show');
	});

	$('#btn_add_reward').on('click', function() {
		$('#rewards_modal').modal('show');
	});

    $('#btn_add_promo').on('click', function() {
        $('#promo_modal').modal('show');
    });

	$('#frm_incentive').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: {
                _token: token,
                inc_id: $('#inc_id').val(),
                price_from: $('#price_from').val(),
                price_to: $('#price_to').val(),
                points: $('#points').val(),
            },
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg,data.status)
                incentives();

                $('#price_from').val('');
                $('#price_to').val('');
                $('#points').val('');
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
        });
    });

    $('#frm_reward').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: {
                _token: token,
                rwd_id: $('#rwd_id').val(),
                deducted_points: $('#deducted_points').val(),
                deducted_price: $('#deducted_price').val(),
            },
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
        });
    });

    $('#frm_discount').on('submit', function(e) {
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
                discounts();
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON.errors;

            if (errors == undefined) {
                msg('Discount Settings: '+errorThrown,textStatus);
            } else {
                showErrors(errors);
            }
        }).always( function() {
            $('.loading').hide();
            clear();
        });
    });

    $('#frm_promo').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();

        var data = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: data,
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg,data.status);
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON.errors;
            showErrors(errors);

            if(errorThrown == "Internal Server Error"){
                msg('Promo Settings: '+errorThrown,textStatus);
            }
        }).always(function() {
            $('.loading').hide();
        });
    });

    $('#tbl_incentive').on('click', '.edit_incentive', function() {
    	$('#inc_id').val($(this).attr('data-inc_id'));
    	$('#price_from').val($(this).attr('data-price_from'));
    	$('#price_to').val($(this).attr('data-price_to'));
    	$('#points').val($(this).attr('data-points'));
    	$('#inc_token').val(token);

    	$('#incentive_modal').modal('show');
    });

    $('#tbl_reward').on('click', '.edit_reward', function() {
    	$('#rwd_id').val($(this).attr('data-rwd_id'));
    	$('#deducted_points').val($(this).attr('data-deducted_points'));
        $('#deducted_price').val($(this).attr('data-deducted_price'));
    	$('#rwd_token').val(token);

    	$('#rewards_modal').modal('show');
    });

    $('#tbl_discount').on('click', '.edit_discount', function() {
        $('#discount_id').val($(this).attr('data-id'));
        $('#discount').val($(this).attr('data-description'));
        $('#percentage').val($(this).attr('data-percentage'));
        $('#dis_token').val(token);
    });

    $('#tbl_promo').on('click', '.edit_promo', function() {
        $('#discount_id').val($(this).attr('data-id'));
        $('#promo_desc').val($(this).attr('data-promo_desc'));
        $('#promo_token').val(token);

        $('#promo_modal').modal('show');
    });

    $('#tbl_discount_body').on('click', '.delete_discount', function() {
        confirm('Delete Discount','Do you want to delete this discount?',$(this).attr('data-id'),'discount');
    });

    $('#tbl_incentive_body').on('click', '.delete_incentive', function() {
        confirm('Delete goal','Do you want to delete this goal?',$(this).attr('data-inc_id'),'incentive');
    });

    $('#tbl_reward_body').on('click', '.delete_reward', function() {
        confirm('Delete reward','Do you want to delete this reward?',$(this).attr('data-rwd_id'),'reward');
    });

    $('#tbl_promo_body').on('click', '.delete_promo', function() {
        confirm('Delete Promo','Do you want to delete this promo?',$(this).attr('data-id'),'promo');
    });

    $('#btn_confirm').on('click', function() {
        var deleteURL = '';

        if ($('#confirm_type').val() == 'discount') {
            deleteURL = '../../general-settings/delete-discount';
        }

        if ($('#confirm_type').val() == 'incentive') {
            deleteURL = '../../general-settings/delete-incentive';
        }

        if ($('#confirm_type').val() == 'reward') {
            deleteURL = '../../general-settings/delete-reward';
        }

        $.ajax({
            url: deleteURL,
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

                if ($('#confirm_type').val() == 'discount') {
                    discounts();
                }

                if ($('#confirm_type').val() == 'incentive') {
                    incentives();
                }

                if ($('#confirm_type').val() == 'reward') {
                    rewards();
                }
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
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
        	{data: 'price_from' },
            {data: 'price_to' },
            {data: 'points' },
            {data: function(x) {
                return '<button class="btn btn-sm btn-info edit_incentive" data-inc_id="'+x.id+'" '+
	                        ' data-price_from="'+x.price_from+'" '+
	                        ' data-price_to="'+x.price_to+'" '+
	                        ' data-points="'+x.points+'">'+
                            '<i class="fa fa-edit"></i>'+
                        '</button>'+
                        '<button class="btn btn-sm btn-danger delete_incentive" data-inc_id="'+x.id+'">'+
                            '<i class="fa fa-times"></i>'+
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
        $('#rwd_id').val(data.id);
        $('#deducted_points').val(data.deducted_points);
        $('#deducted_price').val(data.deducted_price);
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
        	{data: 'deducted_price' },
            {data: 'deducted_points' },
            {data: function(x) {
                return '<button class="btn btn-sm btn-info edit_reward" data-rwd_id="'+x.id+'" '+
	                        ' data-deducted_price="'+x.deducted_price+'" '+
	                        ' data-deducted_points="'+x.deducted_points+'">'+
                            '<i class="fa fa-edit"></i>'+
                        '</button>'+
                        '<button class="btn btn-sm btn-danger delete_reward" data-rwd_id="'+x.id+'">'+
                            '<i class="fa fa-times"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
}

function discounts() {
    $.ajax({
        url: '../../general-settings/discounts',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
        },
    }).done(function(data, textStatus, xhr) {
        makeDiscountDataTable(data);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Discount Settings: '+errorThrown,textStatus);
    });
}

function makeDiscountDataTable(arr) {
    $('#tbl_discount').dataTable().fnClearTable();
    $('#tbl_discount').dataTable().fnDestroy();
    $('#tbl_discount').dataTable({
        data: arr,
        searching: false,
        ordering: false,
        paging: false,
        columns: [
            {data: 'description', searchable: false, orderable: false },
            {data: function(x) {
                return (x.percentage * 100).toFixed(2) + '%';
            }, searchable: false, orderable: false },
            {data: function(x) {
                var percentage = (x.percentage * 100).toFixed(2) + '%';
                return '<button class="btn btn-sm btn-info edit_discount" data-id="'+x.id+'" '+
                            ' data-description="'+x.description+'" '+
                            ' data-percentage="'+percentage+'">'+
                            '<i class="fa fa-edit"></i>'+
                        '</button>'+
                        '<button class="btn btn-sm btn-danger delete_discount" data-id="'+x.id+'">'+
                            '<i class="fa fa-times"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
}

function promos() {
    $.ajax({
        url: '../../general-settings/promos',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
        },
    }).done(function(data, textStatus, xhr) {
        makePromoDataTable(data);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Discount Settings: '+errorThrown,textStatus);
    });
}

function makePromoDataTable(arr) {
    $('#tbl_promo').dataTable().fnClearTable();
    $('#tbl_promo').dataTable().fnDestroy();
    $('#tbl_promo').dataTable({
        data: arr,
        searching: false,
        ordering: false,
        paging: false,
        columns: [
            {data: function(x) {
                return '<img src="'+x.promo_photo+'" class="w-35 rounded-circle">';
            }, searchable: false, orderable: false},
            {data:'promo_desc'},
            {data: function(x) {
                return '<button class="btn btn-sm btn-info edit_promo" data-id="'+x.id+'" '+
                            ' data-promo_desc="'+x.promo_desc+'">'+
                            '<i class="fa fa-edit"></i>'+
                        '</button>'+
                        '<button class="btn btn-sm btn-danger delete_promo" data-id="'+x.id+'">'+
                            '<i class="fa fa-times"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
}