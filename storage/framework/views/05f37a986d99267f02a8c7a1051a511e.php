<div class="am-similar-tutor">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-userinfomore_title">
                    <div class="am-userinfomore_heading"></div>
                </div>
                <div  class="am-skeletontwo">
                    <?php if(!empty($repeatItems)): ?>
                        <?php for($i = 0; $i < $repeatItems; $i ++): ?>
                            <div class="am-skeleton">
                                <div class="am-skeleton_profile">
                                    <div class="am-skeleton_profile_circle am-skeleton_line"> </div>
                                    <div class="am-skeleton_profile_bar">
                                        <div class="am-skeleton_line short"> </div>
                                        <div class="am-skeleton_line shorter"> </div>
                                    </div>
                                </div>
                                <div class="am-skeleton_inner">
                                    <div class="am-skeleton_line"> </div>
                                    <div class="am-skeleton_line"> </div>
                                    <div class="am-skeleton_line"> </div>
                                    <div class="am-skeleton_line"> </div>
                                    <div class="am-skeleton_line"> </div>
                                </div>
                                <div class="am-skeleton_btn">
                                    <div class="am-skeleton_line"> </div>
                                    <div>
                                        <div class="am-skeleton_line"> </div>
                                        <div class="am-skeleton_line"> </div>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\Sahos\Laravel\lla\resources\views/skeletons/related-tutors.blade.php ENDPATH**/ ?>