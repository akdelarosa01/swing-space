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




    "First Name": {
    	ch: "名字",
        en: "First Name"
    },
    "Last Name": {
        ch: "姓",
        en: "Last Name"
    },
    "Gender": {
        ch: "性别",
        en: "Gender"
    },
    "Date of Birth": {
        ch: "出生日期",
        en: "Date of Birth"
    },
    "Position": {
        ch: "地位",
        en: "Position"
    },
    "Email Address": {
        ch: "电邮位置",
        en: "Email Address"
    },
    "Password": {
        ch: "密码",
        en: "Password"
    },
    "Confirm Password": {
        ch: "确认密码",
        en: "Confirm Password"
    },
    "Mobile": {
        ch: "手机号码",
        en: "Mobile"
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
    "Disable": {
        ch: "作不用的",
        en: "Disable"
    },
    "Apply": {
        ch: "寄存器",
        en: "Apply"
    },
    "Cancel": {
        ch: "取消",
        en: "Cancel"
    },
    "Points": {
        ch: "贷款",
        en: "Points"
    }

};

$( function() {
    getLanguage(dict);
});
$( function() {
	check_permission('CUS_MEM');
	$('#phone').mask('(99)999-9999', {placeholder: '(__) ___-____'});
	$('#mobile').mask('(+63)999-999-9999', {placeholder: '(+63)___-___-____'});

	referrer('#referrer');

	$('#frm_membership').on('submit', function(e) {
		e.preventDefault();
		$('.loading').show();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize(),
		}).done(function(data, textStatus, xhr) {
			msg(data.msg,data.status);
			assign_data_to_moodal(data.customer);
			clear();
		}).fail(function(xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;

			if (errors == undefined) {
				msg(errorThrown,textStatus);
			} else {
				showErrors(errors);
			}
		}).always(function() {
			$('.loading').hide();
		});
	});

	display_customer($('#id').val())
});

function clear() {
	$('.clear').val('');
	$('#points').val(0.00);
}

function assign_data_to_moodal(cust) {
	$('#customer_code_v').html(cust.customer_code);
	$('#membership_type_v').html(cust.membership_type);
	$('#date_registered_v').html(cust.date_registered);
	$('#points_v').html(cust.points);
	$('#name_v').html(cust.firstname+' '+cust.lastname);
	$('#email_v').html(cust.email);
	$('#gender_v').html(cust.gender);
	$('#phone_v').html(cust.phone);
	$('#mobile_v').html(cust.mobile);
	$('#facebook_v').html(cust.facebook);
	$('#instagram_v').html(cust.instagram);
	$('#twitter_v').html(cust.twitter);
	$('#occupation_v').html(cust.occupation);
	$('#company_v').html(cust.company);
	$('#school_v').html(cust.school);

	$('#membership_modal').modal('show');
}

function display_customer(id) {
	if (id !== '') {
		$.ajax({
			url: '../../membership/show',
			type: 'GET',
			dataType: 'JSON',
			data: {
				_token: token,
				id: id
			},
		}).done(function(data, textStatus, xhr) {
			$('#firstname').val(data.firstname);
			$('#lastname').val(data.lastname);
			$('#email').val(data.email);
			$('#gender').val(data.gender);
			$('#phone').val(data.phone);
			$('#mobile').val(data.mobile);
			$('#facebook').val(data.facebook);
			$('#instagram').val(data.instagram);
			$('#twitter').val(data.twitter);
			$('#occupation').val(data.occupation);
			$('#company').val(data.company);
			$('#school').val(data.school);
			$('#referrer').val(data.referrer_id);
			$('#points').val(data.points);
			$('#date_of_birth').val(data.date_of_birth);
			$('#membership_type').val(data.membership_type);

			if (data.disable) {
				$('#disable').prop('checked',true);
			}
			
		}).fail(function(xhr, textStatus, errorThrown) {
			console.log("error");
		}).always(function() {
			console.log("complete");
		});
	}
}