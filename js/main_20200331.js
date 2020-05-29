(function($) {
    doc.ready(function() {
        function boxloop(index) {
			$('.mv_ttl_wrap li').each(function(i) {
				var box = $(this);
				// var $elements = $('.section3 .box');
				setTimeout(function() {
					box.addClass('on');
					box.siblings().removeClass('on');
					// boxloop((index + 1) % $elements.length);
				}, 200 * i);
			});
		}

        new YMotion([
		    [
                {method: 'call', fx: function() {
					boxloop(0);
					// setInterval(function() {
				    //     boxloop(0);
				    // }, 10000);
				}},
                {el: '.el1_1', set: {opacity: 0, y: -200}, to: {opacity: 1, y: 0}, d: 0.6, t: '+=6.0'},
                {el: '.el1_2', set: {opacity: 1}, to: {opacity: 0}, d: 0.01}
    		],
            [
                {el: '.el2_2', set: {opacity: 0}, to: {opacity: 1}, d: 0.6},
                {el: '.el2_3', set: {opacity: 0}, to: {opacity: 1}, d: 0.6, t: '-=0.1'},
                {el: '.el2_4', set: {opacity: 0}, to: {opacity: 1}, d: 0.6, t: '-=0.1'},
                {el: '.el2_5', set: {opacity: 0}, to: {opacity: 1}, d: 0.6, t: '-=0.1'},
                {el: '.el2_6', set: {opacity: 0}, to: {opacity: 1}, d: 0.6, t: '-=0.1'},
                {el: '.el2_7', set: {opacity: 0}, to: {opacity: 1}, d: 0.6, t: '-=0.1'},
                {el: '.el2_8', set: {opacity: 0}, to: {opacity: 1}, d: 0.6, t: '-=0.1'},
                {el: '.el2_1', set: {y: 200}, to: {y: 0}, d: 0.8, t: '-=2.9'},
            ],
    	]).activate();

        new Swiper('.lyr2_slide .swiper-container', {
            slidesPerView: 'auto',
            loop: true,
            speed: 500,
                autoplay: {
                delay: 3000,
            }
        });

        new Swiper('.lyr3_slide .swiper-container', {
            slidesPerView: 'auto',
            loop: true,
            spaceBetween: 80,
            speed: 500,
                autoplay: {
                delay: 3000,
            }
        });
    });
}(jQuery));