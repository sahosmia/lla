

<div class="form-group">
    <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-media-<?php echo e(time()); ?>">
        <div class="tk-draganddrop"
            x-on:drop.prevent="isUploading = true; isDragging = false"
            wire:drop.prevent="$upload('questionMedia', $event.dataTransfer.files[0])">
            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['name' => 'file','type' => 'file','id' => 'at_upload_media','xRef' => 'file_upload','accept' => ''.e(join(',', array_map(function($ex){return('.'.$ex);}, array_merge($allowImgFileExt, $allowVideoExt)))).'','xOn:change' => 'isUploading = true; $wire.upload(\'questionMedia\', $refs.file_upload.files[0])']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file','type' => 'file','id' => 'at_upload_media','x-ref' => 'file_upload','accept' => ''.e(join(',', array_map(function($ex){return('.'.$ex);}, array_merge($allowImgFileExt, $allowVideoExt)))).'','x-on:change' => 'isUploading = true; $wire.upload(\'questionMedia\', $refs.file_upload.files[0])']); ?>
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
            <label for="at_upload_media" class="am-uploadfile">
                <span class="am-dropfileshadow">
                    <i class="am-icon-plus-02"></i>
                    <span class="am-uploadiconanimation">
                        <i class="am-icon-upload-03"></i>
                    </span>
                    <?php echo e(__('general.drop_file_here')); ?>

                </span>
                <em>
                    <i class="am-icon-export-03"></i>
                </em>
                <span><?php echo e(__('general.drop_file_here_or')); ?> <i> <?php echo e(__('general.click_here_file')); ?> </i> <?php echo e(__('general.to_upload')); ?> 
                    <em><?php echo e(join(', ', $allowImgFileExt)); ?> (max. <?php echo e($allowImageSize); ?> MB )</em>
                </span>
                <svg class="am-border-svg "><rect width="100%" height="100%" rx="12"></rect></svg>
            </label>
        </div>
    
        <!--[if BLOCK]><![endif]--><?php if(!empty($questionMedia)): ?>
            <div class="am-uploadedfile" x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }">
                <!--[if BLOCK]><![endif]--><?php if($mediaType == 'image'): ?>
                    <!--[if BLOCK]><![endif]--><?php if(method_exists($questionMedia,'temporaryUrl')): ?>
                        <img src="<?php echo e($questionMedia->temporaryUrl()); ?>">
                    <?php else: ?>
                        <img src="<?php echo e(url(Storage::url($questionMedia))); ?>">
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php elseif($mediaType == 'video'): ?>
                    <a href="<?php echo e(url(Storage::url($questionMedia))); ?>" data-vbtype="iframe" data-gall="gall" class="tu-themegallery tu-thumbnails_content">
                        <figure>
                            <img src="<?php echo e(asset('images/video.jpg')); ?>" alt="<?php echo e(__('profile.intro_video')); ?>">
                        </figure>
                        <i class="fas fa-play"></i>
                    </a>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!--[if BLOCK]><![endif]--><?php if(method_exists($questionMedia,'temporaryUrl')): ?>
                    <span><?php echo e(basename(parse_url($questionMedia->temporaryUrl(), PHP_URL_PATH))); ?></span>
    
                <?php else: ?>
                    <span><?php echo e(basename(parse_url($questionMedia, PHP_URL_PATH))); ?></span>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <a href="#" wire:click.prevent="removeMedia('questionMedia')" class="am-delitem">
                    <i class="am-icon-trash-02"></i>
                </a>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => ''.e($questionMedia).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => ''.e($questionMedia).'']); ?>
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
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/elements/question-image.blade.php ENDPATH**/ ?>