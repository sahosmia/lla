<main class="tb-main">
    <div class="tb-menumanagement">
        <div class="row">
            <div class="col-12">
            <div class="tb-dhb-mainheading pb-0">
                <h2> <?php echo e(__('menus.menu_management')); ?></h2>
                <div class="tb-sortingoption">
                    <a href="javascript:void(0);" wire:click.prevent="addMenu" class="tb-menubtn"><?php echo e(__('menus.add_new_menu')); ?> <i class="icon-plus"></i></a>
                    <div class="tb-selectoption">
                        <span class="tb-select" wire:ignore>
                            <select class="am-select2" data-searchable="false" id="menu_id"  data-placeholder="<?php echo e(__('menus.select_menu')); ?>">
                                <option value=""><?php echo e(__('menus.select_menu')); ?></option>
                                <!--[if BLOCK]><![endif]--><?php if( !$menu_list->isEmpty() ): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $menu_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($single->id); ?>" <?php echo e($menu_id==$single->id ? 'selected' : ''); ?>><?php echo e($single->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="tb-accordion <?php echo e(!$menu_id ? 'disabled' : ''); ?>" id="theme-accordion">
                <!--[if BLOCK]><![endif]--><?php if( !$site_pages->isEmpty() ): ?>
                <div class="tb-accordion_wrap" wire:ignore>
                    <div class="tb-accordion_header" id="accordionone">
                        <h2 data-bs-toggle="collapse" data-bs-target="#tb-collapseone" aria-expanded="true">
                            <?php echo e(__('menus.pages')); ?></h2>
                    </div>
                    <div id="tb-collapseone" class="collapse show" aria-labelledby="accordionone"
                        data-parent="#theme-accordion">
                        <div class="tb-accordion_content tb-menupages_list">
                            <div class="tb-addmenupages mCustomScrollbar">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $site_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="tb-checkbox">
                                    <input id="page-<?php echo e($single->id); ?>" value="<?php echo e($single->id); ?>" type="checkbox">
                                    <label for="page-<?php echo e($single->id); ?>"><?php echo e($single->name); ?></label>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="tb-menupages_footer">
                                <div class="tb-checkbox">
                                    <input id="select_pages" name="select_pages" type="checkbox">
                                    <label for="select_pages"><?php echo e(__('menus.select_all_pages')); ?></label>
                                </div>
                                <a href="javascript:void(0);" class="tb-btn add-menu-pages"><?php echo e(__('menus.add_to_menu')); ?></a>
                            </div>

                        </div>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <div class="tb-accordion_wrap">
                    <div class="tb-accordion_header" id="accordiontwo">
                        <h2 data-bs-toggle="collapse" data-bs-target="#tb-collapsetwo" aria-expanded="true"><?php echo e(__('menus.custom_url')); ?></h2>
                    </div>
                    <div id="tb-collapsetwo" class="collapse show" aria-labelledby="accordiontwo"
                        data-parent="#theme-accordion">
                        <div class="tb-accordion_content">
                            <form class="tb-themeform tb-form-menu">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="tb-titleinput"><?php echo e(__('menus.add_label')); ?></label>
                                        <input type="text" wire:model="custom_page_title"
                                            class="form-control  <?php $__errorArgs = ['custom_page_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="<?php echo e(__('menus.add_label')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['custom_page_title'];
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
                                    <div class=" form-group">
                                        <label class="tb-titleinput"><?php echo e(__('menus.enter_url')); ?></label>
                                        <input type="text" wire:model="custom_page_route" class="form-control"
                                            placeholder="<?php echo e(__('menus.enter_url')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <a href="javascript:void(0);" class="tb-btn"
                                            wire:click="addCustomPage"><?php echo e(__('menus.add_to_menu')); ?></a>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-8">
            <div class="tb-addmenu">
                <div class="tb-addmenu_head">
                    <label class="tb-titleinput"><?php echo e(__('menus.menu_title')); ?> </label>
                    <input type="text" wire:model="menu_title"
                        class="form-control <?php $__errorArgs = ['menu_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="<?php echo e(__('menus.menu_title')); ?>">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['menu_title'];
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
                <div class="tb-addmenu_content">
                    <!--[if BLOCK]><![endif]--><?php if( $menu_id ): ?>
                    <p><?php echo e(__('menus.menu_arrange')); ?></p>
                    <!--[if BLOCK]><![endif]--><?php if( !empty($menu_items) && $menu_items->count() > 0): ?>
                    <div class="tb-selectmenu">
                        <div class="tb-checkbox">
                            <input id="select-menu-items" class="select-menu-items" type="checkbox">
                            <label for="select-menu-items"><?php echo e(__('menus.select_all_menu')); ?></label>
                        </div>
                        <a href="javascript:void(0);" class="tb-removemenu d-none remove-selected-items"><?php echo e(__('menus.remove_selected_menu')); ?><i class="icon-trash-2"></i></a>
                    </div>
                    <div class="dd" id="menu-items-edit">
                        <form class="tb-themeform tb-form-menu menu-item-form" wire:key="menu-id-<?php echo e($menu_id); ?>">
                            <ol class="tb-menuaccordion dd-list" id="menu-items" wire:key="menu-items-<?php echo e($menu_id); ?>">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginal7e1a13da8cff92eedd5dcb02aa2c65ae = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7e1a13da8cff92eedd5dcb02aa2c65ae = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.menu-item','data' => ['menu' => $single]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menu' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7e1a13da8cff92eedd5dcb02aa2c65ae)): ?>
