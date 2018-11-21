$( function() {
    get_dropdown_options(7,'#discount');
	get_dropdown_options(6,'#inc_space');
    get_dropdown_options(6,'#rwd_space');

    incentives();
    rewards();
    discounts();

	$('#btn_add_itcentive').on('click', function() {
		$('#incentive_modal').modal('show');
	});

	$('#btn_add_reward').on('click', function() {
		$('#rewards_modal').modal('show');
	});

	$('#frm_incentive').on('submit', function(e) {
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
                incentives();
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
            clear();
        });
    });

    $('#frm_reward').on('submit', function(e) {
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
            clear();
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

    $('#tbl_incentive').on('click', '.edit_incentive', function() {
    	$('#inc_id').val($(this).attr('data-inc_id'));
    	$('#inc_code').val($(this).attr('data-inc_code'));
    	$('#inc_name').val($(this).attr('data-inc_name'));
    	$('#inc_points').val($(this).attr('data-inc_points'));
    	$('#inc_hrs').val($(this).attr('data-inc_hrs'));
    	$('#inc_days').val($(this).attr('data-inc_days'));
    	$('#inc_space').val($(this).attr('data-inc_space'));
    	$('#inc_description').val($(this).attr('data-inc_description'));
    	$('#inc_token').val(token);

    	$('#incentive_modal').modal('show');
    });

    $('#tbl_reward').on('click', '.edit_reward', function() {
    	$('#rwd_id').val($(this).attr('data-rwd_id'));
    	$('#rwd_code').val($(this).attr('data-rwd_code'));
    	$('#rwd_name').val($(this).attr('data-rwd_name'));
    	$('#rwd_points').val($(this).attr('data-rwd_points'));
    	$('#rwd_hrs').val($(this).attr('data-rwd_hrs'));
    	$('#rwd_days').val($(this).attr('data-rwd_days'));
    	$('#rwd_space').val($(this).attr('data-rwd_space'));
    	$('#rwd_description').val($(this).attr('data-rwd_description'));
    	$('#rwd_token').val(token);

    	$('#rewards_modal').modal('show');
    });

    $('#tbl_discount').on('click', '.edit_discount', function() {
        $('#discount_id').val($(this).attr('data-id'));
        $('#discount').val($(this).attr('data-description'));
        $('#percentage').val($(this).attr('data-percentage'));
        $('#dis_token').val(token);
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
        	{data: 'inc_code' },
            {data: 'inc_name' },
            {data: 'inc_points' },
            {data: 'inc_hrs' },
            {data: 'inc_days' },
            {data: 'inc_space' },
            {data: 'inc_description' },
            {data: function(x) {
                return '<button class="btn btn-sm btn-info edit_incentive" data-inc_id="'+x.id+'" '+
	                        ' data-inc_code="'+x.inc_code+'" '+
	                        ' data-inc_name="'+x.inc_name+'" '+
	                        ' data-inc_points="'+x.inc_points+'" '+
	                        ' data-inc_hrs="'+x.inc_hrs+'" '+
	                        ' data-inc_days="'+x.inc_days+'" '+
	                        ' data-inc_space="'+x.inc_space+'" '+
	                        ' data-inc_description="'+x.inc_description+'">'+
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
        makeRewardDataTable(data);
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
        	{data: 'rwd_code' },
            {data: 'rwd_name' },
            {data: 'rwd_points' },
            {data: 'rwd_hrs' },
            {data: 'rwd_days' },
            {data: 'rwd_space' },
            {data: 'rwd_price' },
            {data: 'rwd_description' },
            {data: function(x) {
                return '<button class="btn btn-sm btn-info edit_reward" data-rwd_id="'+x.id+'" '+
	                        ' data-rwd_code="'+x.rwd_code+'" '+
	                        ' data-rwd_name="'+x.rwd_name+'" '+
	                        ' data-rwd_points="'+x.rwd_points+'" '+
	                        ' data-rwd_hrs="'+x.rwd_hrs+'" '+
	                        ' data-rwd_days="'+x.rwd_days+'" '+
	                        ' data-rwd_space="'+x.rwd_space+'" '+
                            ' data-rwd_price="'+x.rwd_price+'" '+
	                        ' data-rwd_description="'+x.rwd_description+'">'+
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