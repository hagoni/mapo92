<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
######################################################################################################################################################
$sql = $main_sql.$view_order;
$out_sql = mysql_query($sql);
$list = mysql_fetch_assoc($out_sql);
view3_hit($view3_table, $list['view3_idx']);
######################################################################################################################################################
// 이전글 다음글
######################################################################################################################################################
$sort = view3_prev_next($view3_table,$view3_idx);
$path_prev = view3_link("||idx","view&idx=".$temp_prev,"",$end_path);
$path_next = view3_link("||idx","view&idx=".$temp_next,"",$end_path);
######################################################################################################################################################
$_SESSION['idx'] = $view3_idx;
$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
$next_command_01 = view3_html($list['view3_command_01']);
if($list['view3_addr_road']) {
	$addr = $list['view3_addr_road']." ".$list['view3_addr_detail'];
} else {
	$addr = $list['view3_addr_number']." ".$list['view3_addr_detail'];
}
?>

<!-- board wrapper start -->
<div id="boardWrap" class="view">

	<div class="board_view_head">
		<p class="board_view_title b_fs_l b_ff_h b_c_h ellipsis"><?=$option['notice']?><?=$list['view3_title_01']?></p>
	</div>
    <ul class="board_view_sns">
        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-fb-share-btn"><img src="../img/board/sns_ico01.png" alt="페이스북 아이콘" class="w100"></a></li>
        <li><a href="http://blog.naver.com/openapi/share?url=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-bl-share-btn"><img src="../img/board/sns_ico02.png" alt="네이버 블로그 아이콘" class="w100"></a></li>
        <li><a href="https://story.kakao.com/share?url=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-ks-share-btn"><img src="../img/board/sns_ico03.png" alt="카카오스토리 아이콘" class="w100"></a></li>
    </ul>

<?
if($option['user_map_view']) {
?>
	<div class="store_view_img">
		<div class="slider-container swiper-container">
			<ul class="slider-wrapper swiper-wrapper">
				<?=$option['user_map_view'];?>
			</ul>
		</div>
		<button type="button" class="slider-btns slider-prev">이전</button>
		<button type="button" class="slider-btns slider-next">다음</button>
	</div>
<?
}
?>
	<div class="store_view_info">
		<ul class="store_info_list">
			<li class="store_info_li">
				<span class="store_info_ico store_info_ico01"></span>
				<div class="store_info_txt_area">
					<p class="store_info_dt b_fs_l b_lh_s b_c_m">매장주소</p>
					<p class="b_fs_m b_lh_s b_c_l"><?=$addr?></p>
				</div>
			</li>
<?
if($list['view3_special_04']) {
?>
			<li class="store_info_li">
				<span class="store_info_ico store_info_ico02"></span>
				<div class="store_info_txt_area">
					<p class="store_info_dt b_fs_l b_lh_s b_c_m">전화번호</p>
					<p class="b_fs_m b_lh_s b_c_l"><?=$list['view3_special_04']?></p>
				</div>
			</li>
<?
}
if($list['view3_special_02']) {
?>
			<li class="store_info_li">
				<span class="store_info_ico store_info_ico03"></span>
				<div class="store_info_txt_area">
					<p class="store_info_dt b_fs_l b_lh_s b_c_m">운영시간</p>
					<p class="b_fs_m b_lh_s b_c_l"><?=view3_html($list['view3_special_02'],'br')?></p>
				</div>
			</li>
<?
}
if($list['view3_special_05'] == 'on' || $list['view3_special_06'] == 'on' || $list['view3_special_07'] == 'on' || $list['view3_special_08'] == 'on') {
?>
			<li class="store_info_li">
				<span class="store_info_ico store_info_ico04"></span>
				<div class="store_info_txt_area">
					<p class="store_info_dt b_fs_l b_lh_s b_c_m">서비스</p>
					<ul class="service_ico_area">
<?
######################################################################################################################################################
	if($list['view3_special_05'] == 'on') {
		echo '						<li class="service_ico service_ico01" title="주차 가능">주차 가능</li>'.PHP_EOL;
	}
	if($list['view3_special_06'] == 'on') {
		echo '						<li class="service_ico service_ico02" title="와이파이">와이파이</li>'.PHP_EOL;
	}
	if($list['view3_special_07'] == 'on') {
		echo '						<li class="service_ico service_ico03" title="신용 카드">신용 카드</li>'.PHP_EOL;
	}
	if($list['view3_special_08'] == 'on') {
		echo '						<li class="service_ico service_ico04" title="포장">포장</li>'.PHP_EOL;
	}
######################################################################################################################################################
?>
					</ul>
				</div>
			</li>
<?
}
?>
		</ul>
	</div>
	<ul class="store_view_tabmenu">
		<li class="on"><a href="#none">지도보기</a></li>
		<li><a href="#none">로드뷰 보기</a></li>
	</ul>
	<div class="store_view_cont">
		<div id="roughMap" class="store_view_cont01"></div>
		<div id="roadView" class="store_view_cont02"></div>
	</div>
