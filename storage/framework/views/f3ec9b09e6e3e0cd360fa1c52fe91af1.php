<div class="am-createquiz" wire:init="loadData">
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.quiz-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="am-quizlist" wire:init="loadData">
            <div class="am-quizlist_filter">
                <div class="am-title">
                    <h2><?php echo e(__('quiz::quiz.all_students')); ?></h2>
                </div>
                <div class="am-quizlist_filter_wrap">
                    <div class="am-quizlist_search">
                        <input type="text" wire:model.live.debounce.500ms="filters.keyword" class="form-control" placeholder="Search by keyword">
                        <i class="am-icon-search-02"></i>
                    </div>
                    <span class="am-select" wire:ignore>
                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" class="am-select2" id="status"  data-wiremodel="filters.status">
                            <option value=""><?php echo e(__('quiz::quiz.all')); ?></option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>"><?php echo e(__('quiz::quiz.' . $status)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </span>
                    <span class="am-select" wire:ignore>
                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" class="am-select2" id="sortby"  data-wiremodel="filters.sort_by">
                            <option value="desc"><?php echo e(__('quiz::quiz.newest_first')); ?></option>
                            <option value="asc"><?php echo e(__('quiz::quiz.oldest_first')); ?></option>
            
                        </select>
                    </span>
                </div>
            </div>
        <div class="am-quizlist_table">
            <div wire:loading wire:target="loadData, filters">
                <?php echo $__env->make('quiz::skeletons.attempted-listing-skeleton', ['total' => $filters['per_page']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <!--[if BLOCK]><![endif]--><?php if(!$isLoading): ?>
                <div class="am-quiztablewrap" wire:loading.remove wire:target="loadData, filters">
                    <!--[if BLOCK]><![endif]--><?php if($quizzes->isNotEmpty()): ?>
                        <table class="am-table ">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('quiz::quiz.student')); ?></th>
                                    <th><?php echo e(__('quiz::quiz.date_time')); ?></th>
                                    <th><?php echo e(__('quiz::quiz.question')); ?></th>
                                    <th><?php echo e(__('quiz::quiz.total_marks')); ?></th>
                                    <th><?php echo e(__('quiz::quiz.correct_answer')); ?></th>
                                    <th><?php echo e(__('quiz::quiz.incorrect_answer')); ?></th>
                                    <th><?php echo e(__('quiz::quiz.earned_marks')); ?></th>
                                    <th><?php echo e(__('quiz::quiz.result')); ?></th>
                                    <th><?php echo e(__('quiz::quiz.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="Student">
                                            <div class="am-quizlist_info am-quizlist_info_student">
                                                <figure class="am-quizlist_info_img">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($quiz->student?->profile?->image) && Storage::disk(getStorageDisk())->exists($quiz->student?->profile?->image)): ?>
                                                        <img src="<?php echo e(resizedImage($quiz->student?->profile?->image,30,30)); ?>" alt="<?php echo e($quiz->student?->profile?->full_name); ?>" />
                                                    <?php else: ?>
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',30,30)); ?>" alt="Quiz image" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </figure>
                                                <div class="am-quizlist_info_details">
                                                    <strong><?php echo e($quiz->student?->profile?->full_name); ?></strong>
                                                    <span><?php echo e($quiz->student?->email); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Date & Time">
                                
                                            <strong>
                                                <?php echo e($quiz?->started_at?->format('j M Y')); ?>

                                                <time datetime=""> <?php echo e($quiz?->started_at?->format('g:i A')); ?></time>
                                            </strong>
                                        </td>
                                        <td data-label="<?php echo e(__('quiz::quiz.question')); ?>"><?php echo e($quiz->total_questions); ?></td>
                                        <td data-label="<?php echo e(__('quiz::quiz.total_marks')); ?>"><?php echo e($quiz->total_marks); ?></td>
                                        <td data-label="<?php echo e(__('quiz::quiz.correct_answer')); ?>"><?php echo e($quiz->correct_answers); ?></td>
                                        <td data-label="<?php echo e(__('quiz::quiz.incorrect_answer')); ?>"><?php echo e($quiz->incorrect_answers); ?></td>
                                        <td data-label="<?php echo e(__('quiz::quiz.earned_marks')); ?>">
                                            <?php echo e($quiz->earned_marks); ?> 
                                            (<?php echo e(round(($quiz->earned_marks / $quiz->total_marks) * 100, 2)); ?>%)
                                        </td>
                                        <td data-label="<?php echo e(__('quiz::quiz.result')); ?>">
                                            <span class="am-status am-status_<?php echo e($quiz->result); ?>">
                                                <em class="am-quizstatus_<?php echo e($quiz->result); ?>"></em>
                                                <?php echo e(__('quiz::quiz.' . $quiz->result)); ?>

                                            </span>
                                        </td>
                                        <td data-label="<?php echo e(__('quiz::quiz.actions')); ?>">
                                            <?php 
                                                $actionRoute = $quiz->result == Modules\Quiz\Models\QuizAttempt::RESULT_IN_REVIEW ? route('quiz.tutor.quiz-mark', ['attemptId' => $quiz->id]) : route('quiz.quiz-result', ['attemptId' => $quiz->id]);
                                            ?>
                                            <a href="<?php echo e($actionRoute); ?>" class="am-btn am-btn-light <?php echo e($quiz->result == Modules\Quiz\Models\QuizAttempt::RESULT_ASSIGNED ? 'am-btn_disabled' : ''); ?>">
                                                <!--[if BLOCK]><![endif]--><?php if($quiz->result == Modules\Quiz\Models\QuizAttempt::RESULT_IN_REVIEW): ?>
                                                    <?php echo e(__('quiz::quiz.mark_result')); ?>

                                                <?php else: ?> 
                                                    <?php echo e(__('quiz::quiz.view_details')); ?>

                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </a>
                                        </td>
                                    </tr>    
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="am-emptyview">
                            <figure class="am-emptyview_img">
                                <img src="<?php echo e(asset('modules/quiz/images/quiz-list/empty.png')); ?>" alt="img description">
                            </figure>
                            <div class="am-emptyview_title">
                                <h3><?php echo e(__('quiz::quiz.no_records_found')); ?></h3>
                                <p><?php echo e(__('quiz::quiz.empty_box_para')); ?></p>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(!$isLoading && $quizzes->links()->paginator->hasPages()): ?>
                <div class='am-pagination am-quiz-pagination'>
                    <!--[if BLOCK]><![endif]--><?php if(!empty($parPageList)): ?>
                        <div class="am-pagination-filter" wire:ignore>
                            <em><?php echo e(__('quiz::quiz.show')); ?></em>
                            <span class="am-select">
                                <select x-init="$wire.dispatch('initSelect2', {target: '#per-page-select'});" class="am-select2" id="per-page-select" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" data-searchable="false" data-wiremodel="filters.per_page">
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
                    <?php echo e($quizzes->links('quiz::pagination.pagination',)); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('modules/quiz/css/main.css')); ?>">
<?php $__env->stopPush(); ?>

<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/quiz-attempts.blade.php ENDPATH**/ ?>