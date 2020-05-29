(function($) {
    doc.ready(function() {
        TweenMax.to($('.lyr_img'), 22.0, {rotationZ: 360, ease: Power0.easeNone, repeat: -1});

        new YMotion([
		    [
                {el: '.el1_1', set: {opacity: 0}, to: {opacity: 1}, d: 0.6},
                {el: '.el1_2', set: {opacity: 0}, to: {opacity: 1}, d: 0.6},
                {el: '.el1_3', set: {opacity: 0}, to: {opacity: 1}, d: 0.6},
    		]
    	]).activate();
    });
}(jQuery));