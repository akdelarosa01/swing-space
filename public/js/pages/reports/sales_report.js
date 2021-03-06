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
    }


};

$( function() {
    getLanguage(dict);
});
$( function() {
	check_permission('SAL_RPT');
	getSales();
	SalesFromCustomerReport();
	SalesOverDiscountsReport();
	yearlyComparisonChartReport();

	$('#btn_customer').on('click', function() {
		$('#sales_per_customer_modal').modal('show');
	});

	$('#sales_per_customer').on('click', function() {
		var ExportURL = '../../sales-report/sales-from-customers-excel?_token='+token+
			'&&date_from='+$('#customer_from').val()+
			'&&date_to='+$('#customer_to').val();
		window.location.href=ExportURL;
	});

	$('#btn_discount').on('click', function() {
		$('#sales_vs_discount_modal').modal('show');
	});

	$('#sales_vs_discount').on('click', function() {
		var ExportURL = '../../sales-report/sales-over-discounts-excel?_token='+token+
			'&&date_from='+$('#discount_from').val()+
			'&&date_to='+$('#discount_to').val();
		window.location.href=ExportURL;
	});

	$('#btn_generate').on('click', function() {
		getSales();
	});
});

async function getSales() {
	await $.ajax({
		url: '../../sales-report/get-sales',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token : token,
			datefrom: $('#datefrom').val(),
			dateto: $('#dateto').val()
		},
	}).done(function(data, textStatus, xhr) {
		salesTable(data)
	}).fail(function(xhr, textStatus, errorThrown) {
		console.log("error");
	});
}

function salesTable(arr) {
    $('#tbl_sales').dataTable().fnClearTable();
    $('#tbl_sales').dataTable().fnDestroy();
    $('#tbl_sales').dataTable({
        data: arr,
        sorting: false,
        columns: [
            { data: 'customer_code' },
            { data: 'firstname' },
            { data: 'lastname' },
            { data: 'customer_type' },
            { data: 'total_sale' },
            { data: 'date_purchase' },
        ]
    });
}

async function monthlySalesPerProductReport() {
	await $.ajax({
		url: '../../sales-report/monthly-sales-product-report',
		type: 'GET',
		dataType: 'JSON',
		data: {param1: 'value1'},
	}).done(function(data, textStatus, xhr) {
		monthlySalesPerProductChart(data)
	}).fail(function(xhr, textStatus, errorThrown) {
		console.log("error");
	});
}

function monthlySalesPerProductChart(data) {
	var chart = new CanvasJS.Chart("monthlySalesPerProduct", {
		animationEnabled: true,
		title:{
			text: "Monthly Sales per Product"
		},
		axisY :{
			includeZero: false,
			prefix: "₱"
		},
		toolTip: {
			shared: true
		},
		legend: {
			fontSize: 13
		},
		data: data
	});
	chart.render();
}

async function SalesFromCustomerReport() {
	await $.ajax({
		url: '../../sales-report/sales-from-customers-report',
		type: 'GET',
		dataType: 'JSON',
		data: {param1: 'value1'},
	}).done(function(data, textStatus, xhr) {
		SalesFromCustomerChart(data)
	}).fail(function(xhr, textStatus, errorThrown) {
		console.log("error");
	});
}

function SalesFromCustomerChart(data) {
	var chart = new CanvasJS.Chart("SalesFromCustomer", {
		animationEnabled: true,
		zoomEnabled:true,
		title:{
			text:"Sales from Regular Customers per Week"
		},
		axisX:{
			interval: 1
		},
		axisY2:{
			interlacedColor: "rgba(1,77,101,.2)",
			gridColor: "rgba(1,77,101,.1)",
			title: "Amount Purchased"
		},
		data: [{
			type: "bar",
			name: "customers",
			axisYType: "secondary",
			color: "#014D65",
			toolTipContent: "<img src=\"../../\"{url}\"\" style=\"width:40px; height:20px;\"> <b>{label}</b><br>Total Amount: ₱ ${y}",
			dataPoints: data
		}]
	});
	chart.render();
}

async function yearlyComparisonChartReport() {
	await $.ajax({
		url: '../../sales-report/yearly-comparison-report',
		type: 'GET',
		dataType: 'JSON',
		data: {param1: 'value1'},
	}).done(function(data, textStatus, xhr) {
		yearlyComparisonChart(data)
	}).fail(function(xhr, textStatus, errorThrown) {
		console.log("error");
	});
}

function yearlyComparisonChart(dt) {
	var chart = new CanvasJS.Chart("YearlyComparisonReport", {
		animationEnabled: true,
		zoomEnabled:true,
		axisY: {
			title: "Sales of "+dt.last_year,
			titleFontColor: "#4F81BC",
			lineColor: "#4F81BC",
			labelFontColor: "#4F81BC",
			tickColor: "#4F81BC"
		},
		axisY2: {
			title: "Sales of "+dt.year_now,
			titleFontColor: "#C0504E",
			lineColor: "#C0504E",
			labelFontColor: "#C0504E",
			tickColor: "#C0504E"
		},	
		toolTip: {
			shared: true
		},
		legend: {
			cursor:"pointer",
			itemclick: toggleDataSeries
		},
		data: dt.details
	});
	chart.render();

	function toggleDataSeries(e) {
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		}
		else {
			e.dataSeries.visible = true;
		}
		chart.render();
	}
}

async function SalesOverDiscountsReport() {
	await $.ajax({
		url: '../../sales-report/sales-over-discounts-report',
		type: 'GET',
		dataType: 'JSON',
		data: {param1: 'value1'},
	}).done(function(data, textStatus, xhr) {
		SalesOverDiscountsChart(data)
	}).fail(function(xhr, textStatus, errorThrown) {
		console.log("error");
	});
}

function SalesOverDiscountsChart(dt) {
	var chart = new CanvasJS.Chart("SalesOverDiscounts", {
		animationEnabled: true,
		zoomEnabled:true,
		axisY: {
			title: "Total sales per month.",
			titleFontColor: "#4F81BC",
			lineColor: "#4F81BC",
			labelFontColor: "#4F81BC",
			tickColor: "#4F81BC"
		},
		axisY2: {
			title: "Total discount per month.",
			titleFontColor: "#C0504E",
			lineColor: "#C0504E",
			labelFontColor: "#C0504E",
			tickColor: "#C0504E"
		},	
		toolTip: {
			shared: true
		},
		legend: {
			cursor:"pointer",
			itemclick: toggleDataSeries
		},
		data: dt.details
	});
	chart.render();

	function toggleDataSeries(e) {
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		}
		else {
			e.dataSeries.visible = true;
		}
		chart.render();
	}
}



	