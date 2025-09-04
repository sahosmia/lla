<div class="am-quizlist" wire:init="loadData" x-data="{quizType: 'manual',duplicateQuizId: <?php if ((object) ('duplicateQuizId') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('duplicateQuizId'->value()); ?>')<?php echo e('duplicateQuizId'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('duplicateQuizId'); ?>')<?php endif; ?>}">
    <?php
        if(!empty(auth()?->user()?->profile->image) && Storage::disk(getStorageDisk())->exists(auth()?->user()?->profile?->image)) {
            $userImage = resizedImage(auth()?->user()?->profile?->image, 36, 36);
        } else {
            $userImage = resizedImage('placeholder.png', 36, 36);
        }
    ?>
    
    <div class="am-title_wrap">
        <div class="am-title">
            <h2><?php echo e(empty($filters['status']) ? __('quiz::quiz.my_quizzes') : __('quiz::quiz.'. $filters['status'] ) . ' ' . __('quiz::quiz.quizzes')); ?></h2>
            <p><?php echo e(__('quiz::quiz.track_student_progress' )); ?></p>
        </div>
        <!--[if BLOCK]><![endif]--><?php if($quizzes->isNotEmpty() || !empty($filters['keyword']) || !empty($filters['status'])): ?>
        <div class="am-_btn_wrap">
            <button class="am-btn"
                <?php if(!empty(setting('_quiz.enable_ai')) && setting('_quiz.enable_ai') == '1'): ?>
                    @click="$nextTick(() => $wire.dispatch('toggleModel', {id: 'quiz-creation',action:'show'}) )"
                <?php else: ?>
                    @click="quizType = 'manual'; $nextTick(() => $wire.dispatch('toggleModel', {id: 'create-quiz-model',action:'show'}) )"
                <?php endif; ?>        
                >
                <?php echo e(__('quiz::quiz.create_quiz')); ?>

                <i class="am-icon-plus-02"></i>
            </button>
        </div>
           <div class="am-quizsearuch_header">
                <div class="am-quizlist_search">
                    <input type="text" wire:model.live.debounce.300ms="filters.keyword" class="form-control" placeholder="Search by keyword">
                    <i class="am-icon-search-02"></i>
                </div>
                <div class="am-slots_wrap">
                    <ul class="am-category-slots">
                        <li>
                            <button wire:click="filterStatus('')" class="<?php echo e($filters['status'] === '' ? 'active' : ''); ?>">
                                <?php echo e(__('quiz::quiz.all')); ?>

                            </button>
                        </li>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $activeStatus =  $status != 'all' ? $status : ''
                            ?>
                            <li>
                                <button wire:click="filterStatus('<?php echo e($activeStatus); ?>')" class="<?php echo e($activeStatus === $filters['status'] ? 'active' : ''); ?>">
                                    <?php echo e(__('quiz::quiz.'.$status)); ?>

                                </button>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </ul>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    
    <!--[if BLOCK]><![endif]--><?php if(!$isLoading): ?>
        <div class="am-quizlist_wrap" wire:loading.remove wire:target="loadData, filterStatus, filters">
            <?php if($quizzes->isNotEmpty()): ?>
                <ul>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <li>
                        <div class="am-quizlist_item">
                            <figure>
                                <?php
                                    $image = null;

                                    if ($quiz->quizzable_type == 'App\Models\UserSubjectGroupSubject') {
                                        $image = $quiz?->quizzable?->image 
                                            ? Storage::url($quiz->quizzable->image) 
                                            : resizedImage('placeholder.png', 342, 176);
                                    } else {
                                        $image = $quiz?->quizzable?->thumbnail?->path 
                                            ? Storage::url($quiz->quizzable->thumbnail->path) 
                                            : resizedImage('placeholder.png', 342, 176);
                                    }
                                ?>
                                <img src="<?php echo e($image); ?>" alt="card image">
                                <figcaption>
                                   <!--[if BLOCK]><![endif]--><?php if(in_array($quiz->status, ['archived','published']) && $quiz?->quiz_attempts_count > 0): ?>
                                        <span class="am-quizattempted"><?php echo e(number_format($quiz?->quiz_attempts_count)); ?><?php echo e(__('quiz::quiz.total_attempted')); ?><i class="am-icon-check-circle03"></i></span>
                                    <?php else: ?>
                                        <?php
                                        $statusClass = match ($quiz?->status) {
                                            'draft' => 'am-quizstatus_draft',
                                            'archived' => 'am-quizstatus_archived',
                                            default => 'am-quizstatus_published',
                                        };
                                        ?>
                                        <span class="am-quizstatus <?php echo e($statusClass); ?>">
                                            <?php echo e(__('quiz::quiz.status', ['status' => ucfirst($quiz?->status)])); ?>

                                        </span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </figcaption>
                            </figure>
                            <div class="am-quizlist_item_content">
                                <div class="am-quizlist_coursename">
                                    <div class="am-quizlist_coursetitle">
                                        <h3><?php echo e($quiz?->title); ?></h3>
                                        <!--[if BLOCK]><![endif]--><?php if($quiz->quizzable_type == 'App\Models\UserSubjectGroupSubject'): ?>
                                            <span><?php echo e($quiz?->quizzable?->subject?->name); ?></span>
                                        <?php else: ?>
                                            <span><?php echo e($quiz?->quizzable?->title); ?></span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="am-itemdropdown">
                                        <a href="javascript:void(0);" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="am-icon-ellipsis-vertical-02"></i>
                                        </a>
                                        <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <!--[if BLOCK]><![endif]--><?php if( in_array($quiz->status, ['draft']) ): ?>
                                                <li>
                                                    <a href="<?php echo e(route('quiz.tutor.quiz-details', ['quizId' => $quiz->id])); ?>">
                                                        <i class="am-icon-pencil-02"></i>
                                                        <?php echo e(__('quiz::quiz.edit_quiz')); ?>

                                                    </a>
                                                </li>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if( in_array($quiz->status, ['archived','published']) ): ?>
                                            <li>
                                                <a href="<?php echo e(route('quiz.tutor.quiz-attempts', ['quizId' => $quiz->id])); ?>">
                                                    <i class="am-icon-eye-open-01"></i>
                                                    <?php echo e(__('quiz::quiz.view_attempts')); ?>

                                                </a>
                                            </li>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <li>
                                                <a href="javascript:void(0);" @click=" duplicateQuizId = <?php echo \Illuminate\Support\Js::from($quiz->id)->toHtml() ?> ; $nextTick(() => $wire.dispatch('toggleModel', {id: 'duplicate_popup',action:'show'}) )" >
                                                    <i class="am-icon-copy-01"></i>
                                                    <?php echo e(__('quiz::quiz.duplicate_quiz')); ?>

                                                </a>
                                            </li>
                                            <!--[if BLOCK]><![endif]--><?php if( !in_array($quiz->status, ['draft']) ): ?>
                                            <li>
                                                <a href="javascript:void(0);" wire:click="archivedQuiz(<?php echo e($quiz?->id); ?>, '<?php echo e($quiz?->status); ?>')">
                                                    <i class="am-icon-archive-01"></i>
                                                    <?php echo e($quiz?->status == 'archived' ? __('quiz::quiz.unarchived_quiz') : __('quiz::quiz.archived_quiz')); ?>

                                                </a>
                                            </li>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </ul>
                                    </div>
                                </div>
                                <ul class="am-quizlist_item_footer">
                                    <li>
                                       <span>
                                            <i class="am-icon-chat-03"></i>
                                            <?php echo e(__('quiz::quiz.total_questions')); ?>

                                        </span> 
                                        <em><?php echo e($quiz->questions_count); ?></em>
                                    </li>
                                    <li>
                                       <span>
                                            <i class="am-icon-calender-day"></i>
                                            <?php echo e(__('quiz::quiz.created_at')); ?>

                                        </span> 

                                        <em><?php echo e(\Carbon\Carbon::parse($quiz->created_at)->format('M d, Y')); ?></em>
                                    </li>
                                    <li>
                                       <span>
                                            <i class="am-icon-file-02"></i>
                                            <?php echo e(__('quiz::quiz.total_marks')); ?>

                                        </span> 
                                        <em><?php echo e($quiz->questions_sum_points ?? 0); ?></em>
                                    </li>
                                    <li>
                                       <span>
                                        <i class="am-icon-time"></i>
                                            <?php echo e(__('quiz::quiz.duration')); ?>

                                        </span> 
                                        <em><?php echo e($quiz->settings->where('meta_key', 'duration')->first()?->meta_value ??  0); ?> <?php echo e(__('quiz::quiz.hrs')); ?>.</em>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
                <!--[if BLOCK]><![endif]--><?php if(!$isLoading && $quizzes->links()->paginator->hasPages()): ?>
                    <div class='am-pagination am-quiz-pagination'>
                        <!--[if BLOCK]><![endif]--><?php if(!empty($parPageList)): ?>
                            <div class="am-pagination-filter" wire:ignore>
                                <em><?php echo e(__('quiz::quiz.show')); ?></em>
                                <span class="am-select">
                                    <select wire:model.live="filters.per_page" x-init="$wire.dispatch('initSelect2', {target: '#per-page-select'});" class="am-select2" id="per-page-select" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" data-searchable="false" data-wiremodel="filters.per_page">
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($filters['per_page']) && !in_array($filters['per_page'], $parPageList)): ?>
                                            <option value="<?php echo e($filters['per_page']); ?>"><?php echo e($filters['per_page']); ?></option>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $parPageList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php echo e($filters['per_page'] == $option ? 'selected' : ''); ?> value="<?php echo e($option); ?>"><?php echo e($option); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                </span>
                                <em><?php echo e(__('quiz::quiz.listing_per_page')); ?></em>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php echo e($quizzes->links('quiz::pagination.pagination')); ?>

                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php else: ?>
                 <div class="am-emptyview">
                    <figure class="am-emptyview_img">
                        <img src="<?php echo e(asset('modules/quiz/images/quiz-list/empty.png')); ?>" alt="img description">
                    </figure>
                    <div class="am-emptyview_title">
                        <!--[if BLOCK]><![endif]--><?php if(!empty($filters['status']) || !empty($filters['keyword'])): ?>
                            <h3><?php echo e(__('quiz::quiz.no_quiz_found')); ?></h3>
                            <p><?php echo e(__('quiz::quiz.no_quiz_found_desc')); ?></p>
                        <?php else: ?>
                            <h3><?php echo e(__('quiz::quiz.empty_box_heading')); ?></h3>
                            <p><?php echo e(__('quiz::quiz.empty_box_para')); ?></p>
                            <p><?php echo e(__('quiz::quiz.get_started')); ?></p>
                            <div class="am-emptyview_btn_wrap">
                                <button class="am-btn" @click="$nextTick(() => $wire.dispatch('toggleModel', {id: 'quiz-creation',action:'show'}) )">
                                    <?php echo e(__('quiz::quiz.create_quiz')); ?>

                                    <i class="am-icon-plus-02"></i>
                                </button>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>     
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php else: ?>
        <div class="am-quizlist_wrap" wire:loading wire:target="loadData, filterStatus, filters">
            <?php echo $__env->make('quiz::skeletons.quiz-listing-skeleton', ['total' => $filters['per_page']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
    <div  wire:ignore.self  class="modal fade am-successfully-popup" id="duplicate_popup">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-body">
                    <span data-bs-dismiss="modal" class="am-closepopup">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                    <div class="am-deletepopup_icon confirm-icon">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30" viewBox="0 0 31 30" fill="none">
                                <path d="M15.2109 20V13.75M15.8359 10C15.8359 10.3452 15.5561 10.625 15.2109 10.625C14.8658 10.625 14.5859 10.3452 14.5859 10M15.8359 10C15.8359 9.65482 15.5561 9.375 15.2109 9.375C14.8658 9.375 14.5859 9.65482 14.5859 10M15.8359 10H14.5859M27.7109 15C27.7109 21.9036 22.1145 27.5 15.2109 27.5C8.30738 27.5 2.71094 21.9036 2.71094 15C2.71094 8.09644 8.30738 2.5 15.2109 2.5C22.1145 2.5 27.7109 8.09644 27.7109 15Z" stroke="#295C51" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    <div class="am-successfully_title">
                        <h3><?php echo e(__('quiz::quiz.confirmation_title')); ?></h3>
                        <p><?php echo e(__('quiz::quiz.confirmation_desc')); ?></p>
                    </div>
                    <div class="am-successfully-popup_btns">
                        <a href="#" data-bs-dismiss="modal" class="am-white-btn"><?php echo e(__('quiz::quiz.cancel')); ?></a>
                        <button  
                            wire:click="duplicateQuiz" 
                            wire:loading.attr="disabled" 
                            wire:loading.class="am-btn_disable" 
                            wire:target="duplicateQuiz" 
                            class="am-btn">
                            <?php echo e(__('quiz::quiz.confirm')); ?>

                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
        <div wire:ignore.self class="modal fade ai-quiz-modal" id="create-quiz-model" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <div class="am-createquiz_details_title">
                            <h2><?php echo e(__('quiz::quiz.qiz_details')); ?>                 
                                <!--[if BLOCK]><![endif]--><?php if(request()->routeIs('quiz.tutor.create-quiz') === 'quiz.tutor.create-quiz' && !empty(setting('_quiz.enable_ai')) && setting('_quiz.enable_ai') == '1'): ?> 
                                    <button class="am-aigenearted" wire:click="prepareAiQuiz" wire:loading.class="am-btn_disable" wire:target="generateAiQuiz"><img src="<?php echo e(asset('modules/quiz/images/ai-generated.png')); ?>" alt="image"><?php echo e(__('quiz::quiz.generate_with_ai')); ?></button></h2>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </h2>
                            <p><?php echo e(__('quiz::quiz.quiz_with_title_description')); ?></p>
                            <button type="button" class="btn-close am-close_btn" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="am-modal-body">
                        <div>
                            <form class="am-createquiz_details_form" id="create-quiz-form"
                                x-data="{
                                    selectedValues: <?php echo e(!empty($selectedSubjectSlots) ? json_encode($selectedSubjectSlots) : '[]'); ?>,
                                    init() {
                                        console.log(this.selectedValues)
                                        this.selectedValues = Array.isArray(this.selectedValues)
                                        ? this.selectedValues
                                        : Object.values(this.selectedValues);
                                        let selectElement = document.getElementById('user_subject_slots');
                                        Livewire.on('slotsList', () => {
                                            setTimeout(() => {
                                                $('#user_subject_slots').select2().on('change', (e)=>{
                                                    let textInput = jQuery(e.target).siblings('span').find('textarea');
                                                    if(textInput){
                                                        setTimeout(() => {
                                                            textInput.val('');
                                                            textInput.attr('placeholder', 'Select session');
                                                        }, 50);
                                                    }
                                                    this.updateSelectedValues()
                                                });
                                            }, 50);
                                        });
                                        $('#user_subject_slots').select2().on('change', ()=>{
                                            this.updateSelectedValues()
                                        });
                                    },
                                    updateSelectedValues(){
                                    let selectElement = document.getElementById('user_subject_slots');
                                        this.selectedValues = Array.from(selectElement.selectedOptions)
                                            .filter(option => option.value)
                                            .map(option => ({
                                                value: option.value,
                                                text: option.text,
                                                price: option.getAttribute('data-price')
                                            })
                                        );
                                    },
                                    removeValue(value) {
                                        const selectElement = document.getElementById('user_subject_slots');
                                        const optionToDeselect = Array.from(selectElement.options).find(option => option.value === value);
                                        if (optionToDeselect) {
                                            optionToDeselect.selected = false;
                                            $(selectElement).trigger('change');
                                        }
                                    },
                                    submitFilter() {
                                        const selectElement = document.getElementById('user_subject_slots');
                                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('subjectGroupIds', $(selectElement).select2('val'));
                                    }
                                }">
                                <fieldset>
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
                                            <span class="am-select" wire:ignore>
                                                <select class="am-select2" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" id="quizzable_type" data-parent="#create-quiz-model" data-live="true" data-wiremodel="form.quizzable_type" data-placeholder="<?php echo e(__('quiz::quiz.select_quiz_type')); ?>">
                                                    <option value=""><?php echo e(__('quiz::quiz.select_quiz_type')); ?></option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $quizzable_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quizzable_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($quizzable_type['value']); ?>" <?php if($form?->quizzable_type == $quizzable_type['value']): ?> selected <?php endif; ?>><?php echo e($quizzable_type['label']); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                            </span>
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
                                    <div class="form-group <?php $__errorArgs = ['form.quizzable_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:loading.class="am-disabled" wire:loading.target="form.quizzable_type">
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
                                        <span class="am-select" wire:ignore>
                                            <select class="am-select2" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" id="quizzable_id" data-parent="#create-quiz-model" data-live="true" data-wiremodel="form.quizzable_id" <?php if(isActiveModule('Courses')): ?> disabled <?php endif; ?> data-placeholder="<?php echo e(__('quiz::quiz.select_option')); ?>">
                                                <option value=""><?php echo e(__('quiz::quiz.select_option')); ?></option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $quizzable_ids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($quiz['id']); ?>" <?php if($form->quizzable_id == $quiz['id']): ?> selected <?php endif; ?>><?php echo e($quiz['title']); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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
                                    <!--[if BLOCK]><![endif]--><?php if($form->quizzable_type == 'App\Models\UserSubjectGroupSubject'): ?>
                                        <div class="form-group am-knowlanguages <?php $__errorArgs = ['form.user_subject_slots'];
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
                                            <div class="form-group-two-wrap am-nativelang">
                                                <div id="user_slot" wire:ignore>
                                                    <span class="am-select am-multiple-select">
                                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-disable_onchange="true" data-parent="#create-quiz-model" class="slots am-select2" data-hide_search_opt="true" id="user_subject_slots" <?php if(!$form->quizzable_id): ?> disabled <?php endif; ?> data-wiremodel="form.user_subject_slots" multiple data-placeholder="<?php echo e(__('quiz::quiz.select_session')); ?>">
                                                            <option value="" ><?php echo e(__('quiz::quiz.select_session')); ?></option>
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option <?php if(!empty($slot['selected'])): ?> selected <?php endif; ?> value="<?php echo e($slot['id']); ?>"><?php echo e($slot['text']); ?></option>      
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                        </select>
                                                        <template x-if="selectedValues.length > 0">
                                                            <ul class="am-subject-tag-list">
                                                                <template x-for="(subject, index) in selectedValues">
                                                                    <li>
                                                                        <a href="javascript:void(0)" class="am-subject-tag" @click="removeValue(subject.value)">
                                                                            <span x-text="`${subject.text}`"></span>
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
                                    <template x-if="quizType === 'manual'">
                                        <div>
                                            <div class="form-group <?php $__errorArgs = ['form.title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <label class="am-label am-important"><?php echo e(__('quiz::quiz.quiz_title')); ?></label>
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
                                            <div wire:ignore class="form-group am-custom-textarea">
                                                <label class="am-label"><?php echo e(__('quiz::quiz.quiz_descriptions')); ?></label>
                                                <div class="am-editor-wrapper">
                                                    <div x-init="$wire.dispatch('initSummerNote', {target: '#profile_desc', wiremodel: 'form.description', conetent: '<?php echo e($form?->description); ?>', componentId: window.Livewire.find('<?php echo e($_instance->getId()); ?>')});" class="am-custom-editor am-custom-textarea" wire:ignore>
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
                                                <!--[if BLOCK]><![endif]--><?php if($activeRoute === 'quiz.tutor.quiz-question-bank'): ?>
                                                    <button type="button" class="am-btn-light" wire:click="onCancel">
                                                        <?php echo e(__('quiz::quiz.cancel')); ?>

                                                    </button>
                                                    <button type="button" wire:click="updateQuiz" wire:loading.class="am-btn_disable" wire:target="updateQuiz" class="am-btn"><?php echo e(__('quiz::quiz.update')); ?></button>
                                                <?php else: ?>
                                                    <button type="button" class="am-btn-light" data-bs-dismiss="modal">
                                                        <?php echo e(__('quiz::quiz.cancel')); ?>

                                                    </button>
                                                    <button 
                                                        type="button" 
                                                        wire:loading.class="am-btn_disable" 
                                                        wire:target="saveQuiz" 
                                                        class="am-btn" 
                                                        wire:click.prevent="saveQuiz($event.target).then((url) => {
                                                        if(url?.length){
                                                            window.location.href = url;
                                                        }
                                                    })"><?php echo e(__('quiz::quiz.save')); ?></button>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        <div>
                                    </template>
                                    <template x-if="quizType=='ai'">
                                        <div>
                                            <div class="form-group <?php $__errorArgs = ['form.description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <label class="am-label am-important"><?php echo e(__('quiz::quiz.quiz_ai_descriptions')); ?></label>
                                                <textarea id="profile_desc" wire:model="form.description" class="form-control am-question-desc" placeholder="<?php echo e(__('quiz::quiz.quiz_ai_description_placeholder')); ?>" ><?php echo e($form?->description ?? ''); ?></textarea>
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
                                            <div class="form-group ai-questions">
                                                <h6 class="am-label"><?php echo e(__('quiz::quiz.question_types_label')); ?>

                                                    <i class="am-tooltip am-icon-exclamation-01">
                                                        <span class="am-tooltip-text">
                                                            <span><?php echo e(__('quiz::quiz.question_types_tooltip')); ?></span>
                                                        </span>
                                                    </i>
                                                </h6>
                                                <ul class="ai-questions_list">
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $form->question_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questionType => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <span><?php echo e(__('quiz::quiz.'.$questionType)); ?></span>
                                                            <div class="am-question_value">
                                                                <input type="number" min="0" max="<?php echo e($value); ?>" id="question_type_<?php echo e($questionType); ?>" wire:model="form.question_types.<?php echo e($questionType); ?>">
                                                                <button type="button" class="am-question_emptybtn btn-close" @click="jQuery(`#question_type_${<?php echo \Illuminate\Support\Js::from($questionType)->toHtml() ?>}`).val('0'); $wire.set(`form.question_types.${<?php echo \Illuminate\Support\Js::from($questionType)->toHtml() ?>}`, '0', false)"></button>
                                                            </div>
                                                        </li>
                                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["form.question_types.$questionType"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.question_types.'.e($questionType).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.question_types.'.e($questionType).'']); ?>
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
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </ul>
                                               <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['question_types'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'question_types']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'question_types']); ?>
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
                                               <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="form-group am-form-btns">
                                                <button type="button" class="am-btn-light" data-bs-dismiss="modal">
                                                    <?php echo e(__('quiz::quiz.cancel')); ?>

                                                </button>
                                                <button type="button" wire:key="ai-quiz-btn" wire:loading.class="am-btn_disable" wire:target="generateAiQuiz" wire:click="generateAiQuiz" class="am-btn">
                                                    <?php echo e(__('quiz::quiz.generate_with_ai')); ?>

                                                </button>
                                            </div>
                                        </div>
                                    </template> 
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <div wire:ignore.self class="modal fade am-create-quiz-modal" id="quiz-creation" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">   
                    <h4><?php echo e(__('quiz::quiz.create_new_quiz')); ?></h4>
                    <p><?php echo e(__('quiz::quiz.create_quiz_para')); ?></p>
                    <button type="button" class="btn-close am-close_btn" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="am-create-quiz-modal_list">
                    <a href="#" @click="jQuery('#quiz-creation').modal('hide'); quizType = 'manual'; $nextTick(() => $wire.dispatch('toggleModel', {id: 'create-quiz-model',action:'show'}) )">
                        <span class="am-create-quiz-modal_icon"><i class="am-icon-plus-02"></i></span>
                        <h6><?php echo e(__('quiz::quiz.create_manual_quiz')); ?></h6>
                        <p><?php echo e(__('quiz::quiz.create_manual_quiz_desc')); ?></p>
                    </a>
                    <a href="#"  @click="jQuery('#quiz-creation').modal('hide'); quizType = 'ai'; $nextTick(() => $wire.dispatch('toggleModel', {id: 'create-quiz-model',action:'show'}) )">
                        <span class="am-create-quiz-modal_icon"><img src="<?php echo e(asset('modules/quiz/images/ai-generated.png')); ?>" alt="image"></span>
                        <h6><?php echo e(__('quiz::quiz.generate_with_ai')); ?></h6>
                        <p><?php echo e(__('quiz::quiz.generate_with_ai_desc')); ?></p>
                    </a>
                </div>            
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('modules/quiz/css/main.css')); ?>" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['public/summernote/summernote-lite.min.css']); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>
    <script type="text/javascript">

        window.addEventListener('editQuiz', (event) => {
            const {quizzable_type, option_list, session_slots} = event.detail.eventData;
            Livewire.dispatch('initSelect2', { target: '.am-select2', timeOut: 150 });
            setTimeout(() => {
                initOptionList(option_list);
                if(quizzable_type === '<?php echo e(UserSubjectGroupSubject::class); ?>'){
                    initOption(session_slots);
                }
            }, 300);

        });

        window.addEventListener('quizValuesUpdated', (event) => {            
            let { options, reset } = event.detail;
            initOptionList(options);
            if(reset) {
                jQuery('#quizzable_id').val('').trigger('change');
            }
        });

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

            setTimeout(() => {
                const event = new CustomEvent('slotsList', { detail: { } });
                document.dispatchEvent(event);
            }, 1000);
        }

        function initOptionList (options) {
            let $select = jQuery('#quizzable_id');
            if ($select.hasClass('select2-hidden-accessible')) {
                $select.select2('destroy').empty();
            }
            $select.select2({ 
                data: [{
                    id: '', 
                    text: 'Select an option'
                }, ...options],
                theme: 'default',
                dropdownParent: jQuery('#create-quiz-model'),
                disabled: false
            });
        }

        function initSummerNoteInput() {
            var initialContent = '';
            var initialContent = window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('form.description');
            $('.am-question-desc').summernote('destroy');
            $('.am-question-desc').summernote(summernoteConfigs('.am-question-desc'));
            $('.am-question-desc').summernote('code', initialContent);
            $(document).on('summernote.change', '.am-question-desc', function(we, contents, $editable) {             
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').set("form.description",contents, false);
            });
        }

        document.addEventListener('DOMContentLoaded', function( ) {
            jQuery(document).ready(function() {
                setTimeout(function() {
                    $(document).on('change', "#subject_list", function(e) {
                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('subject_list', $(this).select2('val'));
                    });
                }, 50);
            });
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-listing/quiz-listing.blade.php ENDPATH**/ ?>