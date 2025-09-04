<main class="tb-main am-dispute-system am-user-system" wire:init="loadData"> 
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('general.all_sub_admins') .' ('. $users->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:void(0)" id="add_user_click" class="tb-btn add-new"
                                       wire:click="openModel()"><?php echo e(__('general.add_new_sub_admin')); ?>

                                        <i class="icon-plus"></i></a>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="filter_user"
                                            data-wiremodel="filterUser">
                                            <option value="" <?php echo e($filterUser=='' ? 'selected' : ''); ?>><?php echo e(__('general.all_sub_admins')); ?>

                                            </option>
                                            <option value="active" <?php echo e($filterUser=='active' ? 'selected' : ''); ?>><?php echo e(__('Active')); ?></option>
                                            <option value="inactive" <?php echo e($filterUser=='inactive' ? 'selected' : ''); ?>><?php echo e(__('Inactive')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="sort_by" data-wiremodel="sortby">
                                            <option value="asc" <?php echo e($sortby=='asc' ? 'selected' : ''); ?>><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc" <?php echo e($sortby=='desc' ? 'selected' : ''); ?>><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"
                                        autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <!--[if BLOCK]><![endif]--><?php if( !$users->isEmpty() ): ?>
                    <table class="tb-table <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#' )); ?></th>
                                <th><?php echo e(__('Name' )); ?></th>
                                <th><?php echo e(__('general.email' )); ?></th>
                                <th><?php echo e(__('general.created_date' )); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($single->id); ?></span></td>
                                <td data-label="<?php echo e(__('Name' )); ?>">
                                    <div class="tb-varification_userinfo">
                                        <strong class="tb-adminhead__img">
                                            <!--[if BLOCK]><![endif]--><?php if(!empty($single->profile->image) && Storage::disk(getStorageDisk())->exists($single->profile->image)): ?>
                                                <img src="<?php echo e(resizedImage($single->profile->image,34,34)); ?>" alt="<?php echo e($single->profile->image); ?>" />
                                            <?php else: ?>
                                                <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($single->profile->image); ?>" />
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </strong>
                                        <span><?php echo e($single->profile->full_name); ?></span>
                                        <!--[if BLOCK]><![endif]--><?php if($single->roles()->first()->name == 'tutor'): ?>
                                            <a href="<?php echo e(route('tutor-detail',['slug' => $single->profile->slug])); ?>" class="am-custom-tooltip">
                                                <span class="am-tooltip-text">
                                                    <span><?php echo e(__('general.visit_profile')); ?></span>
                                                </span>
                                                <i class="icon-external-link"></i>
                                            </a>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </td>
                                <td data-label="<?php echo e(__('general.email' )); ?>"><span><?php echo e($single->email); ?></span></td>
                                <td data-label="<?php echo e(__('general.created_date' )); ?>"><span><?php echo e($single->created_at->format('F d,
                                        Y')); ?></span></td>
                               
                    
                                <td @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->id); ?>, content: `<?php echo e($single->status == 'active' ? __('general.disable_user') : __('general.enable_user')); ?>`, type: '<?php echo e($single->status); ?>', action : 'update-status' })"
                                    data-label="<?php echo e(__('general.status')); ?>">
                                    <em class="tk-project-tag <?php echo e($single->status == 'active' ? 'tk-hourly-tag' : 'tk-fixed-tag'); ?>"><?php echo e($single->status); ?></em>
                                </td>
                                <td  data-label="<?php echo e(__('general.actions')); ?>">
                                    <div class="am-custom-tooltip">
                                        <span class="am-tooltip-text am-tooltip-textimp">
                                            <span><?php echo e(__('general.remove_user')); ?></span>
                                        </span>
                                        <i @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->id); ?>, content: '<?php echo e(__('general.delete_admin')); ?>', action : 'delete-user' })" class="icon-trash-2"></i>
                                    </div> 
                                    <div class="am-custom-tooltip am-tooltip-textimp">
                                        <a href="javascript:void(0);" wire:click="editAdminUser(<?php echo e($single->id); ?>)"><i class="icon-edit-3"></i></a>
                                    </div> 
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                    <?php echo e($users->links('pagination.custom')); ?>

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
        <div wire:ignore.self class="modal fade tb-addonpopup" id="tb-add-user" aria-labelledby="tb_user_info_label"
            role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg tb-modaldialog" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h5 id="tb_user_info_label"><?php echo e(__('general.sub_admin_information')); ?></h5>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <form class="tb-themeform" wire:submit.prevent="addUser" id="add_user_form">
                            <fieldset>
                                <div class="form-group-wrap">
                                    <div class="form-group">
                                        <label class="tb-label tb-important"><?php echo e(__('general.first_name')); ?></label>
                                        <input type="text"
                                            class="form-control <?php $__errorArgs = ['form.first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            wire:model="form.first_name" placeholder="<?php echo e(__('general.name_placeholder')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.first_name'];
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
                                        <label class="tb-label tb-important"><?php echo e(__('general.last_name')); ?></label>
                                        <input type="text"
                                            class="form-control <?php $__errorArgs = ['form.last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            wire:model="form.last_name"
                                            placeholder="<?php echo e(__('general.lastname_placeholder')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.last_name'];
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
                                        <label class="tb-label tb-important"><?php echo e(__('general.email')); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['form.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            wire:model="form.email" placeholder="<?php echo e(__('general.email_placeholder')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.email'];
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
                                        <label class="tb-label <?php if(empty($form->adminId)): ?> tb-important <?php endif; ?>"><?php echo e(__('general.password')); ?></label>
                                        <input type="password" wire:model="form.password"
                                            class="form-control <?php $__errorArgs = ['form.password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="<?php echo e(__('general.password_placeholder')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.password'];
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
                                    <div class="form-group am-knowlanguages <?php $__errorArgs = ['form.permissions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'Slots','class' => 'tb-label tb-important','value' => __('general.permissions')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'Slots','class' => 'tb-label tb-important','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.permissions'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <div id="user_lang" class="am-multiple-select-wrap">
                                            <span class="am-select am-multiple-select">
                                                <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-parent="#tb-add-user"  data-disable_onchange="true" class="languages am-select2" data-searchable="true" id="permissions" data-wiremodel="form.permissions" multiple placeholder="<?php echo e(__('general.permissions')); ?>" >
                                                    <option value="" disabled><?php echo e(__('general.permissions')); ?></option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($id); ?>" <?php if( in_array( $id, $form->permissions) ): ?> selected <?php endif; ?>><?php echo e($permission); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                                <div class="languageList">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty( $form->permissions)): ?>
                                                        <ul class="tu-labels">
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $form->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li><span><?php echo e($permissions[$permission_id]); ?> <a href="javascript:void(0);" class="removeSelectedLang" data-id="<?php echo e($permission_id); ?>"><i class="icon-x"></i></a></span></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                        </ul>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </span>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.permissions'];
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
                                    <div class="form-group tb-formbtn">
                                        <button class="tb-btn" type="submit" wire:target="addUser" wire:loading.class="tb-btn_disable"><?php echo e(__('general.save_update')); ?></button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    var component = '';
    document.addEventListener('livewire:navigated', function() {
        component = window.Livewire.find('<?php echo e($_instance->getId()); ?>');
    });
    document.addEventListener('livewire:initialized', function() {
        document.addEventListener('loadPageJs', (event) => {
            component.dispatch('initSelect2', {target:'.am-select2'});
        })

        $(document).on("change", ".languages", function(e){
            component.set('form.permissions', $(this).select2("val"), false);
            populateLanguageList();
        });

        $( "body" ).delegate( ".removeSelectedLang", "click", function() {
            let id = $(this).attr('data-id');
            var newArray = [];
            new_data = $.grep($('.languages').select2('data'), function (value) {
                if(value['id'] != id)
                    newArray.push(value['id']);
            });
            $('.languages').val(newArray).trigger('change');
            populateLanguageList();
        });

        function populateLanguageList(){
            let languages = $('.languages').select2('data');
            var lang_html = '<ul class="tu-labels">';
            $.each(languages,function(index,elem){
                    lang_html += `<li><span>${elem.text} <a href="javascript:void(0);" class="removeSelectedLang" data-id="${elem.id}"><i class="icon-x"></i></a></span></li>`;
            });
            lang_html += '</ul>';
            $('.languageList').html(lang_html);
        }
    });   
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/manage-admin-users/manage-admin-users.blade.php ENDPATH**/ ?>