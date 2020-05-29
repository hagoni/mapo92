(function($) {
    $(document).ready(function() {

        var lyr1Swiper = new Swiper('.lyr1_slide > .swiper-container', {
            slidesPerView: 'auto',
            centeredSlides: true,
        });



        var lyr3Swiper = new Swiper('.lyr3_slide > .swiper-container', {
            autoplay: {
                delay: 3000,
            },
            pagination: {
                el: '.lyr3_paging',
                type: 'bullets',
                clickable: true,
                renderBullet: function(index, className){
                		return '<li class="' + className + '"><a href="#none"></a></li>';
                }
            },
        });

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
                    html += '<img src="'+data.display_src+'" alt="" class="w100">';
                    html += '<span class="sl_sns blog"></span>';
                    html += '</a>';
                    html += '</li>';
    			}
    			$('.lyr2_list .swiper-wrapper').append(html);

                new Swiper('.lyr2_list.swiper-container', {
                    autoplay: {
                        delay: 3000,
                    },
                    slidesPerView: 2,
                    spaceBetween: 15,
                });
    		}
    	});
    });
}(jQuery))
