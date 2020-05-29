
(function($) {
    doc.ready(function() {

        function boxloop(index) {
			$('.sub_title li').each(function(i) {
				var box = $(this);
				// var $elements = $('.section3 .box');
				setTimeout(function() {
					box.addClass('on');
					box.siblings().removeClass('on');
					// boxloop((index + 1) % $elements.length);
				}, 200 * i);
			});
		}

        (function() {
            var bnrMotion = [
                [
                    {method: 'call', fx: function() {
    					boxloop(0);
    					// setInterval(function() {
    				    //     boxloop(0);
    				    // }, 10000);
    				}},
                ]
            ];
            new YMotion(bnrMotion, {oElems: 'sub-offset'}).activate();
        }());

        //lnb scroll fixed
        (function() {
            function scrollHandler() {
                var scrollTop = win.scrollTop();
                if(fixed === false && scrollTop >= offset) {
                    $topElement.addClass('scroll');
                    fixed = true;
                } else if(fixed === true && scrollTop < offset) {
                    $topElement.removeClass('scroll');
                    fixed = false;
                }
            }

            var $topElement = $('.lnb'),
                offset = $('.lnb').offset().top,
                fixed = false;

            win.scroll(scrollHandler);
            scrollHandler();
        }());
    });
}(jQuery));