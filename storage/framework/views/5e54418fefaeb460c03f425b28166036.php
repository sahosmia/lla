<div class="am-createquiz">
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.quiz-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="am-createquiz">
        <div class="am-userperinfo am-quizsetting">
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2><?php echo e(__('quiz::quiz.qiz_details')); ?></h2>
                    <p><?php echo e(__('quiz::quiz.quiz_with_title_description')); ?></p>
                </div>
            </div>
            <form x-cloak wire:ignore.self class="am-themeform am-themeform_personalinfo" id="create-quiz-form"
                x-data="{
                    selectedValues: <?php echo e(!empty($selectedSubjectSlots) ? json_encode($selectedSubjectSlots) : '[]'); ?>,
                    init() {
                        this.selectedValues = Array.isArray(this.selectedValues) ? this.selectedValues : Object.values(this.selectedValues);
                        Livewire.on('slotsList', () => {
                            this.selectedValues = [];
                            setTimeout(() => {
                                this.onChnageSetValue();
                            }, 50);
                        });
                        this.onChnageSetValue();
                    },
                    onChnageSetValue(){
                        $('#user_subject_slots').select2().on('change', (e)=> {
                            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('form.user_subject_slots', $(e.target).val());
                            let textInput = jQuery(e.target).siblings('span').find('textarea');
                            if(textInput){
                                setTimeout(() => {
                                    textInput.val('');
                                    textInput.attr('placeholder', 'Select session');
                                }, 50);
                            }
                            this.updateSelectedValues()
                        });
                    },
                    updateSelectedValues(){
                        let selectElement = document.getElementById('user_subject_slots');
                        this.selectedValues = Array.from(selectElement.selectedOptions).filter(option => option.value).map(option => ({
                                id: option.value,
                                text: option.text,
                            })
                        );
                    },
                    removeValue(value) {
                        const selectElement = document.getElementById('user_subject_slots');
                        const optionToDeselect = Array.from(selectElement.options).find(option => Number(option.value) === Number(value));
                        if (optionToDeselect) {
                            optionToDeselect.selected = false;
                            $(selectElement).trigger('change');
                        }
                    },
                }">
                <fieldset>
                    <div class="form-group <?php $__errorArgs = ['form.title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <label class="am-label am-important"><?php echo e(__('quiz::quiz.quiz_title')); ?></label>
                        <div class="form-control_wrap">
                            <input class="form-control" wire:model="form.title" placeholder="Add title here" type="text">
                            <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'form.title']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.title']); ?>
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
                    <!--[if BLOCK]><![endif]--><?php if(isActiveModule('Courses')): ?>
                        <div class="form-group <?php $__errorArgs = ['form.quizzable_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['class' => 'am-important','for' => 'quizzable_type','wire:loading.class' => 'am-disabled']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'am-important','for' => 'quizzable_type','wire:loading.class' => 'am-disabled']); ?><?php echo e(__('quiz::quiz.quiz_type')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                            <div class="am-radiowrap">
                                <div class="am-radio">
                                    <input value="<?php echo e(Modules\Courses\Models\Course::class); ?>" wire:model.live="form.quizzable_type" id="quizfor_course" type="radio" name="quizfor">
                                    <label for="quizfor_course">
                                        <span>Course</span>
                                    </label>
                                </div>
                                <div class="am-radio">
                                    <input value="<?php echo e(App\Models\UserSubjectGroupSubject::class); ?>" wire:model.live="form.quizzable_type" id="quizfor_subject" type="radio" name="quizfor">
                                    <label for="quizfor_subject">
                                        <span>Subject</span>
                                    </label>
                                </div>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'form.quizzable_type']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.quizzable_type']); ?>
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
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div 
                        x-init="$wire.dispatch('initSelect2', {target: '#quizzable_id', data: <?php echo \Illuminate\Support\Js::from($quizzable_ids)->toHtml() ?>});" 
                        class="form-group <?php $__errorArgs = ['form.quizzable_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        wire:loading.class="am-disabled" 
                        wire:loading.target="form.quizzable_type"
                        >
                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['class' => 'am-important','for' => 'quizzable_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'am-important','for' => 'quizzable_id']); ?><?php echo e(isActiveModule('Courses') ? __('quiz::quiz.select_option') :  __('quiz::quiz.select_subject')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                        <div class="form-control_wrap">
                            <span class="am-select" wire:ignore>
                                <select class="am-select2" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" id="quizzable_id" data-live="true" data-searchable="true" data-wiremodel="form.quizzable_id" data-placeholder="<?php echo e(__('quiz::quiz.select_option')); ?>">
                                    <option value=""><?php echo e(__('quiz::quiz.select_option')); ?></option>
                                </select>
                            </span>
                            <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'form.quizzable_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.quizzable_id']); ?>
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
                    <!--[if BLOCK]><![endif]--><?php if($form->quizzable_type == 'App\Models\UserSubjectGroupSubject'): ?>
                        <div class="form-group <?php $__errorArgs = ['form.user_subject_slots'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:loading.class="am-disabled" wire:loading.target="form.quizzable_id">
                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'Slots','class' => 'am-important','value' => __('quiz::quiz.select_session')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'Slots','class' => 'am-important','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('quiz::quiz.select_session'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                            <div class="form-control_wrap">
                                <div id="user_slot" wire:ignore>
                                    <span class="am-select am-multiple-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-disable_onchange="true" class="slots am-select2" data-hide_search_opt="true" id="user_subject_slots" <?php if(!$form->quizzable_id): ?> disabled <?php endif; ?> data-live="true" multiple data-placeholder="<?php echo e(__('quiz::quiz.select_session')); ?>">
                                            <option value="" ><?php echo e(__('quiz::quiz.select_session')); ?></option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if(!empty($slot['selected'])): ?> selected <?php endif; ?> value="<?php echo e($slot['id']); ?>"><?php echo e($slot['text']); ?></option>      
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                        <template x-if="selectedValues.length > 0">
                                            <ul class="am-subject-tag-list">
                                                <template x-for="(slot, index) in selectedValues">
                                                    <li>
                                                        <a href="javascript:void(0)" class="am-subject-tag" @click="removeValue(slot.id)">
                                                            <span x-text="slot.text"></span>
                                                            <i class="am-icon-multiply-02"></i>
                                                        </a>
                                                    </li>
                                                </template>
                                            </ul>
                                        </template>
                                    </span>
                                </div>
                                <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'form.user_subject_slots']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.user_subject_slots']); ?>
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
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    
                    <div x-init="$wire.dispatch('initSummerNote', {target: '#profile_desc', wiremodel: 'form.description', conetent: `<?php echo e($form?->description); ?>`, componentId: window.Livewire.find('<?php echo e($_instance->getId()); ?>')});" class="form-group am-custom-textarea">
                        <label class="am-label"><?php echo e(__('quiz::quiz.quiz_descriptions')); ?></label>
                        <div class="am-editor-wrapper">
                            <div wire:ignore class="am-custom-editor am-custom-textarea">
                                <textarea id="profile_desc" class="form-control am-question-desc" placeholder="<?php echo e(__('profile.description_placeholder')); ?>" data-textarea="profile_desc"><?php echo e($form?->description ?? ''); ?></textarea>
                                <span class="characters-count"></span>
                            </div>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.description']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group am-form-btns">
                        <button 
                            type="button" 
                            wire:loading.class="am-btn_disable" 
                            wire:target="updateQuiz" 
                            class="am-btn" 
                            wire:click.prevent="updateQuiz">
                            <?php echo e(__('quiz::quiz.update')); ?>

                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>    
