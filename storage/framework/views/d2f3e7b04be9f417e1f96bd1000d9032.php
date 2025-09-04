<div wire:ignore.self class="modal am-modal fade am-dispute_modal" id="dispute-reason-popup" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="am-modal-header">
                <h2><?php echo e(__('dispute.raise_dispute')); ?></h2>
                <span class="am-closepopup" data-bs-dismiss="modal">
                    <i class="am-icon-multiply-01"></i>
                </span>
            </div>
            <div class="am-modal-body">
                <form class="am-themeform">
                    <fieldset>
                        <div class="form-group">
                            <label class="am-important" for="selectedReason"><?php echo e(__('dispute.select_reason')); ?></label>
                            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-control_wrap', 'am-invalid' => $errors->has('selectedReason')]); ?>">
                                <span class="am-select" wire:ignore>
                                    <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-custom-select" placeholder="<?php echo e(__('dispute.select_a_dispute_reason')); ?>" data-searchable="true" wire:key="<?php echo e(time()); ?>" data-parent="#dispute-reason-popup" id="selectedReason" data-wiremodel="selectedReason">
                                        <option value=""><?php echo e(__('dispute.select_a_dispute_reason')); ?></option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $disputeReason; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($reason); ?>" <?php echo e($reason == $selectedReason ? 'selected' : ''); ?>><?php echo e($reason); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                </span>
                            </div>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'selectedReason']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'selectedReason']); ?>
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
                        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('description')]); ?>">
                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['class' => 'am-important','for' => 'description','value' => __('education.description')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'am-important','for' => 'description','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('education.description'))]); ?>
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
                            <div class="am-custom-editor" wire:ignore>
                                    <textarea id="description" class="form-control" placeholder="<?php echo e(__('dispute.add_dispute_reason')); ?>"></textarea>
                                <span class="characters-count"></span>
                            </div>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'description']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'description']); ?>
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
                        
                        <div class="form-group am-form-btn-wrap">
                            <button wire:target="saveDisputeReason" wire:loading.class="am-btn_disable" wire:click.prevent="saveDisputeReason(<?php echo e($booking['id'] ?? null); ?>, <?php echo e($booking['student_id'] ?? null); ?>, <?php echo e($booking['tutor_id'] ?? null); ?>, '<?php echo e($booking['start_time'] ?? null); ?>')" class="am-btn"><?php echo e(__('dispute.submit')); ?></button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')([
'public/summernote/summernote-lite.min.css',
]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<script type="text/javascript">
document.addEventListener('livewire:initialized', function() { 
    var component = '';
    document.addEventListener('livewire:navigated', function() {
        component = window.Livewire.find('<?php echo e($_instance->getId()); ?>');
    });
    $(document).on('show.bs.modal','#dispute-reason-popup', function () {
        var initialContent = component.get('description');
        $('#description').summernote('destroy');
        $('#description').summernote(summernoteConfigs('#description'));
        $('#description').summernote('code', initialContent);
        $(document).on('summernote.change', '#description', function(we, contents, $editable) {             
            component.set("description",contents, false);
        });
        $('#selectedReason').select2({
            dropdownParent: $('#dispute-reason-popup')
        });
        // Reset the selected reason to ensure it's not retained between modal opens
        $('#selectedReason').val(null).trigger('change');
    });
    jQuery(document).on('change', '.am-custom-select', function(e){
        component.set('selectedReason', jQuery('.am-custom-select').select2("val"), false);
    });
});
</script>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/components/dispute-reason-popup.blade.php ENDPATH**/ ?>