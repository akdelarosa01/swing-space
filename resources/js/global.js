Echo.channel('user_log')
    .listen('UserLogs', (e) => {
        console.log(e.log);
        getUserLogs();
    });

Echo.channel('pos')
    .listen('POS', (e) => {
        var returns = e.pos;
        calculateCustomerSubTotal(returns.bill);
        calculateTotalCustomerView(returns.bill,returns.discount_value,returns.reward_price);
        ordersCustomerViewTable(returns.bill);

        $("#tbl_discountCustomerView_body").html('');
        $("#tbl_rewardCustomerView_body").html('');

        var discount_viewTable = '';

        if (returns.discount_name == undefined) {
            discount_viewTable = '<tr>'+
                                    '<td></td>'+
                                    '<td></td>'+
                                '</tr>';
        } else {
            discount_viewTable = '<tr>'+
                                    '<td>'+returns.discount_name+'</td>'+
                                    '<td>'+'-'+returns.discount_value+'</td>'+
                                '</tr>';
        }

        $('#tbl_discountCustomerView_body').html(discount_viewTable);

        var reward_viewTable = '';

        if (returns.reward_name == undefined) {
            reward_viewTable = '<tr>'+
                                    '<td></td>'+
                                    '<td></td>'+
                                '</tr>';
        } else {
            reward_viewTable = '<tr>'+
                                '<td>'+returns.reward_name+'</td>'+
                                '<td>'+'-'+returns.reward_price+'</td>'+
                            '</tr>';
        }

        $('#tbl_rewardCustomerView_body').html(reward_viewTable);
        
    });


jQuery.fn.extend({
    live: function (event, callback) {
       if (this.selector) {
            jQuery(document).on(event, this.selector, callback);
        }
    }
});

$(document).ready( function() {
    // getLanguage();
    $('.select2').select2();

    $('.validate').on('keyup', function(e) {
        var no_error = $(this).attr('id');
        hideErrors(no_error)
    });

    $('.select-validate').on('change', function(e) {
        var no_error = $(this).attr('id');
        hideErrors(no_error)
    });

    $('.custom-file-input').on('change', function() {
       let fileName = $(this).val().split('\\').pop();
       $(this).next('.custom-file-label').addClass("selected").html(fileName);

       readPhotoURL(this);
    });

    $('#translate_language').on('click', function() {
        translateLanguage($(this).attr('data-language'));
    });
});


function readPhotoURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('.photo').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

function showErrors(errors) {
	$.each(errors, function(i, x) {
		switch(i) {
			case i:
				$('#'+i).addClass('is-invalid');
				if (i == 'photo') {
					var err = '';
					$.each(x, function(ii, xx) {
						err += '<li>'+xx+'</li>';
						$('#photo_feedback').append(err);
					});
					$('#photo_feedback').css('color', '#dc3545');
				} 
				if (i !== 'photo') {
					$('#'+i+'_feedback').addClass('invalid-feedback');
					$('#'+i+'_feedback').html(x);
				}
			break;
		}
	});
}

function hideErrors(error) {
	$('#'+error).removeClass('is-invalid');
	$('#'+error+'_feedback').removeClass('invalid-feedback');
	$('#'+error+'_feedback').html('');
}

function checkAllCheckboxesInTable(checkAllClass,checkItemClass) {
    $(checkAllClass).on('change', function(e) {
        $('input:checkbox'+checkItemClass).not(this).prop('checked', this.checked);
    });
}

function jsUcfirst(word) {
    return word.charAt(0).toUpperCase() + word.slice(1);
}

function clear() {
	$('.clear').val('');
}

function confirm(title,msg,value,delete_type) {
	let confirm_id;

	if (Array.isArray(value)) {
		confirm_id = value.join();
	} else {
		confirm_id = value;
	}

	$('#confirm_title').html(title);
	$('#confirm_msg').html(msg);
	$('#confirm_id').val(confirm_id);
    $('#confirm_type').val(delete_type);

	$('#confirm_modal').modal('show');
}

