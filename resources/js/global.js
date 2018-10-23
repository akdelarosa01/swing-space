$( function() {
    $('.validate').on('keyup', function(e) {
        var no_error = $(this).attr('id');
        hideErrors(no_error)
    });

    $('.select-validate').on('change', function(e) {
        var no_error = $(this).attr('id');
        hideErrors(no_error)
    });
});

jQuery.fn.extend({
    live: function (event, callback) {
       if (this.selector) {
            jQuery(document).on(event, this.selector, callback);
        }
    }
});

function readPhotoURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('.photo').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

function showErrors(errors) {
	$.each(errors, function(i, x) {
		switch(i) {
			case i:
				$('#'+i).addClass('is-invalid');
				if (i == 'photo') {
					var err = '';
					$.each(x, function(ii, xx) {
						err += '<li>'+xx+'</li>';
						$('#photo_feedback').append(err);
					});
					$('#photo_feedback').css('color', '#dc3545');
				} 
				if (i !== 'photo') {
					$('#'+i+'_feedback').addClass('invalid-feedback');
					$('#'+i+'_feedback').html(x);
				}
			break;
		}
	});
}

function hideErrors(error) {
	$('#'+error).removeClass('is-invalid');
	$('#'+error+'_feedback').removeClass('invalid-feedback');
	$('#'+error+'_feedback').html('');
}

function checkAllCheckboxesInTable(checkAllClass,checkItemClass) {
    $(checkAllClass).on('change', function(e) {
        $('input:checkbox'+checkItemClass).not(this).prop('checked', this.checked);
    });
}

function jsUcfirst(word) {
    return word.charAt(0).toUpperCase() + word.slice(1);
}

function clear() {
	$('.clear').val('');
}

function confirm(title,msg,value) {
	let confirm_id;

	if (Array.isArray(value)) {
		confirm_id = value.join();
	} else {
		confirm_id = value;
	}

	$('#confirm_title').html(title);
	$('#confirm_msg').html(msg);
	$('#confirm_id').val(confirm_id);

	$('#confirm_modal').modal('show');
}