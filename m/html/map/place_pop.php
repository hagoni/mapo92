<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
@include_once														"../../../view3.php";
?>
<div class="ex_ttl"><?=$_POST['title']?> 분석</div>
<ul class="lyr6_list">
    <li class="fs_def">
        <p class="list_ttl">운영시간</p>
        <p class="list_con"><?=$_POST['view3_special_04']?></p>
    </li>
    <li class="fs_def">
        <p class="list_ttl">운영형태</p>
        <p class="list_con"><?=$_POST['view3_special_05']?></p>
    </li>
    <li class="fs_def">
        <p class="list_ttl">추천평수</p>
        <p class="list_con"><?=$_POST['view3_special_06']?></p>
    </li>
    <li class="fs_def">
        <p class="list_ttl">목표매출액</p>
        <p class="list_con"><?=$_POST['view3_special_07']?></p>
    </li>
    <?if($_POST['view3_check_01'] == 1) {?>
    <span class="taken l50"><img src="<?=$root?>/img/page/fran/taken.png" alt="입점완료"></span>
    <?}?>
</ul>
