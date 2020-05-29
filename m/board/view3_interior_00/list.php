<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<style>
.layer1{}
.layer1 .lyr1_list{}
.lyr1_list li{margin-top:3.125vw}
.lyr1_list li:first-child{margin-top:0}
.lyr1_list .list_text{width:100%;height:39.0625vw;display:table}
.lyr1_list .list_text .dp_tbc{display:table-cell;background-image:url('../img/page/brand/03/lyr1_list_bg.jpg');vertical-align:middle;font-family:'NotoSansKR-Medium';font-size:4.375vw;letter-spacing:-0.025em;line-height:164%}


.layer2{}
.int_tab{padding:12.5vw 0 3.125vw}
.int_tab li a{display:block;width:43.75vw;height:11.5625vw;border:1px solid rgba(0,0,0,0.2);box-sizing:border-box;font-family:'NotoSansKR-Bold';font-size:4.0625vw;letter-spacing:-0.025em;line-height:11.5625vw;color:#000}
.int_tab li.on a{border:0;background:#cd0010;color:#fff}

.int_slide{}
.int_slide .swiper-slide{width:87.5vw;height:50.3125vw}
.int_slide .int_paging{padding:4.6875vw 0 12.5vw}
.int_slide .int_paging li{margin-left:3.125vw}
.int_slide .int_paging li:first-child{margin-left:0}
.int_slide .int_paging a{display:block;width:2.5vw;height:2.5vw;border-radius:50%;background:rgba(0,0,0,0.2)}
.int_slide .int_paging li.swiper-pagination-bullet-active a{background:#cd0010}
</style>

		<div class="layer1">
			<ul class="lyr1_list inner560">
				<li>
					<img src="<?=$root?>/img/page/brand/03/lyr1_img1.jpg" alt="" class="w100">
				</li>
				<li>
					<img src="<?=$root?>/img/page/brand/03/lyr1_img2.jpg" alt="" class="w100">
				</li>
				<li class="list_text">
					<p class="dp_tbc t_center">
						현대적인 재해석을 통해 완성도를 높였고,<br>
						소비자와 적극적인 소통으로<br>
						검증과 개선을 마쳤습니다.
					</p>
				</li>
			</ul>
		</div>
		<!-- <div class="layer2 bg">
			<div class="inner560">
				<ul class="int_tab fs_def t_center">
					<li class="on"><a href="#none">인테리어</a></li>
					<li><a href="#none">익스테리어</a></li>
				</ul>
				<div class="tab_conts int_conts">
					<div class="tab_cont tab_cont01">
						<div class="int_slide">
							<div class="swiper-container">
								<ul class="swiper-wrapper">
									<li class="swiper-slide bg" style="background-image:url('../img/page/brand/03/int_sl1.jpg')">

									</li>
								</ul>
							</div>
							<ul class="int_paging fs_def t_center">
	                            <li class="swiper-pagination-bullet-active"><a href="#none"></a></li>
	                            <li><a href="#none"></a></li>
	                        </ul>
						</div>
					</div>
					<div class="tab_cont tab_cont02" style="display:none">
						<div class="int_slide">
							<div class="swiper-container">
								<ul class="swiper-wrapper">
									<li class="swiper-slide bg" style="background-image:url('../img/page/brand/03/int_sl1.jpg')">

									</li>
								</ul>
							</div>
							<ul class="int_paging fs_def t_center">
	                            <li class="swiper-pagination-bullet-active"><a href="#none"></a></li>
	                            <li><a href="#none"></a></li>
	                        </ul>
						</div>
					</div>
				</div>
			</div>
		</div> -->


<!-- board wrapper start -->
<div id="boardWrap">

	<div class="tabmenu_wrap">
	    <ul class="tabmenu fs_def">
			<li<?if($view3_tab == '' || $view3_tab == 'interior'){echo ' class="on"';}?>><a href="<?=BOARD;?>/index.php?<?=get("tab","tab=interior");?>">인테리어</a></li>
			<li<?if($view3_tab == 'exterior'){echo ' class="on"';}?>><a href="<?=BOARD;?>/index.php?<?=get("tab","tab=exterior");?>">익스테리어</a></li>
		</ul>
	</div>

<?
if($total_data > 0) {
?>

	<div class="interior_slider rel">
		<div class="swiper-container">
			<ul class="swiper-wrapper">
<?
	$sql = $main_sql.$view_order;
	$out_sql = mysql_query($sql);
	while($list = mysql_fetch_assoc($out_sql)) {
		$temp_file_arr = explode('||', $list['view3_file']);
		for($i=0; $i<count($temp_file_arr); $i++) {
		    if($temp_file_arr[$i] == '') continue;
		    $list_img = $temp_file_arr[$i];
			break;
		}
        $file_size = getimagesize(ROOT_INC.'/upload/'.$board.$list_img);
        $list_html = '';
        $list_html .= '<li class="swiper-slide rel">'.PHP_EOL;
        $list_html .= '  <img src="'.BOARD.'/'.$view3_skin.'/img.php?x='.$file_size[0].'&amp;y='.$file_size[1].'" alt="" class="w100">'.PHP_EOL;
        $list_html .= '  <img data-src="'.$pc_upload.'/'.$board.$list_img.'" alt="" class="w100 swiper-lazy">'.PHP_EOL;
        $list_html .= '</li>'.PHP_EOL;
        echo $list_html;
	}
?>
			</ul>
		</div>
		<!-- <button type="button" class="interior_btns swiper-prev">이전</button>
		<button type="button" class="interior_btns swiper-next">다음</button> -->
		<ul class="swiper-paging fs_def t_center"></ul>
	</div>

<script>
(function($) {
    doc.ready(function() {
        var swiper = new Swiper($('.interior_slider > .swiper-container'), {
            autoplay: {
				delay: 5000,
				disableOnInteraction: false
			},
            setWrapperSize: true,
			pagination: {
				el: '.interior_slider .swiper-paging',
				type: 'bullets',
				clickable: true,
				renderBullet: function(index, className) {
					return '<li class="swiper-pagination-bullet"><a href="#none">'+ index +'</a></li>';
			    }
		    },
			navigation: {
				prevEl: '.interior_btns.swiper-prev',
				nextEl: '.interior_btns.swiper-next'
		    },
            preloadImages: false,
            lazy: true
        });
    });
}(jQuery));
</script>

<?
} else {
    echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->
