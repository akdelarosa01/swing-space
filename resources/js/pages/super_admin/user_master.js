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
            clear();
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
       msg('Langauage : '+errorThrown,textStatus);
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
        	{ data: 'user_type' },
            { data: 'firstname' },
            { data: 'lastname' },
            { data: 'email' },
            { data: 'actual_password' },
            { data: function(x) {
            	let page_button = '';

            	if (x.user_type !== 'Customer') {
            		page_button = '<button class="btn btn-sm btn-success assign-page" data-id="'+x.id+'">'+
		            					'<i class="fa fa-list"></i>'+
		            				'</button>'
            	}

            	return '<div class="btn-group">'+
            				'<button class="btn btn-sm btn-info edit" data-id="'+x.id+'">'+
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