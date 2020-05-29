    <!-- header start -->
    <div id="headerWrap" class="header_wrap">
        <div class="flag l50">
            <div class="flag_img"><img src="<?=$root?>/img/common/flag_sprite.png" alt=""></div>
            <div class="flag_front l50"></div>
            <div class="flag_back l50"></div>
        </div>
        <div class="header bg">
            <div class="hd_ovl bg"></div>
            <h1 class="logo l50 bg">
                <a href="<?=$root?>/" title="HOME">신 마포갈매기</a>
            </h1>
            <ul id="navigation" class="depth1_ul fs_def">
<?
$depth1_link_query = "SELECT * FROM `".TABLE_LEFT."group` WHERE view3_use = '1' AND view3_setup = '$html_idx' ORDER BY view3_order";
$depth1_result = mysql_query($depth1_link_query);
while($depth1_list = mysql_fetch_assoc($depth1_result)) {
$depth2_link_query = "SELECT * FROM `".TABLE_LEFT."board` WHERE view3_use = '1' AND view3_setup = '$html_idx' AND view3_group_idx = '".$depth1_list['view3_idx']."' ORDER BY view3_order";
$depth2_result = mysql_query($depth2_link_query);
unset($depth1_link);
while($depth2_list = mysql_fetch_assoc($depth2_result)) {
switch($depth2_list['view3_style']) {
case 'html':
    if(file_exists(ROOT_INC.'/html/'.$depth2_list['view3_link'])) {
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
    if(file_exists(ROOT_INC.'/html/'.$depth2_list['view3_link'])) {
        $depth1_link = $root.'/html/'.$depth2_list['view3_link'];
    }
}
if($depth1_link) {
if($depth2_list['view3_sca']) {
    if(strpos($depth1_link, '?') > -1) $depth1_link .= '&amp;sca='.$depth2_list['view3_sca'];
    else $depth1_link .= '?sca='.$depth2_list['view3_sca'];
}
if($depth1_list['view3_order_css'] == $gnb_index) $group_list['front_link'] = $depth1_link;
break;
}
}
?>
                <li class="depth1_li depth1_li<?=$depth1_list['view3_order_css']?><?if($depth1_list['view3_order_css'] == $gnb_index){echo ' on';}?>">
                    <span class="shadow"></span>
                    <a href="<?=$depth1_link?>" class="depth1_a">
                        <span class="depth1_ttl">
                            <img src="<?=$root?>/img/common/hd_li<?=$depth1_list['view3_order_css']?>.png" alt="<?=$group_list['view3_title_02']?>" class="neon_off">
                            <span class="neon_on2_wrap">
                                <img src="<?=$root?>/img/common/hd_li<?=$depth1_list['view3_order_css']?>_on.png" alt="<?=$group_list['view3_title_02']?>" class="neon_on2">
                            </span>
                        </span>
                    </a>
                </li>
<?
}
?>
            </ul>
        </div>
    </div>
    <!-- //header end -->