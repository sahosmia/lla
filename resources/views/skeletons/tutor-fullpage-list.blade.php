<div class="col-12 col-lg-8 col-xl-9" id="am-tutor_list">
    <div class="am-tutorlist">
        <div class="am-tutorsearch">
            @if(!empty($repeatItems))
                @for ($i = 0; $i < $repeatItems; $i ++)
                    <div class="am-tutorsearch_card">
                        <div class="am-tutorsearch_video">
                            <div class="am-tutorsearch_videoclip"> </div>
                            <div class="am-tutorsearch_btns">
                                <div class="am-tutorsearch_btn1"> </div>
                                <div class="am-tutorsearch_btn2"> </div>
                                <div class="am-tutorsearch_btn3"> </div>
                            </div>
                        </div>
                        <div class="am-tutorsearch_content">
                            <div class="am-tutorsearch_head">
                                <div class="am-tutorsearch_user">
                                    <div class="am-tutorsearch_user_img"> </div>
                                    <div class="am-tutorsearch_user_name">
                                        <h3>
                                            <span class="am-tutorsearch_username"> </span>
                                            <span class="am-tutorsearch_svg"> </span>
                                            <span class="am-tutorsearch_img"> </span>
                                        </h3>
                                        <div class="am-tutorsearch_tag"> </div>
                                    </div>
                                </div>
                                <div class="am-tutorsearch_fee">
                                    <div class="am-tutorsearch_feestitle"> </div>
                                    <div class="am-tutorsearch_fees"> </div>
                                </div>
                            </div>
                            <ul class="am-tutorsearch_info">
                                <li>
                                    <div class="am-tutorsearch_info_icon">
                                        <div class="am-tutorsearch_icons"> </div>
                                    </div>
                                    <span class="am-tutorsearch_reviews"> </span>
                                </li>
                                <li>
                                    <div class="am-tutorsearch_info_icon">
                                        <div class="am-tutorsearch_icons"> </div>
                                    </div>
                                    <span class="am-tutorsearch_reviews"> </span>
                                </li>
                                <li>
                                    <div class="am-tutorsearch_info_icon">
                                        <div class="am-tutorsearch_icons"> </div>
                                    </div>
                                    <span class="am-tutorsearch_reviews"> </span>
                                </li>
                                <li>
                                    <div class="am-tutorsearch_info_icon">
                                        <div class="am-tutorsearch_icons"> </div>
                                    </div>
                                    <span class="am-tutorsearch_reviews"> </span>
                                </li>
                            </ul>
                            <div class="am-tutorsearch_description">
                                <span> </span>
                                <span> </span>
                                <em> </em>
                            </div>
                        </div>
                    </div>
                @endfor
            @endif
        </div>
    </div>
</div>
