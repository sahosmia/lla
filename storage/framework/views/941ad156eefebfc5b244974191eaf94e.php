<div class="am-createquiz">
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.quiz-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="am-userperinfo am-quizsetting">
        <div class="am-title_wrap">
            <div class="am-title">
                <h2><?php echo e(__('quiz::quiz.basic_settings')); ?></h2>
                <p><?php echo e(__('quiz::quiz.basic_settings_description')); ?></p>
            </div>
        </div>
        <form class="am-themeform am-themeform_personalinfo">
            <fieldset>
                <div class="form-group">
                    <label class="am-label"><?php echo e(__('quiz::quiz.quiz_duration')); ?>

                        <i class="am-tooltip am-icon-exclamation-01">
                            <span class="am-tooltip-text">
                                <strong><?php echo e(__('quiz::quiz.this_set_quiz_duration')); ?></strong>
                                <span><?php echo e(__('quiz::quiz.quiz_duration_description')); ?></span>
                            </span>
                        </i>
                    </label>
                    <div class="form-group-two-wrap quiz-time">
                        <div class="form-control_wrap">
                            <label class="am-label" for=""><?php echo e(__('quiz::quiz.hours')); ?></label>
                            <span class="am-select" wire:ignore>
                                <select 
                                    data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" 
                                    class="am-select2" 
                                    data-parent=".quiz-time" 
                                    data-wiremodel="form.hours" 
                                    data-placeholder="<?php echo e(__('calendar.hour_placeholder')); ?>">
                                    <option label="<?php echo e(__('calendar.hour_placeholder')); ?>"></option>
                                    <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 24; $i++): ?>
                                        <option value="<?php echo e(sprintf('%02d', $i)); ?>" 
                                            <?php echo e(isset($form->hours) && $form->hours == sprintf('%02d', $i) ? 'selected' : ''); ?>>
                                            <?php echo e(sprintf('%02d', $i)); ?>

                                        </option>
                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </span>
                            <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'form.hours']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.hours']); ?>
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
                        </div>
                        <div class="form-control_wrap">
                            <label class="am-label" for=""><?php echo e(__('quiz::quiz.minutes')); ?></label>
                            <span class="am-select" wire:ignore>
                                <select 
                                    data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" 
                                    class="am-select2" 
                                    data-wiremodel="form.minutes" 
                                    data-parent=".quiz-time"
                                    data-placeholder="<?php echo e(__('calendar.minute_placeholder')); ?>">
                                    <option label="<?php echo e(__('calendar.minute_placeholder')); ?>"></option>
                                    <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 60; $i++): ?>
                                        <option value="<?php echo e(sprintf('%02d', $i)); ?>" 
                                            <?php echo e(isset($form->minutes) && $form->minutes == sprintf('%02d', $i) ? 'selected' : ''); ?>>
                                            <?php echo e(sprintf('%02d', $i)); ?>

                                        </option>
                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </span>
                            <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'form.minutes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.minutes']); ?>
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
                        </div>
                    </div>

                </div>
                
                <div class="form-group  <?php $__errorArgs = ['form.passing_grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <label class="am-label" for=""><?php echo e(__('quiz::quiz.passing_grade')); ?>

                        <i class="am-tooltip am-icon-exclamation-01">
                            <span class="am-tooltip-text">
                                <strong><?php echo e(__('quiz::quiz.this_passing_grade')); ?></strong>
                                <span><?php echo e(__('quiz::quiz.passing_grade_description')); ?></span>
                            </span>
                        </i>
                    </label>
                    <div class="form-control_wrap">
                        <div class="am-passing-grade">
                            <input class="form-control" wire:model="form.passing_grade" placeholder="100" type="text">
                            <span>%</span>
                        </div>
                        <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'form.passing_grade']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.passing_grade']); ?>
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
                    </div>        
                </div>
                <div class="form-group">
                    <label class="am-label"><?php echo e(__('quiz::quiz.hide_quiz_timer')); ?></label>
                    <div class="form-group-two-wrap">
                        <div class="am-quiz-switchbtn">
                            <input wire:model.live="form.hide_Quiz" type="checkbox" checked>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2><?php echo e(__('quiz::quiz.advanced_settings')); ?></h2>
                    <p><?php echo e(__('quiz::quiz.advanced_settings_description')); ?></p>
                </div>
            </div>
            <fieldset>
                <div class="form-group">
                    <label class="am-label"><?php echo e(__('quiz::quiz.question_order')); ?></label>
                    <div class="form-group-two-wrap <?php $__errorArgs = ['form.question_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:loading.class="am-disabled">
                        <div class="form-group-half">
                            <span class="am-select" wire:ignore>
                                <select class="am-select2" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" id="question_order" data-live="true" data-wiremodel="form.question_order" data-placeholder="<?php echo e(__('quiz::quiz.select_option')); ?>">
                                    <option value=""><?php echo e(__('quiz::quiz.select_option')); ?></option>
                                    <option value="asc" <?php if($form->question_order == 'asc'): ?> selected <?php endif; ?> ><?php echo e(__('quiz::quiz.ascending')); ?></option>
                                    <option value="desc" <?php if($form->question_order == 'desc'): ?> selected <?php endif; ?> ><?php echo e(__('quiz::quiz.descending')); ?></option>
                                    <option value="random" <?php if($form->question_order == 'random'): ?> selected <?php endif; ?> ><?php echo e(__('quiz::quiz.random')); ?></option>
                                </select>
                            </span>
                            <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'form.question_order']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.question_order']); ?>
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
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="am-label"><?php echo e(__('quiz::quiz.character_limit')); ?></label>
                    <div class="form-group-two-wrap">
                        <div class="form-group-half <?php $__errorArgs = ['form.limit_short_answers'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <label class="am-label" for=""><?php echo e(__('quiz::quiz.short_answer_character_limit')); ?></label>
                            <input class="form-control"  wire:model="form.limit_short_answers" placeholder="500" type="text">
                            <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'form.limit_short_answers']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.limit_short_answers']); ?>
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
                        </div>
                        <div class="form-group-half <?php $__errorArgs = ['form.limit_max_answers'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> ">
                            <label class="am-label" for=""><?php echo e(__('quiz::quiz.essay_max_characters')); ?></label>
                            <div class="form-control_wrap">
                                <input class="form-control" wire:model="form.limit_max_answers" placeholder="5000" type="text">
                                <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'form.limit_max_answers']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.limit_max_answers']); ?>
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
                            </div>        
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="am-label" for=""><?php echo e(__('quiz::quiz.auto_result_generate')); ?>

                        <i class="am-tooltip am-icon-exclamation-01 am-resulttooltip">
                            <span class="am-tooltip-text">
                                <span><?php echo e(__('quiz::quiz.auto_result_generate_description')); ?></span>
                            </span>
                        </i>
                    </label>
                    <div class="form-group-two-wrap">
                        <div class="am-quiz-switchbtn">
                            <input type="checkbox" wire:model.live="form.auto_result_generate" checked>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="am-label"><?php echo e(__('quiz::quiz.hide_question_numbers')); ?></label>
                    <div class="form-group-two-wrap">
                        <div class="am-quiz-switchbtn">
                            <input type="checkbox" wire:model.live="form.hide_question"  checked>
                        </div>
                    </div>
                </div>
                <div class="form-group am-form-btns">
                    <a href="<?php echo e(route('quiz.tutor.quizzes')); ?>" class="am-white-btn"><?php echo e(__('quiz::quiz.cancel')); ?></a>
                    <button type="button" wire:click="saveQuizSetting" wire:loading.class="am-btn_disable" wire:target="saveQuizSetting" class="am-btn"><?php echo e(__('quiz::quiz.save')); ?> &amp; <?php echo e(__('quiz::quiz.update')); ?></button>
                </div>
            </fieldset>
        </form>
    </div>
</div>    

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('modules/quiz/css/main.css')); ?>">
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/quiz-setting.blade.php ENDPATH**/ ?>