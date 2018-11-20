$( function() {
	$('#customers').show();
	$('#pos_control').hide();
	$('#control').hide();

	getProductTypes();
	showCustomer();

	$('#btn_walkin').on('click', function() {
		$('#walkin_modal').modal('show');
	});

	$('#btn_member').on('click', function() {
		checkInMember();
		$('#member_modal').modal('show');
	});

	$('#search_code').on('change', function() {
		checkInMember($(this).val());
	});

	$('#tbl_members_body').on('click', '.btn_checkInMemeber', function() {
		$.ajax({
            url: '../../pos-control/current-customer',
            type: 'POST',
            dataType: 'JSON',
            data: {
            	_token: token,
            	type: 'member',
            	cust_code: $(this).attr('data-cust_code'),
            	cust_firstname: $(this).attr('data-cust_firstname'),
            	cust_lastname: $(this).attr('data-cust_lastname')
            },
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg,data.status)
                clear();
                showCustomer();
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON.errors;

            if (errors == undefined) {
                msg('Check In: '+errorThrown,textStatus);
            } else {
                showErrors(errors);
            }
        }).always( function() {
            $('.loading').hide();
            clear();
        });
	});

	$('#frm_walkin').on('submit', function(e) {
		e.preventDefault();
		$.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'JSON',
            data: $(this).serialize(),
        }).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
                msg(data.msg,data.status)
                clear();
                showCustomer();
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON.errors;

            if (errors == undefined) {
                msg('Check In: '+errorThrown,textStatus);
            } else {
                showErrors(errors);
            }
        }).always( function() {
            $('.loading').hide();
            clear();
        });
	});

	$('#current_customers').on('click', '.current_customer', function() {
		var info = '';
		$('#control').html(info);

		$('#customers').hide();
		$('#pos_control').show();
		$('#control').show();
		var timein = $(this).attr('data-cust_timein');

		info = '<div class="col-md-1">'+
					'<button class="btn btn-lg btn-danger btn-block back" style="height: 120px;">'+
						'<i class="fa fa-reply"></i>'+
					'</button>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<div class="card">'+
						'<div class="card-body text-center" style="font-size:12px;height: 120px;">'+
							'<span style="word-wrap: break-word;">'+
								$(this).attr('data-cust_code')+'<br>'+
								$(this).attr('data-cust_firstname')+'<br>'+
								$(this).attr('data-cust_lastname')+
							'</span><br>'+
							'<input type="hidden" id="current_cust_id" value="'+$(this).attr('data-cust_id')+'">'+
							'<input type="hidden" id="discount_value" name="discount_value" value="0">'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<div class="card">'+
						'<div class="card-body text-center" style="font-size:12px;height: 120px;">'+
							'<span style="word-wrap: break-word;">Timed In: </span><br>'+
							'<span>'+timein.substring(11)+'</span>'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<div class="card">'+
						'<div class="card-body text-center" style="font-size:12px;height: 120px;">'+
							'<span style="word-wrap: break-word;">Available Points: </span><br>'+
							'<span style="font-size:18px">'+$(this).attr('data-points')+'</span>'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<button class="btn btn-lg btn-info btn-block btn-outline rewards" style="height: 120px;">'+
						'<span class="trn">Rewards</span>'+
					'</button>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<button class="btn btn-lg btn-danger btn-block btn-outline discount" style="height: 120px;" '+
						'data-cust_id ="'+$(this).attr('data-cust_id')+'">'+
						'<span class="trn">Discount</span>'+
					'</button>'+
				'</div>'+
				'<div class="col-md-2 ml-1">'+
					'<div class="card">'+
						'<div class="card-body text-center" style="font-size:12px;height: 120px;">'+
							'<span style="word-wrap: break-word;">Payment: </span><br>'+
							'<input type="number" class="form-control form-control-sm" min="1" step="any">'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<button class="btn btn-lg btn-success btn-block btn-outline pay_now" style="height: 120px;">'+
						'<span class="trn">Pay Now</span>'+
					'</button>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<div class="card">'+
						'<div class="card-body text-center" style="font-size:12px;height: 120px;">'+
							'<span style="word-wrap: break-word;">Total Amount: </span><br>'+
							'<span id="total_amount" style="font-size:18px">0.00</span>'
						'</div>'+
					'</div>'+
				'</div>';
		$('#control').html(info);
		showCurrentBill($(this).attr('data-cust_id'));
	});

	$('#control').on('click', '.rewards', function() {
		$('#rewards_modal').modal('show');
	});

	$('#control').on('click', '.discount', function() {
		discounts();
		$('#discount_modal').modal('show');
	});

	$('#control').on('click', '.back', function() {
		$('#customers').show();
		$('#pos_control').hide();
		$('#control').hide();
	});

	$('#product_types').on('click', '.type', function() {
		getProduct($(this).attr('data-product_type'));
	});

	$('#products').on('click', '.product', function() {
		$.ajax({
			url: '../../pos-control/save-current-bill',
			type: 'POST',
			dataType: 'JSON',
			data: {
				_token: token,
				cust_id: $('#current_cust_id').val(),
				prod_id: $(this).attr('data-prod_id'),
				prod_code: $(this).attr('data-prod_code'),
				prod_name: $(this).attr('data-prod_name'),
				price: $(this).attr('data-price'),
				unit_price: $(this).attr('data-price'),
				quantity: 1
			},
		}).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
            	ordersTable(data);
            	$('#sub_total').html(calculateSubTotal(data));
            	$('#total_amount').html(calculateTotal(data,$('#discount_val').val()));
            }
        }).fail(function(xhr, textStatus, errorThrown) {
			console.log("error");
		});
	});

	$('#tbl_orders_body').on('click', '.remove', function() {
		$.ajax({
			url: '../../pos-control/delete-current-item',
			type: 'POST',
			dataType: 'JSON',
			data: {
				_token: token,
				cust_id: $(this).attr('data-cust_id'),
				prod_id: $(this).attr('data-prod_id'),
			},
		}).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
            	ordersTable(data);
            	$('#sub_total').html(calculateSubTotal(data));
            	$('#total_amount').html(calculateTotal(data,$('#discount_val').val()));
            }
        }).fail(function(xhr, textStatus, errorThrown) {
			console.log("error");
		});
    });

    $('#tbl_orders_body').on('change', '.quantity', function() {
    	if ($(this).val() > 0) {
    		$.ajax({
				url: '../../pos-control/update-current-item',
				type: 'POST',
				dataType: 'JSON',
				data: {
					_token: token,
					cust_id: $(this).attr('data-cust_id'),
					prod_id: $(this).attr('data-prod_id'),
					unit_price: $(this).attr('data-unit_price'),
					quantity: $(this).val()
				},
			}).done(function(data, textStatus, xhr) {
	            if (textStatus == 'success') {
	            	ordersTable(data);
	            	$('#sub_total').html(calculateSubTotal(data));
	            	$('#total_amount').html(calculateTotal(data,$('#discount_val').val()));
	            }
	        }).fail(function(xhr, textStatus, errorThrown) {
				console.log("error");
			});
    	} else {
    		showCurrentBill($(this).attr('data-cust_id'));
    	}
    });

    $('#tbl_discounts_body').on('click', '.select_discount', function() {
    	$('#discount_modal').modal('hide');

    	var discount_viewTable = '';
    	$('#tbl_discountView_body').html(discount_viewTable);

    	var sub_total = parseFloat($('#sub_total').html());
    	var percentage = parseFloat($(this).attr('data-percentage'));
    	var discount = sub_total * percentage;
    	
    	$('#discount_value').val((discount).toFixed(2));

    	discount_viewTable = '<tr>'+
    							'<td>'+$(this).attr('data-description')+'</td>'+
    							'<td>'+(discount).toFixed(2)+'</td>'+
    						'</tr>';

    	$('#tbl_discountView_body').html(discount_viewTable);

    	showCurrentBill($('#current_cust_id').val());
    });
});

