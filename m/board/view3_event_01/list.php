<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- 이벤트 리스트 start -->
<div class="event_wrap inner">
    <div class="event_list_wrap">
<?
if($total_data > 0) {
?>
        <ul class="event_list">
<?
    $list_page = 6;
    $page_per_list = 5;
    $start = ($view3_page - 1) * $list_page;
    page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
    $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
    $out_sql = mysql_query($sql);
    while($list = mysql_fetch_assoc($out_sql)) {
        $option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
        $write_day = date('Y-m-d', strtotime($list['view3_write_day']));
        $file_list = explode('||', $list['view3_file']);
        $list_img = '/upload/'.$board.$file_list[2];

        $close_day = date('Y.m.d', strtotime($list['view3_close']));
        $open_day = date('Y.m.d', strtotime($list['view3_open']));
        $today = date('Y.m.d');
        if(($list['view3_open'] == '0000-00-00 00:00:00' || $list['view3_open'] == '') && ($list['view3_close'] == '0000-00-00 00:00:00' || $list['view3_close'] == '')) {
            $status_text = '상시';
            $event_class = 'on';
        } else if(($list['view3_close'] == '0000-00-00 00:00:00' || $list['view3_close'] == '') && $today >= $open_day) {
            $status_text = '진행 중';
            $event_class = 'on';
        } else if($today > $close_day) {
            $status_text = '마감';
            $event_class = 'off';
        } else if($today < $open_day) {
            $status_text = '예정';
            $event_class = 'on';
        } else {
            $write_day = new DateTime($list['view3_write_day']);
            $close_day = new DateTime($list['view3_close']);
            $today = new DateTime('NOW');
            $interval = date_diff($today, $close_day);
            $status_text = 'D-'.($interval->days);
            $event_class = 'on';
        }
?>
                        <li class="<?=$event_class;?>">
                            <a href="<?=$path_view?>">
                                <div class="img_area">
                                    <?=$option['user_list']?>
                                </div>
                                <div class="text_area rel">
                                    <p class="list_title ellipsis"><?=$list['view3_title_01'];?></p>
                                    <p class="list_text ellipsis"><?=strip_tags(htmlspecialchars_decode($list['view3_command_01']));?></p>
                                    <p class="d_day"><?=$status_text;?></p>
                                </div>
                            </a>
                        </li>
<?
    }
?>
        </ul>
<?
} else {
    switch($view3_tab){
        case '2':$no_data_text = '완료된 이벤트가 없습니다.';break;
        case '3':$no_data_text = '등록된 이벤트가 없습니다.';break;
        default:$no_data_text = '진행 중인 이벤트가 없습니다.';break;
    }
    echo '<p class="nodata">'.$no_data_text.'</p>'.PHP_EOL;
}
?>
    </div>
</div>
<!-- //이벤트 리스트 end -->
<div class="paging fs_def">
    <?=$out_page?>
</div>