$( function() {
	$('#phone').mask('(99)999-9999', {placeholder: '(__) ___-____'});
	$('#mobile').mask('(+63)999-999-9999', {placeholder: '(+63)___-___-____'});

	$('#frm_membership').on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize(),
		}).done(function(data, textStatus, xhr) {
			msg(data.msg,data.status);
			clear();
		}).fail(function(xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;

			if (errors == undefined) {
				msg(errorThrown,textStatus);
			} else {
				showErrors(errors);
			}
		}).always(function() {
			console.log("complete");
		});
	});
});

function clear() {
	$('.clear').val('');
}