function msg(msg_content,status) {
    if (status == '') {
        $.toast({
            heading: 'Oops!',
            text: msg_content,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'warning',
            hideAfter: 3000,
            stack: 6
        });
    } else {
        switch(status) {
            case 'success':
               $.toast({
                    heading: jsUcfirst(status)+"!",
                    text: msg_content,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 5000,
                    stack: 6
                });
            break;

            case 'failed':
               $.toast({
                    heading: jsUcfirst(status)+"!",
                    text: msg_content,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'warning',
                    hideAfter: 5000,
                    stack: 6
                });
            break;

            case 'warning':
               $.toast({
                    heading: jsUcfirst(status)+"!",
                    text: msg_content,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'warning',
                    hideAfter: 5000,
                    stack: 6
                });
            break;

            case 'error':
               $.toast({
                    heading: jsUcfirst(status)+"!",
                    text: msg_content,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'danger',
                    hideAfter: 5000,
                    stack: 6
                });
            break;

            case 'notification':
               $.toast({
                    heading: jsUcfirst(status)+"!",
                    text: msg_content,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'info',
                    hideAfter: 5000,
                    stack: 6
                });
            break;
        }
    }
}

async function get_dropdown_options(id,el) {
    var opt = "<option value=''></option>";
    $(el).html(opt);
    await $.ajax({
        url: '../../dropdown/show-option',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token, 
            dropdown_id:id
        },
    }).done(function(data, textStatus, xhr) {
        $.each(data, function(i, x) {
            opt = "<option value='"+x.option_description+"'>"+x.option_description+"</option>";
            $(el).append(opt);
        });
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Dropdown Option: '+errorThrown);
    });
}

async function getProvince() {
    var opt = "<option value=''>Select State/Province</option>";
    $('#state').html(opt);
    await $.ajax({
        url: '../../get-province',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
        },
    }).done(function(data, textStatus, xhr) {
        $.each(data, function(i, x) {
            opt = "<option value='"+x.provCode+"'>"+x.provDesc+"</option>";
            $('#state').append(opt);
        });
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('State Option: '+errorThrown,textStatus);
    });
}

async function getCity(prov_code,val) {
    var opt = "<option value=''>Select City</option>";
    $('#city').html(opt);
    await $.ajax({
        url: '../../get-city',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            prov_code: prov_code
        },
    }).done(function(data, textStatus, xhr) {
        $('#city').prop('disabled',false);
        
        $.each(data, function(i, x) {
            let same = '';
            if (val == x.citymunDesc) {
                same = 'selected';
            }
            opt = "<option value='"+x.citymunDesc+"' "+same+">"+x.citymunDesc+"</option>";
            $('#city').append(opt);
        });
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('State Option: '+errorThrown,textStatus);
    });
}

async function getModules(id) {
    $('.loading').show();
    await $.ajax({
        url: '../../get-modules',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            id: id
        },
    }).done(function(data, textStatus, xhr) {
        ModulesDataTable(data);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Modules: '+errorThrown,textStatus);
    }).always( function() {
        $('.loading').hide();
    });
}

function ModulesDataTable(arr) {
    $('#tbl_modules').dataTable().fnClearTable();
    $('#tbl_modules').dataTable().fnDestroy();
    $('#tbl_modules').dataTable({
        data: arr,
        sorting: false,
        searching: false,
        paging: false,
        columns: [
            {data: 'module_name', searchable: false, orderable: false},

            {data: function(x) {
                var checked = '';
                if (x.access == 1) {
                    checked = 'checked';
                }
                return '<input type="checkbox" name="rw[]" value="'+x.id+'" '+checked+'>';
            }, searchable: false, orderable: false},

            {data: function(x) {
                var checked = '';
                if (x.access == 2) {
                    checked = 'checked';
                }
                return '<input type="checkbox" name="ro[]" value="'+x.id+'" '+checked+'>';
            }, searchable: false, orderable: false}
        ]
    });
}

async function referrer(el,val) {
    var opt = "<option value='0'></option>";
    $(el).html(opt);
    await $.ajax({
        url: '../../get-referrer',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token
        },
    }).done(function(data, textStatus, xhr) {
        $.each(data, function(i, x) {
            let same = '';
            if (val == x.id) {
                same = 'selected';
            }
            opt = "<option value='"+x.id+"' "+same+">"+x.text+"</option>";
            $(el).append(opt);
        });
    }).fail(function(xhr, textStatus, errorThrown) {
       msg('Referrer : '+errorThrown,textStatus);
    });
}

