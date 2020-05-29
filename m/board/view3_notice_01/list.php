<link rel="stylesheet" href="<?skin_path?>/css/skin.css">

<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<div class="notice_wrap">
    <table class="notice_table">
        <caption class="indent">게시판 목록</caption>
        <colgroup>
            <col class="col1">
            <col class="col2">
        </colgroup>
        <thead>
            <tr>
                <th scope="col">번호</th>
                <th scope="col">제목</th>
            </tr>
        </thead>
        <tbody>
<?
$select_query_string = "SELECT * FROM `".TABLE_LEFT.$board."` WHERE `view3_use` = '1'";
$total_rows = mysql_num_rows(mysql_query($select_query_string));
if($total_rows > 0) {
    $notice_query_string = $select_query_string." AND `view3_notice` = '1' ORDER BY view3_order DESC, view3_write_day DESC";
    $notice_result = mysql_query($notice_query_string);
    $notice_rows = mysql_num_rows($notice_result);

    $plain_query_string = $select_query_string." AND `view3_notice` = '99' ORDER BY view3_order DESC, view3_write_day DESC";
    $plain_result = mysql_query($plain_query_string);
    $plain_rows = mysql_num_rows($plain_result);

    $list_num_per_page = 10 - $notice_rows;
    $pagination = 5;
    $start_offset = ($view3_page - 1) * $list_num_per_page;
    $end_offset = $list_num_per_page;
    page($plain_rows, $list_num_per_page, $pagination, $path_next, '', $view3_page, $end_page_path);

    while($notice_list = mysql_fetch_assoc($notice_result)) {
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$notice_list['view3_idx']);
?>
            <tr>
                <td class="num t_center"><span class="label">NOTICE</span></td>
                <td><a href="<?=$path_view?>" class="ellipsis"><?=$notice_list['view3_title_01']?></a></td>
            </tr>
<?
    }

    $query_string = $plain_query_string." LIMIT $start_offset, $end_offset";
    $result = mysql_query($query_string);
    $list_number = $plain_rows - $start_offset;
    while($list = mysql_fetch_assoc($result)) {
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
?>
            <tr>
                <td class="num t_center"><?=$list_number?></td>
                <td><a href="<?=$path_view?>" class="ellipsis"><?=$list['view3_title_01']?></a></td>
            </tr>
<?
        $list_number--;
    }
} else {
?>
            <tr>
                <td colspan="3" class="t_center">게시물이 없습니다.</td>
            </tr>
<?
}
?>
        </tbody>
    </table>
</div>

<!-- paging start -->
<div class="paging fs_def">
	<?=$out_page?>
</div>
<!-- //paging end -->