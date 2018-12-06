$( function() {
	promos();
});

function promos() {
    $.ajax({
        url: '../../general-settings/promos',
        type: 'GET',
        dataType: 'JSON',
        data: {
            _token: token,
        },
    }).done(function(data, textStatus, xhr) {
    	var slide = '<div id="promo_carousel" class="carousel slide" data-ride="carousel">'+
						'<div class="carousel-inner">';


        $.each(data, function(i, x) {
        	if (i == 0) {
        		slide += '<div class="carousel-item active">'+
							'<img class="d-block" src="../../'+x.promo_photo+'" alt="'+x.promo_desc+'" style="height:500px; width: 100% !important">'+
							'<div class="carousel-caption d-none d-md-block">'+
								'<h5>'+x.promo_desc+'</h5>'+
							'</div>'+
						'</div>';
        	} else {
        		slide += '<div class="carousel-item">'+
							'<img class="d-block" src="../../'+x.promo_photo+'" alt="'+x.promo_desc+'" style="height:500px; width: 100% !important">'+
							'<div class="carousel-caption d-none d-md-block">'+
								'<h5>'+x.promo_desc+'</h5>'+
							'</div>'+
						'</div>';
        	}
        	
        });

        slide += '</div>'+
			'</div>';

		$('#promos').html(slide);

		$('.promo_carousel').carousel({
			interval: 3000
		})
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Error Loding Promos: '+errorThrown,textStatus);
    });
}