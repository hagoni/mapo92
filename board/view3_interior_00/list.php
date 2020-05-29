<div class="layer1 max_1800">
    <ul class="fs_def">
        <li class="li1"><img src="<?=$skin_path?>/img/lyr1_img1.jpg" alt="" class="w100"></li>
        <li class="li2"><img src="<?=$skin_path?>/img/lyr1_img2.jpg" alt="" class="w100"></li>
        <li class="li3">
            <img src="<?=$skin_path?>/img/lyr1_tbg.jpg" alt="" class="w100">
            <p class="text_area v_mid">
                현대적인 재해석을 통해<br>
                완성도를 높였고,<br>
                소비자와 적극적인 소통으로<br>
                검증과 개선을 마쳤습니다.
            </p>
        </li>
        <li class="li4"><img src="<?=$skin_path?>/img/lyr1_img3.jpg" alt="" class="w100"></li>
    </ul>
</div>

<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<div class="over_h">
    <!-- board wrapper start -->
    <div id="boardWrap">

        <ul class="tabmenu fs_def">
    		<li<?if($view3_tab == '' || $view3_tab == 'interior'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("tab","tab=interior");?>">인테리어</a></li>
    		<li<?if($view3_tab == 'exterior'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("tab","tab=exterior");?>">익스테리어</a></li>
    	</ul>

<?
if($total_data > 0) {
?>

    	<div class="interior_slider">
    		<div class="slider-container swiper-container">
    			<ul class="slider-wrapper swiper-wrapper">
<?
	$sql = $main_sql.$view_order;
	$out_sql = mysql_query($sql);
	$file = array();
	while($list = mysql_fetch_assoc($out_sql)) {
        $list_file_array = explode('||', $list['view3_file']);
        $list_file = $pc.'/upload/'.$board.$list_file_array[2];
		$file[] = $list_file;
?>
    				<li class="swiper-slide" data-src="<?=$list_file?>">
                        <img src="<?=$list_file?>" alt="" class="w100">
                    </li>
<?
	}
?>
    			</ul>
    		</div>
            <button type="button" class="swiper-buttons swiper-button-prev">이전</button>
            <button type="button" class="swiper-buttons swiper-button-next">다음</button>
    	</div>
    	<ul class="interior_paging fs_def">
    	</ul>

<script>
$(document).ready(function() {
    var $swiperItems = $('.interior_slider .swiper-slide');
    new Swiper('.interior_slider > .slider-container', {
        slidesPerView: 'auto',
        spaceBetween: 150,
		pagination: {
            el: '.interior_paging',
            type: 'bullets',
            clickable: true,
            renderBullet: function(index, className) {
                var html = '';
                html += '<li class="swiper-pagination-bullet">';
                html += '   <a href="#none">';
                html += '   </a>';
                html += '</li>';
                return html;
            }
        },
        navigation: {
            prevEl: '.interior_slider .swiper-button-prev',
            nextEl: '.interior_slider .swiper-button-next'
        }
    });
});
</script>

<?
} else {
    echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

    </div>
    <!-- //board wrapper end -->

</div>