<!-- pop_inq start -->
<div class="pop_inq" style="display:none">
    <div class="pop_inq_inner">
        <button type="button" class="pop_inq_close">닫기</button>
        <h2 class="pop_inq_title"><img src="<?=$root?>/img/common/pop_inq_ttl.png" alt="" class="w100"></h2>
        <!-- pop_inq_bot start -->
        <div class="pop_inq_bot">
            <form method="post" action="<?=$root?>/sms/sms_trans.php" id="inqSms" class="bnr_inquiry">
                <input type="hidden" name="local_divide" value="right">
                <input type="hidden" name="send" value="right">
                <input type="hidden" name="channel" value="mobile">
                <fieldset class="iqr_info">
                    <input type="text" name="name" id="iqr_name" required="required" placeholder="이름" autocomplete="off">
                    <input type="text" name="hp" id="iqr_hp" required="required" onkeyup="hero_key(this,1);" placeholder="전화번호" autocomplete="off">
                    <select name="special_01" id="iqr_special" class="legion">
                        <option value="">가맹희망지역</option>
                        <option value="서울">서울</option>
                        <option value="부산">부산</option>
                        <option value="대구">대구</option>
                        <option value="인천">인천</option>
                        <option value="광주">광주</option>
                        <option value="대전">대전</option>
                        <option value="울산">울산</option>
                        <option value="세종">세종</option>
                        <option value="경기">경기</option>
                        <option value="강원">강원</option>
                        <option value="충북">충북</option>
                        <option value="충남">충남</option>
                        <option value="전북">전북</option>
                        <option value="전남">전남</option>
                        <option value="경북">경북</option>
                        <option value="경남">경남</option>
                        <option value="제주">제주</option>
                    </select>
                    <div class="check_ovh over_h">
                        <div class="type_chk f_left">
                            <input type="checkbox" id="chk_sms_agree1" name="chk_sms_agree">
                            <label for="chk_sms_agree1" class="chk_label"></label>
                            <a href="#none" class="btn_policy bindPolicyModalOpen" data-type="3">개인정보취급방침에 동의합니다.</a>
                        </div>
                        <button type="submit" class="pop_btn bindSmsSubmit">가맹문의하기</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <!-- //pop_inq_bot end -->
        <p class="pop_inq_tel"><img src="<?=$root?>/img/common/pop_inq_bot.png" alt="" class="w100"></p>
    </div>
</div>
<!-- //pop_inq end -->
