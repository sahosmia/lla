<main class="tb-main am-dispute-system am-identitiy-system">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('general.all_identity_verification') .' ('. $users->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="false" data-live='true' id="verification" data-wiremodel="verification" >
                                            <option value="" <?php echo e($verification == '' ? 'selected' : ''); ?> ><?php echo e(__('identity.all_users')); ?></option>
                                            <option value="verified" <?php echo e($verification == 'verified' ? 'selected' : ''); ?> ><?php echo e(__('identity.verified_users')); ?></option>
                                            <option value="non_verified" <?php echo e($verification == 'non_verified' ? 'selected' : ''); ?> ><?php echo e(__('identity.non_verified_users')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="false" data-live='true' id="sort_by" data-wiremodel="sortby" >
                                            <option value="asc" <?php echo e($sortby == 'asc' ? 'selected' : ''); ?> ><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc" <?php echo e($sortby == 'desc' ? 'selected' : ''); ?> ><?php echo e(__('general.desc')); ?></option>
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
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <!--[if BLOCK]><![endif]--><?php if( !$users->isEmpty() ): ?>
                        <table class="tb-table <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('#' )); ?></th>
                                    <th><?php echo e(__('general.name' )); ?></th>
                                    <th><?php echo e(__('identity.country')); ?></th>
                                    <th><?php echo e(__('identity.gaurdian_info' )); ?></th>
                                    <th><?php echo e(__('identity.school_info' )); ?></th>
                                    <th><?php echo e(__('identity.identity_document' )); ?></th>
                                    <th><?php echo e(__('identity.status' )); ?></th>
                                    <th><?php echo e(__('identity.action' )); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($single?->id); ?></span></td>
                                        <td data-label="<?php echo e(__('Name' )); ?>">
                                            <div class="tb-varification_userinfo">
                                                <a href="javascript:void(0);" class="identity-image" data-image="<?php echo e(Storage::url($single?->personal_photo) ?? ''); ?>">
                                                    <strong class="tb-adminhead__img">
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($single?->personal_photo) && Storage::disk(getStorageDisk())->exists($single?->personal_photo)): ?>
                                                            <img src="<?php echo e(resizedImage($single?->personal_photo,34,34)); ?>" alt="<?php echo e($single?->personal_photo); ?>" />
                                                        <?php else: ?>
                                                            <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($single?->personal_photo); ?>" />
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </strong>
                                                </a>
                                                <span><?php echo e($single->name); ?></span>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('identity.country' )); ?>"><span><?php echo e($single?->address?->country?->name ? $single?->address?->country?->name : '-'); ?></span></td>
                                        <td data-label="<?php echo e(__('identity.gaurdian_info' )); ?>">
                                            <span>
                                                <?php echo e($single?->parent_name ?? '-'); ?>

                                                <span><?php echo e($single?->parent_phone); ?></span>
                                                <span><?php echo e($single?->parent_email); ?></span>
                                                <span><?php echo e($single->parent_verified_at && "Verified"); ?></span>
                                            </span>
                                        </td>
                                        <td data-label="<?php echo e(__('identity.school_info' )); ?>">
                                            <span>
                                                <?php echo e($single?->school_id ?? '-'); ?>

                                                <span><?php echo e($single?->school_name); ?></span>
                                            </span>
                                        </td>
                                        <td data-label="<?php echo e(__('identity.identity_document' )); ?>">
                                            <a href="javascript:void(0);" class="identity-image" data-type="attachment" data-image="<?php echo e($single?->attachments ? Storage::url($single->attachments) : ''); ?>">
                                                <strong class="tb-adminhead__img">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($single?->attachments) && Storage::disk(getStorageDisk())->exists($single?->attachments)): ?>
                                                        <img src="<?php echo e(resizedImage($single?->attachments,34,34)); ?>" alt="<?php echo e($single?->attachments); ?>" />
                                                    <?php elseif(!empty($single?->transcript) && Storage::disk(getStorageDisk())->exists($single?->transcript)): ?>
                                                        <img src="<?php echo e(resizedImage($single?->transcript,34,34)); ?>" alt="<?php echo e($single?->transcript); ?>" />
                                                    <?php else: ?>
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($single?->attachments); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </strong>
                                            </a>
                                        </td>
                                        <td data-label="<?php echo e(__('identity.status' )); ?>">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag <?php echo e($single?->status == 'accepted' ? 'tk-hourly-tag' : 'tk-fixed-tag'); ?>"><?php echo e($single?->status); ?></em>
                                            </div>
                                        </td>
                                        <td  data-label="<?php echo e(__('identity.action')); ?>">
                                            <div class="am-resume_item_title">
                                                <div class="am-itemdropdown">
                                                    <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z" fill="#585858"/><path d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z" fill="#585858"/><path d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z" fill="#585858"/></svg></i>
                                                    </a>
                                                    <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <!--[if BLOCK]><![endif]--><?php if($single?->status != 'accepted'): ?>
                                                            <li @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->user_id); ?>, type : 'accepted' , action : 'verified-template' })">
                                                                <span><?php echo e(__('identity.accept' )); ?></span>
                                                            </li>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <li @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->user_id); ?>, type : 'rejected' , action : 'verified-template' })">
                                                            <span><?php echo e(__('identity.reject' )); ?></span>
                                                        </li>
                                                    </ul>   
                                                </div>
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
    </div>
    <div class="modal fade" id="identity-verification-image" tabindex="-1" aria-labelledby="identityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="identityModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <figure class="am-identity-image-placeholder am-noload-shimmer" id="identity-image-placeholder">
                        <img id="modal-identity-img" src="" alt="Image" class="img-fluid rounded" style="display: none;"/>
                    </figure>
                </div>
                <div class="am-deletepopup_btns">
                    <a href="javascript:void(0);" class="am-btn am-btnsmall am-cancel" data-bs-dismiss="modal"><?php echo e(__('general.cancel')); ?></a>
                    <a href="javascript:void(0);" id="download-btn" class="am-btn am-btn-success am-confirm-yes"><?php echo e(__('identity.download')); ?></a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".identity-image").forEach(function (element) {
        element.addEventListener("click", function () {
            let imageUrl = this.getAttribute("data-image");
            let imageType = this.getAttribute("data-type");

            let title = (imageType === "attachment") ? "<?php echo e(__('identity.identity_document')); ?>" : "<?php echo e(__('identity.personal_photo')); ?>";
            let imgElement = document.getElementById("modal-identity-img");
            let placeholder = document.getElementById("identity-image-placeholder");

            if (imageUrl) {
                imgElement.style.display = "none"; 
                placeholder.classList.add("am-noload-shimmer");

                imgElement.onload = function () {
                    placeholder.classList.remove("am-noload-shimmer"); 
                    imgElement.style.display = "block"; 
                };

                imgElement.src = imageUrl;
                document.getElementById("identityModalLabel").textContent = title;

                let buttonContainer = document.querySelector(".am-deletepopup_btns");
                if (imageType === "attachment") {
                    buttonContainer.style.display = "flex";
                    document.getElementById("download-btn").setAttribute("wire:click", `download('${imageUrl}')`);
                } else {
                    buttonContainer.style.display = "none";
                }

                var modal = new bootstrap.Modal(document.getElementById("identity-verification-image"));
                modal.show();
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/admin/identity-verification/identitiy_verification.blade.php ENDPATH**/ ?>