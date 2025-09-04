<div class="col-lg-4 col-md-12 tb-md-40">
    <div class="tb-dbholder tb-packege-setting">
        <div class="tb-dbbox tb-dbboxtitle">
            <h5>
                 <?php echo e($editMode ? __('category.update_category') : __('category.add_category')); ?>

            </h5>
        </div>
        <div class="tb-dbbox">
            <form class="tk-themeform tk-form-blogcategories">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <div class="form-group">
                            <label class="tb-label"><?php echo e(__('category.title')); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"   wire:model.defer="name" required placeholder="<?php echo e(__('category.title')); ?>">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
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
                        
                            <div class="form-group" wire:ignore>
                                <label class="tb-titleinput"><?php echo e(__('category.parent_category')); ?></label>
                                <input class="from-control" type="text" id="category_dropdown-<?php echo e(time()); ?>" placeholder="<?php echo e(__('category.parent_category')); ?>" autocomplete="off"/>
                            </div>
                        

                        <div class="form-group">
                            <label class="tb-label"><?php echo e(__('category.description')); ?></label>
                            <textarea class="form-control" placeholder="<?php echo e(__('category.description')); ?>" wire:model.defer="description" id=""></textarea>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($editMode): ?>
                            <div class="form-group">
                                <label class="tb-label"><?php echo e(__('general.status')); ?>:</label>
                                <div class="tb-email-status">
                                    <span> <?php echo e(__('category.category_status')); ?> </span>
                                    <div class="tb-switchbtn">
                                        <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes"><?php echo e($status == 'active' ? __('general.active') : __('general.deactive')); ?></span></label>
                                        <input wire:change="updateStatus($event.target.checked)" <?php echo e($status == 'active' ? 'checked' : ''); ?> class="tb-checkaction" type="checkbox" id="tb-emailstatus">
                                    </div>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['status'];
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
                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                <?php echo e($editMode ? __('category.update_category') : __('category.add_category')); ?>

                            </a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:load', function () {
            $(document).on('click', '.tb-themeselect .tb-select', function(event) {
                event.stopPropagation();
                $(document).find('.tb-categorytree-dropdown').addClass('tk-custom-scrollbar');
                $(this).next(".tb-themeselect_options").slideToggle();                
            });

            $(document).on('click', '.tb-themeselect_options li label', function(event) {
                let listText = jQuery(this).text();
                $('.tb-themeselect_value').text(listText);
                $('.tb-themeselect_value').addClass('tk-selected');
                $(this).parents(".tb-themeselect_options").slideUp();
                $('.tb-categorytree-dropdown').mCustomScrollbar('destroy');
            });

            $(document).on('click', '.tb-checkaction', function(event){
                let _this = $(this);
                let status = '';
                if(_this.is(':checked')){
                    _this.parent().find('#tb-textdes').html("<?php echo e(__('general.active')); ?>");
                    status = 'active';
                } else {
                    _this.parent().find('#tb-textdes').html( "<?php echo e(__('general.deactive')); ?>");
                    status = 'deactive';
                }
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('status', status, true);
            });

        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/admin/blog-categories/update.blade.php ENDPATH**/ ?>