<div class="am-quizlist am-quizlist_students" wire:init="loadData">
    <div class="am-title_wrap">
        <div class="am-title">
            <h2><?php echo e(__('quiz::quiz.quizzes')); ?></h2>
            <p><?php echo e(__('quiz::quiz.browse_and_manage_place')); ?></p>
        </div>
        <div class="am-slots_right">
            <div class="am-searchinput">
                <input wire:model.live.debounce.250ms="filters.keyword" type="text" placeholder="<?php echo e(__('general.search_by_keyword')); ?>" class="form-control" id="keyword">
                <span class="am-searchinput_icon">
                    <i class="am-icon-search-02"></i>
                </span>
            </div>
            <ul class="am-category-slots">
                <li>
                    <button class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active'=> $filters['status'] === 'upcoming']); ?>" wire:click="filterStatus('upcoming')">
                        <?php echo e(__('quiz::quiz.upcoming')); ?>

                    </button>
                </li>
                <li>
                    <button class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active'=> $filters['status'] === 'attempted']); ?>" wire:click="filterStatus('attempted')">
                        <?php echo e(__('quiz::quiz.attempted')); ?>

                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="am-quizlist_wrap" wire:loading wire:target="loadData, filterStatus, filters">
        <?php echo $__env->make('quiz::skeletons.quiz-listing-skeleton', ['total' => $filters['per_page']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <!--[if BLOCK]><![endif]--><?php if(!$isLoading): ?>
        <div class="am-quizlist_wrap" wire:loading.remove wire:target="loadData,filterStatus, filters">
            <!--[if BLOCK]><![endif]--><?php if($quizAttempts->isNotEmpty()): ?>
                <ul>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $quizAttempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quizAttempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="am-quizlist_item">
                                <figure>
                                    <?php 
                                        $routeURL = $quizAttempt->result == Modules\Quiz\Models\QuizAttempt::RESULT_ASSIGNED ? route('quiz.student.quiz-details', ['attemptId' => $quizAttempt->id]) : route('quiz.quiz-result', ['attemptId' => $quizAttempt->id]);
                                    ?> 
                                    <a href="<?php echo e($routeURL); ?>">
                                        <!--[if BLOCK]><![endif]--><?php if($quizAttempt->quiz?->quizzable_type == 'App\Models\UserSubjectGroupSubject'): ?>
                                            <img src="<?php echo e(Storage::url($quizAttempt->quiz?->quizzable?->image)); ?>" alt="<?php echo e($quizAttempt->quiz?->title); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo e(Storage::url($quizAttempt->quiz?->quizzable?->thumbnail?->path)); ?>" alt="<?php echo e($quizAttempt->quiz?->title); ?>">  
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </a>
                                    <!--[if BLOCK]><![endif]--><?php if($quizAttempt->result != Modules\Quiz\Models\QuizAttempt::RESULT_ASSIGNED): ?>
                                        <figcaption>
                                            <span class="am-quizattempted"><?php echo e(__('quiz::quiz.total_attempted')); ?><i class="am-icon-check-circle03"></i></span>
                                        </figcaption>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </figure>
                                <div class="am-quizlist_item_content">
                                    <div class="am-quizlist_coursename">
                                        <div class="am-quizlist_coursetitle">
                                            <h3><a href="<?php echo e($routeURL); ?>"><?php echo e($quizAttempt->quiz?->title); ?></a></h3>
                                            <!--[if BLOCK]><![endif]--><?php if($quizAttempt->quiz?->quizzable_type == 'App\Models\UserSubjectGroupSubject'): ?>
                                                <span><?php echo e($quizAttempt->quizzable?->subject?->name); ?></span>
                                            <?php else: ?>
                                                <span><?php echo e($quizAttempt->quiz?->quizzable?->title); ?></span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                    <ul class="am-quizlist_item_footer">
                                        <li>
                                            <span>
                                                <i>
                                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                                                        <g opacity="0.8">
                                                        <path d="M7.50293 9.33268C7.50293 9.49377 7.37235 9.62435 7.21126 9.62435C7.05018 9.62435 6.9196 9.49377 6.9196 9.33268M7.50293 9.33268C7.50293 9.1716 7.37235 9.04102 7.21126 9.04102C7.05018 9.04102 6.9196 9.1716 6.9196 9.33268M7.50293 9.33268H6.9196M6.0446 6.12435V5.83268C6.0446 5.18835 6.56693 4.66602 7.21126 4.66602C7.8556 4.66602 8.37793 5.18835 8.37793 5.83268V5.90345C8.37793 6.23164 8.24756 6.54639 8.01549 6.77845L7.21126 7.58268M13.0446 6.99935C13.0446 10.221 10.4329 12.8327 7.21126 12.8327C6.54663 12.8327 5.97666 12.738 5.44742 12.5487C4.94723 12.3698 4.69711 12.2803 4.60115 12.2578C3.7157 12.0495 3.34837 12.6564 2.58523 12.7835C2.2104 12.846 1.87688 12.5391 1.90798 12.1604C1.93518 11.8292 2.1642 11.516 2.25558 11.198C2.44556 10.5369 2.18777 10.0357 1.91541 9.44777C1.57052 8.70325 1.37793 7.87377 1.37793 6.99935C1.37793 3.77769 3.9896 1.16602 7.21126 1.16602C10.4329 1.16602 13.0446 3.77769 13.0446 6.99935Z" stroke="#585858" stroke-width="0.972222" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>
                                                </i>
                                                <?php echo e(__('quiz::quiz.total_questions')); ?>

                                            </span> 
                                            <em><?php echo e($quizAttempt->total_questions); ?></em>
                                        </li>
                                        <li>
                                            <span>
                                                <i class="am-icon-calender-day"></i>
                                                <?php echo e(__('quiz::quiz.created_at')); ?>

                                            </span> 
    
                                            <em><?php echo e(\Carbon\Carbon::parse($quizAttempt?->quiz?->created_at)->format('M d, Y')); ?></em>
                                        </li>
                                        <li>
                                            <span>
                                                <i class="am-icon-file-02"></i>
                                                <?php echo e(__('quiz::quiz.total_marks')); ?>

                                            </span> 
                                            <em><?php echo e(number_format($quizAttempt?->total_marks) ?? 0); ?></em>
                                        </li>
                                        <li>
                                            <span>
                                            <i class="am-icon-time"></i>
                                                <?php echo e(__('quiz::quiz.duration')); ?>

                                            </span> 
                                            <em><?php echo e($quizAttempt?->quiz->settings?->where('meta_key', 'duration')->first()?->meta_value ??  0); ?> <?php echo e(__('quiz::quiz.hrs')); ?>.</em>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
                <!--[if BLOCK]><![endif]--><?php if(!$isLoading && $quizAttempts->links()->paginator->hasPages()): ?>
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
                        <?php echo e($quizAttempts->links('quiz::pagination.pagination')); ?>

                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php else: ?>
                <div class="am-emptyview">
                    <figure class="am-emptyview_img">
                        <img src="<?php echo e(asset('modules/quiz/images/quiz-list/empty.png')); ?>" alt="img description">
                    </figure>
                    <div class="am-emptyview_title">
                        <h3><?php echo e(__('quiz::quiz.no_quizzes_available')); ?></h3>
                        <p><?php echo e(__('quiz::quiz.no_quizzes_available_desc')); ?></p>
                        
                    </div>
                </div>    
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('modules/quiz/css/main.css')); ?>">
<?php $__env->stopPush(); ?>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/student/quiz-listing/quiz-listing.blade.php ENDPATH**/ ?>