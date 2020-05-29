<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
@include_once														"../../../view3.php";

$recommend_board = 'recommend_01';
if($_REQUEST['local1'] && $_REQUEST['local3']) {
    $recommend_select_query = "SELECT * FROM `".TABLE_LEFT.$recommend_board."` WHERE view3_use = '1' AND view3_special_02 = '".$_REQUEST['local1']."' AND view3_special_03 = '".$_REQUEST['local2']."' AND view3_title_01 = '".$_REQUEST['local3']."'";
} else if($_REQUEST['local1'] && !$_REQUEST['local3']) {
    $recommend_select_query = "SELECT * FROM `".TABLE_LEFT.$recommend_board."` WHERE view3_use = '1' AND view3_special_02 = '".$_REQUEST['local1']."'";
} else {
    $recommend_select_query = "SELECT * FROM `".TABLE_LEFT.$recommend_board."` WHERE view3_use = '1'";
}
$recommend_order_query = " ORDER BY view3_idx";
$recommend_result = mysql_query($recommend_select_query.$recommend_order_query);
$map_data = Array();
while($recommend_list = mysql_fetch_assoc($recommend_result)) {
    $recommend_list['title'] = $recommend_list['view3_special_02'].' '.($recommend_list['view3_special_03'] ? $recommend_list['view3_special_03'].' ' : '').$recommend_list['view3_title_01'];
    $map_data[] = $recommend_list;
}
echo json_encode($map_data);
?>