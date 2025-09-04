<?php
    use App\Livewire\Components\Courses;
?>
<?php if(\Nwidart\Modules\Facades\Module::has('Courses') && \Nwidart\Modules\Facades\Module::isEnabled('Courses') && Courses::hasCourses()): ?>
    <section class="am-feedback am-courses-block <?php echo e(pagesetting('select_verient')); ?>"> 
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-feedback-two_wrap">
                        <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
                            <div class="am-section_title am-section_title_center <?php echo e(pagesetting('section_title_variation')); ?>">
                                <?php if(!empty(pagesetting('pre_heading'))): ?> 
                                    <span 
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
                        <?php endif; ?>
                    </div>
                    <?php
                        $sectionVerient = !empty(pagesetting('select_verient')) ? pagesetting('select_verient') : 'am-courses-block';
                        $coursesLimit   = !empty(pagesetting('courses_limit')) ? pagesetting('courses_limit') : 6;
                    ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.courses', ['sectionVerient' => $sectionVerient,'coursesLimit' => $coursesLimit]);

$__html = app('livewire')->mount($__name, $__params, 'lw-754793617-0', $__slots ?? [], get_defined_vars());

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
        <?php if(!empty(pagesetting('first_shape_image'))): ?>
            <?php if(!empty(pagesetting('first_shape_image')[0]['path'])): ?>
                <img src="<?php echo e(url(Storage::url(pagesetting('first_shape_image')[0]['path']))); ?>" alt="First shape image" class="am-shapimg-1">
            <?php endif; ?>      
        <?php endif; ?>
        <?php if(!empty(pagesetting('second_shape_image'))): ?>
            <?php if(!empty(pagesetting('second_shape_image')[0]['path'])): ?>
                <img src="<?php echo e(url(Storage::url(pagesetting('second_shape_image')[0]['path']))); ?>" alt="Second shape image" class="am-shapimg-2">
            <?php endif; ?>      
        <?php endif; ?>
        <?php if(!empty(pagesetting('third_shape_image'))): ?>
            <?php if(!empty(pagesetting('third_shape_image')[0]['path'])): ?>
                <img src="<?php echo e(url(Storage::url(pagesetting('third_shape_image')[0]['path']))); ?>" alt="Third shape image" class="am-shapimg-3">
            <?php endif; ?>      
        <?php endif; ?>
    </section>
<?php endif; ?>

<?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/courses/view.blade.php ENDPATH**/ ?>