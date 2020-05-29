<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
$_SESSION['idx'] = $view3_idx;
$skinPath = $root.'/board/'.$view3_skin;
######################################################################################################################################################
$sql = $main_sql.' and view3_idx = '.$view3_idx.$view_order;
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

$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
$next_command_01 = view3_html($list['view3_command_01']);
if($list['view3_addr_road']) {
	$addr = $list['view3_addr_road']." ".$list['view3_addr_detail'];
} else {
	$addr = $list['view3_addr_number']." ".$list['view3_addr_detail'];
}
?>
<style media="screen">
.section{background:none}
.sub_banner_wrap{background: url('../img/sub/sub02_banner02.jpg') no-repeat 50% 0}
.biz02_con a{display:block;width:1100px;height:2159px;margin:0 auto;background: url('../img/page/biz_2.jpg') no-repeat 50% 0}
.biz02_view{display:block;width:1101px;height:1079px;margin:0 auto;background: url('../img/page/biz02_view.png') no-repeat 50% 0}
.globalAnchorTag{position:absolute;width:0;height:0;opacity:0;text-indent:-99999px;opacity: 0;}
/* overseas_list_top */
.lyr_line{margin-top:78px}
.lyr_tit{padding-top:77px;padding-bottom:45px}
.process_wrap{padding:55px 0;background:#fafafa}
.overseas_process{width:100%;font-size:0;text-align:center}
.overseas_process li:first-child{margin-left:0}
.overseas_process li{display:inline-block;margin-left:70px;vertical-align:top;width:195px}
.process_txt{position:relative;height:80px;padding:3px 0 0 40px;font-size:1rem;color:#444;line-height:156%}
.process_txt:after{display:block;position:absolute;top:0;left:0;width:29px;height:29px;line-height:29px;background: url('../img/num_bg.png') no-repeat 0 0;color:#fff;font-weight:700;font-size:0.9375rem}
.p01 .process_txt:after{content:"1";}
.p02 .process_txt:after{content:"2";}
.p03 .process_txt:after{content:"3";}
.p04 .process_txt:after{content:"4";left:48px;text-align:center}
.p04 .process_txt{text-align:left;padding-left:87px}
.process_img{position:relative}
.overseas_process li:first-child .process_img:before{display:none}
.process_img:before{display:block;content:"";position:absolute;top:66px;left:-40px;width:12px;height:21px;background: url('../img/process_arrow.png') no-repeat 0 0}

.overseas_inq{position:relative;margin:30px 18.1818% 0;text-align:center}
.overseas_inq .inq_in{position:absolute;top:26.6666%;left:0;width:100%;}
.inq_tit{position:relative;display:inline-block;padding-left:30px;font-size:1.25em;color:#f27824}
.inq_tit:after{display:block;content:"";position:absolute;top:0;left:0;width:20px;height:20px;background: url('../img/inq_ico.png') no-repeat 0 0}
.inq_txt{padding-top:16px;font-size:0.8125em;color:#888}

/* overseas_list_con */
.overseas_list_con{margin-bottom:80px}
.select_area{position:relative;width:380px;margin:0 auto;z-index:1}
.select_area:after{display:block;content:"";clear:both}
.select.sel01{float:left}
.select.sel02{float:right}
.select{position:relative;width:180px;height:45px;}
.select > a.selBtn{;display:block;width:100%;height: 100%;;font-size:0.9375rem;font-weight:700;color:#444;background:#FFFFFF;border-width:0px 0px 2px 0px;border-style:solid;border-color:#cbcbcb;-webkit-box-sizing:border-box;
-moz-box-sizing:border-box;
-ms-box-sizing:border-box;
-o-box-sizing:border-box;
box-sizing:border-box}
/* ( for javascript )   .select > a.selBtn:hover{border-color:#ffc19d;}*/
.select:hover .depth{display: block;}
.select > a.selBtn > span.selSubject{position: absolute;left:19px;top:14px;}
.select > a.selBtn > span.selIcon{position:absolute;top:14px;right:10px}
.depth{display:none;position:absolute;top:43px;left:0;width:100%;border-top:2px solid #f86714;-webkit-box-sizing:border-box;
-moz-box-sizing:border-box;
-ms-box-sizing:border-box;
-o-box-sizing:border-box;
box-sizing:border-box
}
.depth ul{border-width:0 1px 1px 1px;border-style:solid;border-color:#cbcbcb;-webkit-box-sizing:border-box;
-moz-box-sizing:border-box;
-ms-box-sizing:border-box;
-o-box-sizing:border-box;
box-sizing:border-box
}
.depth ul li{height:40px;border-top:1px solid #cbcbcb;background:#fff}
.depth ul li:hover a{color:#f86714}
.depth ul li:first-child{border-top:none}
.depth ul li a{display:block;color:#888;font-size:0.8125rem;padding:15px 0 0 20px}

.map_area{position:relative;width:100%;height:451px;overflow:hidden;margin-top:35px;background:#dadde2}
.map_area .map_logo{position:absolute;z-index:10;top:30px;left:30px}
.worldMap{position: relative;margin:0 auto;max-width:670px;max-height: 487px;background-image:url('../img/world_map_full.png');background-size:100% 100%;background-position:center;background-repeat:no-repeat}
.worldMap .marker{position: absolute;width:5%;height:6%;background-image:url('../img/spot.png');background-size:100% 100%;background-position:center;background-repeat:no-repeat}
.store_wrap{margin-top:45px}
.store_list li{position:relative;width:100%;padding:17px 0;border-bottom:1px dotted #bdbdbd}
.store_list li:after{display:block;content:"";clear:both}
.store_arrow{position:absolute;top:50%;right:29px;margin-top:-8px;width:10px;height:16px;background: url('../img/store_arrow.png') no-repeat;background-position:0 0;text-indent:-100000px;font-size:0}
.store_list li a:hover .store_arrow{background-position:0 -16px}
.store_list li a:hover .store_name{color:#f86714}
.store_list li a:hover .store_add{color:#f86714}
.store_list li .cols{position:relative;}
.store_list li .col1{float:left;width:8.1818%;padding:10px 0}
.store_list li .col2_wrap{float:left;width:91.8182%}
.store_list li .col2_1{float:left;width:21.9801%}
.store_list li .col2_2{float:left;width:78.0198%}

.flag{position:absolute;top:50%;left:50%;margin-top:-16px;margin-left:-16px;width:32px;height:32px;}
.store_name{padding-top:3px;font-size:0.8125rem;color:#444}
.store_add{padding-right:40px;font-size:0.8125rem;color:#888;line-height:169%}

@media screen and (max-width:1180px) {

}

@media screen and (max-width:1100px) {
.overseas_process li{margin-left:20px}
.process_img:before{left:-15px}
.inq_txt{padding-top:5px}
}

@media screen and (max-width:960px) {
.lyr_br{display:inline-block}
.overseas_process{width:515px;margin:0 auto}
.overseas_process li{margin-left:110px}
.process_img:before{left:-65px}
.overseas_process li.p03 , .overseas_process li.p04{margin-top:35px}
.overseas_process li.p03{margin-left:0}
.overseas_process li.p03 .process_img:before{display:none}
}

@media screen and (max-width:768px) {
.overseas_inq > img{display:none}
.overseas_inq{height:107px;border:2px solid #d9d9d9}
.overseas_inq .inq_in{top:18.6666%}
.inq_br{display:block}
.lyr_line{margin-top:50px}
/* .store_list li .cols{position:relative;float:left;} */

/* .store_list li .col1{width:8.1818%;padding:10px 0} */


}

@media screen and (max-width:640px) {
.cont_stxt{margin:0}
.overseas_inq{margin:35px auto}
.inq_tit{font-size:1.125rem}
.overseas_process{width:65%;margin:0 auto}
.overseas_process li{margin-left:0}
.overseas_process li{margin-top:35px}
.overseas_process li:first-child{margin-top:0}
.overseas_process li .process_img:before{display:none}
.inq_txt{line-height:158%}
.store_list li .col1{width:11.8032%}
.store_list li .col2_wrap{width:88.1606%}
.store_list li .col2_1 , .store_list li .col2_2{float:none;width:100%}
.store_add{padding-top:15px}
.select_area{width:300px}
.select{width:140px}
}

@media screen and (max-width:480px) {
.overseas_list_con{margin-bottom:40px}
.lyr_tit{font-size:1.25rem;padding-top:35px;padding-bottom:22px}
.store_wrap{margin-top:20px}
.store_list li .col1{width:16%}
.store_list li .col2_wrap{width:84%}
.store_add{padding-right:20px}
.store_arrow{right:5px}
}




















.overseas_view_con{margin-bottom:300px;}
.lyr_tit{padding-top:77px;padding-bottom:45px}
.view_cons{width:100%}
.view_cons:after{display:block;content:"";clear:both}

.view_map{width:100%;height:406px;background:#eee}
.view_slide{overflow:hidden;position:relative;float:right;width:550px;margin-top:-100px}
.view_slide .slider-wrapper{overflow:hidden;}
.view_slide .slider-items{width:100%}
.view_slide .slider-items a:after{display:block;content:"";clear:both}
.view_slide .swiper-paging{margin-top:10px;font-size:0;text-align:center}
.view_slide .swiper-paging li{display:inline-block;margin-left:20px}
.view_slide .swiper-paging li:first-child{margin-left:0}
.view_slide .swiper-paging li a{display:block;width:10px;height:10px;text-indent:-90000px;background-image:url('../img/view_paging.png');background-repeat:no-repeat;background-size:10px 20px;background-position:0 0}
.view_slide .swiper-paging li.swiper-pagination-bullet.swiper-pagination-bullet-active a , .view_slide .swiper-paging li:hover a , .view_slide .swiper-paging li.on a{background-position:0 -10px}

.view_info{float:left;width:493px}
.info_top{margin:20px 0 66px 0}
.info_top span , .info_top p{display:inline-block;vertical-align:middle}

.view_con02{margin:50px 0 20px 0}
.info_flag{padding-left:12px}
.info_tit{padding-left:20px;color:#444;font-size:1.5625rem;line-height:100%}
.info_list li{width:100%;padding:20px 0;border-bottom:1px dotted #bdbdbd}
.info_list li:after{display:block;content:"";clear:both}
.info_list .cols{float:left}
.info_list .col1{width:35.6997%}
.info_list .col2{width:64.3002%}
.info_stit  , .info_txt{font-size:0.8125rem}
.info_stit{position:relative;color:#444;text-align:center}
.info_stit:after{display:block;content:"";position:absolute;top:0;left:23px;width:15px;height:15px;background-repeat:no-repeat;background-position:50% 50%;}
.stit01:after{background-image: url('../img/info_ico01.png')}
.stit02:after{background-image: url('../img/info_ico02.png')}
.stit03:after{background-image: url('../img/info_ico03.png')}
.info_txt{color:#666;line-height:169%}

.btn_wrap{margin-bottom:60px}
.btn_list{display:block;float:right;width:86px;height:38px;background: url('../img/btn_list.png') no-repeat 0 0;text-indent:-100000px;font-size:0}

@media screen and (max-width:1180px) {
.view_slide{width:50%}
.view_info{width:44.8181%}
}

@media screen and (max-width:1100px) {
.view_slide , .view_info{float:none}
.view_slide{width:80%;margin:0 auto}
.info_top{margin:40px 0}
.view_info{width:100%;margin-top:30px}

}

@media screen and (max-width:960px) {

}

@media screen and (max-width:768px) {

}

@media screen and (max-width:640px) {
.view_map{height:240px}
.info_tit{font-size:0.9375rem}
.view_slide{width:300px;margin:0 auto}

}

@media screen and (max-width:480px) {
.lyr_tit{padding-top:35px;padding-bottom:23px}
.info_top{margin:20px 0}
.view_info{margin-top:15px}
.info_list .col1{width:30%}
.info_list .col2{width:70%}
.info_stit:after{left:0}
}

</style>
		<!-- overseas_view_con start -->
		<div class="overseas_view_con">
			<div class="inner">
				<!-- <span class="lyr_line"></span> -->
				<div class="view_con01 view_cons">
					<div class="view_map" id="gmap"></div>
				</div>
				<div class="view_con02 view_cons">
					<div class="info_top">
						<span class="info_flag"><img src="<?=$skinPath?>/img/flag/<?=strtolower($list['view3_special_06']);?>.png" alt=""></span>
						<p class="info_tit"><?=$list['view3_title_01'];?></p>
					</div>
					<!-- view_slide start -->
					<div class="view_slide">
						<div class="slider-container swiper-container">
							<ul class="slider-wrapper swiper-wrapper">
								<?
								$fileList = array_filter(explode('||',$list['view3_file']));
								$check_i = 0;
								foreach($fileList as $file){
									$image = $pc.'/upload/'.$board.$file;
								?>
								<li class="slider-items swiper-slide slide01"><img src="<?=$image?>" alt="" class="w100"></li>
								<?
									$check_i++;
								}
								?>
							</ul>
						</div>
						<ul class="swiper-paging slider-paging">
								<?
								/*
								for($i = 1;$i<=$check_i;$i++){
								?>
									<li class="<?=$i==1?'on':'';?>"><a href="#none"><?=$i;?></a></li>
								<?
								}
								*/
								?>
						</ul>
					</div>
					<!-- //view_slide end -->
					<!-- view_info start -->
					<div class="view_info">
						<div class="info_con">
							<ul class="info_list">
								<li>
									<div class="col1 cols">
										<p class="info_stit stit01">매장주소</p>
									</div>
									<div class="col2 cols">
										<p class="info_txt"><?=$list['view3_addr_road'].$list['view3_addr_detail'];?></p>
									</div>
								</li>
								<li>
									<div class="col1 cols">
										<p class="info_stit stit02">전화번호</p>
									</div>
									<div class="col2 cols">
										<p class="info_txt"><?=$list['view3_special_04'];?></p>
									</div>
								</li>
								<li>
									<div class="col1 cols">
										<p class="info_stit stit03">인사말</p>
									</div>
									<div class="col2 cols">
										<p class="info_txt"><?=nl2br($list['view3_command_01']);?></p>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<!-- //view_info end -->
				</div>
				<div class="btn_wrap clearFix">
					<a href="?<?=get('type||idx');?>#storeList" class="btn_list">목록으로 가기</a>
				</div>
			</div>
		</div>
		<!-- //overseas_view_con end -->
		<script type="text/javascript" src="<?=$root;?>/plug_in/swiper/js/swiper.jquery.min.js"></script>


		<?
		$markerImgPath = '/design/other/marker.png';
		$markerImgSize = getImagesize(ROOT_INC.$markerImgPath);
		?>

		<script type="text/javascript">
		var map_x = <?=$list['view3_addr_x'];?>;
		var map_y = <?=$list['view3_addr_y'];?>;
		function initMap() {
		  var map_geo = {lat: map_y, lng: map_x};
		  var map = new google.maps.Map(document.getElementById('gmap'), {
			zoom: 11,
			scrollwheel: false,
			center: map_geo
		  });
		  var marker = new google.maps.Marker({
			// icon:<?=$pc.$markerImgPath?>,
			position: map_geo,
			map: map
		  });
		}
		(function($) {
			doc.ready(function() {
				var swiper = new Swiper($('.view_slide > .swiper-container'), {
					loop:true,
					autoplay: 5000,
					autoplayDisableOnInteraction: false,
					setWrapperSize: true,
					paginationClickable: true,
					pagination: {
						el: '.slider-paging',
						renderBullet: function (index, className) {
							return '<li class="'+className+'"><a href="#none">'+index+'</a></li>';
						},
					},
					preloadImages: false,
					lazyLoading: true
				});
			});
		}(jQuery));
		</script>
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?language=ko&amp;region=kr&amp;libraries=geometry&amp;key=<?=$settings_data['google_api_key']?>&callback=initMap"></script>
