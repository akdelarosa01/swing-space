get_dropdown_options(1,'#position');
getProvince();
getModules();

$( function() {
	$('#state').on('change', function() {
		getCity($(this).val());
	});

	$('#frm_registration').on('submit', function(e) {
		e.preventDefault();
		$('.loading').show();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize(),
		}).done(function(data, textStatus, xhr) {
			if (textStatus == 'success') {
				msg(data.msg,data.status);
				clear();
			}
		}).fail(function(xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;
			showErrors(errors);
		}).always(function() {
			$('.loading').hide();
		});
	});
});