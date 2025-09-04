<main class="tb-main tb-emailtemplatewrap">
    <div class ="row">
        <?php echo $__env->make('livewire.pages.admin.notification-templates.update', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('notification_template.all_templates')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" >
                                    <div class="tb-select">
                                        <select class="am-select2 form-control" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" data-searchable="false" data-wiremodel="sortby" id="sortby">
                                            <option value="asc"><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc"><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" >
                                    <div class="tb-select">
                                        <select class="am-select2 form-control" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" data-searchable="false" data-wiremodel="per_page" id="per_page">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $per_page_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>"><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-pagesemail">
                <!--[if BLOCK]><![endif]--><?php if( !$listed_templated->isEmpty() ): ?>
                    <div class="tb-table-wrap">
                        <table class="table tb-table tb-dbholder <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('notification_template.notification_title')); ?> </th>
                                    <th><?php echo e(__('notification_template.role_type')); ?></th>
                                    <th><?php echo e(__('general.status')); ?></th>
                                    <th><?php echo e(__('general.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $listed_templated; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('notification_template.notification_title')); ?>"><span><?php echo $single->title; ?></span></td>
                                        <td data-label="<?php echo e(__('notification_template.role_type')); ?>"><span><?php echo e(ucfirst($single->role)); ?></span></td>
                                        <td data-label="<?php echo e(__('general.status')); ?>">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-<?php echo e($single->status == 'active' ? 'active' : 'disabled'); ?>"><?php echo e($single->status == 'active' ? __('general.active') : __('general.deactive')); ?></em>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('general.actions')); ?>">
                                            <ul class="tb-action-icon">
                                                <li> <a href="javascript:void(0);"  wire:click.prevent="edit(<?php echo e($single->id); ?>)"><i class="icon-edit-3"></i></a> </li>
                                                <li> <a href="javascript:;"  @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->id); ?>, action : 'delete-template' })" class="tb-delete"><i class="icon-trash-2"></i></a> </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                    <?php echo e($listed_templated->links('pagination.custom')); ?>

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
</main>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/admin/notification-templates/notification-templates.blade.php ENDPATH**/ ?>