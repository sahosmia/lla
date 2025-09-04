<main class="tb-main tb-pageslanguagewrap">
    <div class ="row">
        <div class="col-lg-4 col-md-12 tb-md-40">
            <div class="tb-dbholder tb-packege-setting">
                <div class="tb-dbbox tb-dbboxtitle">
                    <!--[if BLOCK]><![endif]--><?php if($editMode): ?>
                        <h5> <?php echo e(__('taxonomy.update_language')); ?></h5>
                    <?php else: ?>
                        <h5> <?php echo e(__('taxonomy.add_language')); ?></h5>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div class="tb-dbbox">
                    <form class="tk-themeform">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group">
                                    <label class="tb-label"><?php echo e(__('general.name')); ?></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> "  wire:model="name" required placeholder="<?php echo e(__('general.name')); ?>">
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
                                <div class="form-group">
                                    <label class="tb-label"><?php echo e(__('general.description')); ?></label>
                                    <textarea class="form-control" placeholder="<?php echo e(__('general.description')); ?>" wire:model="description" id=""></textarea>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if($editMode): ?>
                                    <div class="form-group">
                                        <label class="tb-label"><?php echo e(__('general.status')); ?>:</label>
                                        <div class="tb-email-status">
                                            <span><?php echo e(__('taxonomy.language_status')); ?></span>
                                            <div class="tb-switchbtn">
                                                <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes"><?php echo e($status == 'active' ? __('general.active') : __('general.deactive')); ?></span></label>
                                                <input class="tb-checkaction" <?php echo e($status == 'active' ? 'checked' : ''); ?> type="checkbox" id="tb-emailstatus">
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
                                        <!--[if BLOCK]><![endif]--><?php if($editMode): ?>
                                            <?php echo e(__('taxonomy.update_language')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('general.add_now')); ?>

                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('taxonomy.languages')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred <?php echo e($selectedLanguages ? '' : 'd-none'); ?>"  @click="$wire.dispatch('showConfirm', { action : 'delete-language' })" ><?php echo e(__('general.delete_selected')); ?></a>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model.live="sortby" class="form-control tk-select2">
                                            <option value="asc"><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc"><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model.live="perPage" class="form-control tk-select2">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $perPageOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>"><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"  autocomplete="off" placeholder="<?php echo e(__('taxonomy.search_here')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="tb-disputetable tb-pageslanguage">
                <!--[if BLOCK]><![endif]--><?php if(!empty($languages) && $languages->count() > 0): ?>
                    <div class="tb-table-wrap">
                        <table class="table tb-table tb-dbholder <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="tb-checkbox">
                                            <input id="checkAll" wire:model.lazy="selectAll"  type="checkbox">
                                            <label for="checkAll"><?php echo e(__('general.name')); ?></label>
                                        </div>
                                    </th>
                                    <th><?php echo e(__('general.description')); ?></th>
                                    <th><?php echo e(__('general.status')); ?></th>
                                    <th><?php echo e(__('general.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('taxonomy.name')); ?>">
                                            <div class="tb-checkboxwithimg">
                                                <div class="tb-checkbox">
                                                    <input id="language_id<?php echo e($single->id); ?>" wire:model.lazy="selectedLanguages" value="<?php echo e($single->id); ?>" type="checkbox">
                                                    <label for="language_id<?php echo e($single->id); ?>">
                                                        <span>
                                                            <?php echo $single->name; ?>

                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('general.description')); ?>"><span><?php echo $single->description; ?></span></td>
                                        <td data-label="<?php echo e(__('general.status')); ?>">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-<?php echo e($single->status == 'active' ? 'active' : 'disabled'); ?>"><?php echo e($single->status); ?></em>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('general.actions')); ?>">
                                            <ul class="tb-action-icon">
                                                <li> <a href="javascript:void(0);" wire:click="edit(<?php echo e($single->id); ?>)"><i class="icon-edit-3"></i></a> </li>
                                                <li> <a href="javascript:void(0);" @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->id); ?>, action : 'delete-language' })"  class="tb-delete"><i class="icon-trash-2"></i></a> </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                        <?php echo e($languages->links('pagination.custom')); ?>

                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/empty.png'),'title' => __('general.no_record_title')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/empty.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_record_title'))]); ?>
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
                </div>
            </div>
        </div>
    </div>
</main>

<?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/admin/taxonomy/language.blade.php ENDPATH**/ ?>