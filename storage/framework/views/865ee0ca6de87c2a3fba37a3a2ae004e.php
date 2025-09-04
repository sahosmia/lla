<div class="uc-certificates" wire:init="loadData">
    <div class="uc-certificates_header">
        <div class="uc-certificates_title">
            <h2><?php echo e(__('upcertify::upcertify.all_certificates')); ?></h2>
            <p><?php echo e(__('upcertify::upcertify.browse_certificates')); ?></p>
        </div>
        <div class="uc-certificates_btn">
            <a href="javascript:void(0);" class="uc-btn" @click="openModal('#uc-create-certificate-popup')"><?php echo e(__('upcertify::upcertify.create_certificate')); ?> <i class="uc-btn_icon"> <?php if (isset($component)) { $__componentOriginal4151627588b7e04ffaa45402586a16d7 = $component; } ?>
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
<?php endif; ?> </i></a>
        </div>
    </div>
    <div class="uc-certificates_list">
        <!--[if BLOCK]><![endif]--><?php if( $isLoading ): ?>
            <ul class="uc-certificates_list_items">
                <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 7; $i++): ?>
                    <li class="uc-skeleton">
                        <figure class="uc-template_item">
                        </figure>
                    </li>
                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
            </ul>
        <?php elseif( $templates->count() > 0 ): ?>
            <ul class="uc-certificates_list_items">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <div class="uc-certificates_item">
                            <figure class="uc-certificates_item_img <?php if( empty($template->thumbnail_url) ): ?> uc-certificates_item_empty <?php endif; ?>">
                                <!--[if BLOCK]><![endif]--><?php if( !empty($template->thumbnail_url) ): ?>
                                    <img src="<?php echo e(Storage::url($template->thumbnail_url).'?v='.time()); ?>" alt="<?php echo e(__('courses::courses.promotional_video')); ?>">
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </figure>
                            <div class="uc-certificates_item_content">
                                <h3><?php echo e($template->title); ?></h3>
                                <div class="uc-certificates_item_actions">
                                    <a href="javascript:void(0);" class="uc-certificates_item_actions_btn"><i><?php if (isset($component)) { $__componentOriginalde8e93f50520e27f6902a6c55b551330 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalde8e93f50520e27f6902a6c55b551330 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.ellipsis-horizontal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.ellipsis-horizontal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalde8e93f50520e27f6902a6c55b551330)): ?>
