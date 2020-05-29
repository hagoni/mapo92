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

        function boxloop2(index) {
			$('.layer1 .li2_crst').each(function(i) {
				var box = $(this);
				// var $elements = $('.section3 .box');
				setTimeout(function() {
					box.addClass('on');
					// boxloop((index + 1) % $elements.length);
				}, 200 * i);
                box.removeClass('on');
			});
		}

        new YMotion([
		    [
                {method: 'call', fx: function() {
					boxloop(0);
					// setInterval(function() {
				    //     boxloop(0);
				    // }, 10000);
				}, t: '+=3'}
    		],
            [
                {method: 'call', fx: function() {
					boxloop2(0);
					setInterval(function() {
				        boxloop2(0);
				    }, 4000);
				}},
                {el: '.el2_1', set: {y: 200}, to: {y: 0, repeat: -1, repeatDelay: 3}, d: 0.8, t: '-=2.9'},
            ],
    	]).activate();


        new Swiper('.lyr3_slide .swiper-container', {
            slidesPerView: 'auto',
            loop: true,
            spaceBetween: 80,
            speed: 500,
                autoplay: {
                delay: 3000,
            }
        });

        // new Swiper('.lyr2_slide .swiper-container', {
        //     slidesPerView: 'auto',
        //     loop: true,
        //     speed: 500,
        //         autoplay: {
        //         delay: 3000,
        //     }
        // });

        // 인스타그램
        $.ajax({
    		url: CONST_ROOT + '/freebest/xcross.php?http://view3landing.ivyro.net/_outline/instagram.php?',
    		data: {hashTag : '신마포갈매기'},
    		dataType: 'jsonp',
    		type: 'get',
    		success:function(res){
    			var html = "";
    			for (var i = 0; i < 20; i++) {
    				var data = res.entry_data.TagPage[0].tag.media.nodes[i];
                    console.log(data);
                    html += '<li class="swiper-slide">';
                    html += '<a href="https://www.instagram.com/p/'+data.code+'" target="_blank">';
                    html += '<span class="blank"><img src="'+data.display_src+'" alt="" class="w100"></span>';
                    html += '<span class="ico"><img src="/img/main/ico_ig.png" alt=""></span>';
                    html += '</a>';
                    html += '</li>';
    			}
    			$('.lyr2_slide .swiper-wrapper').append(html);

                new Swiper('.lyr2_slide .swiper-container', {
                    slidesPerView: 'auto',
                    loop: true,
                    speed: 500,
                        autoplay: {
                        delay: 3000,
                    }
                });
    		}
    	});

    });
}(jQuery));
