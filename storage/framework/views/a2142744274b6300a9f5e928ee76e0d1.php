<main class="tb-main tb-blogwrap" wire:init="loadData">
    <div class="row">
        <?php echo $__env->make('livewire.pages.admin.blog-categories.update', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4><?php echo e(__('category.text')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred <?php echo e($selectedCategories ? '' : 'd-none'); ?>" @click="$wire.dispatch('showConfirm', { action : 'delete-category' })"><?php echo e(__('general.delete_selected')); ?></a>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select" wire:ignore>
                                        <select class="am-select2" id="sortBy" data-searchable="false">
                                            <option value="asc"><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc"><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select" wire:ignore>
                                        <select class="form-control am-select2" id="perPage" data-searchable="false">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $per_page_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>"><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search" autocomplete="off" placeholder="<?php echo e(__('category.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-db-categoriestable">
                <!--[if BLOCK]><![endif]--><?php if($categories->count() > 0): ?>
                    <div class="tb-table-wrap">
                        <table class="table tb-table tb-dbholder">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="tb-checkbox">
                                            <input id="checkAll" wire:model.lazy="selectAll" type="checkbox">
                                            <label for="checkAll"><?php echo e(__('category.title')); ?></label>
                                        </div>
                                    </th>
                                    <th><?php echo e(__('category.description')); ?></th>
                                    <th><?php echo e(__('general.status')); ?></th>
                                    <th><?php echo e(__('general.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('category.title')); ?>">
                                            <div class="tb-namewrapper">
                                                <div class="tb-checkbox">
                                                    <input id="category_id<?php echo e($single->id); ?>" wire:model.lazy="selectedCategories" value="<?php echo e($single->id); ?>" type="checkbox">
                                                    <label for="category_id<?php echo e($single->id); ?>">
                                                        <span>
                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($single->image)): ?>
                                                                <?php
                                                                    $image = unserialize($single->image);
                                                                    $image_path = $image['file_path'];
                                                                    $image_name = $image['file_name'];
                                                                ?>
                                                                <img src="<?php echo e(url(Storage::url($image_path))); ?>" alt="<?php echo e($image_name); ?>">
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            <?php echo $single->name; ?>

                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('category.description')); ?>"><span><?php echo $single->description; ?></span></td>
                                        <td data-label="<?php echo e(__('general.status')); ?>">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-<?php echo e($single->status == 'active' ? 'active' : 'disabled'); ?>"><?php echo e($single->status); ?></em>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('general.actions')); ?>">
                                            <ul class="tb-action-icon">
                                                <li><a href="javascript:void(0);" wire:click="edit(<?php echo e($single->id); ?>)"><i class="icon-edit-3"></i></a></li>
                                                <li>    
                                                    <a href="javascript:void(0);" 
                                                    @click="$wire.dispatch('showConfirm', { id: <?php echo e($single->id); ?>, action: 'delete-category' })" 
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
                    </div>
                    <?php echo e($categories->links('pagination.custom')); ?>

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
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/css/combotree.css', 
    ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('js/combotree.js')); ?>"></script>
    <script>
        var categoryInstance = null;

        document.addEventListener('livewire:navigated', function() {

            let title           = '<?php echo e(__("general.confirm")); ?>';
            let listenerName    = 'delete-category-confirm';
            let content         = '<?php echo e(__("general.confirm_content")); ?>';
            let action          = 'deleteConfirmRecord'; 
            
            window.addEventListener('initDropDown', function(event){
                let parentId = event.detail.parentId;
                if( event.detail.categories_tree.length ){
                    initDropDown(event.detail.categories_tree, parentId);
                }
            });

            jQuery('#sortBy').on('change', function() {
                let sortByValue = jQuery(this).val();
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('sortby', sortByValue);
            });

            jQuery('#perPage').on('change', function() {
                let perPageValue = jQuery(this).val();
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('per_page', perPageValue);
            });

            jQuery('.am-select2').each((index, item) => {
                let _this = jQuery(item);
                searchable = _this.data('searchable');
                let params = {
                    dropdownCssClass: _this.data('class'),
                    placeholder: _this.data('placeholder'),
                    allowClear: true
                }
                if(!searchable){
                    params['minimumResultsForSearch'] = Infinity;
                }
                _this.select2(params);

            });


            function initDropDown(categories, parentId = null){

                // jQuery('input[id^="category_dropdown-"]').parent('.form-group').removeClass('d-none');
                if(categoryInstance != null){
                    categoryInstance.clearSelection();
                    categoryInstance.destroy();
                }

                let settings = {
                    source : categories,
                    isMultiple: false,
                    collapse: false
                }

                if(parentId){
                    settings['selected'] = [parentId.toString()]
                }
                setTimeout(() => {  
                    categoryInstance = $('input[id^="category_dropdown-"]').comboTree(settings);
                }, 100);
            }
                
                // confirmAlert({title,listenerName, content, action});

            

                // if( window.categories_tree.length ){
                //     initDropDown(window.categories_tree);
                // }

                

                jQuery(document).on('change', 'input[id^="category_dropdown-"]', function(event){
                    if(categoryInstance){
                        let id = categoryInstance.getSelectedIds();
                        if(id){
                            window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('parentId', id[0], true);
                        }
                    }
                });
                // iniliazeSelect2Scrollbar();
        });
        
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/admin/blog-categories/categories.blade.php ENDPATH**/ ?>