</div>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('modules/quiz/css/main.css')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['public/summernote/summernote-lite.min.css']); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>
    <script type="text/javascript">

        window.addEventListener('quizValuesUpdated', (event) => {            
            let { options, reset, target } = event.detail;
            initOptionList(options, target);
            if(reset) {
                jQuery(target).val('').trigger('change');
            }
        });

        function initOptionList (options, target) {
            let $select = jQuery(target);
            if ($select.hasClass('select2-hidden-accessible')) {
                $select.select2('destroy').empty();
            }
            $select.select2({ 
                data: [{
                    id: '', 
                    text: 'Select an option'
                }, ...options],
                theme: 'default',
                disabled: false
            });
        }

        window.addEventListener('addSlotsOptions', (event) => {
            let {options = []} = event.detail;
            const listItem = Object?.values(options) ?? []
            initOption(listItem);
        });

        function initOption (optionList) {
            let $select = jQuery('#user_subject_slots');
            if ($select.hasClass('select2-hidden-accessible')) {
                $select.select2('destroy').empty();
            }

            $select.select2({ 
                data: [{
                    id: '', 
                    text: 'Select an option'
                }, ...optionList],
                theme: 'default',
                disabled: false
            });
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/edit-quiz-detail.blade.php ENDPATH**/ ?>