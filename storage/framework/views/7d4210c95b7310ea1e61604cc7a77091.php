<div class="modal fade" :id="'message-model-'+recepientId" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="am-review-detail am-sendmassage-modal">
            <div class="am-review-session">
                <div class="am-modal-header">
                    <h3><?php echo e(__('tutor.send_a_message')); ?></h3>
                    <span class="am-closepopup" data-bs-dismiss="modal">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                </div>
                <div id="new-button-container"></div>
                <div class="am-review-user">
                    <a href="#" class="am-review-user-detail">
                        <img :src="tutorInfo?.image ?? ''" :alt="tutorInfo?.name ?? ''">
                        <div class="am-review-user-title">
                            <span x-text="tutorInfo?.name ?? ''"></span>
                            <em x-text="tutorInfo?.tagline ?? ''"></em>
                        </div>
                    </a>
                </div>
                <div class="am-review-details <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <textarea placeholder="<?php echo e(__('tutor.type_message')); ?>" x-model="message" x-on:input="updateCharLeft"></textarea>
                    <!--[if BLOCK]><![endif]--><?php if(!empty($threadId)): ?>
                        <span><?php echo e(__('general.char_left')); ?> 500</span>
                    <?php else: ?>
                        <span x-text="' <?php echo e(__('general.char_left')); ?>' + charLeft"></span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'message']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'message']); ?>
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
                <div class="am-sendmassage-modal_btns" wire:key="buttons-<?php echo e($tutor?->id ?? ''); ?>">
                    <a href="javascript:;" class="am-btn send-message-btn" wire:click="sendMessage" wire:loading.class="am-btn_disable"><?php echo e(__('tutor.send_message')); ?></a>
                    <!--[if BLOCK]><![endif]--><?php if(!empty($threadId)): ?>
                        <a href="<?php echo e(route('laraguppy.messenger', ['thread_id' => $threadId ])); ?>"  class="am-openchat am-custom-tooltip">
                            <span class="am-tooltip-text">
                                <span><?php echo e(__('general.open_chat')); ?></span>
                            </span>
                            <i class="am-icon-external-link-02"></i>
                        </a>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/tutor/action/message.blade.php ENDPATH**/ ?>