<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
if(!$_REQUEST['modal']) {
?>
				<div class="view_page_opt">
<?
	if($temp_prev) {
?>
					<a href="<?=URL_PATH.'?'.$path_prev?>" class="view_prevnext view_prev"><img src="<?=$root?>/img/board/paging_prev_.png" alt="" class="w100"><span>이전글</span></a>
<?
	}
?>
					<a href="<?=URL_PATH.'?'.$path_list?>" class="list"><img src="<?=$root?>/img/board/list_ico.png" alt="목록" class="w100"></a>
<?
	if($temp_next) {
?>
					<a href="<?=URL_PATH.'?'.$path_next?>" class="view_prevnext view_next"><span>다음글</span><img src="<?=$root?>/img/board/paging_next_.png" alt="" class="w100"></a>
<?
	}
?>
				</div>
<?
}
?>
