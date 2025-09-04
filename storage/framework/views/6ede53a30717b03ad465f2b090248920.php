<main class="main-content" x-data="{ 
    isDragging: false,
    activeTab: <?php if ((object) ('media_type') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('media_type'->value()); ?>')<?php echo e('media_type'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('media_type'); ?>')<?php endif; ?>,
    isOpenModal: false,
get popupHeading() {
    return this.activeTab == 'media' 
        ? `<?php echo e(__('upcertify::upcertify.media')); ?>`
        : this.activeTab == 'pattern' 
            ? `<?php echo e(__('upcertify::upcertify.pattern')); ?>`
            : `<?php echo e(__('upcertify::upcertify.attachment')); ?>`;
},
    customActiveTab(tab, event) {
        event.stopPropagation();
       
        this.activeTab = tab;
        let target = event.target.getAttribute('data-target');
        if (!target && event.target.parentElement) {
            target = event.target.parentElement.getAttribute('uc-data-target');
        }
        openModal(target);
        this.isOpenModal = true;
        toggleAccordion('accordion-'+tab, true);
    },
    closePopupModal(){
        closeModal();
        this.isOpenModal = false;
        this.isDragging = false;
        window.Livewire.find('<?php echo e($_instance->getId()); ?>').resetErrors();
    }
    }" x-on:dragover.prevent="isDragging = true" x-on:drop="isDragging = false" x-on:ondragleave.prevent="isDragging = false">
    <div class="uc-main-wrap" wire:ignore.self>
        <aside class="uc-sidenav_wrap">
            <?php echo $__env->make('upcertify::livewire.sidepanel.sidebar.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('upcertify::livewire.sidepanel.'.$tab.'.'.$tab, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </aside>
        <div class="uc-main-content">
            <div class="uc-header">
                    <strong><?php echo e($title); ?></strong>
                <div wire:ignore class="uc-header_actions">
                    <!-- <button type="button" class="uc-btn uc-outline-btn">
                        <i class="am-icon-forward-4"></i>
                    </button>
                    <button type="button" class="uc-btn uc-outline-btn">
                        <i class="am-icon-forward-5"></i>
                    </button>
                    <button type="button" class="uc-btn uc-outline-btn uc-previewbtn">
                        Preview
                    </button> -->
                    <!--[if BLOCK]><![endif]--><?php if( !empty($id)): ?>
                        <button type="button" class="uc-btn uc-btn-primary uc-publish-certificate">
                                <?php echo e(__('upcertify::upcertify.publish_certificate')); ?>

                        </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
            <div id="uc-course_wrap" class="uc-course_wrap" wire:ignore>
                <div class="uc-course" id="uc-canvas-wrap">
                    <div class="uc-course_optionwrap">
                        <div class="uc-course_editbar">
                            <div class="uc-course_options">
                                <div class="uc-course_options_font-size">
                                    <div class="uc-font-size-input">
                                        <span id="uc-course_font-size" class="uc-course_font-size"></span>
                                        <button class="uc-font-size-dropdown">
                                            <?php if (isset($component)) { $__componentOriginalee1cfdfcff4ca19a8f3dc5060fe9b85e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee1cfdfcff4ca19a8f3dc5060fe9b85e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.chevron-down','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.chevron-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee1cfdfcff4ca19a8f3dc5060fe9b85e)): ?>
