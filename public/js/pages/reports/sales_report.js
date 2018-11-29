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
	SalesFromCustomerReport();
	yearlyComparisonChartReport();
});

function monthlySalesPerProduct(data) {
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		title:{
			text: "Monthly Expenses, 2016-17"
		},
		axisY :{
			includeZero: false,
			prefix: "$"
		},
		toolTip: {
			shared: true
		},
		legend: {
			fontSize: 13
		},
		data: [{
			type: "splineArea",
			showInLegend: true,
			name: "Salaries",
			yValueFormatString: "$#,##0",
			xValueFormatString: "MMM YYYY",
			dataPoints: [
				{ x: new Date(2016, 2), y: 30000 },
				{ x: new Date(2016, 3), y: 35000 },
				{ x: new Date(2016, 4), y: 30000 },
				{ x: new Date(2016, 5), y: 30400 },
				{ x: new Date(2016, 6), y: 20900 },
				{ x: new Date(2016, 7), y: 31000 },
				{ x: new Date(2016, 8), y: 30200 },
				{ x: new Date(2016, 9), y: 30000 },
				{ x: new Date(2016, 10), y: 33000 },
				{ x: new Date(2016, 11), y: 38000 },
				{ x: new Date(2017, 0),  y: 38900 },
				{ x: new Date(2017, 1),  y: 39000 }
			]
	 	},
		{
			type: "splineArea", 
			showInLegend: true,
			name: "Office Cost",
			yValueFormatString: "$#,##0",
			dataPoints: [
				{ x: new Date(2016, 2), y: 20100 },
				{ x: new Date(2016, 3), y: 16000 },
				{ x: new Date(2016, 4), y: 14000 },
				{ x: new Date(2016, 5), y: 18000 },
				{ x: new Date(2016, 6), y: 18000 },
				{ x: new Date(2016, 7), y: 21000 },
				{ x: new Date(2016, 8), y: 22000 },
				{ x: new Date(2016, 9), y: 25000 },
				{ x: new Date(2016, 10), y: 23000 },
				{ x: new Date(2016, 11), y: 25000 },
				{ x: new Date(2017, 0), y: 26000 },
				{ x: new Date(2017, 1), y: 25000 }
			]
	 	},
		{
			type: "splineArea", 
			showInLegend: true,
			name: "Entertainment",
			yValueFormatString: "$#,##0",     
			dataPoints: [
				{ x: new Date(2016, 2), y: 10100 },
				{ x: new Date(2016, 3), y: 6000 },
				{ x: new Date(2016, 4), y: 3400 },
				{ x: new Date(2016, 5), y: 4000 },
				{ x: new Date(2016, 6), y: 9000 },
				{ x: new Date(2016, 7), y: 3900 },
				{ x: new Date(2016, 8), y: 4200 },
				{ x: new Date(2016, 9), y: 5000 },
				{ x: new Date(2016, 10), y: 14300 },
				{ x: new Date(2016, 11), y: 12300 },
				{ x: new Date(2017, 0), y: 8300 },
				{ x: new Date(2017, 1), y: 6300 }
			]
	 	},
		{
			type: "splineArea", 
			showInLegend: true,
			yValueFormatString: "$#,##0",      
			name: "Maintenance",
			dataPoints: [
				{ x: new Date(2016, 2), y: 1700 },
				{ x: new Date(2016, 3), y: 2600 },
				{ x: new Date(2016, 4), y: 1000 },
				{ x: new Date(2016, 5), y: 1400 },
				{ x: new Date(2016, 6), y: 900 },
				{ x: new Date(2016, 7), y: 1000 },
				{ x: new Date(2016, 8), y: 1200 },
				{ x: new Date(2016, 9), y: 5000 },
				{ x: new Date(2016, 10), y: 1300 },
				{ x: new Date(2016, 11), y: 2300 },
				{ x: new Date(2017, 0), y: 2800 },
				{ x: new Date(2017, 1), y: 1300 }
			]
		}]
	});
	chart.render();
}

function SalesFromCustomerReport() {
	$.ajax({
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
		
		title:{
			text:"Sales from Regular Customers"
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

function yearlyComparisonChartReport() {
	$.ajax({
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



	