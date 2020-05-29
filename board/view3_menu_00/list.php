<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- board wrapper start -->
<div id="boardWrap" >
<?
if($total_data > 0) {
?>
	<ul class="menu_list over_h">
	<?
	$sql = $main_sql.$view_order;
	$result = mysql_query($sql);
	while($list = mysql_fetch_assoc($result)) {
		$list_file_array = explode('||', $list['view3_file']);
		echo PHP_EOL;
	?>
	<li>
		<div class="img" style="background-image:url('<?=$pc.'/upload/'.$board.$list_file_array[2]?>')"></div>
		<div class="text_area t_center">
			<div class="menu_title"><?=$list['view3_title_01']?></div>
			<p class="menu_text"><?=nl2br($list['view3_command_01'])?></p>
		</div>
	</li>
	<?}?>

	</ul>


<?
} else {
	echo '<p class="nodata">준비중입니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->