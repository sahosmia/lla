<div class="tb-translator tb-translatorwrap">
    <div class="am-insights_title">
        <h2><?php echo e(__('general.language_translations')); ?></h2>
    </div>
    <div class="tb-langtranswrap">
        <form class="tb-themeform tb-langtrans-form">
            <fieldset>
                <div class="form-group-wrap">
                    <div class="form-group">
                        <label class="tb-label"><?php echo e(__('general.languages')); ?></label>
                        <div class="tk-error <?php $__errorArgs = ['targetLang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <div class="tb-select" wire:ignore>
                                <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="true" data-live='true' id="target-language" data-wiremodel="targetLang" placeholder="<?php echo e(__('general.select_language')); ?>">
                                    <option value=""><?php echo e(__('general.select_language')); ?></option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($code); ?>"><?php echo e($name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]--> 
                                </select>
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['targetLang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="tk-errormsg">
                                <span><?php echo e($message); ?></span>
                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div class="form-group">
                        <label class="tb-label"><?php echo e(__('general.translation_method')); ?></label>
                        <div class="tb-switchbtn">
                            <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes"><?php echo e($translationMethod ? __('general.continue_with_queue_job') : __('general.continue_without_queue_job')); ?> </span></label>
                            <input class="tb-checkaction" wire:model.live="translationMethod" type="checkbox" id="status" checked="">
                        </div>
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if($translationMethod): ?>
                        <div class="form-group">
                            <div  class="am-translationprogress"
                                x-data="{
                                    init() {
                                        const savedId = sessionStorage.getItem('translate_job_id');
                                        if (savedId && !window.location.search.includes('job_id=')) {
                                            window.location.href = '?job_id=' + savedId;
                                            }
                            
                                        Livewire.on('jobStarted', jobId => {
                                            sessionStorage.setItem('translate_job_id', jobId);
                                            window.location.href = '?job_id=' + jobId;
                                            });
                                    }
                                    }"
                                x-init="init()">
                                <!--[if BLOCK]><![endif]--><?php if($running && $progress <= 100): ?>
                                    <div wire:poll.2000ms="pollProgress" class="am-uploadedfil">
                                        <div class="uploadbar-wrap">
                                            <span id="file-name" class="uploaded-zip"><?php echo e(__('general.translation_in_progress')); ?></span>
                                            <div class="uploadbar progress">
                                                <div 
                                                    id="progress-bar"
                                                    class="progress-bar progress-bar-striped progress-bar-animated"
                                                    role="progressbar"
                                                    style="width: <?php echo e($progress); ?>%;"
                                                    aria-valuenow="<?php echo e($progress); ?>"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                                >
                                                    <?php echo e($progress); ?>%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->    
                    <!--[if BLOCK]><![endif]--><?php if(!$running): ?>
                        <div class="form-group">
                            <button type="button" wire:target="translateLangFiles" wire:loading.class="tb-btn_disable" class="tb-btn" wire:click="translateLangFiles"><?php echo e(__('general.translate')); ?></button>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </fieldset>
        </form>
        <!--[if BLOCK]><![endif]--><?php if($translationMethod): ?>
            <div class="am-insights_notice">
                <strong><?php echo e(__('general.note')); ?></strong>
                <div class="am-alertmsg">
                    <strong><?php echo e(__('general.translation_in_background')); ?></strong>
                    <p><?php echo e(__('general.translation_in_background_note')); ?></p>

                    <strong><?php echo e(__('general.why_this_is_recommended')); ?></strong>
                    <ul>
                        <li><?php echo e(__('general.why_this_is_recommended_1')); ?></li>

                        <li><?php echo e(__('general.why_this_is_recommended_2')); ?></li>
                    </ul>
                    <p><?php echo e(__('general.need_a_language')); ?><em><?php echo e(__('general.site_management')); ?></em> <?php echo e(__('general.and_enable_it_under')); ?> <strong><?php echo e(__('general.multi_language_selection')); ?></strong> </p>
                    
                </div>
            </div>
        <?php else: ?>
            <div id="instant-mode" class="am-insights_notice">
                <strong><?php echo e(__('general.note')); ?></strong>
                <div class="am-alertmsg">
                    <strong><?php echo e(__('general.instant_mode')); ?></strong>
                    <p><?php echo e(__('general.instant_mode_note')); ?> <strong><?php echo e(__('general.not_refresh_close_or_leave')); ?></strong></p>
        
                    <p><?php echo e(__('general.need_a_language')); ?><em><?php echo e(__('general.site_management')); ?></em> <?php echo e(__('general.and_enable_it_under')); ?> <strong><?php echo e(__('general.multi_language_selection')); ?></strong></p>
            
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div><?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/admin/language-translator/language-translator.blade.php ENDPATH**/ ?>