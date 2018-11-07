jQuery.fn.extend({
    live: function (event, callback) {
       if (this.selector) {
            jQuery(document).on(event, this.selector, callback);
        }
    }
});

$( function() {
    getLanguage();
    $('.select2').select2();

    $('.validate').on('keyup', function(e) {
        var no_error = $(this).attr('id');
        hideErrors(no_error)
    });

    $('.select-validate').on('change', function(e) {
        var no_error = $(this).attr('id');
        hideErrors(no_error)
    });

    $('.custom-file-input').on('change', function() {
       let fileName = $(this).val().split('\\').pop();
       $(this).next('.custom-file-label').addClass("selected").html(fileName);

       readPhotoURL(this);
    });

    $('#translate_language').on('click', function() {
        translateLanguage($(this).attr('data-language'));
    });
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

function msg(msg_content,status) {
    if (status == '') {
        $.toast({
            heading: 'Oops!',
            text: msg_content,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'warning',
            hideAfter: 3000,
            stack: 6
        });
    } else {
        switch(status) {
            case 'success':
               $.toast({
                    heading: jsUcfirst(status)+"!",
                    text: msg_content,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 5000,
                    stack: 6
                });
            break;

            case 'failed':
               $.toast({
                    heading: jsUcfirst(status)+"!",
                    text: msg_content,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'warning',
                    hideAfter: 5000,
                    stack: 6
                });
            break;

            case 'warning':
               $.toast({
                    heading: jsUcfirst(status)+"!",
                    text: msg_content,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'warning',
                    hideAfter: 5000,
                    stack: 6
                });
            break;

            case 'error':
               $.toast({
                    heading: jsUcfirst(status)+"!",
                    text: msg_content,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'danger',
                    hideAfter: 5000,
                    stack: 6
                });
            break;

            case 'notification':
               $.toast({
                    heading: jsUcfirst(status)+"!",
                    text: msg_content,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'info',
                    hideAfter: 5000,
                    stack: 6
                });
            break;
        }
    }
}

function get_dropdown_options(id,el) {
    var opt = "<option value=''></option>";
    $(el).html(opt);
    $.ajax({
        url: '../../dropdown/show-option',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token, 
            dropdown_id:id
        },
    }).done(function(data, textStatus, xhr) {
        $.each(data, function(i, x) {
            opt = "<option value='"+x.option_description+"'>"+x.option_description+"</option>";
            $(el).append(opt);
        });
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Dropdown Option: '+errorThrown);
    });
}

function getProvince() {
    var opt = "<option value=''>Select State/Province</option>";
    $('#state').html(opt);
    $.ajax({
        url: '../../get-province',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
        },
    }).done(function(data, textStatus, xhr) {
        $.each(data, function(i, x) {
            opt = "<option value='"+x.provCode+"'>"+x.provDesc+"</option>";
            $('#state').append(opt);
        });
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('State Option: '+errorThrown,textStatus);
    });
}

function getCity(prov_code,val) {
    var opt = "<option value=''>Select City</option>";
    $('#city').html(opt);
    $.ajax({
        url: '../../get-city',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            prov_code: prov_code
        },
    }).done(function(data, textStatus, xhr) {
        $('#city').prop('disabled',false);
        
        $.each(data, function(i, x) {
            let same = '';
            if (val == x.citymunDesc) {
                same = 'selected';
            }
            opt = "<option value='"+x.citymunDesc+"' "+same+">"+x.citymunDesc+"</option>";
            $('#city').append(opt);
        });
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('State Option: '+errorThrown,textStatus);
    });
}

function getModules(id) {
    $('.loading').show();
    $.ajax({
        url: '../../get-modules',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
            id: id
        },
    }).done(function(data, textStatus, xhr) {
        ModulesDataTable(data);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Modules: '+errorThrown,textStatus);
    }).always( function() {
        $('.loading').hide();
    });
}

function ModulesDataTable(arr) {
    $('#tbl_modules').dataTable().fnClearTable();
    $('#tbl_modules').dataTable().fnDestroy();
    $('#tbl_modules').dataTable({
        data: arr,
        sorting: false,
        searching: false,
        paging: false,
        deferRender: true,
        columns: [
            {data: 'module_name', searchable: false, orderable: false},

            {data: function(x) {
                var checked = '';
                if (x.access == 1) {
                    checked = 'checked';
                }
                return '<input type="checkbox" name="rw[]" value="'+x.id+'" '+checked+'>';
            }, searchable: false, orderable: false},

            {data: function(x) {
                var checked = '';
                if (x.access == 2) {
                    checked = 'checked';
                }
                return '<input type="checkbox" name="ro[]" value="'+x.id+'" '+checked+'>';
            }, searchable: false, orderable: false}
        ]
    });
}

function referrer(el,val) {
    var opt = "<option value='0'></option>";
    $(el).html(opt);
    $.ajax({
        url: '../../get-referrer',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token
        },
    }).done(function(data, textStatus, xhr) {
        $.each(data, function(i, x) {
            let same = '';
            if (val == x.id) {
                same = 'selected';
            }
            opt = "<option value='"+x.id+"' "+same+">"+x.text+"</option>";
            $(el).append(opt);
        });
    }).fail(function(xhr, textStatus, errorThrown) {
       msg('Referrer : '+errorThrown,textStatus);
    });
}

function getLanguage() {
    $.ajax({
        url: '../../get-language',
        type: 'GET',
        dataType: 'JSON',
    }).done(function(data, textStatus, xhr) {
        // if (data.language !== 'en') {
        //     console.log(data);
            $("[data-localize]").localize('local', data);
        // }
    }).fail(function(xhr, textStatus, errorThrown) {
       msg('Langauage : '+errorThrown,textStatus);
    });
}

function translateLanguage(language) {
    $.ajax({
        url: '../../translate-language',
        type: 'POST',
        dataType: 'JSON',
        data: {
            _token: token,
            language: language
        },
    }).done(function(data, textStatus, xhr) {
        location.reload();
    }).fail(function(xhr, textStatus, errorThrown) {
       msg('Langauage : '+errorThrown,textStatus);
    });
}