function getProductTypes() {
	$.ajax({
        url: '../../pos-control/product-types',
        type: 'GET',
        dataType: 'JSON',
        data: {_token: token},
    }).done(function(data, textStatus, xhr) {
        productTypeButton(data);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg(errorThrown,textStatus);
    }).always(function() {
        console.log("complete");
    });
}

function productTypeButton(data) {
	var cards = '';
	$('#product_types').html(cards);
	$.each(data, function(i, x) {
		cards = '<div class="col-md-1 ml-1 mb-1">'+
					'<button type="button" class="btn btn-lg btn-block btn-accent type" '+
						'data-product_type="'+x.option_description+'" style="font-size:12px">'+
						x.option_description+
					'</button>'+
				'</div>';
		$('#product_types').append(cards);
	});
}

function getProduct(product_type) {
	$.ajax({
        url: '../../pos-control/products',
        type: 'GET',
        dataType: 'JSON',
        data: {
        	_token: token,
        	product_type: product_type
        },
    }).done(function(data, textStatus, xhr) {
        productButton(data);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg(errorThrown,textStatus);
    }).always(function() {
        console.log("complete");
    });
}

function productButton(data) {
	var cards = '';
	$('#products').html(cards);
	$.each(data, function(i, x) {
		cards = '<div class="col-md-3 ml-1">'+
					'<div class="card card-info">'+
						'<div class="card-body product text-center" style="font-size:12px;height: 100px;"'+
						'data-prod_id="'+x.id+'" '+
						'data-prod_code="'+x.prod_code+'" '+
						'data-prod_name="'+x.prod_name+'" '+
						'data-price="'+(x.price).toFixed(2)+'">'+
							'<span style="word-wrap: break-word;">'+x.prod_name+'</span><br>'+
							'<span>'+(x.price).toFixed(2)+'</span>'+
						'</div>'+
					'</div>'+
				'</div>';
		$('#products').append(cards);
	});
}

