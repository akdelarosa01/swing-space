$( function() {
	getEmployees();
});

function getEmployees() {
	$('.loading').show();
	$.ajax({
		url: '../../employee-show-list',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token
		},
	}).done(function(data, textStatus, xhr) {
		EmployeeList(data);
	}).fail(function(xhr, textStatus, errorThrown) {
		msg('Employee List: '+errorThrown,textStatus);
	}).always(function() {
		$('.loading').hide();
	});

	$('#employee_list').on('click', '.delete-employee', function() {
		confirm('Remove Employee','Do you want to remove this employee?',$(this).attr('data-id'));
	});

	$('#btn_confirm').on('click', function() {
		$('.loading').show();
		$.ajax({
			url: '../../employee/delete',
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
				EmployeeList(data.employee);
			}
			
		}).fail(function(xhr, textStatus, errorThrown) {
			msg('Remove Employee: '+errorThrown,textStatus);
		}).always(function() {
			$('.loading').hide();
		});
	});
}

function EmployeeList(data) {
	let list = '';
	$('#employee_list').html(list);
	$.each(data, function(i, x) {
		list = '<div class="col-md-6 col-lg-4 col-xxl-3">'+
					'<div class="card contact-item">'+
						'<div class="card-header border-none">'+
							'<ul class="actions top-right">'+
								'<li class="dropdown">'+
									'<a href="javascript:void(0)" class="btn btn-sm btn-info" data-toggle="dropdown" aria-expanded="false">'+
										'<i class="fa fa-cog"></i>'+
									'</a>'+
									'<div class="dropdown-menu dropdown-menu-right">'+
										'<div class="dropdown-header">'+
											'<span class="trn">Manage Employee</span>'+
										'</div>'+
										'<a href="../../employee/'+x.id+'/edit" class="dropdown-item">'+
											'<i class="icon dripicons-pencil"></i> <span class="trn">Edit</span>'+
										'</a>'+
										'<a href="javascript:void(0)" class="dropdown-item delete-employee permission" data-id="'+x.id+'">'+
											'<i class="icon dripicons-trash"></i> <span class="trn">Remove</span>'+
										'</a>'+
									'</div>'+
								'</li>'+
							'</ul>'+
						'</div>'+
						'<div class="card-body">'+
							'<div class="row">'+
								'<div class="col-md-12 text-center">'+
									'<img src="../../'+x.photo+'" alt="user" class="rounded-circle max-w-100 m-t-20">'+
								'</div>'+
								'<div class="col-md-12 text-center">'+
									'<h5 class="card-title">'+x.firstname+' '+x.lastname+'</h5>'+
									'<small class="text-muted d-block">'+x.position+'</small>'+
									'<small class="text-muted d-block">'+x.employee_id+'</small>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>';
		$('#employee_list').append(list);
	});

	check_permission('EMP_LST');

	getLanguage(dict);
}