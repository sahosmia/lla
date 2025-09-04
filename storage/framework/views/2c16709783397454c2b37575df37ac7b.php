<main class="tb-main am-dispute-system tb-packages-main" wire:loading.class="tb-isloading" wire:target="filters, update-status, delete-addon">
    <div class="tb-section-load" wire:loading.flex wire:target="filters, update-status, delete-addon">
        <p><?php echo e(__('general.loading')); ?></p>
    </div>
    <div class="row">
            <div class="col-lg-12 col-md-12 tb-md-12">
                <div class="tb-dhb-mainheading">
                    <h4> <?php echo e(__('admin/general.manage_packages')); ?></h4>
                    <div class="tb-sortby">
                        <form class="tb-themeform tb-displistform">
                            <fieldset>
                                <div class="tb-themeform__wrap">
                                    <a href="<?php echo e(route('admin.packages.index')); ?>" class="tb-btn tb-menubtn">
                                        <?php echo e(__('admin/general.add_new')); ?> <i class="icon-plus"></i>
                                    </a>
                                    
                                    <div class="tb-actionselect">
                                        <div class="tb-select" wire:ignore>
                                            <select id="filter_sort" class="form-control tk-select2">
                                                <option value="asc" <?php echo e($filters['sortby'] == 'asc' ? 'selected' : ''); ?>><?php echo e(__('general.asc')); ?></option>
                                                <option value="desc" <?php echo e($filters['sortby'] == 'desc' ? 'selected' : ''); ?>><?php echo e(__('general.desc')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tb-actionselect" wire:ignore>
                                        <div class="tb-select">
                                            <select id="filter_per_page" class="form-control tk-select2">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $perPageOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($opt); ?>" <?php echo e($filters['per_page'] == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group tb-inputicon tb-inputheight">
                                        <i class="icon-search"></i>
                                        <input type="text" class="form-control" wire:model.live.debounce.500ms="filters.name" autocomplete="off" placeholder="<?php echo e(__('taxonomy.search_here')); ?>">
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="am-disputelist_wrap">
                    <div class="am-disputelist am-custom-scrollbar-y">
                        <table class="tb-table <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('general.title')); ?></th>
                                    <th><?php echo e(__('general.description')); ?></th>
                                    <th><?php echo e(__('general.status')); ?></th>
                                    <th><?php echo e(__('general.actions')); ?></th>
                                </tr>
                            </thead>
                            <!--[if BLOCK]><![endif]--><?php if($packages->isNotEmpty()): ?>
                                <tbody>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td data-label="<?php echo e(__('general.title')); ?>">
                                                <div class="am-list-wrap">
                                                    <figure>
                                                        <img src="<?php echo e('https://lernen.amentotech.com/addons/icons/'. $single->image); ?>" alt="<?php echo e($single->name); ?>" width="100"> 
                                                    </figure>
                                                    <span>
                                                        <?php echo $single->name; ?>

                                                    </span>
                                                </div>
                                            </td>
                                            <td data-label="<?php echo e(__('general.description')); ?>">
                                                <span><?php echo e(\Illuminate\Support\Str::limit(strip_tags($single->description), 100)); ?></span>
                                            </td>
                                            <!--[if BLOCK]><![endif]--><?php if($single->type != 'core'): ?>
                                                <td data-label="<?php echo e(__('general.status')); ?>">
                                                    <div class="am-status-tag">
                                                        <em class="tk-project-tag tk-<?php echo e($single->isEnabled() ? 'active' : 'fixed-tag'); ?>">
                                                            <?php echo e($single->isEnabled() ? __('admin/general.activated') : __('admin/general.deactivated')); ?>

                                                        </em>
                                                    </div>
                                                </td>
                                            <?php else: ?>
                                                <td data-label="<?php echo e(__('general.status')); ?>">
                                                    <div class="am-status-tag">
                                                        <em class="tk-project-tag tk-disabled"><?php echo e(__('admin/general.core_addon')); ?></em>
                                                    </div>
                                                </td>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <td data-label="<?php echo e(__('general.actions')); ?>">
                                                <ul class="tb-action-icon">
                                                    <li>
                                                        <div class="am-itemdropdown">
                                                            <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z" fill="#585858"/><path d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z" fill="#585858"/><path d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z" fill="#585858"/></svg></i>
                                                            </a>
                                                            <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <!--[if BLOCK]><![endif]--><?php if($single->isDisabled()): ?>
                                                                    <li @click="$wire.dispatch('showConfirm', { id : '<?php echo e($single->slug); ?>', content: `<?php echo e($single->isEnabled() ? __('admin/general.deactivate_addon') : __('admin/general.activate_addon')); ?>`, type: '<?php echo e($single->isEnabled() ? 'active' : 'disabled'); ?>', action : 'update-status' })">
                                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                                            <path d="M13.7037 2.53291C12.588 1.97845 11.3304 1.66669 9.99996 1.66669C5.39759 1.66669 1.66663 5.39765 1.66663 10C1.66663 14.6024 5.39759 18.3334 9.99996 18.3334C14.6023 18.3334 18.3333 14.6024 18.3333 10C18.3333 9.68705 18.316 9.37811 18.2824 9.0741M7.49996 9.16669L9.99996 11.6667L18.3333 3.33335" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        </svg>
                                                                        <span><?php echo e(__('admin/general.activate')); ?></span>
                                                                    </li>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                <!--[if BLOCK]><![endif]--><?php if($single->isEnabled()): ?>
                                                                    <li @click="$wire.dispatch('showConfirm', { id : '<?php echo e($single->slug); ?>', content: `<?php echo e($single->isEnabled() ? __('admin/general.deactivate_addon') : __('admin/general.activate_addon')); ?>`, type: '<?php echo e($single->isEnabled() ? 'active' : 'disabled'); ?>', action : 'update-status' })">
                                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                                            <path d="M15.8333 15.8334L4.16663 4.16669M18.3333 10C18.3333 14.6024 14.6023 18.3334 9.99996 18.3334C5.39759 18.3334 1.66663 14.6024 1.66663 10C1.66663 5.39765 5.39759 1.66669 9.99996 1.66669C14.6023 1.66669 18.3333 5.39765 18.3333 10Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        </svg>
                                                                        <span><?php echo e(__('admin/general.deactivate')); ?></span>
                                                                    </li>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                <li @click="$wire.dispatch('showConfirm', { id: '<?php echo e($single->slug); ?>', action: 'delete-addon', content: `<?php echo e(__('admin/general.delete_addon_warning')); ?>` })">
                                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                                        <path d="M3.33329 4.16669L3.82408 12.5101C3.93762 14.4402 3.99439 15.4053 4.37565 16.1521C4.79536 16.9742 5.48648 17.6259 6.33182 17.9966C7.09974 18.3334 8.06648 18.3334 9.99996 18.3334V18.3334C11.9334 18.3334 12.9002 18.3334 13.6681 17.9966C14.5134 17.6259 15.2046 16.9742 15.6243 16.1521C16.0055 15.4053 16.0623 14.4402 16.1758 12.5101L16.6666 4.16669M3.33329 4.16669H1.66663M3.33329 4.16669H16.6666M16.6666 4.16669H18.3333M13.3333 4.16669L13.047 3.30774C12.8503 2.71763 12.7519 2.42257 12.5695 2.20442C12.4084 2.01179 12.2015 1.86268 11.9678 1.77077C11.7032 1.66669 11.3922 1.66669 10.7701 1.66669H9.22978C8.60775 1.66669 8.29673 1.66669 8.03209 1.77077C7.7984 1.86268 7.59152 2.01179 7.43043 2.20442C7.248 2.42257 7.14965 2.71763 6.95294 3.30774L6.66663 4.16669M8.33329 8.33335V14.1667M11.6666 8.33335V11.6667" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    </svg>
                                                                    <span><?php echo e(__('general.delete')); ?></span>
                                                                </li>
                                                            </ul>   
                                                        </div>  
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </table>
                        <!--[if BLOCK]><![endif]--><?php if($packages->isEmpty()): ?>
                            <div class="am-disputelist-empty">
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
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if(!$packages->isEmpty()): ?>
                        <?php echo e($packages->links('pagination.custom')); ?>

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
        </div>    
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" data-navigate-once>
        document.addEventListener('livewire:navigated', function() {
            component = window.Livewire.find('<?php echo e($_instance->getId()); ?>');
        });

        jQuery('#filter_sort').on('change', function (e) {
            var selectedSort = $(this).val();
            component.set('filters.sortby', selectedSort);
        });

        jQuery('#filter_per_page').on('change', function (e) {
            var selectedSort = $(this).val();
            component.set('filters.per_page', selectedSort);
        });

        Livewire.on('update-status', function(e) {
            jQuery('.tb-section-load').parent().addClass('tb-isloading');
            jQuery('.tb-section-load').addClass('d-flex');
        });

        Livewire.on('delete-addon', function(e) {
            jQuery('.tb-section-load').parent().addClass('tb-isloading');
            jQuery('.tb-section-load').addClass('d-flex');
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/packages/installed-packages.blade.php ENDPATH**/ ?>