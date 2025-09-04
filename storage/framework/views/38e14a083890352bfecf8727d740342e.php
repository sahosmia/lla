<div class="am-quiz_setting_section">
    <div class="am-quiz_setting_title">
        <div class="am-quiz_setting_heading">
            <h5><?php echo e(__('quiz::quiz.question_settings')); ?></h5>
            <p><?php echo e(__('quiz::quiz.question_settings_desc')); ?></p>
        </div>
    </div>
    <div class="am-quiz_setting_listing">
        <div class="am-quiz_setting_item">
            <span>
            <?php echo e(__('quiz::quiz.points_for_correct_answer')); ?>

                <i class="am-tooltip am-icon-exclamation-01">
                    <span class="am-tooltip-text">
                        <span><?php echo e(__('quiz::quiz.point_awarded_tooltip')); ?></span>
                    </span>
                </i>
            </span>
            <input class="form-control" wire:model="points" placeholder="10" type="text">
            
        </div>
        <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'points']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'points']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal87266e1d5ace8a508026121cd3fa4221)): ?>
<?php $attributes = $__attributesOriginal87266e1d5ace8a508026121cd3fa4221; ?>
<?php unset($__attributesOriginal87266e1d5ace8a508026121cd3fa4221); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal87266e1d5ace8a508026121cd3fa4221)): ?>
<?php $component = $__componentOriginal87266e1d5ace8a508026121cd3fa4221; ?>
<?php unset($__componentOriginal87266e1d5ace8a508026121cd3fa4221); ?>
<?php endif; ?> 
        <div class="am-quiz_setting_item">
            <span>
                <?php echo e(__('quiz::quiz.answer_required')); ?>

                <i class="am-tooltip am-icon-exclamation-01">
                <span class="am-tooltip-text">
                    <span><?php echo e(__('quiz::quiz.answer_required_tooltip')); ?></span>
                </span>
            </i>
            </span>
            
            <div class="am-quiz-switchbtn">
                <input type="checkbox" wire:model="answerRequired">
            </div>
        </div>
        <!--[if BLOCK]><![endif]--><?php if($questionType == 'mcq'): ?>
            <div class="am-quiz_setting_item">
                <span>
                    <?php echo e(__('quiz::quiz.random_choice')); ?>

                    <i class="am-tooltip am-icon-exclamation-01">
                        <span class="am-tooltip-text">
                            <span><?php echo e(__('quiz::quiz.random_choice_tooltip')); ?></span>
                        </span>
                    </i>
                </span>
                <div class="am-quiz-switchbtn">
                    <input type="checkbox" wire:model="displayPoints">
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <div class="am-quiz_setting_item">
            <span>
                <?php echo e(__('quiz::quiz.display_points')); ?>

                <i class="am-tooltip am-icon-exclamation-01">
                    <span class="am-tooltip-text">
                        <span><?php echo e(__('quiz::quiz.display_points_tooltip')); ?></span>
                    </span>
                </i>
            </span>
            <div class="am-quiz-switchbtn">
                <input type="checkbox" wire:model="randomChoice">
            </div>
        </div>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/score-settings.blade.php ENDPATH**/ ?>