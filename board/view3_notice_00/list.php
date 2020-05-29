<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- board wrapper start -->
<div id="boardWrap">
<?
if($total_data > 0) {
?>

    <!-- board list start -->
    <ul class="board_list">
<?
    $list_page = 10;
    $page_per_list = 10;
    $start = ($view3_page - 1) * $list_page;
    page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
    $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
    $out_sql = mysql_query($sql);
    while($list = mysql_fetch_assoc($out_sql)) {
        $option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
        $next_command_01 = cut($list['view3_command_01'], 126);
        $write_day = date('Y-m-d', strtotime($list['view3_write_day']));
        $currentImage = '';
        // 정규식을 이용해서 img 태그 전체 / src 값만 추출하기
        $matches = [];
        preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $option['user_list'], $matches);
        $blankImage = current($matches[1]);
        $matches = [];
        preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $list['view3_command_01'], $matches);
        $contImage = current($matches[1]);
        $fileList = explode('||',$list['view3_file']);
        if($fileList[2]!=''){
            $currentImage = $pc.'/upload/'.$board.$fileList[2];
        }else if(current(array_filter($fileList))!=''){
            $currentImage = $pc.'/upload/'.$board.current(array_filter($fileList));
        }else if($contImage != ''){
			if(strpos($contImage, '://') == false){
				$contImage = $pc.$contImage;
			}
            $currentImage = $contImage;
        }else{
            $currentImage = $blankImage;
        }
		$option['user_list'] = '<img src="'.$currentImage.'" class="w100" alt="게시글 대표 사진">';
?>
        <li>
            <a href="<?=$path_view?>">
                <div class="board_list_thumb"><?=$option['user_list']?></div>
                <div class="board_list_text">
                    <p class="board_list_title b_fs_xl b_ff_h b_c_h ellipsis"><?=$option['notice'].$list['view3_title_01']?></p>
                    <p class="board_list_desc b_fs_m b_ff_m b_lh_l b_c_m"><?=$next_command_01?></p>
                </div>
                <p class="board_list_right board_list_date b_fs_m b_ff_l b_c_l"><?=$write_day?></p>
            </a>
        </li>
<?
    }
?>
    </ul>
    <!-- //board list end -->

    <!-- paging start -->
	<div class="paging fs_def">
		<?=$out_page?>
	</div>
	<!-- //paging end -->

<?
} else {
	echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->