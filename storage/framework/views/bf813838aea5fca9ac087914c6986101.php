<div class="am-insights am-upgradewrapper" x-data="{ uploading: false, progress: 0, fileName: '' }">
    <div class="am-insights_section am-revenue">
        <div class="am-insights_header">
            <div class="am-insights_title">
                <h2><?php echo e(__('admin/general.lernen_upgrade')); ?></h2>
                <p><?php echo e(__('admin/general.lernen_upgrade_desc')); ?></p>
            </div>
            <div class="am-insights_actions">
                <em><?php echo e(__('admin/general.current_version')); ?>:</em>
                <span>
                    <?php echo e($currentVersion); ?>

                </span>
            </div>
        </div>
        <div class="am-insights_notice">
            <p><strong><?php echo __('admin/general.note'); ?></strong> <i class="text-warning"><?php echo __('admin/general.upgrade_warning', ['addons' => '<strong><a href="/admin/packages" class="text-danger">Manage Addons</a></strong>']); ?></i></p>
        </div>
        <div class="am-insights_content am-upgrade">
            <form>
                <div class="am-insights_content_inner" role="alert">
                    <div>
                        <strong class="tb-block"><?php echo e(__('admin/general.server_requirements')); ?></strong>
                        <ul class="tb-warning-list">
                            <li>post_max_size = 512M</li>
                            <li>upload_max_filesize = 512M</li>
                            <li><?php echo e(__('admin/general.should_be_writable', ['path' => base_path()])); ?></li>
                            <li><?php echo e(__('admin/general.should_be_writable', ['path' => base_path('vendor')])); ?></li>
                            <li><?php echo e(__('admin/general.symlink_should_be_enabled')); ?></li>
                        </ul>
                    </div>
                    <div>
                        <strong class="tb-block"><?php echo e(__('admin/general.current_server_values')); ?></strong>
                        <ul class="tb-warning-list">
                            <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'tk-successmsg' => $isPostMaxSizeValid,
                                'tk-errormsg' => !$isPostMaxSizeValid
                            ]); ?>">
                                <i class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'icon-check-circle' => $isPostMaxSizeValid,
                                    'icon-x-circle' => !$isPostMaxSizeValid
                                ]); ?>"></i>
                                post_max_size = <?php echo e($postMaxSize); ?>

                            </li>
                            <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'tk-successmsg' => $isUploadMaxFilesizeValid,
                                'tk-errormsg' => !$isUploadMaxFilesizeValid
                            ]); ?>">
                                <i class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'icon-check-circle' => $isUploadMaxFilesizeValid,
                                    'icon-x-circle' => !$isUploadMaxFilesizeValid
                                ]); ?>"></i>
                                upload_max_filesize = <?php echo e($uploadMaxFilesize); ?>

                            </li>
                            <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'tk-successmsg' => is_writable(base_path()),
                                'tk-errormsg' => !is_writable(base_path())
                            ]); ?>">
                                <i class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'icon-check-circle' => is_writable(base_path()),
                                    'icon-x-circle' => !is_writable(base_path())
                                ]); ?>"></i>
                                <?php echo e(__('admin/general.should_be_writable', ['path' => base_path()])); ?>

                            </li>
                            <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'tk-successmsg' => is_writable(base_path('vendor')),
                                'tk-errormsg' => !is_writable(base_path('vendor'))
                            ]); ?>">
                                <i class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'icon-check-circle' => is_writable(base_path('vendor')),
                                    'icon-x-circle' => !is_writable(base_path('vendor'))
                                ]); ?>"></i>
                                <?php echo e(__('admin/general.should_be_writable', ['path' => base_path('vendor')])); ?>

                            </li>
                            <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'tk-successmsg' => $symlinkAllowed,
                                'tk-errormsg'   => !$symlinkAllowed
                            ]); ?>">
                                <i class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'icon-check-circle' => $symlinkAllowed,
                                    'icon-x-circle' => !$symlinkAllowed
                                ]); ?>"></i>
                                <?php echo e(__('admin/general.symlink_enabled')); ?>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="am-insights_content_uploadfile"
                    x-on:livewire-upload-start="uploading = true"
                    x-on:livewire-upload-cancel="uploading = false"
                    x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress;"
                >
                    <h6><?php echo e(__('admin/general.choose_file')); ?></h6>
                    <label for="file" class="tb-label">
                        <div class="am-insights_content_uploadfile_icon">
                            <i class="icon-upload-cloud"></i>
                            <input type="file" class="form-control" id="file" wire:model="file" accept=".zip" x-on:change="fileName = $el.files[0].name">
                        </div>
                        <p><?php echo e(__('admin/general.upload_upgrade_file')); ?></p>
                    </label>
                    <div class="am-uploadedfile" x-cloak x-show="uploading"> 
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="uploadbar-wrap">
                            <span x-text="fileName" class="uploaded-zip"></span>
                            <div class="uploadbar progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="{width: progress + '%'}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-text="progress + '%'"></div>
                                <button type="button" wire:click="$cancelUpload('file')"><i class="fa fa-times"></i></button>  
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="tb-btn am-insights_btn <?php if(empty($file)): ?> tb-btn_disabled <?php endif; ?> <?php if(!$isPostMaxSizeValid || !$isUploadMaxFilesizeValid || !$symlinkAllowed || !is_writable(base_path())): ?> tb-btn_disabled <?php endif; ?>" wire:loading.class="tb-btn_disable" wire:click="upgradeLernen"><?php echo e(__('admin/general.upgrade')); ?></button>
            </form>
            <!--[if BLOCK]><![endif]--><?php if($validationErrors): ?>
            <div class="error-messages">
                <ul>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $validationErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/upgrade/upgrade.blade.php ENDPATH**/ ?>