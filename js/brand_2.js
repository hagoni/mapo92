(function($) {
    doc.ready(function() {

        new Swiper('.lyr2_slide .swiper-container', {
            loop:true,
            speed: 500,
                autoplay: {
                delay: 5000,
            }
        });
    });
}(jQuery));