<div class="am-resumebox_content" wire:init="loadData">
    <?php $__env->slot('title'); ?>
        <?php echo e(__('certificate.certificate_details')); ?>

    <?php $__env->endSlot(); ?>
    <div class="am-resumewrap">
        <!--[if BLOCK]><![endif]--><?php if($isLoading): ?>
        <?php echo $__env->make('skeletons.certificate', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <!--[if BLOCK]><![endif]--><?php if(!$certificates->isEmpty()): ?>
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2><?php echo e(__('certificate.certificate_details')); ?></h2>
                    <p><?php echo e(__('certificate.certificate_message')); ?></p>
                </div>
                <button class="am-btn am-btnsmall" wire:click="addCertificate" wire:loading.class="am-btn_disable">
                    <?php echo e(__('general.add_new')); ?>

                    <i class="am-icon-plus-02"></i>
                </button>
            </div>
            <div class="am-resume">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="am-resume_item am-resume_wrap">
                    <!--[if BLOCK]><![endif]--><?php if(!empty($certificate->image)): ?>
                    <img src="<?php echo e(url(Storage::url($certificate->image))); ?>" alt="image">
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="am-resume_content">
                        <div class="am-resume_item_title">
                            <h3><?php echo e($certificate->title); ?></h3>
                            <div class="am-itemdropdown">
                                <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="am-icon-ellipsis-horizontal-02"></i>
                                </a>
                                <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li>
                                        <a href="#" wire:click="editCertificate(<?php echo e($certificate); ?>)">
                                            <i class="am-icon-pencil-02"></i>
                                            <?php echo e(__('certificate.edit_certificate')); ?>

                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="am-del-btn" @click="$wire.dispatch('showConfirm', { id : <?php echo e($certificate->id); ?>, action : 'delete-certificate' })">
                                            <i class="am-icon-trash-02"></i>
                                            <?php echo e(__('certificate.delete_certificate')); ?>

                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div id="certificate-model-<?php echo e($certificate->id); ?>" class="modal am-educationpopup" tabindex="-1"
                                role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="am-modal-header">
                                            <?php echo e(__('certificate.certificate_description')); ?>

                                            <span data-bs-dismiss="modal" class="am-closepopup">
                                                <i class="am-icon-multiply-01"></i>
                                            </span>
                                        </div>
                                        <div class="am-modal-body">
                                            <p><?php echo e($certificate->description); ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="am-btn"
                                                x-on:click="$('#certificate-model-<?php echo e($certificate->id); ?>').modal('hide')"><?php echo e(__('general.close_btn')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="am-resume_item_info">
                            <li>
                                <span>
                                    <i class="am-icon-book-1"></i>
                                    <?php echo e($certificate->institute_name); ?>

                                </span>
                            </li>
                            <li>
                                <span>
                                    <i class="am-icon-calender-minus"></i>
                                    <?php echo e(__('certificate.issued')); ?> <?php echo e(date('M d, Y', strtotime($certificate->issue_date))); ?>

                                </span>
                            </li>
                            <li>
                                <span>
                                    <i class="am-icon-calender-xmark"></i>
                                    <?php echo e(__('certificate.expiry')); ?> <?php echo e(date('M d, Y', strtotime($certificate->expiry_date))); ?>

                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php else: ?>
            <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/certificate.png'),'title' => __('general.no_record_title'),'description' => __('general.no_record_desc'),'btnText' => __('certificate.add_new_certificate'),'wire:click' => 'addCertificate']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/certificate.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_record_title')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_record_desc')),'btn_text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('certificate.add_new_certificate')),'wire:click' => 'addCertificate']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $attributes = $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $component = $__componentOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <div wire:ignore.self class="modal fade am-educationpopup" id="certificate-popup" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2>
                            <!--[if BLOCK]><![endif]--><?php if($updateMode): ?>
                            <?php echo e(__('certificate.update_new_certificate')); ?>

                            <?php else: ?>
                            <?php echo e(__('certificate.add_new_certificate')); ?>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </h2>
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form wire:submit="storeCertificate" class="am-themeform">
                            <fieldset>
                                <div class="form-group">
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'image','class' => 'am-important','value' => __('certificate.image_title')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'image','class' => 'am-important','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('certificate.image_title'))]); ?>
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
                                    <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-profile-<?php echo e(time()); ?>">
                                        <div class="tk-draganddrop"
                                            x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading  }"
                                            x-on:drop.prevent="isUploading = true;isDragging = false"
                                            wire:drop.prevent="$upload('form.image', $event.dataTransfer.files[0])">
                                            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['name' => 'file','type' => 'file','id' => 'at_upload_photo','xRef' => 'file_upload','accept' => ''.e(!empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*').'','xOn:change' => ' isUploading = true; $wire.upload(\'form.image\', $refs.file_upload.files[0])']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file','type' => 'file','id' => 'at_upload_photo','x-ref' => 'file_upload','accept' => ''.e(!empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*').'','x-on:change' => ' isUploading = true; $wire.upload(\'form.image\', $refs.file_upload.files[0])']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                            <label for="at_upload_photo" class="am-uploadfile">
                                                <span class="am-dropfileshadow">
                                                    <svg class="am-border-svg "><rect width="100%" height="100%" rx="12"></rect></svg>
                                                    <i class="am-icon-plus-02"></i>
                                                    <span class="am-uploadiconanimation">
                                                        <i class="am-icon-upload-01"></i>
                                                    </span>
                                                    <?php echo e(__('general.drop_file_here')); ?>

                                                </span>
                                                <em>
                                                    <i class="am-icon-export-03"></i>
                                                </em>
                                                <span><?php echo e(__('general.drop_file_here_or')); ?> <i> <?php echo e(__('general.click_here_file')); ?> </i> <?php echo e(__('general.to_upload')); ?> <em><?php echo e($fileExt); ?> (max. <?php echo e($allowImageSize); ?> MB)</em></span>
                                            </label>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($form->image)): ?>
                                        <div class="am-uploadedfile">
                                            <!--[if BLOCK]><![endif]--><?php if(method_exists($form->image,'temporaryUrl')): ?>
                                            <img src="<?php echo e($form->image->temporaryUrl()); ?>">
                                            <?php else: ?>
                                            <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : url(Storage::url($form->image))); ?>">
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]--><?php if(method_exists($form->image,'temporaryUrl')): ?>
                                            <span><?php echo e(basename(parse_url($form->image->temporaryUrl(), PHP_URL_PATH))); ?></span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <a href="#" wire:click.prevent="removePhoto()" class="am-delitem">
                                                <i class="am-icon-trash-02"></i>
                                            </a>
                                        </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.image']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.image']); ?>
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
                                <div class="form-group <?php $__errorArgs = ['form.title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'title','class' => 'am-important','value' => __('certificate.certificate_title')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'title','class' => 'am-important','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('certificate.certificate_title'))]); ?>
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
                                    <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['wire:model' => 'form.title','id' => 'title','name' => 'title','placeholder' => ''.e(__('certificate.title_placeholder')).'','type' => 'text','autofocus' => true,'autocomplete' => 'name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'form.title','id' => 'title','name' => 'title','placeholder' => ''.e(__('certificate.title_placeholder')).'','type' => 'text','autofocus' => true,'autocomplete' => 'name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.title']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.title']); ?>
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
                                <div class="form-group <?php $__errorArgs = ['form.institute_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'institute_name','class' => 'am-important','value' => __('certificate.university')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'institute_name','class' => 'am-important','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('certificate.university'))]); ?>
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
                                    <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['wire:model' => 'form.institute_name','id' => 'institute_name','name' => 'institute_name','placeholder' => ''.e(__('certificate.university_placeholder')).'','type' => 'text','autofocus' => true,'autocomplete' => 'name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'form.institute_name','id' => 'institute_name','name' => 'institute_name','placeholder' => ''.e(__('certificate.university_placeholder')).'','type' => 'text','autofocus' => true,'autocomplete' => 'name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.institute_name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.institute_name']); ?>
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
                                <div class="form-group form-group-two-wrap">
                                    <div class="<?php $__errorArgs = ['form.issue_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'issue_date','class' => 'am-important','value' => __('certificate.issue_date')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'issue_date','class' => 'am-important','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('certificate.issue_date'))]); ?>
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
                                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['wire:model' => 'form.issue_date','class' => 'flat-date','id' => 'datepicker','name' => 'issue_date','placeholder' => ''.e(__('certificate.issue_date_placeholder')).'','dataFormat' => 'Y-m-d','type' => 'text','dataModal' => 'true','autofocus' => true,'autocomplete' => 'name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'form.issue_date','class' => 'flat-date','id' => 'datepicker','name' => 'issue_date','placeholder' => ''.e(__('certificate.issue_date_placeholder')).'','data-format' => 'Y-m-d','type' => 'text','data-modal' => 'true','autofocus' => true,'autocomplete' => 'name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.issue_date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.issue_date']); ?>
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
                                    <div class="<?php $__errorArgs = ['form.expiry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'expiry_date','class' => 'am-important','value' => __('certificate.expiry_date')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'expiry_date','class' => 'am-important','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('certificate.expiry_date'))]); ?>
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
                                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['wire:model' => 'form.expiry_date','class' => 'flat-date','id' => 'datepicker','name' => 'expiry_date','placeholder' => ''.e(__('certificate.expiry_date_placeholder')).'','dataFormat' => 'Y-m-d','type' => 'text','dataModal' => 'true','autofocus' => true,'autocomplete' => 'name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'form.expiry_date','class' => 'flat-date','id' => 'datepicker','name' => 'expiry_date','placeholder' => ''.e(__('certificate.expiry_date_placeholder')).'','data-format' => 'Y-m-d','type' => 'text','data-modal' => 'true','autofocus' => true,'autocomplete' => 'name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.expiry_date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.expiry_date']); ?>
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
                                <div class="form-group <?php $__errorArgs = ['form.description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <div class="am-label-wrap">
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'description','value' => __('certificate.description')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'description','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('certificate.description'))]); ?>
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
                                        <!--[if BLOCK]><![endif]--><?php if(setting('_ai_writer_settings.enable_on_awards_settings') == '1'): ?>
                                            <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal"  data-prompt-type="awards" data-parent-model-id="certificate-popup" data-target-selector="#description" data-target-summernote="true">
                                                <img src="<?php echo e(asset('images/ai-icon.svg')); ?>" alt="AI">
                                                <?php echo e(__('general.write_with_ai')); ?>

                                            </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="am-custom-editor" wire:ignore>
                                        <textarea id="description" class="form-control"
                                            placeholder="<?php echo e(__('certificate.description_placeholder')); ?>"></textarea>
                                        <span class="total-characters">
                                            <div class='tu-input-counter'>
                                                <span><?php echo e(__('general.char_left')); ?>:</span>
                                                <b>
                                                    <?php echo $MAX_PROFILE_CHAR - Str::length($form->description); ?>

                                                </b> <em>/ <?php echo e($MAX_PROFILE_CHAR); ?></em>
                                            </div>
                                        </span>
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
                                <div class="form-group am-form-btns">
                                    <button type="submit" class="am-btn" wire:loading.class="am-btn_disable"><?php echo e(__('general.save_update')); ?></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')([
'public/css/flatpicker.css',
'public/summernote/summernote-lite.min.css',
'public/css/flatpicker-month-year-plugin.css'
]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('js/flatpicker.js')); ?>"></script>
<script defer src="<?php echo e(asset('js/flatpicker-month-year-plugin.js')); ?>"></script>
<script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>

<script type="text/javascript" data-navigate-once>
    var component = '';
    document.addEventListener('livewire:navigated', function() {
        component = window.Livewire.find('<?php echo e($_instance->getId()); ?>');
    });
    document.addEventListener('livewire:initialized', function() {
        $(document).on('show.bs.modal','#certificate-popup', function () {
            setTimeout(() => {
                initializeDatePicker()
            }, 100);
            var initialContent = component.get('form.description');
            $('#description').summernote('destroy');
            $('#description').summernote(summernoteConfigs('#description', '.total-characters'));
            $('#description').summernote('code', initialContent);

            $(document).on('summernote.change', '#description', function(we, contents, $editable) {
                component.set("form.description",contents, false);
                updateCharacterCounter();
            });
            updateCharacterCounter();
        });

        function updateCharacterCounter() {

            let contentLength = $('#description').summernote('code').replace(/(<([^>]+)>)/gi, "").length;
            let maxChars = <?php echo $MAX_PROFILE_CHAR; ?>;
            let charsLeft = maxChars - contentLength;

            $('.total-characters b').text(charsLeft);
        }

        document.addEventListener('loadPageJs', (event) => {
            component.dispatch('initSelect2', {target:'.am-select2'});
            setTimeout(() => {
                $('#description').summernote('destroy');
                $('#description').summernote(summernoteConfigs('#description','.total-characters'));
                initializeDatePicker()
            }, 500);
        })
    })

</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/common/profile-settings/resume/certificate.blade.php ENDPATH**/ ?>