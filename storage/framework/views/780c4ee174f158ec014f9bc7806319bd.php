<main class="tb-main am-dispute-system am-blogs-system">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('blogs.blogs')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred <?php echo e($selectedBlogs ? '' : 'd-none'); ?>" @click="$wire.dispatch('showConfirm', { action : 'delete-blog' })"><?php echo e(__('general.delete_selected')); ?></a>
                                </div>
                                <a href="<?php echo e(route('admin.create-blog')); ?>" class="tb-btn tb-menubtn">
                                    <?php echo e(__('blogs.add_blog')); ?> <i class="icon-plus"></i>
                                </a>
                                
                                <div class="tb-actionselect">
                                    <div class="tb-select" wire:ignore>
                                        <select id="filter_sort" class="form-control tk-select2">
                                            <option value="asc" <?php echo e($sortby == 'asc' ? 'selected' : ''); ?>><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc" <?php echo e($sortby == 'desc' ? 'selected' : ''); ?>><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_per_page" class="form-control tk-select2">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $perPageOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>"><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search" autocomplete="off" placeholder="<?php echo e(__('taxonomy.search_here')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <!--[if BLOCK]><![endif]--><?php if(!empty($blogs) && $blogs->count() > 0): ?>
                        <table class="tb-table <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="tb-checkbox">
                                            <input id="checkAll" wire:model.lazy="selectAll" type="checkbox">
                                            <label for="checkAll"><?php echo e(__('general.title')); ?></label>
                                        </div>
                                    </th>
                                    <th><?php echo e(__('Description')); ?></th>
                                    <th><?php echo e(__('blogs.category')); ?></th>
                                    <th><?php echo e(__('general.status')); ?></th>
                                    <th><?php echo e(__('general.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('title')); ?>">
                                            <div class="tb-checkboxwithimg">
                                                <div class="tb-checkbox">
                                                    <input id="blog_id<?php echo e($single->id); ?>" wire:model.lazy="selectedBlogs" value="<?php echo e($single->id); ?>" type="checkbox">
                                                    <label for="blog_id<?php echo e($single->id); ?>">
                                                        <img src="<?php echo e(url(Storage::url($single->image))); ?>" alt="<?php echo e($single->title); ?>" width="100"> 
                                                        <span>
                                                            <?php echo $single->title; ?>

                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('description')); ?>">
                                            <span class="fw-form-description"><?php echo e(\Illuminate\Support\Str::limit(strip_tags($single->description), 100)); ?></span>
                                        </td>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($single->categories)): ?>
                                            <td data-label="<?php echo e(__('blogs.category')); ?>">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $single->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <em class="am-blogs-category_em"><?php echo e($category?->name); ?><?php echo e($key < count($single->categories) - 1 ? ',' : ''); ?></em>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->        
                                            </td>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <td data-label="<?php echo e(__('general.status')); ?>">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-<?php echo e($single->status == 'published' ? 'active' : 'disabled'); ?>"><?php echo e($single->status); ?></em>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('general.actions')); ?>">
                                            <ul class="tb-action-icon">
                                                <li> <a href="<?php echo e(route('admin.update-blog', $single->id)); ?>"><i class="icon-edit-3"></i></a> </li>
                                                <li> <a href="<?php echo e(route('blog-details', ['slug' => $single->slug, 'source' => 'admin'])); ?>" target="_blank"><i class="icon-eye"></i></a> </li>
                                                <li>    
                                                    <a href="javascript:void(0);" 
                                                    @click="$wire.dispatch('showConfirm', { id: <?php echo e($single->id); ?>, action: 'delete-blog' })" 
                                                    class="tb-delete">
                                                    <i class="icon-trash-2"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                        <?php echo e($blogs->links('pagination.custom')); ?>

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
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/summernote/summernote-lite.min.css',
    ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>

    <script type="text/javascript" data-navigate-once>
        document.addEventListener('livewire:navigated', function() {
            component = window.Livewire.find('<?php echo e($_instance->getId()); ?>');
        });

        document.addEventListener('livewire:initialized', function() {
            jQuery('#filter_sort').on('change', function (e) {
                var selectedSort = $(this).val();
                component.set('sortby', selectedSort);
            });

            jQuery('#filter_per_page').on('change', function (e) {
                var selectedSort = $(this).val();
                component.set('perPage', selectedSort);
            });
        });
        
        
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/admin/blogs.blade.php ENDPATH**/ ?>