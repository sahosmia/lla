<main class="tb-main tb-commissionwrap">
    <div class="tb-dbholder tb-dbholdervtwoa">
        <div class="tb-sectiontitle">
            <h5> <?php echo e(__('settings.commission_settings')); ?></h5>
        </div>
        <div class="tb-dbsettingbox">
            <form class="tb-comiisionform">
                <fieldset>
                    <div class="tb-themeform__wrap">
                        <div class="tb-commisionarea">
                            <span class="tb-titleinput"><?php echo e(__('settings.project_commission_free')); ?></span>
                            <div class="tb-radiotabwrap">
                                <div class="tb-radiowrap">
                                    <label for="free">
                                        <input type="radio" wire:model.lazy="commission_type" id="free" value="free" <?php echo e($commission_type == 'free' ? 'checked' : ''); ?>/>
                                        <span><?php echo e(__('settings.no_commission')); ?></span>
                                    </label>
                                </div>
                                <div class="tb-radiowrap">
                                    <label for="fixed">
                                        <input type="radio" wire:model.lazy="commission_type" id="fixed" value="fixed" <?php echo e($commission_type == 'fixed' ? 'checked' : ''); ?> />
                                        <span><?php echo e(__('settings.fixed_commission')); ?></span>
                                    </label>
                                </div>
                                <div class="tb-radiowrap">
                                    <label for="percentage">
                                        <input type="radio" wire:model.lazy="commission_type" id="percentage" value="percentage" <?php echo e($commission_type == 'percentage' ? 'checked' : ''); ?> />
                                        <span><?php echo e(__('settings.percentage_commission')); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="tb-nocommision <?php if( $commission_type == 'free' ): ?> d-flex <?php else: ?> d-none <?php endif; ?>">
                            <img src="<?php echo e(asset('images/empty.png')); ?>" alt="">
                            <span><?php echo e(__('settings.no_commission_desc')); ?></span>
                        </div>

                        <div class="tb-commision <?php if( in_array( $commission_type, ['fixed', 'percentage']) ): ?> d-block <?php else: ?> d-none <?php endif; ?>">
                            <div class="tb-formcomision">
                                <div class="form-group form-vertical">
                                    <label class="tb-titleinput tk-required"><?php echo e(__('settings.fixed_commission_per_course')); ?></label>
                                    <!--[if BLOCK]><![endif]--><?php if( $commission_type == 'fixed' ): ?>
                                        <div class="form-group form-vertical tb-inputiconleft">
                                            <input type="number" wire:model="fixed_course_price" class="form-control <?php $__errorArgs = ['fixed_course_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('settings.fixed_price_placeholder')); ?>">
                                            <i class="icon-dollar-sign"></i>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fixed_course_price'];
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
                                    <?php else: ?>
                                        <div class="form-group form-vertical tb-inputiconleft">
                                            <input type="number" wire:model="percentage_course_price" class="form-control <?php $__errorArgs = ['percentage_course_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('settings.percentage_amount_placeholder')); ?>">
                                            <i class="icon-percent"></i>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['percentage_course_price'];
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
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <span><?php echo e(__('settings.course_price_desc')); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                <?php echo e(__('settings.save_setting')); ?>

                            </a>
                        </div>

                </fieldset>
            </form>
        </div>
    </div>
</main>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Courses/resources/views/livewire/admin/commission-settings.blade.php ENDPATH**/ ?>