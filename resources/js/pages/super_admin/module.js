$( function() {
	getModules([]);

	$('#frm_module').on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize(),
		}).done(function(data, textStatus, xhr) {
			if (textStatus == 'success') {
				alert(textStatus);
				clear();
				getModules(data);
			}
		}).fail(function(xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;
			showErrors(errors);
		}).always(function() {
			console.log("complete");
		});
	});

	$('#tbl_modules_body').on('click', '.btn_edit', function() {
		$('#id').val($(this).attr('data-id'));
		$('#module_code').val($(this).attr('data-module_code'));
		$('#module_name').val($(this).attr('data-module_name'));
		$('#module_category').val($(this).attr('data-module_category'));
		$('#icon').val($(this).attr('data-ic'));
	});

	$('#tbl_modules_body').on('click', '.btn_remove', function() {
		confirm('Delete Module','Do you want to delete this module?',$(this).attr('data-id'));
	});

	$('#btn_confirm').on('click', function() {
		$.ajax({
			url: '/admin/module/delete',
			type: 'POST',
			dataType: 'JSON',
			data: {
				_token: token,
				id: $('#confirm_id').val()
			},
		}).done(function(data, textStatus, xhr) {
			if (textStatus == 'success') {
				$('#confirm_modal').modal('hide');
				alert(textStatus);
				ModulesDataTable(data);
			}
			
		}).fail(function(xhr, textStatus, errorThrown) {
			console.log("error");
		}).always(function() {
			console.log("complete");
		});
	});
});

function getModules(data) {
	if (data.length > 0) {
		console.log(data);
		ModulesDataTable(data);
	} else {
		$.ajax({
			url: '/admin/module/show',
			type: 'GET',
			dataType: 'JSON',
			data: {_token: token},
		}).done(function(data, textStatus, xhr) {
			ModulesDataTable(data);
		}).fail(function(xhr, textStatus, errorThrown) {
			console.log("error");
		}).always(function() {
			console.log("complete");
		});
		
	}
}

function ModulesDataTable(arr) {
	$('#tbl_modules').dataTable().fnClearTable();
    $('#tbl_modules').dataTable().fnDestroy();
    $('#tbl_modules').dataTable({
        data: arr,
        searching: false,
	    paging: false,
	    deferRender: true,
        columns: [
            {data:'module_code'},
            {data:'module_name'},
            {data:'module_category'},
            {data: function(x) {
            	return '<i class="'+x.icon+'"></i>';
            }},
            {data: function(x) {
            	return '<button class="btn btn-sm btn-info btn_edit" data-id="'+x.id+'"'+
	            			'data-module_code="'+x.module_code+'" '+
	            			'data-module_name="'+x.module_name+'" '+
	            			'data-module_category="'+x.module_category+'" '+
	            			'data-ic="'+x.icon+'">Edit</button>'+
            			'<button class="btn btn-sm btn-danger btn_remove" data-id="'+x.id+'">Delete</button>';
            }, searchable: false, orderable: false},
        ]
    });
}