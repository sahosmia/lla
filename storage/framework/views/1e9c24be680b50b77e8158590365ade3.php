<div class="cr-course-box cr-noticeboardwrap">
    <div class="cr-titlewrap">
        <div class="cr-content-box">
            <h2><?php echo e(__('courses::courses.noticeboard')); ?></h2>
            <p><?php echo e(__('courses::courses.noticeboard_desc')); ?></p>
        </div>
    </div>
        <div class="noticeboard-editor">
            <div class="am-themeform_field am-custom-editor am-custom-textarea" wire:ignore>
                <textarea id="content" class="form-control"></textarea>
                <span class="characters-count"></span>
            </div>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="am-error-msg"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            <button wire:click="updateNoticeboard" class="am-btn" wire:loading.attr="disabled" wire:target="updateNoticeboard" wire:loading.class="am-btn_disable"><?php echo e($noticeboardId ? __('courses::courses.udpate') : __('courses::courses.add_to_noticeboard')); ?></button>
        </div>
        <div class="cr-noticeboard">
            <div class="cr-noticeboard_title">
                <h3>Posted on noticeboard</h3>
            </div>
            <ul class="am-promoslist">
                <!--[if BLOCK]><![endif]--><?php if(!empty($noticeboards) && $noticeboards->isNotEmpty()): ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $noticeboards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="am-promoowrap">
                                <div class="am-promoowrap_date">
                                    <em>June 27, 2024</em>
                                    <span wire:click="editNoticeboard(<?php echo e($item->id); ?>)" class="am-editpromo">
                                        <svg opacity="0.5" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path d="M8.75065 2.91675C8.75065 4.20541 9.79532 5.25008 11.084 5.25008M2.33398 11.6667L2.69563 9.8585C2.77803 9.44651 2.81923 9.24051 2.89458 9.04842C2.96145 8.87792 3.04817 8.71589 3.15294 8.56567C3.27098 8.39643 3.41952 8.24788 3.71662 7.95079L9.33406 2.3334C9.65211 2.01536 9.81114 1.85633 9.98268 1.77132C10.3091 1.60956 10.6923 1.60957 11.0188 1.77133C11.1903 1.85635 11.3493 2.01538 11.6674 2.33343V2.33343C11.9854 2.65148 12.1444 2.8105 12.2294 2.98205C12.3912 3.30846 12.3912 3.69169 12.2294 4.01811C12.1444 4.18965 11.9854 4.34867 11.6674 4.66671L6.04994 10.2841C5.75285 10.5812 5.6043 10.7298 5.43506 10.8478C5.28484 10.9526 5.12281 11.0393 4.95231 11.1062C4.76022 11.1815 4.55423 11.2227 4.14224 11.3051L2.33398 11.6667Z" stroke="#585858" stroke-width="1.3125" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    <span @click="$wire.dispatch('showConfirm', { id : <?php echo e($item->id); ?>, action : 'delete-noticeboard' })" class="am-deletepromo">
                                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none">
                                            <g opacity="0.5">
                                                <path d="M4 12.19L12 4.19M4 4.19L12 12.19" stroke="#585858" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                                <div class="am-description">
                                    <p><?php echo $item->content; ?></p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                        <div class="cr-no-record-container">
                            <h6><?php echo e(__('courses::courses.no_records_found')); ?></h6>
                            <p> <?php echo e(__('courses::courses.no_records_available')); ?></p>
                        </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </ul>
        </div>
   
    <div class="am-themeform_footer">
        <a href="<?php echo e($backRoute); ?>">
            <button class="am-white-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M10.5 4.5L6 9L10.5 13.5" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <?php echo e(__('courses::courses.back')); ?>

            </button>
        </a>
        <a href="javascript:void(0)" wire:click="save" class="am-btn">
            <?php echo e(__('courses::courses.save_continue')); ?>

        </a>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('modules/courses/css/main.css')); ?>">
 <?php echo app('Illuminate\Foundation\Vite')([
    'public/summernote/summernote-lite.min.css',
 ]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
 <script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>
 <script type="text/javascript">
     document.addEventListener('DOMContentLoaded', (event) => {
         setTimeout(() => {
             $('#content').summernote('destroy');
             $('#content').summernote(summernoteConfigs('#content','.characters-count'));
         }, 0);
     });

    document.addEventListener('livewire:initialized', function() {
        $(document).on('summernote.change', '#content', function(we, contents, $editable) {
            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set("content",contents, false);
        });
    });

    document.addEventListener('updateContent', function(evt) {
        $('#content').summernote('code', evt?.detail?.content);
    });
 </script>
<?php $__env->stopPush(); ?>

<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Courses/resources/views/livewire/tutor/course-creation/components/course-noticeboard.blade.php ENDPATH**/ ?>