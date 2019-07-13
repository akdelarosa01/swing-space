$( function() {
	check_permission('CUS_MEM');
	$('#phone').mask('(99)999-9999', {placeholder: '(__) ___-____'});
	$('#mobile').mask('(+63)999-999-9999', {placeholder: '(+63)___-___-____'});

	referrer('#referrer');

	$('#frm_membership').on('submit', function(e) {
		e.preventDefault();
		$('.loading').show();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize(),
		}).done(function(data, textStatus, xhr) {
			msg(data.msg,data.status);
			assign_data_to_moodal(data.customer);
			clear();
		}).fail(function(xhr, textStatus, errorThrown) {
			var errors = xhr.responseJSON.errors;

			if (errors == undefined) {
				msg(errorThrown,textStatus);
			} else {
				showErrors(errors);
			}
		}).always(function() {
			$('.loading').hide();
		});
	});

	display_customer($('#id').val())
});

function clear() {
	$('.clear').val('');
	$('#points').val(0.00);
}

function assign_data_to_moodal(cust) {
	$('#customer_code_v').html(cust.customer_code);
	$('#membership_type_v').html(cust.membership_type);
	$('#date_registered_v').html(cust.date_registered);
	$('#points_v').html(cust.points);
	$('#name_v').html(cust.firstname+' '+cust.lastname);
	$('#email_v').html(cust.email);
	$('#gender_v').html(cust.gender);
	$('#phone_v').html(cust.phone);
	$('#mobile_v').html(cust.mobile);
	$('#facebook_v').html(cust.facebook);
	$('#instagram_v').html(cust.instagram);
	$('#twitter_v').html(cust.twitter);
	$('#occupation_v').html(cust.occupation);
	$('#company_v').html(cust.company);
	$('#school_v').html(cust.school);

	$('#membership_modal').modal('show');
}

function display_customer(id) {
	if (id !== '') {
		$.ajax({
			url: '../../membership/show',
			type: 'GET',
			dataType: 'JSON',
			data: {
				_token: token,
				id: id
			},
		}).done(function(data, textStatus, xhr) {
			$('#firstname').val(data.firstname);
			$('#lastname').val(data.lastname);
			$('#email').val(data.email);
			$('#gender').val(data.gender);
			$('#phone').val(data.phone);
			$('#mobile').val(data.mobile);
			$('#facebook').val(data.facebook);
			$('#instagram').val(data.instagram);
			$('#twitter').val(data.twitter);
			$('#occupation').val(data.occupation);
			$('#company').val(data.company);
			$('#school').val(data.school);
			$('#referrer').val(data.referrer_id);
			$('#points').val(data.points);
			$('#date_of_birth').val(data.date_of_birth);
			$('#membership_type').val(data.membership_type);

			if (data.disable) {
				$('#disable').prop('checked',true);
			}
			
		}).fail(function(xhr, textStatus, errorThrown) {
			console.log("error");
		}).always(function() {
			console.log("complete");
		});
	}
}