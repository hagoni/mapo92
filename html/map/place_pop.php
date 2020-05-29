<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
@include_once														"../../view3.php";
?>

<div class="store_info">
    <p class="store_name t_center"><?=$_POST['title']?> 분석</p>
    <ul class="over_h">
        <li>
            <dl class="over_h">
                <dt>운영시간</dt>
                <dd><?=$_POST['view3_special_04']?></dd>
            </dl>
        </li>
        <li>
            <dl class="over_h">
                <dt>추천평수</dt>
                <dd><?=$_POST['view3_special_06']?></dd>
            </dl>
        </li>
        <li>
            <dl class="over_h">
                <dt>운영형태</dt>
                <dd><?=$_POST['view3_special_05']?></dd>
            </dl>
        </li>
        <li>
            <dl class="over_h">
                <dt>목표매출액</dt>
                <dd><?=$_POST['view3_special_07']?></dd>
            </dl>
        </li>
    </ul>
    <?if($_POST['view3_check_01'] == 1) {?>
    <span class="taken l50"><img src="<?=$root?>/img/page/fran/taken.png" alt="입점완료"></span>
    <?}?>
</div>