$( function() {
	check_permission('SAL_RPT');
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
});

function monthlySalesPerProductReport() {
	$.ajax({
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

function SalesOverDiscountsReport() {
	$.ajax({
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



	