<?php $attributes = $__attributesOriginalee1cfdfcff4ca19a8f3dc5060fe9b85e; ?>
<?php unset($__attributesOriginalee1cfdfcff4ca19a8f3dc5060fe9b85e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee1cfdfcff4ca19a8f3dc5060fe9b85e)): ?>
<?php $component = $__componentOriginalee1cfdfcff4ca19a8f3dc5060fe9b85e; ?>
<?php unset($__componentOriginalee1cfdfcff4ca19a8f3dc5060fe9b85e); ?>
<?php endif; ?>
                                        </button>
                                    </div>
                                    <div class="uc-font-size-slider uc-none">
                                        <div id="font-size-slider"></div>
                                    </div>
                                </div>
                                <div class="uc-course_options_color uc-colorPicker">
                                    <input type="text" name="uc-course_color" class="uc-course_color" value="#000000">
                                    <span class="uc-colorPicker-preview"></span>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if(!empty($fonts)): ?>
                                    <div class="uc-select">
                                        <span class="uc-select-title" data-showmore_text="<?php echo e(__('upcertify::upcertify.show_more')); ?>" data-placeholder_text="<?php echo e(__('upcertify::upcertify.search_font')); ?>"><?php echo e(__('upcertify::upcertify.select_font')); ?></span>
                                        <ul id="uc-fonts" class="uc-fontoptions">
                                            <li class="uc-fonts-search"><input type="text" class="uc-fontoption-search" placeholder="<?php echo e(__('upcertify::upcertify.search_font')); ?>"></li>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = array_slice($fonts, 0, 10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $font): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li id="font-<?php echo e($key); ?>" class="uc-fontoption">
                                                    <a href="javascript:void(0);" class="uc-fontoption-item" data-font="<?php echo e($font['family']); ?>">
                                                        <?php echo e($font['family']); ?>

                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if(count($fonts) > 10): ?>
                                                <li class="uc-fonts-showmore">
                                                    <a href="javascript:void(0);">
                                                        <?php echo e(__('upcertify::upcertify.show_more')); ?>

                                                    </a>
                                                </li>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </ul>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="uc-course_options_align">
                                    <a href="javascript:void(0);" class="uc-alignleft" data-action_class="uc-alignment-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M7.75 4.25H16.5V5.5H7.75V4.25ZM7.75 8H14V9.25H7.75V8ZM7.75 11.75H16.5V13H7.75V11.75ZM7.75 15.5H14V16.75H7.75V15.5ZM4 3H5.25V18H4V3Z" fill="#212529"/>
                                    </svg>
                                    </a>
                                    <a href="javascript:void(0);" class="uc-aligncenter" data-action_class="uc-alignment-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M2 3H17V4.5H2V3ZM5 7.5H14V9H5V7.5ZM2 12H17V13.5H2V12ZM5 16.5H14V18H5V16.5Z" fill="#212529"/>
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0);" class="uc-alignright" data-action_class="uc-alignment-right">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M2 4.25H12.5V5.5H2V4.25ZM5 8H12.5V9.25H5V8ZM2 11.75H12.5V13H2V11.75ZM5 15.5H12.5V16.75H5V15.5ZM15.5 3H17V18H15.5V3Z" fill="#212529"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="uc-course_options_more">
                                    <a href="javascript:void(0);" class="uc-bold" data-action_class="uc-text-bold">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4.64286C5 3.18325 6.18325 2 7.64286 2H9.25C11.5972 2 13.5 3.90279 13.5 6.25C13.5 7.55721 12.9098 8.72658 11.9814 9.50619C14.221 9.62636 16 11.4804 16 13.75C16 16.0972 14.0972 18 11.75 18H8.35714C6.50304 18 5 16.497 5 14.6429V4.64286ZM6 10.5V14.6429C6 15.9447 7.05533 17 8.35714 17H11.75C13.5449 17 15 15.5449 15 13.75C15 11.9551 13.5449 10.5 11.75 10.5H6ZM6 9.5H9.25C11.0449 9.5 12.5 8.04493 12.5 6.25C12.5 4.45507 11.0449 3 9.25 3H7.64286C6.73553 3 6 3.73553 6 4.64286V9.5Z" fill="#585858"/> </svg>
                                    </a>
                                    <a href="javascript:void(0);" class="uc-italic" data-action_class="uc-text-italic">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.2839 2.00008H10.0806C9.80447 2.00008 9.58062 2.22394 9.58062 2.50008C9.58062 2.77622 9.80447 3.00007 10.0806 3.00007H10.7001L8.29157 16.9999H7.49999C7.22386 16.9999 7 17.2238 7 17.4999C7 17.7761 7.22386 17.9999 7.49999 17.9999H8.70447C8.71049 18 8.7165 18 8.72249 17.9999H9.91933C10.1955 17.9999 10.4193 17.7761 10.4193 17.4999C10.4193 17.2238 10.1955 16.9999 9.91933 16.9999H9.30625L11.7148 3.00007H12.4999C12.7761 3.00007 12.9999 2.77622 12.9999 2.50008C12.9999 2.22394 12.7761 2.00008 12.4999 2.00008H11.3019C11.2959 1.99997 11.2899 1.99997 11.2839 2.00008Z" fill="#585858"/> </svg>
                                    </a>
                                    <a href="javascript:void(0);" class="uc-underline" data-action_class="uc-text-underline">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 2C5.77614 2 6 2.22386 6 2.5V8.88298C6 11.437 8.02459 13.4894 10.5 13.4894C12.9754 13.4894 15 11.437 15 8.88298V2.5C15 2.22386 15.2239 2 15.5 2C15.7761 2 16 2.22386 16 2.5V8.88298C16 11.9693 13.5474 14.4894 10.5 14.4894C7.45256 14.4894 5 11.9693 5 8.88298V2.5C5 2.22386 5.22386 2 5.5 2ZM5 17.5C5 17.2239 5.22386 17 5.5 17H15.5C15.7761 17 16 17.2239 16 17.5C16 17.7761 15.7761 18 15.5 18H5.5C5.22386 18 5 17.7761 5 17.5Z" fill="#585858"/> </svg>
                                    </a>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <?php if (isset($component)) { $__componentOriginal05870b75444afb7df62bf18c56ad5d9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal05870b75444afb7df62bf18c56ad5d9d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.body','data' => ['body' => $body]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['body' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($body)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal05870b75444afb7df62bf18c56ad5d9d)): ?>
<?php $attributes = $__attributesOriginal05870b75444afb7df62bf18c56ad5d9d; ?>
<?php unset($__attributesOriginal05870b75444afb7df62bf18c56ad5d9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal05870b75444afb7df62bf18c56ad5d9d)): ?>
<?php $component = $__componentOriginal05870b75444afb7df62bf18c56ad5d9d; ?>
<?php unset($__componentOriginal05870b75444afb7df62bf18c56ad5d9d); ?>
<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Add media popup -->
    <div id="uc-addmediapopup" class="uc-modal uc-addmediapopup" wire:ignore.self>
        <div class="uc-modaldialog">
            <div class="uc-modal_wrap">
                <div class="uc-modal_title">
                    <h2 x-text="popupHeading"></h2>
                    <a href="javascript:void(0);" class="uc-removemodal" @click="closePopupModal"><?php if (isset($component)) { $__componentOriginalc75daebea8dbf1b37f7b7223ad120b78 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.close','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.close'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78)): ?>
<?php $attributes = $__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78; ?>
<?php unset($__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc75daebea8dbf1b37f7b7223ad120b78)): ?>
<?php $component = $__componentOriginalc75daebea8dbf1b37f7b7223ad120b78; ?>
<?php unset($__componentOriginalc75daebea8dbf1b37f7b7223ad120b78); ?>
<?php endif; ?></a>
                </div>
                <div class="uc-modal_body">
                    <form class="uc-themeform">
                        <fieldset>
                            <div class="form-group">
                                <label for="title" class="uc-important"><?php echo e(__('upcertify::upcertify.title')); ?></label>
                                <div class="form-group-wrap <?php $__errorArgs = ['media_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> uc-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <input class="form-control" type="text" placeholder="<?php echo e(__('upcertify::upcertify.enter_title')); ?>" required="" wire:model="media_title">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['media_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="uc-error-msg"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="uc-uploadoption" x-data="{isUploading:false}" wire:key="uploading-video-<?php echo e(time()); ?>">
                                    <div class="uc-draganddrop" 
                                        wire:loading.class="uc-uploading" 
                                        wire:target="media" 
                                        x-bind:class="{ 'uc-dragfile' : isDragging && isOpenModal, 'uc-uploading' : isUploading }" 
                                        x-on:drop.prevent="isDragging = false; isUploading = true" 
                                        wire:drop.prevent="$upload('media', $event.dataTransfer.files[0])">
                                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['name' => 'file','type' => 'file','id' => 'at_upload_video','xRef' => 'file_upload','accept' => ''.e(!empty($allowFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowFileExt)) : '*').'','xOn:change' => 'isUploading=true; $wire.upload(\'media\', $refs.file_upload.files[0])']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file','type' => 'file','id' => 'at_upload_video','x-ref' => 'file_upload','accept' => ''.e(!empty($allowFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowFileExt)) : '*').'','x-on:change' => 'isUploading=true; $wire.upload(\'media\', $refs.file_upload.files[0])']); ?>
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
                                        <label for="at_upload_video" class="uc-uploadfile">
                                            <svg class="uc-border-svg ">
                                                <rect width="100%" height="100%"></rect>
                                            </svg>
                                            <span class="uc-dropfileshadow">
                                                <svg class="uc-border-svg ">
                                                    <rect width="100%" height="100%"></rect>
                                                </svg>
                                                <?php if (isset($component)) { $__componentOriginal4151627588b7e04ffaa45402586a16d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4151627588b7e04ffaa45402586a16d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.plus','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4151627588b7e04ffaa45402586a16d7)): ?>
