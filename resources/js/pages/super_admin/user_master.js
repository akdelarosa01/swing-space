let users = [];

$( function() {
	checkAllCheckboxesInTable('.check_all_users','.check_user');
	getUsers();

	$('#frm_users').on('submit', function(e) {
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
                makeUserDataTable(data.users);
                clear();
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            var errors = xhr.responseJSON.errors;

            if (errors == undefined) {
                msg('Users: '+errorThrown,textStatus);
            } else {
                showErrors(errors);
            }
        }).always( function() {
            $('.loading').hide();
        });
    });

    $('#frm_access').on('submit', function(e) {
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
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            msg('User Access: '+errorThrown,textStatus);
        }).always( function() {
            $('.loading').hide();
        });
    });

    $('#tbl_users_body').on('click', '.assign_page', function() {
        $('#user_id').val($(this).attr('data-id'));
        getModules($(this).attr('data-id'));
        $('#user_master_modal').modal('show');
    });

    $('#tbl_users_body').on('click', '.edit', function() {
        $('#id').val($(this).attr('data-id'));
        $('#id_number').val($(this).attr('data-id_number'));
        $('#user_type').val($(this).attr('data-user_type'));
        $('#firstname').val($(this).attr('data-firstname'));
        $('#lastname').val($(this).attr('data-lastname'));
        $('#gender').val($(this).attr('data-gender'));
        $('#date_of_birth').val($(this).attr('data-date_of_birth'));
        $('#email').val($(this).attr('data-email'));
    });

    $('#btn_delete').on('click', function() {
        var chkArray = [];
        $(".check_user:checked").each(function() {
            chkArray.push($(this).val());
        });

        if (chkArray.length > 0) {
            confirm('Delete User','Do you want to delete this user/s?',chkArray);
        } else {
            msg("Please select at least 1 item.",'failed');
        }

        $('.check_all').prop('checked',false);
        
    });

    $('#btn_confirm').on('click', function() {
        $.ajax({
            url: '../../admin/user-master/delete',
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
                makeUserDataTable(data.users);
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

function getUsers() {
	$('.loading').show();
	$.ajax({
		url: '../../admin/user-master/show',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		users = data;
		makeUserDataTable(users);
	}).fail(function(xhr, textStatus, errorThrown) {
        msg('Users : '+errorThrown,textStatus);
    }).always(function() {
		$('.loading').hide();
	});	
}

function makeUserDataTable(arr) {
	$('#tbl_users').dataTable().fnClearTable();
    $('#tbl_users').dataTable().fnDestroy();
    $('#tbl_users').dataTable({
        data: arr,
        columns: [
        	{ data: function(x) {
            	return '<input type="checkbox" class="check_user" value="'+x.id+'">';
            }, searchable: false, orderable: false },
            { data: 'id_number' },
        	{ data: 'user_type' },
            { data: 'firstname' },
            { data: 'lastname' },
            { data: 'email' },
            { data: 'actual_password' },
            { data: function(x) {
            	let page_button = '';

            	if (x.user_type !== 'Customer') {
            		page_button = '<button class="btn btn-sm btn-success assign_page" data-id="'+x.id+'">'+
		            					'<i class="fa fa-list"></i>'+
		            				'</button>'
            	}

            	return '<div class="btn-group">'+
            				'<button class="btn btn-sm btn-info edit" data-id="'+x.id+'"'+
                                'data-id_number="'+x.id_number+'"'+
                                'data-user_type="'+x.user_type+'"'+
                                'data-firstname="'+x.firstname+'"'+
                                'data-lastname="'+x.lastname+'"'+
                                'data-gender="'+x.gender+'"'+
                                'data-date_of_birth="'+x.date_of_birth+'"'+
                                'data-email="'+x.email+'"'+
                            '>'+
            					'<i class="fa fa-edit"></i>'+
            				'</button>'+page_button+
            			'</div>';
            }, searchable: false, orderable: false }
        ],
        createdRow: function (row, data, dataIndex) {
            if (data.disabled > 0) {
                $(row).css('background-color', '#ff6266');
                $(row).css('color', '#fff');
            }
        }
    });
}