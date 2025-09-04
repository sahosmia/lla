<div class="am-createquiz" wire:init="loadData">
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.quiz-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="am-createques">
        <div class="am-createques_header">
            <div class="am-createques_title">
                <h3><?php echo e(__('quiz::quiz.question_manager')); ?></h3>
                <p><?php echo e(__('quiz::quiz.question_manager_desc')); ?></p>
            </div>
            <!--[if BLOCK]><![endif]--><?php if($quiz->status != Modules\Quiz\Models\Quiz::STATUS_PUBLISHED && $quiz->questions_count > 0): ?>
                <div class="question-manager">
                    <!--[if BLOCK]><![endif]--><?php if(!empty($quiz->questions_count)): ?>
                        <button class="am-publish" data-bs-toggle="modal" data-bs-target="#course_completed_popup">
                            <i class="am-icon-compare-1"></i>
                            <?php echo e(__('quiz::quiz.publish')); ?>

                        </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    
                    <button class="am-btn" data-bs-toggle="modal" data-bs-target="#am-createques-modal">
                        <i class="am-icon-plus-02"></i>
                        <?php echo e(__('quiz::quiz.add_question')); ?>

                    </button>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <?php if(!empty($quiz->questions_count) ): ?>
            <div class="am-createques_search">
                <div class="am-quizlist_search">
                    <input type="text" wire:model.live.debounce.500ms="keyword" class="form-control" placeholder="<?php echo e(__('quiz::quiz.search_by_keyword')); ?>" />
                    <i class="am-icon-search-02"></i>
                </div>
                <div class="am-select" wire:ignore>

                    <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" class="am-select2" id="status"  data-wiremodel="questionType">
                        <option value=""><?php echo e(__('quiz::quiz.all')); ?></option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $questionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questionType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($questionType['value']); ?>" <?php if(!empty($questionType['is_disabled'])): ?> disabled="disabled" <?php endif; ?>><?php echo e(__('quiz::quiz.' . $questionType['type'])); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                    <!--[if BLOCK]><![endif]--><?php if($autoResultGenerte): ?>
                        <i class="am-tooltip am-icon-exclamation-01">
                            <span class="am-tooltip-text">
                                <strong><?php echo e(__('quiz::quiz.alert')); ?></strong>
                                <span><?php echo e(__('quiz::quiz.not_allowed_to_create')); ?></span>
                            </span>
                        </i>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="am-quizlist_wrap" wire:loading wire:target="loadData, questionType, keyword">
            <?php echo $__env->make('quiz::skeletons.question-skeleton', ['total' => $perPage], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!--[if BLOCK]><![endif]--><?php if(!$isLoading): ?>
        <div class="am-question_manager" wire:loading.remove wire:target="loadData, questionType, keyword">
            <!--[if BLOCK]><![endif]--><?php if($questions->isNotEmpty()): ?>
                <ul <?php if($quiz->status != Modules\Quiz\Models\Quiz::STATUS_PUBLISHED): ?> wire:sortable="updateQuistionPosition" <?php endif; ?> class="am-createques_details" id="am-accordion-questionlist">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li wire:sortable.item="<?php echo e($question->id); ?>" wire:key="question-<?php echo e($question->id); ?>" id="question-<?php echo e($question->id); ?>" class="am-resume_item">
                            <div class="am-resume_item_question">
                                <div class="am-resume_content" data-bs-toggle="collapse" data-bs-target="#am-content-question-<?php echo e($question->id); ?>" aria-expanded="false" aria-controls="question-<?php echo e($question->id); ?>">
                                    <h4>
                                        <span><?php echo e(__('quiz::quiz.question_number', ['number' => $index + 1])); ?></span>
                                        <?php echo e(str_replace(array('[blank]', '[Blank]'), '______', $question?->title )); ?>

                                    </h4>
                                    <ul class="am-resume_item_info">
                                        <li>
                                            <div class="am-resume_item_list">
                                                <span>
                                                    <i class="am-icon-layer-01"></i>
                                                    <?php echo e(__('quiz::quiz.type')); ?>

                                                </span>
                                                <h6><?php echo e(__('quiz::quiz.'.$question?->type)); ?></h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="am-resume_item_list">
                                                <span>
                                                    <i class="am-icon-shield-check"></i>
                                                    <?php echo e(__('quiz::quiz.marks')); ?>

                                                </span>
                                                <h6><?php echo e($question?->points); ?></h6>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if($quiz->status != Modules\Quiz\Models\Quiz::STATUS_PUBLISHED): ?>
                                    <span class="am-dropdown-icon" data-bs-container="body" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="am-icon-ellipsis-horizontal-02"></i>
                                    </span>
                                    <ul class="dropdown-menu am-dropdown">
                                        <li wire:key="edit-<?php echo e($question?->id); ?>">
                                            <a href="<?php echo e(route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => $question?->type, 'questionId' => $question?->id])); ?>"  class="dropdown-item">
                                                <i class="am-icon-pencil-02"></i>
                                                <?php echo e(__('quiz::quiz.edit')); ?>

                                            </a>
                                        </li>
                                        <li>
                                            <a  @click="$wire.dispatch('showConfirm', { id : <?php echo e($question?->id); ?>, action : 'delete-question' })" class="dropdown-item">
                                                <i class="am-icon-trash-02"></i>
                                                <?php echo e(__('quiz::quiz.delete')); ?>

                                            </a>
                                        </li>
                                    </ul>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if(
                                (in_array($question?->type, [Modules\Quiz\Models\Question::TYPE_MCQ, Modules\Quiz\Models\Question::TYPE_TRUE_FALSE, Modules\Quiz\Models\Question::TYPE_FILL_IN_BLANKS]) && $question?->options->count() > 0) ||
                                !empty($question?->description)
                            ): ?>
                                <div class="am-createques_collapse accordion-collapse collapse" id="am-content-question-<?php echo e($question->id); ?>" aria-labelledby="am-content-question-<?php echo e($question->id); ?>" 
                                    data-bs-parent="#am-accordion-questionlist">
                                    <div class="am-createques_list_wrap">
                                        <!--[if BLOCK]><![endif]--><?php if(in_array($question?->type, [Modules\Quiz\Models\Question::TYPE_MCQ, Modules\Quiz\Models\Question::TYPE_TRUE_FALSE]) && $question?->options->count() > 0): ?>
                                            <ul class="am-createques_list">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $question?->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-correct-answer' =>  !empty($option?->is_correct)]); ?>">
                                                        <div class="am-radio">
                                                            <input type="radio" disabled <?php echo e($option?->is_correct == 1 ? 'checked' : ''); ?> id="am-option-<?php echo e($option->id); ?>" name="option-<?php echo e($question->id); ?>" value="<?php echo e($option?->option_text); ?>">
                                                            <label for="am-option-<?php echo e($option->id); ?>"><?php echo e($option?->option_text); ?></label>
                                                        </div>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </ul>
                                        <?php elseif($question?->type == Modules\Quiz\Models\Question::TYPE_FILL_IN_BLANKS && $question?->options->count() > 0): ?>
                                            <ul class="am-createques_list am-createques_fitb-options">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $question?->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <span><?php echo e($option?->option_text); ?></span>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </ul>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($question?->description)): ?>
                                            <p><?php echo $question?->description; ?></p>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if($quiz->status != Modules\Quiz\Models\Quiz::STATUS_PUBLISHED): ?>
                                <span wire:sortable.handle ><i class="am-icon-youtube-1"></i></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            <?php else: ?>
                <div class="am-emptyview">
                    <figure class="am-emptyview_img">
                        <img src="<?php echo e(asset('modules/quiz/images/quiz-list/empty.png')); ?>" alt="img description">
                    </figure>
                    <div class="am-emptyview_title">
                        <h3><?php echo e(__('quiz::quiz.no_questions_added_yet')); ?></h3>
                        <p><?php echo e(__('quiz::quiz.no_questions_added_yet_desc')); ?></p>
                        <div class="am-emptyview_btn_wrap">
                            <button class="am-btn" data-bs-toggle="modal" data-bs-target="#am-createques-modal">
                                <i class="am-icon-plus-02"></i>
                                <?php echo e(__('quiz::quiz.add_question')); ?>

                            </button>
                        </div>
                    </div>
                </div>     
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>    
        <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
        
        <div class="modal fade am-createques-modal" id="am-createques-modal" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div >
                            <h4><?php echo e(__('quiz::quiz.select_question_type')); ?></h4>
                            <p><?php echo e(__('quiz::quiz.select_question_type_desc')); ?></p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="am-createques-modal_list">
                            <li>
                                <a href="<?php echo e(route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => 'fill_in_blanks'])); ?>">
                                    <i class="am-icon-pencil-02"></i>
                                    <?php echo e(__('quiz::quiz.fill_in_blanks')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => 'mcq'])); ?>">
                                    <i class="am-icon-list-02"></i>
                                    <?php echo e(__('quiz::quiz.multiple_choice')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => 'true_false'])); ?>">
                                    <i class="am-icon-check-circle01"></i>
                                    <?php echo e(__('quiz::quiz.true_false')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e($autoResultGenerte ? 'javascript:void(0);' : route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => 'short_answer'])); ?>">
                                    <i class="am-icon-screen"></i>
                                    <?php echo e(__('quiz::quiz.short_answer')); ?>

                                    <!--[if BLOCK]><![endif]--><?php if($autoResultGenerte): ?>
                                        <i class="am-tooltip am-icon-exclamation-01">
                                            <span class="am-tooltip-text">
                                                <strong><?php echo e(__('quiz::quiz.alert')); ?></strong>
                                                <span><?php echo e(__('quiz::quiz.not_allowed_to_create')); ?></span>
                                            </span>
                                        </i>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e($autoResultGenerte ? 'javascript:void(0);' :  route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => 'open_ended_essay'])); ?>">
                                    <i class="am-icon-menu-5"></i>
                                    <?php echo e(__('quiz::quiz.essay')); ?>

                                    <!--[if BLOCK]><![endif]--><?php if($autoResultGenerte): ?>
                                        <i class="am-tooltip am-icon-exclamation-01">
                                            <span class="am-tooltip-text">
                                                <strong><?php echo e(__('quiz::quiz.alert')); ?></strong>
                                                <span><?php echo e(__('quiz::quiz.not_allowed_to_create')); ?></span>
                                            </span>
                                        </i>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade am-successfully-popup" id="course_completed_popup">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-body">
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                        <div class="am-deletepopup_icon confirm-icon">
                            <span>
                                <i class="am-icon-exclamation-01"></i>
                            </span>
                        </div>
                        <div class="am-successfully_title">
                            <h3><?php echo e(__('quiz::quiz.publish_quiz_confirmation_title')); ?></h3>
                            <p><?php echo e(__('quiz::quiz.publish_quiz_confirmation_desc')); ?></p>
                        </div>
                        <div class="am-successfully-popup_btns">
                            <a href="#" data-bs-dismiss="modal" class="am-white-btn"><?php echo e(__('quiz::quiz.cancel')); ?></a>
                            <a  
                            wire:loading.class="am-btn_disable" 
                            wire:target="publishQuiz"
                            wire:click="publishQuiz" class="am-btn"><?php echo e(__('quiz::quiz.publish')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('modules/quiz/css/main.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('js/livewire-sortable.js')); ?>"></script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/question-manager.blade.php ENDPATH**/ ?>