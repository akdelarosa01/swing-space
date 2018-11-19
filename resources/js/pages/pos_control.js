let orders = [];

$( function() {
	getProductTypes()

	$('#product_types').on('click', '.type', function() {
		getProduct($(this).attr('data-product_type'));
	});

	$('#products').on('click', '.product', function() {
		var count = 0;
		for (var i = 0; i < orders.length; i++) {
			if (orders[i].prod_id == $(this).attr('data-prod_id')){
				count++;
			}
		}

		if (count > 0) {
			msg('Product is already selected.','failed');
		} else {
			var index = orders.length;
			orders.push({
				index: index,
				prod_id: $(this).attr('data-prod_id'),
				prod_code: $(this).attr('data-prod_code'),
				prod_name: $(this).attr('data-prod_name'),
				price: $(this).attr('data-price'),
				orig_price: $(this).attr('data-price'),
				quantity: 1
			});

			ordersTable(orders);
		}

		console.log(calculateTotal(orders));
	});

	$('#tbl_orders_body').on('click', '.remove', function() {
        orders.splice($(this).attr('data-index'), 1);

        count = 0;
        $.each(orders, function(i, x) {
            x.index = count++;
        });

        ordersTable(orders);

        console.log(calculateTotal(orders));
    });

    $('#tbl_orders_body').on('change', '.quantity', function() {
        for (var i = 0; i < orders.length; i++) {
			if (orders[i].prod_id == $(this).attr('data-prod_id')){
				orders[i].quantity = $(this).val()
				orders[i].price = ($(this).val()*$(this).attr('data-orig_price')).toFixed(2);
			}
		}

        ordersTable(orders);

        console.log(calculateTotal(orders));
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
					'<button type="button" class="btn btn-lg btn-block btn-accent type" data-product_type="'+x.option_description+'" style="font-size:12px">'+
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
		cards = '<div class="col-md-3 ml-1 mb-1">'+
					// '<div class="card">'+
					// 	'<div class="card-body product"'+
					// 		'data-prod_code="'+x.prod_code+'" '+
					// 		'data-price="'+x.price+'">'+
					// 		'<span style="font-size:12px;word-wrap: break-word;">'+x.prod_name+'</span>'+
					// 	'</div>'+
					// '</div>'
					'<button type="button" class="btn btn-lg btn-block btn-info product" '+
					'data-prod_id="'+x.id+'" '+
					'data-prod_code="'+x.prod_code+'" '+
					'data-prod_name="'+x.prod_name+'" '+
					'data-price="'+(x.price).toFixed(2)+'">'+
						'<span style="font-size:12px;word-wrap: break-word;">'+x.prod_name+'</span>'+
					'</button>'+
				'</div>';
		$('#products').append(cards);
	});
}

function ordersTable(arr) {
	$('#tbl_orders').dataTable().fnClearTable();
    $('#tbl_orders').dataTable().fnDestroy();
    $('#tbl_orders').dataTable({
        data: arr,
        sorting: false,
        searching: false,
        paging: false,
	    deferRender: true,
	    scrollY: "250px",
        columns: [
            {data: function(x) {
            	return x.prod_name+'<input type="hidden" name="prod_name[]" value="'+x.prod_name+'">';
            }, searchable: false, orderable: false},
            {data: function(x) {
            	return '<input type="number" name="quantity[]" class="form-control form-control-sm quantity" '+
            			'data-prod_id="'+x.prod_id+'" '+
            			'data-price="'+x.price+'" '+
            			'data-orig_price="'+x.orig_price+'" '+
            			'value="'+x.quantity+'">';
            }, searchable: false, orderable: false},
            {data: function(x) {
            	return x.price+'<input type="hidden" name="price[]" value="'+x.price+'">';
            }, searchable: false, orderable: false},
            {data: function(x) {
            	return '<div class="btn-group">'+
            				'<button class="btn btn-sm btn-danger remove" data-index="'+x.index+'">'+
            					'<i class="fa fa-times"></i>'+
            				'</button>'+
            			'</div>';
            }, searchable: false, orderable: false},
        ]
    });
}

function calculateTotal(data) {
	var total = 0;
	$.each(data, function(i,x) {
		total = parseFloat(total) + parseFloat(x.price);
	});

	return total.toFixed(2);
}