<?php $attributes = $__attributesOriginal7e1a13da8cff92eedd5dcb02aa2c65ae; ?>
<?php unset($__attributesOriginal7e1a13da8cff92eedd5dcb02aa2c65ae); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e1a13da8cff92eedd5dcb02aa2c65ae)): ?>
<?php $component = $__componentOriginal7e1a13da8cff92eedd5dcb02aa2c65ae; ?>
<?php unset($__componentOriginal7e1a13da8cff92eedd5dcb02aa2c65ae); ?>
<?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </ol>
                            <input type="hidden" name="updateItems" id="updateItems"
                                wire:key="updated-items-<?php echo e($menu_id); ?>">
                            <input type="hidden" name="removalIds" id="removalIds"
                                wire:key="removed-items-<?php echo e($menu_id); ?>">
                        </form>
                    </div>
                    <div class="tb-selectmenu">
                        <div class="tb-checkbox">
                            <input id="allselectmenu" class="select-menu-items" type="checkbox">
                            <label for="allselectmenu"><?php echo e(__('menus.select_all_menu')); ?></label>
                        </div>
                        <a href="javascript:void(0);" class="tb-removemenu d-none remove-selected-items"><?php echo e(__('menus.remove_selected_menu')); ?> <i class="icon-trash-2"></i></a>
                    </div>
                    <?php else: ?>
                    <div class="tb-addheremenu">
                        <span><?php echo e(__('menus.no_menu_items_found')); ?></span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="tb-selectmenu_position">
                        <h6><?php echo e(__('menus.menu_position')); ?></h6>
                        <ul class="tb-menuposition_list">
                            <li>
                                <div class="tb-radiobox">
                                    <input id="menu-header" <?php echo e($menu_location=='header' ? 'checked' : ''); ?>

                                        name="menu_location" value="header" type="radio">
                                    <label for="menu-header"><?php echo e(__('menus.add_header_menu')); ?></label>
                                </div>
                            </li>
                            <li>
                                <div class="tb-radiobox">
                                    <input id="menu-footer" <?php echo e($menu_location=='footer' ? 'checked' : ''); ?>

                                        name="menu_location" value="footer" type="radio">
                                    <label for="menu-footer"><?php echo e(__('menus.add_footer_menu')); ?></label>
                                </div>
                            </li>
                        </ul>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['menu_location'];
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
                </div>
                <div class="tb-addmenu_footer">
                    <a  href="javascript:void(0);" class="tb-btn <?php echo e(!$add_menu && $menu_id ? 'update-menu-items' : ''); ?>"
                    <?php if($add_menu && !$menu_id): ?> wire:click.prevent="createMenu" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>><?php echo e(__('menus.save_menu')); ?></a>
                    <!--[if BLOCK]><![endif]--><?php if( $menu_id ): ?>
                        <a href="javascript:void(0);" class="tb-removemenu" @click="$wire.dispatch('showConfirm', { id : <?php echo e($menu_id); ?>, action : 'delete-menu' })"
                            ><?php echo e(__('menus.delete_menu')); ?> <i class="icon-trash-2"></i></a>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('js/jquery.nestable.min.js')); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
            var removal_Ids = [];
            setTimeout(function() {

                $('.tb-menuposition_list input[type="radio"]').on('click', function (e) {
                    $('.tb-menuposition_list input[type="radio"]').prop('checked', false);
                    $(this).prop('checked', true);
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('menu_location', e.target.value, false);
                });

                $('.add-menu-pages').on('click', function (e) {
                    let page_ids = [];
                    $(".tb-menupages_list input[type='checkbox']:checked").not('#select_pages').each(function(){
                        page_ids.push(this.value);
                    });
                    if( page_ids != '' ){
                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('page_ids', page_ids, true);
                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('addPages');
                        $('.tb-menupages_list input[type="checkbox"]').prop('checked', false);
                    }
                });

                $("#select_pages").on('click', function(){
                    $('.tb-menupages_list input[type="checkbox"]').prop('checked', this.checked);
                });

                $(document).on('click', '.select-menu-items', function(e) {
                    if(this.checked){
                        $('.remove-selected-items').removeClass('d-none');
                    }else{
                        $('.remove-selected-items').addClass('d-none');
                    }
                    $('.tb-menuaccordion_wrap input[type="checkbox"]').prop('checked', this.checked);
                });

                $(document).on('click', '.tb-menuaccordion_wrap input[type="checkbox"]', function(e) {
                    let checked= $('.tb-menuaccordion_wrap input[type="checkbox"]:checked');
                    if(checked.length){
                        $('.remove-selected-items').removeClass('d-none');
                    }else{
                        $('.remove-selected-items').addClass('d-none');
                    }
                });

                $(document).on('click', '.update-menu-items', function(e) {
                    if(removal_Ids.length){
                        $('#removalIds').val(window.JSON.stringify(removal_Ids))
                    }
                    updateItems($('#menu-items-edit').data('output', $('#updateItems')));
                    let form = $('.menu-item-form').serialize();
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('updateMenuItems', form);
                    removalIds = [];
                });

                let updateItems = function(e){
                    let list   = e.length ? e : $(e.target),
                    output = list.data('output');
                    if (typeof output != 'undefined' && window.JSON) {
                        output.val(window.JSON.stringify(list.nestable('serialize')));
                    }
                };

                window.addEventListener('initializeSortable', event=>{
                    setTimeout(() => {
                        $('#menu-items-edit').nestable({
                            group: 1,
                            maxDepth:10
                        }).on('change', updateItems);
                    }, 50);
                });

                $(document).on('change', "#menu_id", function(e) {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('menu_id', $(this).select2('val'));
                })

                $(document).on('change', ".dd-item input[type='checkbox']", function(e) {
                    let _this = jQuery(this);
                    let isChecked = _this.is(':checked');
                    _this.closest('.dd-item').each(function(index, ev){
                        let __this = jQuery(this);
                        __this.find("input[type='checkbox']").prop('checked', isChecked);
                    });
                });

                $(document).on('click', '.remove-selected-items', function(e) {

                    $(".dd-item input[type='checkbox']:checked").each(function(e){
                        let _this = jQuery(this);
                        removal_Ids.push(_this.val())
                        _this.closest('.dd-item').remove();
                    });
                    if( $('ol#menu-items li').length == 0 ){
                        $('.tb-selectmenu').remove()
                    }
                });

                $(document).on('click', '.remove-item', function(e) {
                    let _this= $(this);
                    _this.closest('.dd-item').each(function(index, ev){
                        let __this = jQuery(this);
                        __this.find("input[type='checkbox']").each(function(i){
                            removal_Ids[i] = $(this).val();
                        });
                    });
                    $(this).closest('li').remove();

                    if( $('ol#menu-items li').length == 0 ){
                        $('.tb-selectmenu').remove()
                    }
                });

            }, 50);
        });

        function deleteMenu( id ){

            let title           = '<?php echo e(__("general.confirm")); ?>';
            let content         = '<?php echo e(__("general.confirm_content")); ?>';
            let action          = 'confirmDeleteMenu';
            let type_color      = 'red';
            let btn_class       = 'danger';
            ConfirmationBox({title, content, action, id,  type_color, btn_class})
        }
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/menu/manage-menu.blade.php ENDPATH**/ ?>