async function getLanguage(dict) {
    await $.ajax({
        url: '../../get-language',
        type: 'GET',
        dataType: 'JSON',
    }).done(function(data, textStatus, xhr) {
        $('body').translate({lang: data.language, t: dict});
        // if (data.language !== 'en') {
        //     console.log(data);
        //     $("[data-localize]").localize('../../local', data);
        // }
    }).fail(function(xhr, textStatus, errorThrown) {
       msg('Langauage : '+errorThrown,textStatus);
    });
}

async function translateLanguage(language) {
    await $.ajax({
        url: '../../translate-language',
        type: 'POST',
        dataType: 'JSON',
        data: {
            _token: token,
            language: language
        },
    }).done(function(data, textStatus, xhr) {
        location.reload();
    }).fail(function(xhr, textStatus, errorThrown) {
       msg('Langauage : '+errorThrown,textStatus);
    });
}

async function getUserLogs() {
    await $.ajax({
        url: '../../../admin/getlogs',
        type: 'GET',
        dataType: 'JSON',
    }).done(function(data, textStatus, xhr) {
        user_log = [];
        user_log = data;
        makeUserLogTable(user_log);
    }).fail(function(xhr, textStatus, errorThrown) {
        console.log(xhr+' '+errorThrown);
    });
}

function makeUserLogTable(arr) {
    $('#tbl_logs').dataTable().fnClearTable();
    $('#tbl_logs').dataTable().fnDestroy();
    $('#tbl_logs').dataTable({
        data: arr,
        sorting: false,
        searching: false,
        deferRender: true,
        columns: [
            { data: 'id', searchable: false, orderable: false },
            { data: 'module', searchable: false, orderable: false },
            { data: 'action', searchable: false, orderable: false },
            { data: 'user_name', searchable: false, orderable: false },
            { data: 'log_date', searchable: false, orderable: false },
        ]
    });
}

function checkTimeSpent(timein) {
    var myTimer = setInterval(function() {
        console.log('idle');
    }, 1000);

    clearInterval(myTimer);
    document.getElementById("time_spent").innerHTML = '';

    var timeSpent = function() {
        document.getElementById("time_spent").innerHTML = '';
        var startTime = new Date(timein).getTime();
        var now = new Date().getTime();

        var distance = now - startTime;

        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("time_spent").innerHTML = hours + "h "
        + minutes + "m " + seconds + "s ";
    };
    myTimer = setInterval(timeSpent, 1000);
}

async function check_permission(code) {
    await $.ajax({
        url: '../../check-permission',
        type: 'GET',
        dataType: 'JSON',
        data: { code: code }
    }).done(function(data, textStatus, xhr) {
        if (data.access == 2) {
            $('.permission').prop('readonly', true);
            $('.btn-permission').prop('disabled', true);
        } else {
            $('.permission').prop('readonly', false);
            $('.btn-permission').prop('disabled', false);
        }
    }).fail(function(xhr, textStatus, errorThrown) {
        msg(errorThrown,textStatus);
    }).always(function() {
        console.log("complete");
    });
    
}

// POS CONTROL

