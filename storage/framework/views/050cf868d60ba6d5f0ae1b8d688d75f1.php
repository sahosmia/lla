<div class="am-featured-mentors <?php echo e(pagesetting('select_verient')); ?> <?php echo e(pagesetting('bg_color_verient')); ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
                    <div class="am-featured-mentors-head">
                        <div class="am-section_title <?php echo e(pagesetting('section_title_variation')); ?>">
                            <?php if(!empty(pagesetting('pre_heading'))): ?>
                                <span class="am-tag"
                                    <?php if((!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)') || (!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)')): ?>
                                        style="
                                            <?php if(!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)'): ?>
                                                color: <?php echo e(pagesetting('pre_heading_text_color')); ?>;
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)'): ?>
                                                background-color: <?php echo e(pagesetting('pre_heading_bg_color')); ?>;
                                            <?php endif; ?>
                                        "
                                    <?php endif; ?>>
                                    <?php echo e(pagesetting('pre_heading')); ?>

                                </span> 
                            <?php endif; ?> 
                            <?php if(!empty(pagesetting('heading'))): ?> <h2><?php echo pagesetting('heading'); ?></h2> <?php endif; ?>
                            <?php if(!empty(pagesetting('paragraph'))): ?> <p><?php echo pagesetting('paragraph'); ?></p> <?php endif; ?>
                        </div>
                        <?php if(!empty(pagesetting('explore_mentors_btn_text'))): ?>
                            <a href="<?php if(!empty(pagesetting('explore_mentors_btn_url'))): ?> <?php echo e(pagesetting('explore_mentors_btn_url')); ?> <?php endif; ?>" class="am-primary-btn-white">
                                <?php echo e(pagesetting('explore_mentors_btn_text')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php
                    $sectionVerient     = !empty(pagesetting('select_verient')) ? pagesetting('select_verient') : 'am-tutors-varient-two';
                    $viewProfileBtn     = !empty(pagesetting('view_tutor_btn_text')) ? pagesetting('view_tutor_btn_text') : 'View Profile';
                    $viewProfileBtnUrl  = !empty(pagesetting('view_tutor_btn_url')) ? pagesetting('view_tutor_btn_url') : '#';
                    $selectTutor        = !empty(pagesetting('select_tutor')) ? pagesetting('select_tutor') : 8;
                    $slider             = true; 
                ?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('experienced-tutors', ['sectionVerient' => $sectionVerient,'viewProfileBtn' => $viewProfileBtn,'viewProfileBtnUrl' => $viewProfileBtnUrl,'selectTutor' => $selectTutor,'slider' => $slider]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2590092607-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>
        </div>
    </div>
    <?php if(!empty(pagesetting('left_shape_image'))): ?>
        <?php if(!empty(pagesetting('left_shape_image')[0]['path'])): ?>
            <img src="<?php echo e(url(Storage::url(pagesetting('left_shape_image')[0]['path']))); ?>" class="am-bgimg1" alt="Background shape image">
        <?php endif; ?>
    <?php endif; ?>
    <?php if(!empty(pagesetting('right_shape_image'))): ?>
        <?php if(!empty(pagesetting('right_shape_image')[0]['path'])): ?>
            <img src="<?php echo e(url(Storage::url(pagesetting('right_shape_image')[0]['path']))); ?>" class="am-bgimg2" alt="Background shape image">
        <?php endif; ?>
    <?php endif; ?>
</div>






<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/featured-mentors/view.blade.php ENDPATH**/ ?>