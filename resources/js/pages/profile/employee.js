$( function() {
	qr_code();
});

function qr_code() {
    $.ajax({
        url: '../../profile/qr_code_employee',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token
        },
    }).done(function(data, textStatus, xhr) {
        $('#qr_code').attr('src','/qr_codes/'+data.employee_id+'.png');
        $('#qr_code').attr('alt',data.employee_id);
        $('#emp_id').html(data.employee_id);
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Referred Customers: '+ errorThrown,textStatus);
    });
}