<main class="tb-main tb-mainbg tk-paymentsection">
    <div class="row">
        <div class="col-lg-4 col-md-12 tb-md-40">

            <div class="tb-dbholder tb-package-settings">
                <div class="tb-payment-methods_title">
                    <h6><?php echo e(__('settings.checkout_method')); ?></h6>
                </div>
                <form class="tb-todobox">
                    <fieldset>
                        <div class="form-group-wrap">
                            <div class="form-group">
                                <label class="tk-label"><?php echo e(__('settings.method_placeholder')); ?></label>
                                <div class="tk-settingarea <?php $__errorArgs = ['method_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <div wire:ignore class="tb-select">
                                        <select class="am-select2" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" data-searchable="true"  data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.method_placeholder')); ?>" id="tk_checkout_method" data-wiremodel="method_type">
                                            <option></option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value=<?php echo e($method); ?> <?php echo e($method_type == $method ? 'selected' : ''); ?> ><?php echo e(__("settings." .$method. "_title")); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </div>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['method_type'];
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
                            <div class="form-group tb-updatesave-btn">
                                <a href="javascript:void(0);" wire:click="saveMethod" class="tb-btn ">
                                    <?php echo e(__('settings.save_method')); ?>

                                </a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="tb-dbholder tb-package-settings">
                <div class="tb-payment-methods_title">
                    <h6><?php echo e(__('settings.payment_methods')); ?></h6>
                </div>
                <ul class="tb-payment-methods_list">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="tb-payment-items">
                                <div class="tb-paymethod-items">
                                    <img src="<?php echo e(asset('images/payment_methods/'.$method. '.png')); ?>" alt="<?php echo e(__("settings." .$method. "_title")); ?>">

                                    <h6><?php echo e(__("settings." .$method. "_title")); ?></h6>
                                </div>
                                <div class="tb-paymethod-items">
                                    <!--[if BLOCK]><![endif]--><?php if($method != 'escrow'): ?>
                                        <div class="checkbox">
                                            <input type="checkbox" wire:change="updateStatus('<?php echo e($method); ?>')" <?php if($methods[$method]['status'] == 'on'): ?> checked <?php endif; ?>>
                                            <label for="<?php echo e($method.'_method'); ?>" class="text"></label>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="tb-paymethodedit">
                                        <a href="javascript:void(0);" wire:click.prevent="editMethod('<?php echo e($method); ?>')" ><?php echo e(__('settings.edit')); ?> <i class="icon-edit-3"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 tb-md-60" wire:loading.class="tk-section-preloader" wire:target="editMethod">
            <div class="preloader-outer" wire:loading wire:target="editMethod">
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
            <!--[if BLOCK]><![endif]--><?php if($edit_method): ?>
                <div class="tb-payment-methods">
                    <div class="tb-payment-methods_title">
                        <h6><?php echo e(__('settings.'. $edit_method .'_payment_title')); ?></h6>
                    </div>
                    <form class="tb-themeform tb-payment-settings">
                        <fieldset>
                            <div class="form-group-wrap">
                                <!--[if BLOCK]><![endif]--><?php if($edit_method == 'escrow'): ?>
                                    <div class="form-group form-group-half">
                                        <label class="tk-label"><?php echo e(__('settings.escrow_email')); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['methods.escrow.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="methods.escrow.email" placeholder="<?php echo e(__('settings.escrow_email_placeholer')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['methods.escrow.email'];
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
                                        <span class="tb-form-span"> <?php echo __('settings.escrow_email_desc', ['escrow_site_link' => '<a target="_blank" href="https://www.escrow.com/login-page">'. __("settings.escrow_site").' </a>']); ?></span>
                                    </div>
                                    <div class="form-group form-group-half">
                                        <label class="tk-label"><?php echo e(__('settings.escrow_api_key')); ?></label>
                                        <input type="text" wire:model.defer="methods.escrow.api_key" class="form-control <?php $__errorArgs = ['methods.escrow.api_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('settings.escrow_api_key_placeholer')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['methods.escrow.api_key'];
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
                                        <span class="tb-form-span"><?php echo __('settings.api_key_desc',['get_api_key'=> '<a target="_blank" href="https://www.escrow.com/">'. __("checkout.escrow_site_title").' </a>' ]); ?></span>
                                    </div>
                                    <div class="form-group ">
                                        <label class="tk-label"><?php echo e(__('settings.escrow_url')); ?></label>
                                        <input type="text" wire:model.defer="methods.escrow.api_url" class="form-control" placeholder="<?php echo e(__('settings.escrow_url_placeholer')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['methods.escrow.api_url'];
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
                                        <span class="tb-form-span">
                                            <?php echo __('settings.escrow_url_desc',
                                                [
                                                    'production_url'   => '<a target="_blank" href="https://api.escrow.com/">'. __("settings.escrow_production_url").' </a>',
                                                    'testing_url'      => '<a target="_blank" href=" https://api.escrow-sandbox.com/">'. __("settings.escrow_testing_url").' </a>'
                                                ]); ?>

                                        </span>
                                    </div>
                                    <div class="form-group form-group-3half">
                                        <label class="tk-label"><?php echo e(__('settings.currency')); ?></label>
                                        <div wire:ignore class="tb-select border-0">
                                            <select  id="tk_currency" data-method="escrow" data-hide_search_opt="true" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.currency')); ?>" class="form-control tk-select2">
                                                <option></option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currency_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php echo e($methods['escrow']['currency'] == $key ? 'selected' : ''); ?> ><?php echo e($currency); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['methods.escrow.currency'];
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
                                    <div class="form-group form-group-3half">
                                        <label class="tk-label"><?php echo e(__('settings.inspection_period')); ?></label>
                                        <div wire:ignore class="tb-select">
                                            <select id="tk_insp_period" data-hide_search_opt="true" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.insp_period_placeholder')); ?>" class="form-control tk-select2">
                                                <option></option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $inspection_day_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php echo e($methods['escrow']['inspection_period'] == $key ? 'selected' : ''); ?> ><?php echo e($day); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['methods.escrow.inspection_period'];
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

                                    <div class="form-group form-group-3half">
                                        <label class="tk-label"><?php echo e(__('settings.fee_paid_by')); ?></label>
                                        <div wire:ignore class="tb-select border-0">
                                            <select id="tk_fees_payer" data-hide_search_opt="true" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.fee_paid_by_placeholder')); ?>" class="form-control tk-select2">
                                                <option></option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $fee_paid_by_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php echo e($methods['escrow']['fees_payer'] == $key ? 'selected' : ''); ?> ><?php echo e($day); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['methods.escrow.fees_payer'];
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
                                <?php else: ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $methods[$edit_method]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <!--[if BLOCK]><![endif]--><?php if($key == 'status'): ?> <?php continue; ?> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <!--[if BLOCK]><![endif]--><?php if( $key == 'exchange_rate' && (!empty($methods[$edit_method]['currency']) && $methods[$edit_method]['currency'] == $site_currency ) ): ?> <?php continue; ?> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <!--[if BLOCK]><![endif]--><?php if($key == 'enable_test_mode'): ?>
                                            <div id="<?php echo e($key); ?>_field" class="form-group form-group-half tb-testmode-wrapper">
                                                <div class="tb-paymethod-items tb-test-opt px-0">
                                                    <div class="checkbox tb-payment-items">
                                                        <input type="checkbox" wire:model="<?php echo e('methods.'.$edit_method.'.'. $key); ?>" id="<?php echo e($method.'_test_mode'); ?>">
                                                        <span for="<?php echo e($method.'_test_mode'); ?>" class="tk-label text"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div id="<?php echo e($key); ?>_field" class="form-group form-group-half">
                                                <label class="tk-label <?php if($key !== 'exchange_rate' && $key !== 'currency'): ?> tb-important <?php endif; ?>"><?php echo e(__('settings.'.$key)); ?>

                                                    <!--[if BLOCK]><![endif]--><?php if($key == 'exchange_rate'): ?>
                                                        ( 1 <?php echo e($this->site_currency); ?> = 1 <?php echo e($methods[$edit_method]['currency']); ?> )
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </label>
                                                <!--[if BLOCK]><![endif]--><?php if($key == 'currency'): ?>
                                                    <div class="tb-select border-0">
                                                        <select id="tk_def_currency" wire:model="<?php echo e('methods.'.$edit_method.'.'. $key); ?>" data-method="<?php echo e($edit_method); ?>" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.currency')); ?>" class="form-control tk-select">
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currencies[$edit_method]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($currency); ?>" <?php echo e($methods[$edit_method][$key] == $currency ? 'selected' : ''); ?> ><?php echo e($currency); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                        </select>
                                                    </div>
                                                <?php else: ?>
                                                    <input type="text" class="form-control <?php $__errorArgs = ['methods.'.$edit_method.'.'. $key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="<?php echo e('methods.'.$edit_method.'.'. $key); ?>" placeholder="<?php echo e(__('settings.enter_value')); ?>">
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['methods.'.$edit_method.'.'. $key];
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
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="tb-updatesave-btn">
                                <a href="javascript:void(0);" wire:click.prevent="updateSetting" class="tb-btn">
                                    <?php echo e(__('settings.save_setting')); ?>

                                </a>
                            </div>
                        </fieldset>
                    </form>
                </div>
            <?php else: ?>
                <div class="tb-payment-methods tb-emptypaysetting">
                    <img class="tb-empty-img" src="<?php echo e(asset('images/empty.png')); ?>" alt="images">
                    <h2 class="tb-empty"><?php echo __('settings.empty_setting_desc', ['edit_btn_txt' => '<a href="javascript:;">'. __("settings.edit_txt").' <i class="icon-edit-3"></i></a>']); ?></h2>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        </div>
    </div>
</main>
<?php $__env->startPush('scripts'); ?>
<script>
    window.addEventListener('editMethod', function (event){
        jQuery('#tk_currency').on('change', function (e) {
            let _this = jQuery(this);
            let method = _this.data('method');
            let currency = jQuery('#tk_currency').select2("val");
            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('methods.'+method+'.currency', currency);
        });

        jQuery('#tk_insp_period').on('change', function (e) {
            let value = jQuery('#tk_insp_period').select2("val");
            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('methods.escrow.inspection_period', value, true);
        });

        jQuery('#tk_fees_payer').on('change', function (e) {
            let value = jQuery('#tk_fees_payer').select2("val");
            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('methods.escrow.fees_payer', value, true);
        });
    });
    document.addEventListener('livewire:initialized', () => {
        window.Livewire.find('<?php echo e($_instance->getId()); ?>').on('refreshPage', () => {
            window.location.reload();
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/payments/payment-methods.blade.php ENDPATH**/ ?>