<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
@include_once														"../../view3.php";

$recommend_board = 'recommend_01';
$recommend_select_query = "SELECT * FROM `".TABLE_LEFT.$recommend_board."` WHERE view3_use = '1' AND view3_special_02 = '".$_REQUEST['local1']."' ORDER BY view3_special_03";
$recommend_result = mysql_query($recommend_select_query);
$local2_data = Array();
while($recommend_list = mysql_fetch_assoc($recommend_result)) {
    $local2_data[] = Array(
        'local2' => $recommend_list['view3_special_03'],
        'local3' => $recommend_list['view3_title_01']
    );
}
echo json_encode($local2_data);
?>