<div class="tb-dbholder tb-packege-setting">
    <div class="tb-dbbox tb-dbboxtitle">
        <h5>
            <?php echo e($edit ? __('pagebuilder::pagebuilder.update_page') : __('pagebuilder::pagebuilder.add_page')); ?>

        </h5>
    </div>
    <div class="tb-dbbox" id="add_edit">
        <form class="tb-themeform" id="page_form">
            <?php echo csrf_field(); ?>
            <fieldset>
                <div class="tb-themeform__wrap">

                    <div class="form-group">
                        <label class="tb-label"><?php echo e(__('pagebuilder::pagebuilder.page_name')); ?></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
                            value="<?php echo e($page->name??null); ?>" id="name"
                            placeholder="<?php echo e(__('pagebuilder::pagebuilder.page_name')); ?>">
                        <?php if($edit): ?>
                        <input type="hidden" name="id" id="id" value="<?php echo e($page->id??null); ?>" />
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="tb-label"><?php echo e(__('pagebuilder::pagebuilder.page_title')); ?></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="title"
                            id="title" value="<?php echo e($page->title??null); ?>"
                            placeholder="<?php echo e(__('pagebuilder::pagebuilder.page_title')); ?>">
                    </div>

                    <div class="form-group">
                        <label class="tb-label"><?php echo e(__('pagebuilder::pagebuilder.page_description')); ?></label>
                        <textarea class="form-control" name="description" id="description"
                            placeholder="<?php echo e(__('pagebuilder::pagebuilder.page_description')); ?>"><?php echo e($page->description??null); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="tb-label"><?php echo e(__('pagebuilder::pagebuilder.page_slug')); ?></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="slug"
                            id="slug" value="<?php echo e($page->slug??null); ?>"
                            placeholder="<?php echo e(__('pagebuilder::pagebuilder.page_slug')); ?>">
                    </div>

                    <?php if($edit): ?>
                    <div class="form-group">
                        <label class="tb-label"><?php echo e(__('pagebuilder::pagebuilder.status')); ?>:</label>
                        <div class="tb-email-status">
                            <span> <?php echo e(__('pagebuilder::pagebuilder.page_status')); ?> </span>
                            <div class="tb-switchbtn">
                                <label for="tb-pagestatus" class="tb-textdes"><span
                                        id="tb-textdes"><?php echo e((($page->status??null)=='published') ?
                                        __('pagebuilder::pagebuilder.active') :
                                        __('pagebuilder::pagebuilder.deactive')); ?></span></label>

                                <input type="checkbox" class="tb-checkaction" name="status" id="status" <?php echo e((($page->status??null)== 'published')?'checked': ''); ?> />
                            </div>
                        </div>
                    </div>

                    <?php endif; ?>
                    <div class="form-group tb-dbtnarea">
                        <button class="pb-btn" type="submit" id="form_submit_btn"><?php echo e($edit?__('pagebuilder::pagebuilder.update_page'):__('pagebuilder::pagebuilder.add_page')); ?></button>

                        <?php if($edit): ?>
                        <button class="pb-btn goBack" type="button"
                            id="form_submit_btn"><?php echo e(__('pagebuilder::pagebuilder.back')); ?></button>
                        <?php endif; ?>

                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/vendor/larabuild/pagebuilder/src/../resources/views/components/update-page.blade.php ENDPATH**/ ?>