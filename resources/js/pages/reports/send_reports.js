$( function() {
	check_permission('SND_RPT');
	$('#frm_reports').on('submit', function(e) {
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
                msg('Send Reports: '+errorThrown,textStatus);
            }
		}).always(function() {
			$('.loading').hide();
		});
	});
});