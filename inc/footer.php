    <!-- bnr_inquiry start -->
    <div class="bnr_inquiry bg">
        <div class="inner over_h">
            <form method="post" action="<?=$request_root?>/sms/sms_trans.php" class="bnr_form" id="directSms1">
                <input type="hidden" name="send" value="right">
                <fieldset>
                    <legend class="indent">신마포갈매기 가맹상담문의</legend>
                    <div class="clearfix">
                        <div class="type_txt_wrap over_h f_left">
                            <div class="type_txt f_left m_r05">
                                <label for="name0" class="type_txt_label">이름</label>
                                <input type="text" name="name" id="name0" class="labeling" autocomplete="off">
                            </div>
                            <div class="type_txt f_left m_r05">
                                <label for="hp0" class="type_txt_label">연락처</label>
                                <input type="text" name="hp" id="hp0" class="labeling">
                            </div>
                        </div>
                        <div class="type_chk f_left">
                            <input type="checkbox" name="chk_sms_agree" id="chk_sms_agree0">
                            <label for="chk_sms_agree0" class="chk_label">개인정보수집 동의</label>
                        </div>
                        <p class="check_p f_left">개인정보취급방침에<br>동의합니다</p>
                        <button type="submit" class="bindSmsSubmit btn_send f_left">문의하기</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <!-- //bnr_inquiry end -->
    <!-- footer start -->
    <div class="footer_wrap" id="footerWrap">
        <div class="footer">
            <div class="inner">
                <ul class="policy fs_def">
                    <li><a href="#none" class="bindPolicyModalOpen" data-type="0">개인정보처리방침</a></li>
                    <li><a href="#none" class="bindPolicyModalOpen" data-type="1">이메일무단수집거부</a></li>
                    <li><a href="#none">가맹점주 공간</a></li>
                    <li><a href="#none">가맹문의</a></li>
                </ul>
                <p class="address">
                    본사 : 인천광역시 남동구 논현로46번길 39-24&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;대표전화 : 1544-6092<br>
                    전화 : 032-819-6870&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;팩스 : 032-815-6870&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;이메일 : franchise@didimfood.co.kr
                </p>
                <div class="fam_links abs">
                    <a href="#none">패밀리 사이트</a>
                    <ul class="fam_depth">
                        <li><a href="http://didimglobal.com/" target="_blank">디딤</a></li>
                        <li><a href="http://www.yeonansikdang.co.kr/" target="_blank">연안식당</a></li>
                        <li><a href="http://misoolkwan.co.kr/" target="_blank">미술관</a></li>
                        <li><a href="http://xn--hy1b43d89c.com/" target="_blank">레드문</a></li>
                        <li><a href="http://www.goraesikdang.co.kr/" target="_blank">고래식당</a></li>
                        <li><a href="http://www.goraegamja.co.kr/" target="_blank">고래감자탕</a></li>
                        <li><a href="http://www.chadol6kiro.co.kr/" target="_blank">차돌6키로</a></li>
                    </ul>
                </div>
                <p class="copy abs">Copyright ⓒ 2020 MAGAL</p>
            </div>
        </div>
    </div>
    <!-- //footer end -->
