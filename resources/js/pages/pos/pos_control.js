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

	$('#btn_open').on('click', function() {
		window.open('../../pos-control/customer-view','_blank');
	});

	$('#tbl_members_body').on('click', '.btn_checkInMemeber', function() {
		$.ajax({
            url: '../../pos-control/current-customer',
            type: 'POST',
            dataType: 'JSON',
            data: {
            	_token: token,
            	type: 'M',
            	customer_user_id: $(this).attr('data-customer_user_id'),
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
            $('#member_modal').modal('hide');
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
            $('#walkin_modal').modal('hide');
            clear();
        });
	});

	$('#btn_view_pos').on('click', function() {
		$('#menu_modal').modal('hide');

		var info = '';
		$('#control').html(info);

		$('#customers').hide();
		$('#pos_control').show();
		$('#control').show();
		var timein = $(this).attr('data-cust_timein');

		info = '<div class="col-md-1">'+
					'<button class="btn btn-lg btn-danger btn-block back" style="height: 80px;padding: 0.5rem;">'+
						'<i class="fa fa-reply"></i>'+
					'</button>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<div class="card">'+
						'<div class="card-body text-center" style="font-size:10px;height: 80px;padding: 0.5rem;">'+
							'<span style="word-wrap: break-word;">'+
								$('#data-cust_code').val()+'<br>'+
								$('#data-cust_firstname').val()+'<br>'+
								$('#data-cust_lastname').val()+'<br>'+
								(($('#data-customer_type').val() == 'W')? 'WALK-IN' : 'MEMBER')+
							'</span><br>'+
							'<input type="hidden" id="current_cust_id" value="'+$('#data-cust_id').val()+'">'+
							'<input type="hidden" id="discount_value" name="discount_value" value="0">'+
							'<input type="hidden" id="discount_name" name="discount_name" value="Discount">'+
							'<input type="hidden" id="reward_price" name="reward_price" value="0">'+
							'<input type="hidden" id="reward_points" name="reward_points" value="0">'+
							'<input type="hidden" id="reward_name" name="reward_name" value="Discount from Rewards">'+
							'<input type="hidden" id="sub_total_value" name="sub_total_value" value="0">'+
							'<input type="hidden" id="customer_type" name="customer_type" value="'+$('#data-customer_type').val()+'">'+
							'<input type="hidden" id="cust_firstname" name="cust_firstname" value="'+$('#data-cust_firstname').val()+'">'+
							'<input type="hidden" id="cust_lastname" name="cust_lastname" value="'+$('#data-cust_lastname').val()+'">'+
							'<input type="hidden" id="customer_user_id" name="customer_user_id" value="'+$('#data-customer_user_id').val()+'">'+
							'<input type="hidden" id="customer_code" name="customer_code" value="'+$('#data-cust_code').val()+'">'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<div class="card">'+
						'<div class="card-body text-center" style="font-size:10px;height: 80px;padding: 0.5rem;">'+
							'<span style="word-wrap: break-word;" class="trn">Email Receipt</span> <br>'+
							'<input type="checkbox" name="email_receipt" id="email_receipt" '+(($('#data-customer_type').val() == 'W')? '' : 'checked')+'>'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<div class="card">'+
						'<div class="card-body text-center" style="font-size:10px;height: 80px;padding: 0.5rem;">'+
							'<span style="word-wrap: break-word;" class="trn">Available Points</span><br>'+
							'<span style="font-size:18px">'+$('#data-points').val()+'</span>'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<button class="btn btn-lg btn-info btn-block btn-outline rewards" '+
						'data-available_points="'+$('#data-points').val()+'" style="height: 80px;padding: 0.5rem;">'+
						'<span class="trn">Rewards</span>'+
					'</button>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<button class="btn btn-lg btn-danger btn-block btn-outline discount" style="height: 80px;padding: 0.5rem;" '+
						'data-cust_id ="'+$('#data-cust_id').val()+'">'+
						'<span class="trn">Discount</span>'+
					'</button>'+
				'</div>'+
				'<div class="col-md-2 ml-1">'+
					'<div class="card">'+
						'<div class="card-body text-center" style="font-size:10px;height: 80px;padding: 0.5rem;">'+
							'<span style="word-wrap: break-word;" class="trn">Payment:</span><br>'+
							'<input type="number" id="order_payment" class="form-control form-control-sm" min="1" step="any">'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<button class="btn btn-lg btn-success btn-block btn-outline pay_now" style="height: 80px;padding: 0.5rem;">'+
						'<span class="trn">Pay Now</span>'+
					'</button>'+
				'</div>'+
				'<div class="col-md-1 ml-1">'+
					'<div class="card">'+
						'<div class="card-body text-center" style="font-size:10px;height: 80px;padding: 0.5rem;">'+
							'<span style="word-wrap: break-word;" class="trn">Total Amount:</span><br><br>'+
							'<span id="total_amount" style="font-size:16px">0.00</span>'+
							'<input type="hidden" id="order_total_amount">'+
						'</div>'+
					'</div>'+
				'</div>';
		$('#control').html(info);
		showCurrentBill($('#data-cust_id').val(),
						$('#discount_name').val(),
						$('#discount_value').val(),
						$('#reward_name').val(),
						$('#reward_price').val());

		getLanguage(dict);
	});

	$('#btn_cancel_customer').on('click', function() {
		confirm('Cancel Customer','Do you want to cancel this customer?',$('#data-cust_id').val());
		$('#menu_modal').modal('hide');
	});

	$('#btn_confirm').on('click', function() {
        $.ajax({
            url: '../../pos-control/cancel-customer',
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
                showCustomer();
            }
            
        }).fail(function(xhr, textStatus, errorThrown) {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    });

	$('#current_customers').on('click', '.current_customer', function() {
		$('#data-cust_code').val($(this).attr('data-cust_code'));
		$('#data-cust_firstname').val($(this).attr('data-cust_firstname'));
		$('#data-cust_lastname').val($(this).attr('data-cust_lastname'));
		$('#data-customer_type').val($(this).attr('data-customer_type'));
		$('#data-customer_user_id').val($(this).attr('data-customer_user_id'));
		$('#data-points').val($(this).attr('data-points'));
		$('#data-cust_id').val($(this).attr('data-cust_id'));

		$('#detail_fullname').html('Customer:' + ' ' +$(this).attr('data-cust_firstname') + ' ' + $(this).attr('data-cust_lastname'));

		$('#menu_modal').modal('show');
	});

	$('#control').on('click', '.rewards', function() {
		$('#available_points').val($(this).attr('data-available_points'));
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
				discount_name: $('#discount_name').val(),
				discount_value: $('#discount_value').val(),
				reward_name: $('#reward_name').val(),
				reward_price: $('#reward_price').val(),
				quantity: 1
			},
		}).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
            	ordersTable(data);
            	$('#sub_total').html(calculateSubTotal(data));
            	$('#total_amount').html(
            		calculateTotal(data,$('#discount_value').val(),$('#reward_price').val())
            	);
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
				discount_name: $('#discount_name').val(),
				discount_value: $('#discount_value').val(),
				reward_name: $('#reward_name').val(),
				reward_price: $('#reward_price').val()
			},
		}).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
            	ordersTable(data);
            	$('#sub_total').html(calculateSubTotal(data));
            	$('#total_amount').html(calculateTotal(data,$('#discount_value').val(),$('#reward_price').val()));
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
					discount_name: $('#discount_name').val(),
					discount_value: $('#discount_value').val(),
					reward_name: $('#reward_name').val(),
					reward_price: $('#reward_price').val(),
					quantity: $(this).val()
				},
			}).done(function(data, textStatus, xhr) {
	            if (textStatus == 'success') {
	            	ordersTable(data);
	            	$('#sub_total').html(calculateSubTotal(data));
	            	$('#total_amount').html(calculateTotal(data,$('#discount_value').val(),$('#reward_price').val()));
	            }
	        }).fail(function(xhr, textStatus, errorThrown) {
				console.log("error");
			});
    	} else {
    		showCurrentBill($(this).attr('data-cust_id'),$('#discount_name').val(),$('#discount_value').val(),$('#reward_name').val(),$('#reward_price').val());
    	}
    });

    $('#tbl_discounts_body').on('click', '.select_discount', function() {
    	$('#discount_modal').modal('hide');

    	var discount_viewTable = '';
    	$('#tbl_discountView_body').html(discount_viewTable);

    	var sub_total = parseFloat($('#sub_total').html());
    	var percentage = parseFloat($(this).attr('data-percentage'));
    	var discount = sub_total * percentage;

    	var discount_value = (discount).toFixed(2);
    	var discount_name = $(this).attr('data-description');
    	
    	$('#discount_value').val(discount_value);
    	$('#discount_name').val(discount_name);

    	discount_viewTable = '<tr>'+
    							'<td>'+discount_name+'</td>'+
    							'<td>'+'-'+discount_value+'</td>'+
    						'</tr>';

    	$('#tbl_discountView_body').html(discount_viewTable);
    	// $('#tbl_discountCustomerView_body').html(discount_viewTable);

    	showCurrentBill($('#current_cust_id').val(),discount_name,discount_value,$('#reward_name').val(),$('#reward_price').val());
    });

    $('#tbl_rewards_body').on('click', '.select_reward', function() {
    	var reward_viewTable = '';
    	$('#tbl_rewardView_body').html(reward_viewTable);

    	var discount = parseFloat($('#reward_price').val()) + parseFloat($(this).attr('data-rwd_price'));
    	var deducted_points = parseFloat($('#reward_points').val()) + parseFloat($(this).attr('data-rwd_points'));

    	var reward_price = (discount).toFixed(2);
    	var reward_name = $(this).attr('data-rwd_name');
    	
    	$('#reward_price').val(reward_price);
    	$('#reward_points').val(deducted_points);
    	$('#reward_name').val(reward_name);

    	reward_viewTable = '<tr>'+
    							'<td>'+reward_price+'</td>'+
    							'<td>'+'-'+reward_name+'</td>'+
    						'</tr>';

    	$('#tbl_rewardView_body').html(reward_viewTable);

    	showCurrentBill($('#current_cust_id').val(),$('#discount_name').val(),$('#discount_value').val(),reward_name,reward_price);
    });

    $('#control').on('click', '.pay_now', function() {
		var order_payment = parseFloat($('#order_payment').val());
		var order_total_amount = parseFloat($('#order_total_amount').val());

		if (order_payment >= order_total_amount) {
			$('.loading').show();
			var order_change = order_payment - order_total_amount;

			$('#order_change').val((order_change).toFixed(2));
			$('#change_view').html((order_change).toFixed(2));

			$('#change_modal').modal('show');

			var email_receipt = 0;

			if ($('#email_receipt').is(":checked")) {
				email_receipt = 1;
			}

			$.ajax({
				url: '../../pos-control/save-payments',
				type: 'POST',
				dataType: 'JSON',
				data: {
					_token: token,
					cust_id: $('#current_cust_id').val(),
					discount_value: $('#discount_value').val(),
					reward_price: $('#reward_price').val(),
					reward_points: $('#reward_points').val(),
					order_payment: $('#order_payment').val(),
					order_total_amount: $('#order_total_amount').val(),
					order_change: $('#order_change').val(),
					order_prod_name: $('input[name="order_prod_name[]"]').map(function(){return $(this).val();}).get(),
					order_quantity: $('input[name="order_quantity[]"]').map(function(){return $(this).val();}).get(),
					order_price: $('input[name="order_price[]"]').map(function(){return $(this).val();}).get(),
					order_prod_code: $('input[name="order_prod_code[]"]').map(function(){return $(this).val();}).get(),
					order_prod_id: $('input[name="order_prod_id[]"]').map(function(){return $(this).val();}).get(),
					email_receipt: email_receipt,
					discount_name: $('#discount_name').val(),
					reward_name: $('#reward_name').val(),
					sub_total: $('#sub_total_value').val(),
					customer_type: $('#customer_type').val(),
					cust_firstname: $('#cust_firstname').val(),
					cust_lastname: $('#cust_lastname').val(),
					customer_user_id: $('#customer_user_id').val(),
					customer_code: $('#customer_code').val()
				},
			}).done(function(data, textStatus, xhr) {
				showCustomer();
				$('#customers').show();
				$('#pos_control').hide();
				$('#control').hide();
				$('#tbl_discounts_body').html('');
				$('#tbl_rewards_body').html('');

				$('#tbl_discountView_body').html('');
				$('#tbl_rewardView_body').html('');
				msg(data.msg,data.status);
			}).fail(function(xhr, textStatus, errorThrown) {
				msg('Payment: '+errorThrown,textStatus);
			}).always(function() {
		        $('.loading').hide();
		    });
		} else {
			msg('Customer payment is insufficient. Please pay exact or more than the total bill.','failed');
		}
			
	});

	$('#btn_calculateRewards').on('click', function() {
		if (parseFloat($('#points_used').val()) < 1 || $('#points_used').val() == '' || parseFloat($('#points_used').val()) > parseFloat($('#available_points').val())) {
			msg('Please enter a valid point value.','failed');
		} else {
			CalculateRewards($('#points_used').val());
		}
	});
});