<?php $attributes = $__attributesOriginalde8e93f50520e27f6902a6c55b551330; ?>
<?php unset($__attributesOriginalde8e93f50520e27f6902a6c55b551330); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalde8e93f50520e27f6902a6c55b551330)): ?>
<?php $component = $__componentOriginalde8e93f50520e27f6902a6c55b551330; ?>
<?php unset($__componentOriginalde8e93f50520e27f6902a6c55b551330); ?>
<?php endif; ?></i></a>
                                    <ul class="uc-certificates_item_actions_dropdown">
                                        <li>
                                            <a href="<?php echo e(route('upcertify.update', ['id' => $template->id, 'tab' => 'general', 'as_template' => true])); ?>"><i><?php if (isset($component)) { $__componentOriginal201346d59f8140011c0c514248eecb50 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal201346d59f8140011c0c514248eecb50 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.template','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.template'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal201346d59f8140011c0c514248eecb50)): ?>
<?php $attributes = $__attributesOriginal201346d59f8140011c0c514248eecb50; ?>
<?php unset($__attributesOriginal201346d59f8140011c0c514248eecb50); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal201346d59f8140011c0c514248eecb50)): ?>
<?php $component = $__componentOriginal201346d59f8140011c0c514248eecb50; ?>
<?php unset($__componentOriginal201346d59f8140011c0c514248eecb50); ?>
<?php endif; ?></i><?php echo e(__('upcertify::upcertify.use_template')); ?></a>
                                        </li>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($template->user_id)): ?>
                                            <li>
                                                <a href="<?php echo e(route('upcertify.update', ['id' => $template->id, 'tab' => 'media'])); ?>"><i><?php if (isset($component)) { $__componentOriginal93f48a0b0faff8e9465a2925140ecf42 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93f48a0b0faff8e9465a2925140ecf42 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.pen','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.pen'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal93f48a0b0faff8e9465a2925140ecf42)): ?>
<?php $attributes = $__attributesOriginal93f48a0b0faff8e9465a2925140ecf42; ?>
<?php unset($__attributesOriginal93f48a0b0faff8e9465a2925140ecf42); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal93f48a0b0faff8e9465a2925140ecf42)): ?>
<?php $component = $__componentOriginal93f48a0b0faff8e9465a2925140ecf42; ?>
<?php unset($__componentOriginal93f48a0b0faff8e9465a2925140ecf42); ?>
<?php endif; ?></i><?php echo e(__('upcertify::upcertify.edit_template')); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="uc-delete-template" data-id="<?php echo e($template->id); ?>"><i><?php if (isset($component)) { $__componentOriginalbc103f460d42234caf40a1e53bb24294 = $component; } ?>
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
<?php endif; ?></i><?php echo e(__('upcertify::upcertify.delete_template')); ?></a>
                                            </li>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </ul>
            <?php echo e($templates->links('upcertify::pagination.pagination')); ?>

        <?php else: ?>
            <div class="uc-certificates_list_empty">
                <img src="<?php echo e(asset('modules/upcertify/images/empty-view.svg')); ?>" alt="<?php echo e(__('upcertify::upcertify.no_data_found')); ?>">
                <h3><?php echo e(__('upcertify::upcertify.no_data_found')); ?></h3>
                <p><?php echo e(__('upcertify::upcertify.no_data_found_description')); ?></p>
                <a href="javascript:void(0);" class="uc-btn" @click="openModal('#uc-create-certificate-popup')"><?php echo e(__('upcertify::upcertify.create_certificate')); ?> <i class="uc-btn_icon"> <?php if (isset($component)) { $__componentOriginal4151627588b7e04ffaa45402586a16d7 = $component; } ?>
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
<?php endif; ?> </i></a>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <div id="uc-create-certificate-popup" class="uc-modal uc-addmediapopup" wire:ignore.self>
        <div class="uc-modaldialog">
            <div class="uc-modal_wrap">
                <div class="uc-modal_title">
                    <h2><?php echo e(__('upcertify::upcertify.create_certificate')); ?></h2>
                    <a href="javascript:void(0);" class="uc-removemodal" @click="closeModal"><?php if (isset($component)) { $__componentOriginalc75daebea8dbf1b37f7b7223ad120b78 = $component; } ?>
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
                                <div class="form-group-wrap <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> uc-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <input class="form-control" type="text" placeholder="<?php echo e(__('upcertify::upcertify.enter_title')); ?>" wire:model="title" wire:keydown.enter="createNow">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['title'];
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
                                <button type="button" class="uc-white-btn close-modal" @click="closeModal"><?php echo e(__('upcertify::upcertify.cancel')); ?></button>
                                <button type="button" class="uc-btn" wire:loading.class="uc-btn_disable" wire:click.prevent="createNow">
                                    <span wire:loading.remove wire:target="createNow"><?php echo e(__('upcertify::upcertify.create')); ?></span>
                                    <span wire:loading wire:target="createNow"><?php echo e(__('upcertify::upcertify.creating')); ?></span>
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
                        <a href="javascript:void(0);" class="uc-btn uc-btnsmall uc-cancel" @click="closeModal"><?php echo e(__('upcertify::upcertify.no')); ?></a>
                        <a href="javascript:void(0);" class="uc-btn uc-btn-del uc-confirm-yes"><?php echo e(__('upcertify::upcertify.yes')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Upcertify/resources/views/livewire/certificate-list/certificate-list.blade.php ENDPATH**/ ?>