function ordersTable(arr) {
    $('#tbl_orders').dataTable().fnClearTable();
    $('#tbl_orders').dataTable().fnDestroy();
    $('#tbl_orders').dataTable({
        data: arr,
        sorting: false,
        lengthChange: false,
        ordering: false,
        paging: false,
        searching: false,
        deferRender: true,
        columnDefs: [
            { targets: 0, sortable: false, orderable: false },
        ],
        scrollX: true,
        scrollY: 300,

        // sorting: false,
        // searching: false,
        // paging: false,
        // deferRender: true,
        // scrollY: "200px",
        bInfo : false,
        columns: [
            {data: function(x) {
                return x.prod_name+'<input type="hidden" name="order_prod_name[]" value="'+x.prod_name+'">'+
                '<input type="hidden" name="order_prod_code[]" value="'+x.prod_code+'">'+
                '<input type="hidden" name="order_prod_id[]" value="'+x.prod_id+'">';
            }, searchable: false, orderable: false},
            {data: function(x) {
                return '<input type="number" name="order_quantity[]" class="form-control form-control-sm quantity" '+
                        'data-cust_id="'+x.current_cust_id+'" '+
                        'data-prod_id="'+x.prod_id+'" '+
                        'data-price="'+x.price+'" '+
                        'data-unit_price="'+x.unit_price+'" '+
                        'value="'+x.quantity+'">';
            }, searchable: false, orderable: false},
            {data: function(x) {
                return (x.price).toFixed(2)+'<input type="hidden" name="order_price[]" value="'+(x.price).toFixed(2)+'">';
            }, searchable: false, orderable: false},
            {data: function(x) {
                return '<div class="btn-group">'+
                            '<button class="btn btn-sm btn-danger remove" data-cust_id="'+x.current_cust_id+'" '+
                                'data-prod_id="'+x.prod_id+'">'+
                                '<i class="fa fa-times"></i>'+
                            '</button>'+
                        '</div>';
            }, searchable: false, orderable: false},
        ],
        language : {
            zeroRecords: " "
        },
    });
}

function ordersCustomerViewTable(arr) {
    $('#tbl_custview').dataTable().fnClearTable();
    $('#tbl_custview').dataTable().fnDestroy();
    $('#tbl_custview').dataTable({
        data: arr,
        sorting: false,
        searching: false,
        paging: false,
        deferRender: true,
        scrollY: "250px",
        bInfo : false,
        columns: [
            {data: 'prod_name', searchable: false, orderable: false},
            {data: 'quantity', searchable: false, orderable: false},
            {data: function(x) {
                return (x.price).toFixed(2);
            }, searchable: false, orderable: false},
        ],
        language : {
            zeroRecords: " "
        },
    });
}

function calculateSubTotal(data) {
    var total = 0;
    $.each(data, function(i,x) {
        total = parseFloat(total) + parseFloat(x.price);
    });

    $('#sub_total_value').val(total);

    return total.toFixed(2);
}

function calculateCustomerSubTotal(data) {
    var total = 0;
    $.each(data, function(i,x) {
        total = parseFloat(total) + parseFloat(x.price);
    });

    $('#sub_total_customer').html(total.toFixed(2));
    console.log('fired');

    return total.toFixed(2);
}

function calculateTotal(data,discounts,rewards) {
    var total = 0;
    $.each(data, function(i,x) {
        total = parseFloat(total) + parseFloat(x.price);
    });

    total = parseFloat(total) - parseFloat(discounts) - parseFloat(rewards);

    $('#order_total_amount').val(total);

    return total.toFixed(2);
}

function calculateTotalCustomerView(data,discounts,rewards) {
    var total = 0;
    $.each(data, function(i,x) {
        total = parseFloat(total) + parseFloat(x.price);
    });

    var discounts_val = parseFloat(discounts);
    var rewards_val = parseFloat(rewards);

    total = parseFloat(total) - parseFloat(discounts_val) - parseFloat(rewards_val);

    if (isNaN(total)) {
        $('#total_amount_customer').html(0.00);
        return 0.00;
    } else {
        $('#total_amount_customer').html(total.toFixed(2));
        return total.toFixed(2);
    }
}

async function showCurrentBill(cust_id,discount_name,discount_value,reward_name,reward_price) {
    await $.ajax({
        url: '../../pos-control/show-current-bill',
        type: 'POST',
        dataType: 'JSON',
        data: {
            _token: token,
            cust_id: cust_id,
            discount_name: discount_name,
            discount_value: discount_value,
            reward_name: reward_name,
            reward_price: reward_price
        },
    }).done(function(data, textStatus, xhr) {
        ordersTable(data);
        $('#sub_total').html(calculateSubTotal(data));
        $('#total_amount').html(calculateTotal(data,$('#discount_value').val(),$('#reward_price').val()));
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Current Bill: '+errorThrown,textStatus);
    });
}