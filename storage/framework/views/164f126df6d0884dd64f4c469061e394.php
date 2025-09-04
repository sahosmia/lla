<main class="tb-main am-dispute-system am-user-system">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('general.all_users') .' ('. $users->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:void(0)" wire:click="exportUsers"  id="export" class="tb-btn add-new"><?php echo e(__('general.export')); ?>

                                    </a>
                                </div>
                                <div class="tb-actionselect">
                                    <a href="javascript:void(0)" id="add_user_click" class="tb-btn add-new"
                                        data-bs-toggle="modal" data-bs-target="#tb-add-user"><?php echo e(__('general.add_new_user')); ?>

                                        <i class="icon-plus"></i></a>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="verification"
                                            data-wiremodel="verification">
                                            <option value="" <?php echo e($verification=='' ? 'selected' : ''); ?>><?php echo e(__('All users')); ?>

                                            </option>
                                            <option value="verified" <?php echo e($verification=='verified' ? 'selected' : ''); ?>><?php echo e(__('Verified users')); ?></option>
                                            <option value="unverified" <?php echo e($verification=='non_verified' ? 'selected' : ''); ?>><?php echo e(__('Non verified users')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="filter_user"
                                            data-wiremodel="filterUser">
                                            <option value="" <?php echo e($filterUser=='' ? 'selected' : ''); ?>><?php echo e(__('All users')); ?>

                                            </option>
                                            <option value="active" <?php echo e($filterUser=='active' ? 'selected' : ''); ?>><?php echo e(__('Active')); ?></option>
                                            <option value="inactive" <?php echo e($filterUser=='inactive' ? 'selected' : ''); ?>><?php echo e(__('Inactive')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="roles" data-wiremodel="roles">
                                            <option value="" <?php echo e($roles=='' ? 'selected' : ''); ?>><?php echo e(__('All users')); ?>

                                            </option>
                                            <option value="student" <?php echo e($roles=='student' || $role=='student' ? 'selected' : ''); ?>><?php echo e($student_name); ?></option>
                                            <option value="tutor" <?php echo e($roles=='tutor' || $role=='tutor' ? 'selected' : ''); ?>><?php echo e($tutor_name); ?></option>
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
                                <th><?php echo e(__('general.email_phone' )); ?></th>
                                <th><?php echo e(__('general.created_date' )); ?></th>
                                <th><?php echo e(__('admin/general.role')); ?></th>
                                <th><?php echo e(__('general.email_verification' )); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('profile.country')); ?></th>
                                <th><?php echo e(__('general.identity_verification')); ?></th>
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
                                <td data-label="<?php echo e(__('general.email' )); ?>"><span><?php echo e($single->email); ?> <?php echo e($single->profile?->phone_number); ?></span></td>
                                <td data-label="<?php echo e(__('general.created_date' )); ?>"><span><?php echo e($single->created_at->format('F d,
                                        Y')); ?></span></td>
                                <td data-label="<?php echo e(__('admin/general.role')); ?>">
                                    <?php echo e(ucfirst( $single->default_role )); ?>

                                </td>
                                <?php
                                    $verified_at = $single->email_verified_at ? "verified" : "non_verified";
                                    $content = $single->email_verified_at ? __('general.reject_account') : __('general.approve_this_account');
                                ?>
                                <td @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->id); ?>, content: '<?php echo e($content); ?>', type: '<?php echo e($verified_at); ?>', action : 'verified-at-template' })" data-label="<?php echo e(__('general.verification')); ?>">
                                    <a href="javascript:;"
                                       class="tb-email-verifiedbtn tk-project-tag"
                                       <?php if(!$single->email_verified_at): ?>
                                           disabled
                                       <?php endif; ?>>
                                        <i class="icon-mail"></i>
                                        <?php echo e($single->email_verified_at ? "Verified" : "Non verified"); ?>

                                    </a>
                                </td>
                                <td @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->id); ?>, content: `<?php echo e($single->status == 'active' ? __('general.disable_user') : __('general.enable_user')); ?>`, type: '<?php echo e($single->status); ?>', action : 'update-status' })"
                                    data-label="<?php echo e(__('general.status')); ?>">
                                    <em class="tk-project-tag <?php echo e($single->status == 'active' ? 'tk-hourly-tag' : 'tk-fixed-tag'); ?>"><?php echo e($single->status); ?></em>
                                </td>
                                <td><?php echo e($single->address?->country?->name); ?></td>
                                <td data-label="<?php echo e(__('general.identity_verification')); ?>">
                                    <div class="am-status-tag">
                                        <div class="am-status-tag">
                                            <em class="tk-project-tag <?php echo e(!empty($single->profile->verified_at) ? 'tk-hourly-tag' : 'tk-fixed-tag'); ?>"><?php echo e(!empty($single->profile->verified_at) ? __('general.verified') : __('general.non_verified')); ?></em>
                                        </div>
                                    </div>
                                </td>
                                <td  data-label="<?php echo e(__('general.actions')); ?>">
                                    <div class="am-custom-tooltip">
                                        <span class="am-tooltip-text am-tooltip-textimp">
                                            <span><?php echo e(__('general.remove_user')); ?></span>
                                        </span>
                                        <i @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->id); ?>, action : 'delete-user', title: 'Delete User!', 
                                            content: '<?php echo e(__('general.delete_user')); ?>', icon: 'delete' })" class="icon-trash-2"></i>
                                    </div> 
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($single->email_verified_at)): ?>
                                        <div class="am-custom-tooltip am-tooltip-textimp">
                                            <span class="am-tooltip-text">
                                                <span><?php echo e(__('admin/general.impersonate_user')); ?></span>
                                            </span>
                                                <i @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->id); ?>, action : 'impersonate-user', title: '<?php echo e(__('admin/general.impersonate')); ?>', 
                                                    content: '<?php echo e(__('admin/general.impersonate_user_confirm')); ?>', icon: 'warning', overrideClass:'am-impersonate' })" class="icon-eye"></i>
                                        </div> 
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
            role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg tb-modaldialog" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h5 id="tb_user_info_label"><?php echo e(__('general.user_information')); ?></h5>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <form class="tb-themeform" wire:submit.prevent="addUser" id="add_user_form">
                            <fieldset>
                                <div class="form-group-wrap">
                                    <div class="form-group">
                                        <label class="tb-label"><?php echo e(__('general.first_name')); ?></label>
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
                                        <label class="tb-label"><?php echo e(__('general.last_name')); ?></label>
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
                                        <label class="tb-label"><?php echo e(__('general.email')); ?></label>
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
                                        <label class="tb-label"><?php echo e(__('User role')); ?></label>
                                        <div class="tk-error <?php $__errorArgs = ['form.userRole'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <div class="tb-select" wire:ignore>
                                                <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control"
                                                    data-searchable="false" data-parent="#tb-add-user" data-live='true'
                                                    id="user_role" data-wiremodel="form.userRole">
                                                    <option value="tutor"><?php echo e($tutor_name); ?></option>
                                                    <option value="student"><?php echo e($student_name); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.userRole'];
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
                                        <label class="tb-label"><?php echo e(__('general.password')); ?></label>
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
                                    <div class="form-group">
                                        <label class="tb-label"><?php echo e(__('general.confirm_password')); ?></label>
                                        <input type="password" wire:model="form.confirm_password"
                                            class="form-control <?php $__errorArgs = ['form.confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="<?php echo e(__('general.password_placeholder')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.confirm_password'];
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
                                        <button class="tb-btn" type="submit" wire:target="addUser"
                                            wire:loading.class="tb-btn_disable"><?php echo e(__('general.save_user')); ?></button>
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
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/admin/users/users.blade.php ENDPATH**/ ?>