get_dropdown_options(1,'#position');
getProvince();
getModules('');

$( function() {

	check_permission('EMP_REG');

	if ($('#id').val() !== '') {
		show_employee($('#id').val());
	}

	$('#state').on('change', function() {
		getCity($(this).val(),'');
	});

	$('#frm_registration').on('submit', function(e) {
		e.preventDefault();
		$('.loading').show();

		var data = new FormData(this);
   		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: data,
			mimeType:"multipart/form-data",
			contentType: false,
			cache: false,
			processData:false,
		}).done(function(data, textStatus, xhr) {
            if (textStatus == 'success') {
				msg(data.msg,data.status);
			}
		}).fail(function(xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;
			showErrors(errors);

			if(errorThrown == "Internal Server Error"){
                msg('Employee Registration: '+errorThrown,textStatus);
            }
		}).always(function() {
			$('.loading').hide();
		});
	});
});

function show_employee(id) {
	$.ajax({
		url: '../../employee/show',
		type: 'GET',
		dataType: 'JSON',
		data: {
			_token: token,
			id: id
		},
	}).done(function(data, textStatus, xhr) {
		getModules(data.id);

		$('#firstname').val(data.firstname);
		$('#lastname').val(data.lastname);
		$('#email').val(data.email);
		$('#gender').val(data.gender);
		$('#date_of_birth').val(data.date_of_birth);
		$('#position').val(data.position);
		$('#phone').val(data.phone);
		$('#mobile').val(data.mobile);
		$('#street').val(data.street);
		$('#state').val(data.state);
		
		$('#zip').val(data.zip);
		$('#tin').val(data.tin);
		$('#sss').val(data.sss);
		$('#philhealth').val(data.philhealth);
		$('#pagibig').val(data.pagibig);

		getCity(data.state,data.city);

		$('#profile_photo').attr('src','../../'+data.photo);

	}).fail(function(xhr, textStatus, errorThrown) {
		msg("Employee Data: "+errorThrown,textStatus)
	});
}