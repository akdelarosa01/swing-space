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
    	// var slide = '<div id="promo_carousel" class="carousel slide" data-ride="carousel">'+
					// 	'<div class="carousel-inner">';
        var slide = '<ul>';

        var transition = [
            'fade',
            'zoomout',
            'slidedown',
            'slideleft',
            'zoomin',
            'zoomout'
        ];

        $.each(data, function(i, x) {

            var desc = '';

            if (x.promo_desc == null) {
                desc = '';
            } else {
                desc = x.promo_desc;
            }

            slide += '<li data-transition="'+transition[i]+'" data-slotamount="7" data-masterspeed="2000">'+
                        '<img src="../../'+x.promo_photo+'">'+
                        '<div class="tp-caption mediumlarge_light_white_center customin customout"'+
                            'data-x="center" data-hoffset="0"'+
                            'data-y="bottom" data-voffset="-120"'+
                            'data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"'+
                            'data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"'+
                            'data-speed="1000"'+
                            'data-start="1900"'+
                            'data-easing="Back.easeInOut"'+
                            'data-endspeed="300"'+
                            'style="z-index: 12">'+
                                desc+
                        '</div>'+
                    '</li>';
        });

        // slide += '</div>'+
		// 	'</div>';

        slide += '</ul>';

		$('.banner').html(slide);

		// $('.promo_carousel').carousel({
		// 	interval: 2000
		// })

        $('.banner').revolution({
            delay:9000,
            startwidth:1170,
            startheight:600,
            hideThumbs:10,
            lazyLoad:"on"
        });
    }).fail(function(xhr, textStatus, errorThrown) {
        msg('Error Loding Promos: '+errorThrown,textStatus);
    });
}