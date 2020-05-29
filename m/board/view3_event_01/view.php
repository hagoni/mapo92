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

$close_day = date('Y.m.d', strtotime($list['view3_close']));
$open_day = date('Y.m.d', strtotime($list['view3_open']));
$today = date('Y.m.d');
if(($list['view3_open'] == '0000-00-00 00:00:00' || $list['view3_open'] == '') && ($list['view3_close'] == '0000-00-00 00:00:00' || $list['view3_close'] == '')) {
	$event_date = '상시 진행';
} else {
	$close_date = ($list['view3_close'] == '0000-00-00 00:00:00' || $list['view3_close'] == '') ? '' : $close_day;
	$open_date = ($list['view3_open'] == '0000-00-00 00:00:00' || $list['view3_open'] == '') ? '' : $open_day;
	$event_date = $open_date.' ~ '.$close_date;
}
?>

<style>
.page_title_area{display:none}
</style>

<!-- board wrapper start -->
<div id="boardWrap">

	<!-- 공지사항 상세페이지 start -->
	<div class="notice_view">
		<h3 class="page_title view_title">
			<?=$list['view3_title_01']?>
		</h3>
		<p class="date t_center"><?=$status_text?></p>
		<div class="board_view_body">
<?
if($option['user_down'] || $option['user_view']) {
?>
			<div class="board_view_file">
<?
		echo $option['user_down'];
		echo $option['user_view'];
?>
			</div>
<?
}
?>
		</div>
		<div class="view_cont">
			<?=$next_command_01?>
		</div>
		<ul class="view_share fs_def t_center">
			<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-fb-share-btn"><img src="<?=$root?>/img/board/view_sns1.png" alt="페이스북 아이콘" class="w100"></a></li>
			<li><a href="http://blog.naver.com/openapi/share?url=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-bl-share-btn"><img src="<?=$root?>/img/board/view_sns2.png" alt="네이버 블로그 아이콘" class="w100"></a></li>
			<li><a href="https://story.kakao.com/share?url=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-ks-share-btn"><img src="<?=$root?>/img/board/view_sns3.png" alt="카카오스토리 아이콘" class="w100"></a></li>
		</ul>
	</div>
	<!-- //공지사항 상세페이지 end -->
<?
######################################################################################################################################################
include_once(BOARD_INC.'/setup_bottom.php');
######################################################################################################################################################
?>

</div>
<!-- //board wrapper end -->