async function getProductTypes() {
	await $.ajax({
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
		cards = '<div class="col-md-2 ml-1 mb-1">'+
					'<button type="button" class="btn btn-lg btn-block btn-accent type" '+
						'data-product_type="'+x.option_description+'" style="font-size:12px">'+
						x.option_description+
					'</button>'+
				'</div>';
		$('#product_types').append(cards);
	});
}

async function getProduct(product_type) {
	await $.ajax({
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
		if (x.quantity > 0) {
			cards = '<div class="col-md-2 ml-1">'+
						'<div class="card card-info">'+
							'<div class="card-body product text-center" style="font-size:10px;height:80px;padding:0.5rem;"'+
							'data-prod_id="'+x.id+'" '+
							'data-prod_code="'+x.prod_code+'" '+
							'data-prod_name="'+x.prod_name+'" '+
							'data-variants="'+x.variants+'" '+
							'data-price="'+(x.price).toFixed(2)+'">'+
								'<span style="word-wrap: break-word;">'+x.prod_name+'</span><br>'+
								'<span>'+(x.price).toFixed(2)+'</span>'+
							'</div>'+
						'</div>'+
					'</div>';
			$('#products').append(cards);
		} else {
			if (x.prod_type === 'Services' || x.prod_type === 'Space Rental') {
				cards = '<div class="col-md-3 ml-1">'+
							'<div class="card card-info">'+
								'<div class="card-body product text-center" style="font-size:12px;height: 80px;"'+
								'data-prod_id="'+x.id+'" '+
								'data-prod_code="'+x.prod_code+'" '+
								'data-prod_name="'+x.prod_name+'" '+
								'data-variants="'+x.variants+'" '+
								'data-price="'+(x.price).toFixed(2)+'">'+
									'<span style="word-wrap: break-word;">'+x.prod_name+'</span><br>'+
									'<span>'+(x.price).toFixed(2)+'</span>'+
								'</div>'+
							'</div>'+
						'</div>';
				$('#products').append(cards);
			}
		}
	});
}