<?php $attributes = $__attributesOriginal4151627588b7e04ffaa45402586a16d7; ?>
<?php unset($__attributesOriginal4151627588b7e04ffaa45402586a16d7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4151627588b7e04ffaa45402586a16d7)): ?>
<?php $component = $__componentOriginal4151627588b7e04ffaa45402586a16d7; ?>
<?php unset($__componentOriginal4151627588b7e04ffaa45402586a16d7); ?>
<?php endif; ?>
                                                <span class="uc-uploadiconanimation">
                                                    <?php if (isset($component)) { $__componentOriginalc9953b6292424149e21ed5e2c445878e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc9953b6292424149e21ed5e2c445878e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.cloud-upload','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.cloud-upload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc9953b6292424149e21ed5e2c445878e)): ?>
<?php $attributes = $__attributesOriginalc9953b6292424149e21ed5e2c445878e; ?>
<?php unset($__attributesOriginalc9953b6292424149e21ed5e2c445878e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc9953b6292424149e21ed5e2c445878e)): ?>
<?php $component = $__componentOriginalc9953b6292424149e21ed5e2c445878e; ?>
<?php unset($__componentOriginalc9953b6292424149e21ed5e2c445878e); ?>
<?php endif; ?>
                                                </span>
                                                <?php echo e(__('upcertify::upcertify.drop_file')); ?>

                                            </span>
                                            <em>
                                                <?php if (isset($component)) { $__componentOriginalc9953b6292424149e21ed5e2c445878e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc9953b6292424149e21ed5e2c445878e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.cloud-upload','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.cloud-upload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc9953b6292424149e21ed5e2c445878e)): ?>
