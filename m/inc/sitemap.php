<!-- 사이트맵 start -->
<div id="sitemapWrap" class="sitemap_wrap" style="display:none">
	<div class="sitemap">
		<ul class="stm_list fs_def t_center">
			<li class="li1"><a href="<?=$root?>/html/menu_1.html">메뉴</a></li>
			<li class="li2"><a href="<?=$root?>/html/fran.html">창업</a></li>
			<li class="li3"><a href="<?=$root?>/board/index.php?board=map_01&sca=all">매장</a></li>
		</ul>
		<ul class="stm_depth1_ul">
<?
$depth1_link_query = "SELECT * FROM `".TABLE_LEFT."group` WHERE view3_use_m = '1' AND view3_setup = '$html_idx' ORDER BY view3_order_m";
$depth1_result = @mysql_query($depth1_link_query);
while($depth1_list = @mysql_fetch_assoc($depth1_result)) {
    $depth2_link_query = "SELECT * FROM `".TABLE_LEFT."board` WHERE view3_use_m = '1' AND view3_setup = '$html_idx' AND view3_group_idx = '".$depth1_list['view3_idx']."' ORDER BY view3_order_m";
    $depth2_result = @mysql_query($depth2_link_query);
	$depth2_count = @mysql_num_rows($depth2_result);
	unset($depth1_link);
	while($depth2_list = mysql_fetch_assoc($depth2_result)) {
		switch($depth2_list['view3_style']) {
			case 'html':
				if(file_exists(ROOT_M_INC.'/html/'.$depth2_list['view3_link'])) {
					$depth1_link = $root.'/html/'.$depth2_list['view3_link'];
				}
				break;
			case 'board':
				$depth1_link = BOARD.'/index.php?board='.$depth2_list['view3_link'];
				break;
			case 'http':
				$depth1_link = $depth2_list['view3_link'].'" target="_blank';
				break;
			case 'url':
				$depth1_link = $depth2_list['view3_link'];
				break;
			default:
				if(file_exists(ROOT_M_INC.'/html/'.$depth2_list['view3_link'])) {
					$depth1_link = $root.'/html/'.$depth2_list['view3_link'];
				}
		}
		if($depth1_link) {
			if($depth2_list['view3_sca']) {
				if(strpos($depth1_link, '?') > -1) $depth1_link .= '&amp;sca='.$depth2_list['view3_sca'];
				else $depth1_link .= '?sca='.$depth2_list['view3_sca'];
			}
			break;
		}
	}
?>
			<li class="stm_depth1_li<?if($depth1_list['view3_order_css'] == $gnb_index){echo ' on';}?>">
				<a href="<?=$depth1_link?>" class="stm_depth1_a"><img src="<?=$root?>/img/common/stm_li<?=$depth1_list['view3_order_css']?>.png" alt="<?=$depth1_list['view3_title_02']?>" class="w100"></a>
				<ul class="stm_depth2_ul stm_depth2_ul<?=$depth1_list['view3_order_css']?>">
<?
	    $depth2_result = @mysql_query($depth2_link_query);
		$depth2_i = 1;
	    while($depth2_list = @mysql_fetch_assoc($depth2_result)) {
	        switch($depth2_list['view3_style']) {
	            case 'html':
	                $depth2_link = $root.'/html/'.$depth2_list['view3_link'];
	                break;
	            case 'board':
	                $depth2_link = BOARD.'/index.php?board='.$depth2_list['view3_link'];
	                break;
	            case 'http':
	                $depth2_link = $depth2_list['view3_link'].'" target="_blank';
	                break;
	            case 'url':
	                $depth2_link = $depth2_list['view3_link'];
	                break;
	            default:
	                $depth2_link = $root.'/html/'.$depth2_list['view3_link'];
	        }
	        if($depth2_list['view3_sca']) {
	            if(strpos($depth2_link, '?') > -1) $depth2_link .= '&amp;sca='.$depth2_list['view3_sca'];
	            else $depth2_link .= '?sca='.$depth2_list['view3_sca'];
	        }
			$depth2_link .= '#'.$depth2_i;
?>
                    <li class="stm_depth2_li stm_depth2_li<?=$depth2_list['view3_order_css']?><?if($depth1_list['view3_order_css'] == $gnb_index && $depth2_list['view3_order_css'] == $minor_index){echo ' on';}?>">
                        <a href="<?=$depth2_link?>" class="stm_depth2_a"><?=strip_tags(html_entity_decode($depth2_list['view3_title_01']))?></a>
                    </li>
<?
        $depth2_i++;
    }
?>
                </ul>
			</li>
<?
}
?>
		</ul>
        <a href="tel:1544.6092" class="stm_inq">가맹문의</a>
	</div>
</div>
<!-- //사이트맵 end -->
