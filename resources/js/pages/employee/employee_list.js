$( function() {

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
}

function EmployeeList(data) {
	let list = '';
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
											'Manage Employee'+
										'</div>'+
										'<a href="javascript:void(0)" class="dropdown-item">'+
											'<i class="icon dripicons-view-list"></i> View'+
										'</a>'+
										'<a href="javascript:void(0)" class="dropdown-item">'+
											'<i class="icon dripicons-pencil"></i> Edit'+
										'</a>'+
										'<a href="javascript:void(0)" class="dropdown-item">'+
											'<i class="icon dripicons-cloud-download"></i> Export'+
										'</a>'+
										'<a href="javascript:void(0)" class="dropdown-item">'+
											'<i class="icon dripicons-trash"></i> Remove'+
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
									'<small class="text-muted d-block">'+x.email+'</small>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>';
		$('#employee_list').append(list);
	});
}