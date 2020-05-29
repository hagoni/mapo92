(function($) {
    $(document).ready(function() {
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

                if (scrollTop > scrollbefore) {
                    $topElement.addClass('lnb_hide');
                    $('.lnb_pop').slideUp(500);
                }else{
                    $topElement.removeClass('lnb_hide');
                }
                scrollbefore = scrollTop;

            }

            var $topElement = $('.lnb_wrap'),
                offset = $('.lnb_wrap').offset().top - $('.header_wrap').innerHeight(),
                fixed = false
                scrollbefore = win.scrollTop();

            win.scroll(scrollHandler);
            scrollHandler();
        }());

        (function(){ //lnb보다 내용이 더 길면 ...적용
            var lnb_w = $('.lnb').innerWidth(),
                lnb_item_w = 0;
            $('.lnb li').each(function () {
                lnb_item_w = lnb_item_w + $(this).outerWidth(true);
            });
            if(lnb_item_w < lnb_w)$('.lnb_right').hide(0);
        }());

        var lnbSwiper = new Swiper('.lnb_wrap > .swiper-container', {
            initialSlide: $('.lnb li.on').index(),
            slidesPerView: 'auto',
            freeMode: true
        });
        $('.lnb_btn').click(function() {
            $('.lnb_pop').slideDown(500);
        });
        $('.lnb_pop_close').click(function() {
            $('.lnb_pop').slideUp(500);
        });
    });
}(jQuery))
