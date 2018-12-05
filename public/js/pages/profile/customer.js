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
    "Street": {
        ch: "街",
        en: "Street"
    },
    "State": {
        ch: "州",
        en: "State"
    },
    "City": {
        ch: "市",
        en: "City"
    },
    "Zip": {
        ch: "邮政编码",
        en: "Zip"
    },

    "Choose Photo": {
        ch: "选择照片",
        en: "Choose Photo"
    },
    "Browse": {
        ch: "浏览",
        en: "Browse"
    },
    "Upload": {
        ch: "上载",
        en: "Upload"
    },

    "Product Code": {
        ch: "产品代码",
        en: "Product Code"
    },
    "Product Name": {
        ch: "产品名称",
        en: "Product Name"
    },
    "Description": {
        ch: "描述",
        en: "Description"
    },
    "Quantity": {
        ch: "数量",
        en: "Quantity"
    },
    "Price": {
        ch: "价钱",
        en: "Price"
    },
    "Variant": {
        ch: "变种",
        en: "Variants"
    },
    "Date": {
        ch: "日期",
        en: "Date"
    },

    "Purchase History": {
        ch: "购买历史",
        en: "Purchase History"
    },

    "Membership Date": {
        ch: "会员日期",
        en: "Membership Date"
    }


};

$( function() {
    getLanguage(dict);
});
$( function() {
	qr_code();
	purchaseHistory();

	$('#frm_upload').on('submit', function(e) {
		e.preventDefault();

		if ($('#photo').val() == '') {
			msg('Please choose an image file.','failed');
		} else {
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
					$('#profile_photo').attr('src','../../'+data.photo);
				}
			}).fail(function(xhr, textStatus, errorThrown) {
				var errors = xhr.responseJSON.errors;
				showErrors(errors);

				if(errorThrown == "Internal Server Error"){
	                msg('Upload Photo: '+errorThrown,textStatus);
	            }
			}).always(function() {
				$('.loading').hide();
			});
		}
			
	});
});

function qr_code() {
	$.ajax({
		url: '../../profile/qr_code',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		$('#qr_code').attr('src','/qr_codes/'+data.customer_code+'.png');
		$('#qr_code').attr('alt',data.customer_code);
		$('#cust_code').html(data.customer_code);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Referred Customers: '+ errorThrown,textStatus);
	});
}

function purchaseHistory(argument) {
	$.ajax({
		url: '../../profile/purchase-history',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		purchaseHistoryTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Referred Customers: '+ errorThrown,textStatus);
	});
}

function purchaseHistoryTable(arr) {
	$('#tbl_history').dataTable().fnClearTable();
    $('#tbl_history').dataTable().fnDestroy();
    $('#tbl_history').dataTable({
        data: arr,
        bLengthChange : false,
        ordering: false,
        searching: false,
        columns: [
        	{ data: 'prod_code', searchable: false, orderable: false },
			{ data: 'prod_name', searchable: false, orderable: false },
			{ data: 'variants', searchable: false, orderable: false },
			{ data: 'quantity', searchable: false, orderable: false },
			{ data: 'cost', searchable: false, orderable: false },
			{ data: 'created_at', searchable: false, orderable: false }
        ]
    });
}