async function showCustomer() {
	await $.ajax({
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

async function checkInMember(cust_code) {
	await $.ajax({
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
            	return x.cust_code+'<input type="hidden" name="cust_code[]" value="'+x.cust_code+'">'+
            		'<input type="hidden" name="customer_user_id[]" value="'+x.customer_user_id+'">';
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
                			'data-customer_user_id="'+x.customer_user_id+'"'+
                			'>'+
                        	'<span class="trn">Check In</span>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
    getLanguage(dict);
}

function customers(data) {
	var cards = '';
	$('#current_customers').html(cards);
	
	$.each(data, function(i, x) {
		var type = 'btn-info';
		if (x.cust_code == 'N/A') {
			type = 'btn-success';
		}

		cards = '<div class="col-md-2 ml-1 mb-1">'+
					'<button type="button" class="btn btn-lg btn-block '+type+' current_customer btn-outline btn-permission" '+
					'data-cust_id="'+x.id+'" '+
					'data-cust_code="'+x.cust_code+'" '+
					'data-cust_firstname="'+x.cust_firstname+'" '+
					'data-cust_lastname="'+x.cust_lastname+'" '+
					'data-customer_user_id="'+x.customer_user_id+'" '+
					'data-customer_type="'+x.customer_type+'" '+
					'data-points="'+x.points+'">'+
						'<span style="font-size:12px;word-wrap: break-word;">'+x.cust_firstname+' '+x.cust_lastname+'</span>'+
					'</button>'+
				'</div>';
		$('#current_customers').append(cards);
	});

	check_permission('POS_CTRL');
}

async function discounts() {
	await $.ajax({
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
                        	'<i class="fa fa-plus"></i>'+
                        '</button>';
            }, searchable: false, orderable: false},
        ]
    });
}

async function CalculateRewards(points) {
	await $.ajax({
		url: '../../pos-control/calculate-rewards',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token,
			points: points
		},
	}).done(function(data, textStatus, xhr) {
		var price = (data.price_to_deduct).toFixed(2);
		$('#reward_points').val(data.points_to_deduct);
		$('#reward_price').val(price);
		$('#reward_name').val('Reward Discount');

		var reward_viewTable = '';
    	$('#tbl_rewardView_body').html(reward_viewTable);

    	reward_viewTable = '<tr>'+
    							'<td class="trn">Discount from reward points</td>'+
    							'<td>'+'-'+price+'</td>'+
    						'</tr>';

    	$('#tbl_rewardView_body').html(reward_viewTable);

    	$('#rewards_modal').modal('hide');

    	showCurrentBill($('#current_cust_id').val(),$('#discount_name').val(),$('#discount_value').val(),$('#reward_name').val(),$('#reward_price').val());
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Discounts: '+errorThrown,textStatus);
	});
}