<?php $attributes = $__attributesOriginalc9953b6292424149e21ed5e2c445878e; ?>
<?php unset($__attributesOriginalc9953b6292424149e21ed5e2c445878e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc9953b6292424149e21ed5e2c445878e)): ?>
<?php $component = $__componentOriginalc9953b6292424149e21ed5e2c445878e; ?>
<?php unset($__componentOriginalc9953b6292424149e21ed5e2c445878e); ?>
<?php endif; ?>
                                            </em>
                                            <span><?php echo e(__('upcertify::upcertify.drop_file_here')); ?> <i><?php echo e(__('upcertify::upcertify.click_here')); ?></i> <?php echo e(__('upcertify::upcertify.to_upload')); ?> <!--[if BLOCK]><![endif]--><?php if(!empty($vedioExt)): ?> <em><?php echo e($vedioExt); ?> (max. <?php echo e($fileSize); ?> mb)</em><?php endif; ?><!--[if ENDBLOCK]><![endif]--></span>
                                        </label>
                
                                    </div>
                                    
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($media) && in_array($media->getClientOriginalExtension(), $allowFileExt)): ?>
                                        <div class="uc-uploadedfile">
                                            <a href="javascript:void(0);" data-vbtype="iframe" class="tu-thumbnails_content">
                                                <figure>
                                                    <img src="<?php echo e(method_exists($media,'temporaryUrl') ? $media->temporaryUrl() : asset('images/video.jpg')); ?>" alt="<?php echo e(__('courses::courses.promotional_video')); ?>">
                                                </figure>
                                                <i class="fas fa-play"></i>
                                            </a>
                                            <span class="uc-uploadedfile_icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                    <path d="M10.9636 1.33331H8.00065C6.26368 1.33331 5.39519 1.33331 4.6906 1.55547C3.19701 2.0264 2.02707 3.19634 1.55614 4.68992C1.33398 5.39452 1.33398 6.26301 1.33398 7.99998V7.99998C1.33398 9.73695 1.33398 10.6054 1.55614 11.31C2.02707 12.8036 3.19701 13.9736 4.6906 14.4445C5.39519 14.6666 6.26368 14.6666 8.00065 14.6666V14.6666C9.73762 14.6666 10.6061 14.6666 11.3107 14.4445C12.8043 13.9736 13.9742 12.8036 14.4452 11.31C14.6673 10.6054 14.6673 9.73695 14.6673 7.99998V7.25924M6.00065 7.33331L8.00065 9.33331L14.6673 2.66665" stroke="#079455" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                            <span><?php echo e(basename($media->getClientOriginalName())); ?></span>
                                            <a id="uc-trash-<?php echo e(time()); ?>" href="javascript:void(0);" wire:click.prevent="removeMedia" class="uc-delitem asdad">
                                                <?php if (isset($component)) { $__componentOriginalbc103f460d42234caf40a1e53bb24294 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc103f460d42234caf40a1e53bb24294 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.trash','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.trash'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc103f460d42234caf40a1e53bb24294)): ?>
<?php $attributes = $__attributesOriginalbc103f460d42234caf40a1e53bb24294; ?>
<?php unset($__attributesOriginalbc103f460d42234caf40a1e53bb24294); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc103f460d42234caf40a1e53bb24294)): ?>
<?php $component = $__componentOriginalbc103f460d42234caf40a1e53bb24294; ?>
<?php unset($__componentOriginalbc103f460d42234caf40a1e53bb24294); ?>
<?php endif; ?>
                                            </a>
                    
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['media'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="uc-error-msg"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            <div class="form-group form-group-btns">
                                <button type="button" class="uc-white-btn close-modal" @click="closePopupModal"><?php echo e(__('upcertify::upcertify.cancel')); ?></button>
                                <button type="button" class="uc-btn <?php if(!$media): ?> uc-disable_btn <?php endif; ?>"  wire:loading.class="uc-btn_disable" wire:click="uploadMedia">
                                    <span wire:loading.remove wire:target="uploadMedia"><?php echo e(__('upcertify::upcertify.save')); ?></span>
                                    <span wire:loading wire:target="uploadMedia"><?php echo e(__('upcertify::upcertify.saving')); ?></span>
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Alert Popup -->
    <div id="uc-deletepopup" class="uc-modal uc-deletepopup" wire:ignore.self>
        <div class="uc-modaldialog">
            <div class="uc-modal_wrap">
                <div class="uc-modal_body">
                    <span class="uc-closepopup" @click="closePopupModal()">
                        <?php if (isset($component)) { $__componentOriginalc75daebea8dbf1b37f7b7223ad120b78 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.close','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.close'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78)): ?>
<?php $attributes = $__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78; ?>
<?php unset($__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc75daebea8dbf1b37f7b7223ad120b78)): ?>
<?php $component = $__componentOriginalc75daebea8dbf1b37f7b7223ad120b78; ?>
<?php unset($__componentOriginalc75daebea8dbf1b37f7b7223ad120b78); ?>
<?php endif; ?>
                    </span>
                    <div class="uc-deletepopup_icon delete-icon">
                        <span><?php if (isset($component)) { $__componentOriginalbc103f460d42234caf40a1e53bb24294 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc103f460d42234caf40a1e53bb24294 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.trash','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.trash'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc103f460d42234caf40a1e53bb24294)): ?>
<?php $attributes = $__attributesOriginalbc103f460d42234caf40a1e53bb24294; ?>
<?php unset($__attributesOriginalbc103f460d42234caf40a1e53bb24294); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc103f460d42234caf40a1e53bb24294)): ?>
<?php $component = $__componentOriginalbc103f460d42234caf40a1e53bb24294; ?>
<?php unset($__componentOriginalbc103f460d42234caf40a1e53bb24294); ?>
<?php endif; ?></span>
                    </div>
                    <div class="uc-deletepopup_title">
                        <h3><?php echo e(__('upcertify::upcertify.confirm')); ?></h3>
                        <p><?php echo e(__('upcertify::upcertify.are_you_sure')); ?></p>
                    </div>
                    <div class="uc-deletepopup_btns">
                        <a href="javascript:void(0);" class="uc-btn uc-btnsmall uc-cancel" @click="closePopupModal()"><?php echo e(__('upcertify::upcertify.no')); ?></a>
                        <a href="javascript:void(0);" class="uc-btn uc-btn-del uc-confirm-yes"><?php echo e(__('upcertify::upcertify.yes')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div id="uc-alertpopup" class="uc-modal uc-deletepopup" wire:ignore.self>
        <div class="uc-modaldialog">
            <div class="uc-modal_wrap">
                <div class="uc-modal_body">
                    <span class="uc-closepopup" @click="closeModal">
                        <?php if (isset($component)) { $__componentOriginalc75daebea8dbf1b37f7b7223ad120b78 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.close','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.close'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78)): ?>
<?php $attributes = $__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78; ?>
<?php unset($__attributesOriginalc75daebea8dbf1b37f7b7223ad120b78); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc75daebea8dbf1b37f7b7223ad120b78)): ?>
<?php $component = $__componentOriginalc75daebea8dbf1b37f7b7223ad120b78; ?>
<?php unset($__componentOriginalc75daebea8dbf1b37f7b7223ad120b78); ?>
<?php endif; ?>
                    </span>
                    <div class="uc-deletepopup_icon delete-icon">
                        <span><?php if (isset($component)) { $__componentOriginal2cb19bd4fab6d878784a825f59b2b87e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2cb19bd4fab6d878784a825f59b2b87e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.warning','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.warning'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2cb19bd4fab6d878784a825f59b2b87e)): ?>
<?php $attributes = $__attributesOriginal2cb19bd4fab6d878784a825f59b2b87e; ?>
<?php unset($__attributesOriginal2cb19bd4fab6d878784a825f59b2b87e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2cb19bd4fab6d878784a825f59b2b87e)): ?>
<?php $component = $__componentOriginal2cb19bd4fab6d878784a825f59b2b87e; ?>
<?php unset($__componentOriginal2cb19bd4fab6d878784a825f59b2b87e); ?>
<?php endif; ?></span>
                    </div>
                    <div class="uc-deletepopup_title">
                        <h3><?php echo e(__('upcertify::upcertify.confirm')); ?></h3>
                        <p><?php echo e(__('upcertify::upcertify.are_you_sure_use_template')); ?></p>
                    </div>
                    <div class="uc-deletepopup_btns">
                        <a href="javascript:void(0);" class="uc-btn uc-btnsmall uc-cancel" @click="closePopupModal()"><?php echo e(__('upcertify::upcertify.no')); ?></a>
                        <a href="javascript:void(0);" class="uc-btn uc-btn-del uc-confirm-yes"><?php echo e(__('upcertify::upcertify.yes')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
    <script>
        const elements = (element) => {

            <!--[if BLOCK]><![endif]--><?php if(!empty($wildcards)): ?>

                switch (element) {
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $wildcards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wildcard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        case '<?php echo e($wildcard); ?>':
                        return `
                            <div class="uc-element-wildcard uc-alignment-left" data-font="SF Pro Text" data-wildcard_name="<?php echo e($wildcard); ?>" data-actions="<?php echo e($wildcard === 'custom_message' ? 'edit, delete, copy' : 'delete, copy'); ?>" data-handles="e, w">
                                <span class="uc-wildcard_content">
                                    <!--[if BLOCK]><![endif]--><?php if($wildcard === 'custom_message'): ?>
                                        [ <?php echo e(__('upcertify::upcertify.edit_your_custom_message')); ?> ]
                                    <?php else: ?>
                                        [<?php echo e($wildcard); ?>]
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </span>
                            </div>
                        `;

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                    case 'separation_horizontal':
                        return `<div class="uc-element-wildcard uc-alignment-left uc-separation_card" data-font="SF Pro Text" data-wildcard_name="separation_horizontal" data-actions="delete, copy" data-handles="e, w"> 
                                <div class="uc-wildcard_content uc-separation"><span class="signle-line uc-separation_horizontal"> </span></div>
                            </div>`;

                    case 'separation_vertical':
                        return `<div class="uc-element-wildcard uc-alignment-left uc-separation_card" data-font="SF Pro Text" data-wildcard_name="separation_vertical" data-actions="delete, copy" data-handles="n, s"> 
                                <div class="uc-wildcard_content uc-separation"><span class="signle-line uc-separation_vertical"> </span></div>
                            </div>`;
                }

            <?php endif; ?>
        }

        document.addEventListener('DOMContentLoaded', function() {
            window.allFonts = <?php echo json_encode($fonts, 15, 512) ?>;
            jQuery(document).on('click', '.uc-publish-certificate', function (e) {
                e.preventDefault();
                const wildcardElements = document.querySelectorAll('.uc-element-wildcard');
                const elementsInfo = [];
                const fontFamilies = [];
                if(wildcardElements.length > 0){
                    wildcardElements.forEach((element) => {
                         const fontFamily = element.style.fontFamily;
                        if (fontFamily && fontFamily !== 'SF Pro Text') {
                            fontFamilies.push(fontFamily.replace(/['"]/g, ''));
                        }
                        const elementInfo = {
                            classes: Array.from(element.classList).filter(cls => cls !== 'uc-wildcard_edit'),
                            actions: element.getAttribute('data-actions') || '',
                            handles: element.getAttribute('data-handles') || '',
                            inlineStyle: element.getAttribute('style') || '',
                            wildcardName: element.getAttribute('data-wildcard_name') || '',
                        };

                        if(elementInfo.wildcardName == 'custom_message'){
                            elementInfo['custom_message'] = element.textContent.replace(/\n/g, '').trim();
                        }
                        if (elementInfo.wildcardName === 'attachment') {
                            const imgElement = element.querySelector('img');
                            const svgElement = !imgElement && element.querySelector('.uc-wildcard_content svg');
                            if (imgElement) {
                                elementInfo.attachment = imgElement.src.replace(`${window.location.origin}/`, '');
                            } else if (svgElement) {
                                elementInfo.attachment = svgElement.outerHTML;
                            } else {
                                elementInfo.attachment = '';
                            }
                        }
                        elementsInfo.push(elementInfo);
                    });
                }

                const canvasBoundry = document.getElementById('uc-canvas-boundry');
                const inlineStyle = canvasBoundry.getAttribute('style');                     
                const backgroundImageStyle = window.getComputedStyle(canvasBoundry).backgroundImage;
                const backgroundColorStyle = window.getComputedStyle(canvasBoundry).backgroundColor;                 
                const backgroundImage = backgroundImageStyle.replace(/url\(['"]?(.+?)['"]?\)/, '$1');                
                let body = {
                    elementsInfo,
                    fontFamilies,
                    backgroundImage: backgroundImage != 'none' ? backgroundImage : '',
                    backgroundColorStyle: backgroundColorStyle ? backgroundColorStyle : '',
                    inlineStyle :inlineStyle
                }
             
                let _this = jQuery(this);
                _this.addClass('uc-btn_disable').attr('disabled', true);
                var element = document.getElementById('uc-canvas-boundry');
                element.style.boxShadow = 'none';
                setTimeout(() => {
                    html2canvas(element).then(async function(canvas) {
                        var imgData = canvas.toDataURL('image/png');
                        body.thumbnail = imgData;
                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set("body", body, false);
                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set("canvasImage", imgData, false);
                        await window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('publishCertificate');
                        _this.removeClass('uc-btn_disable').attr('disabled', false);
                    });
                }, 400)
            });

            //delete Template
            jQuery(document).on('click', '.uc-delete-template', function (e) {
                var _this = jQuery(this);
                var id = _this.data('id');
                openModal('#uc-deletepopup');
                var confirmDeleteTemplate = document.querySelector('.uc-confirm-yes');
                const deleteHandler = async function () {
                    let _deleteButton = jQuery(this);
                    _deleteButton.addClass('uc-btn_disable');
                    try {
                        await window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('deleteTemplate', id);
                    } catch (error) {
                        console.error('Error deleting template:', error);
                    } finally {
                        _deleteButton.removeClass('uc-btn_disable');
                        closeModal('#uc-deletepopup');
                        confirmDeleteTemplate.removeEventListener('click', deleteHandler);
                    }
                };
                confirmDeleteTemplate.addEventListener('click', deleteHandler);
            });

            jQuery(document).on('click', '.uc-use-template', function (e) {
                var _this = jQuery(this);
                var id = _this.data('id');
                openWarningModal('#uc-alertpopup');
                var confirmDeleteTemplate = document.querySelector('#uc-alertpopup .uc-confirm-yes');
                const deleteHandler = async function () {
                    let _deleteButton = jQuery(this);
                    _deleteButton.addClass('uc-btn_disable');
                    try {
                        await window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('useAsTemplate', id);
                    } catch (error) {
                        console.error('Error deleting template:', error);
                    } finally {
                        _deleteButton.removeClass('uc-btn_disable');
                        closeModal('#uc-alertpopup');
                        confirmDeleteTemplate.removeEventListener('click', deleteHandler);
                    }
                };
                confirmDeleteTemplate.addEventListener('click', deleteHandler);
            });

            //delete media item
            jQuery(document).on('click', '.uc-trash', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var _this = jQuery(this);
                var id = _this.data('id');
                openModal('#uc-deletepopup');
                var confirmDeleteBackground = document.querySelector('.uc-confirm-yes');
                const deleteHandler = async function () {
                    let _deleteButton = jQuery(this);
                    _deleteButton.addClass('uc-btn_disable');
                    await window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('deleteMedia', id);
                    id = null;
                    _deleteButton.removeClass('uc-btn_disable');
                    closeModal('#uc-deletepopup');
                    confirmDeleteBackground.removeEventListener('click', deleteHandler);
                };
                confirmDeleteBackground.addEventListener('click', deleteHandler);
            });
        });

        document.addEventListener('embedTemplate', function (e) {
            jQuery('#uc-canvas-wrap .uc-course_box').remove();
            jQuery('#uc-canvas-wrap .uc-course_optionwrap').after(e.detail.template);

            if (typeof initializeCanvasElements === 'function') {
                initializeCanvasElements();
            }
        });

    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Upcertify/resources/views/livewire/create-certificate/create-certificate.blade.php ENDPATH**/ ?>