<?
######################################################################################################################################################
include_once(BOARD_INC.'/setup_bottom.php');
######################################################################################################################################################
?>

<?
$markerImgPath = '/design/other/marker.png';
$markerImgSize = getImagesize(ROOT_INC.$markerImgPath);
?>
<script src="//maps.googleapis.com/maps/api/js?language=<?=$language?>&amp;region=<?=$language?>&amp;libraries=geometry&amp;key=<?=$settings_data['google_api_key']?>"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?libraries=services&appkey=<?=$settings_data['kakao_api_m_key']?>"></script>
<?
if ($board == 'map_01') {
?>
	<script>
	(function($) {
		$(document).ready(function() {
			if($('.store_view_img li').length > 1) {
				new Swiper($('.store_view_img > .slider-container'), {
					autoplay: {
						delay: 5000,
						disableOnInteraction: false
					},
					speed: 500,
					setWrapperSize: true,
					navigation: {
						nextEl: '.store_view_img > .slider-next',
						prevEl: '.store_view_img > .slider-prev'
				    }
				});
			}

			var $mapContainer = $('.store_view_cont > div');
			var $mapTabs = $('.store_view_tabmenu > li');
			$mapTabs.on('click', function(e) {
				if($(this).index() !== $mapTabs.filter('.on').index()) {
					$mapContainer.eq($mapTabs.filter('.on').index()).css({visibility: 'hidden'});
					$mapContainer.eq($(this).index()).css({visibility: 'visible'});
					$mapTabs.filter('.on').removeClass('on');
					$(this).addClass('on');
				}
				e.preventDefault();
			});

			function setRV(r) {
				if(radius > maxRadius) return false;
				rvClient.getNearestPanoId(rvc, r, function(panoId) {
					if(typeof panoId === 'string') {
						roadView.setPanoId(panoId, rvc);
						roadView.setViewpoint({
							zoom: '<?=$list['view3_addr_rv_zoom']?>' != 0 ? '<?=$list['view3_addr_rv_zoom']?>' : 0,
							tilt: '<?=$list['view3_addr_rv_tilt']?>' != 0 ? '<?=$list['view3_addr_rv_tilt']?>' : 0,
							pan: '<?=$list['view3_addr_rv_pan']?>' != 0 ? '<?=$list['view3_addr_rv_pan']?>' : 0
						});
					} else {
						setRV(radius += 10);
					}
				});
			}

			var markerImage = {
				src: '<?=$pc.$markerImgPath?>',
				offset: {x: <?=$markerImgSize[0] / 2?>, y: <?=$markerImgSize[1]?>},
				size: {x: <?=$markerImgSize[0]?>, y: <?=$markerImgSize[1]?>}
			};
			var center = new daum.maps.LatLng('<?=$list['view3_addr_y']?>', '<?=$list['view3_addr_x']?>');
			var map = new daum.maps.Map(document.getElementById('roughMap'), {
				center: center,
				scrollwheel: false,
				level: 3
			});
			var markerOptions = {
				position: center,
				image: new daum.maps.MarkerImage(
					markerImage.src,
					new daum.maps.Size(markerImage.size.x, markerImage.size.y),
					{
						offset: new daum.maps.Point(markerImage.offset.x, markerImage.offset.y)
					}
				)
			};
			var marker = new daum.maps.Marker(markerOptions);
			marker.setMap(map);

			map.addControl(new daum.maps.MapTypeControl(), daum.maps.ControlPosition.TOPRIGHT);
			map.addControl(new daum.maps.ZoomControl(), daum.maps.ControlPosition.RIGHT);

			var roadView = new daum.maps.Roadview(document.getElementById('roadView'));
			var rvClient = new daum.maps.RoadviewClient();

			var rvc = new daum.maps.LatLng(
				'<?=$list['view3_addr_rv_lat']?>' != 0 ? '<?=$list['view3_addr_rv_lat']?>' : '<?=$list['view3_addr_y']?>',
				'<?=$list['view3_addr_rv_lng']?>' != 0 ? '<?=$list['view3_addr_rv_lng']?>' : '<?=$list['view3_addr_x']?>'
			);

			var maxRadius = 200;
			var radius = 50;

			setRV(radius);
		});
	}(jQuery));
	</script>
<?
} else if ($board == 'map_other_01') {
?>
<script>
	$(document).ready(function(){
		var lat = '<?=$list['view3_addr_y']?>';
		var lng = '<?=$list['view3_addr_x']?>';

		if (lat == 'undefined' || lng == 'undefined') {
			$('#roughMap').css('background','url("<?=$request_root?>/design/noimg/map_01.jpg")');
		} else {
			var map = new google.maps.Map(document.getElementById('roughMap'), {zoom: 4, center: {lat:<?=$list['view3_addr_y']?>, lng: <?=$list['view3_addr_x']?>}});
			var marker = new google.maps.Marker({position: {lat:<?=$list['view3_addr_y']?>, lng: <?=$list['view3_addr_x']?>}, icon: '<?=$pc.$markerImgPath?>', map: map, title: 'store position'});
		}
	});
</script>
<?
}
?>


</div>