function showCustomer() {
	$.ajax({
		url: '../../pos-control/show-customer',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		customers(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Current Customers: '+errorThrown,textStatus);
	});
}

function checkInMember(cust_code) {
	$.ajax({
		url: '../../pos-control/check-in-member',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token,
			cust_code: cust_code
		},
	}).done(function(data, textStatus, xhr) {
		membersTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Check In: '+errorThrown,textStatus);
	});
}

function membersTable(arr) {
	$('#tbl_members').dataTable().fnClearTable();
    $('#tbl_members').dataTable().fnDestroy();
    $('#tbl_members').dataTable({
        data: arr,
        searching: false,
        ordering: false,
        columns: [
            {data: function(x) {
            	return x.cust_code+'<input type="hidden" name="cust_code[]" value="'+x.cust_code+'">';
            }},
            {data: function(x) {
            	return x.cust_firstname+'<input type="hidden" name="cust_firstname[]" value="'+x.cust_firstname+'">';
            }},
            {data: function(x) {
            	return x.cust_lastname+'<input type="hidden" name="cust_lastname[]" value="'+x.cust_lastname+'">';
            }},
            {data: function(x) {
                return '<button type="button" class="btn btn-info btn-sm btn_checkInMemeber" '+
                			'data-cust_code="'+x.cust_code+'"'+
                			'data-cust_firstname="'+x.cust_firstname+'"'+
                			'data-cust_lastname="'+x.cust_lastname+'"'+
                			'>'+
                        	'<span class="trn">Check In</span>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
}

function customers(data) {
	var cards = '';
	$('#current_customers').html(cards);
	
	$.each(data, function(i, x) {
		var type = 'btn-info';
		if (x.cust_code == 'N/A') {
			type = 'btn-success';
		}

		cards = '<div class="col-md-3 ml-1 mb-1">'+
					'<div class="btn btn-lg btn-block '+type+' current_customer btn-outline" '+
					'data-cust_id="'+x.id+'" '+
					'data-cust_code="'+x.cust_code+'" '+
					'data-cust_firstname="'+x.cust_firstname+'" '+
					'data-cust_lastname="'+x.cust_lastname+'" '+
					'data-points="'+x.points+'" '+
					'data-cust_timein="'+x.cust_timein+'">'+
						'<span style="font-size:12px;word-wrap: break-word;">'+x.cust_firstname+' '+x.cust_lastname+'</span>'+
					'</div>'+
				'</div>';
		$('#current_customers').append(cards);
	});
}

function discounts() {
	$.ajax({
		url: '../../pos-control/show-discounts',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		discountTable(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Discounts: '+errorThrown,textStatus);
	});
}

function discountTable(arr) {
	$('#tbl_discounts').dataTable().fnClearTable();
    $('#tbl_discounts').dataTable().fnDestroy();
    $('#tbl_discounts').dataTable({
        data: arr,
        searching: false,
        ordering: false,
        columns: [
            {data: function(x) {
            	return x.description+'<input type="hidden" name="description[]" value="'+x.description+'">';
            }},
            {data: function(x) {
            	var percent = x.percentage * 100;
            	return percent+'%'+'<input type="hidden" name="percentage[]" value="'+x.percentage+'">';
            }},
            {data: function(x) {
                return '<button type="button" class="btn btn-info btn-sm select_discount" '+
                			'data-description="'+x.description+'"'+
                			'data-percentage="'+x.percentage+'"'+
                			'>'+
                        	'<i class="fa fa-pencil"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
}