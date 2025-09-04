<div class="tb-manage-addons">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cards">
                    <div class="cards_header">
                        <div class="cards_header_heading">
                            <h4><?php echo e(__('admin/general.lernen_addons')); ?></h4>
                            <p><?php echo e(__('admin/general.lernen_addons_desc')); ?></p>
                        </div>
                        <div class="cards_header_btns">
                            <button class="tb-btn" wire:click="addNewPackage"><?php echo e(__('admin/general.add_new')); ?></button>
                        </div>
                    </div>
                    <div class="cards_wrap">
                        <ul>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <div class="cards_item <?php echo e($package['type'] == 'external' ? 'cards_item-purchase' : ''); ?>">
                                    <figure>
                                        <img src="<?php echo e('https://lernen.amentotech.com/addons/'. $package['image']); ?>" alt="<?php echo e($package['name']); ?>">
                                    </figure>
                                    <div class="cards_item_content">
                                        <h5>
                                            <?php echo e($package['name']); ?> 
                                            <span><?php echo e(ucfirst($package['type'])); ?></span>
                                            <!--[if BLOCK]><![endif]--><?php if($package['type'] == 'external' && !empty($package['demo_url'])): ?>
                                                <em><?php echo e($package['price']); ?></em>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </h5>
                                        <p><?php echo e($package['description']); ?></p>
                                        <div class="cards_item_btns">
                                            <!--[if BLOCK]><![endif]--><?php if($package['type'] == 'core' && $package['status'] == 'active' && !empty($package['demo_url'])): ?>
                                                <a class="tb-btnvtwo" href="<?php echo e($package['demo_url']); ?>" target="_blank"><?php echo e(__('admin/general.preview')); ?></a>
                                            <?php elseif($package['type'] == 'external' && $package['status'] == 'active' && $package['version'] == 'lite'): ?>
                                                <a class="tb-btnvtwo" href="<?php echo e($package['demo_url']); ?>" target="_blank"><?php echo e(__('admin/general.upgrade')); ?></a>
                                            <?php elseif($package['type'] == 'external' && $package['status'] == 'inactive' && !empty($package['demo_url'])): ?>
                                                <a class="tb-btnvtwo" href="<?php echo e($package['demo_url']); ?>" target="_blank"><?php echo e(__('admin/general.buy_now')); ?></a>
                                            <?php elseif($package['status'] == 'active' && !empty($package['demo_url'])): ?>
                                                <a class="tb-btnvtwo" href="<?php echo e($package['demo_url']); ?>" target="_blank"><?php echo e(__('admin/general.preview')); ?></a>
                                            <?php elseif($package['status'] != 'active' && empty($package['demo_url'])): ?>
                                                <button class="tb-btnvtwo btn-coming-soon" disabled><?php echo e(__('admin/general.coming_soon')); ?></button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade tb-fileupload-modal" data-bs-backdrop="static" id="addNewPackageModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h5 class="modal-title" id="fileUploadModalLabel"><?php echo e(__('admin/general.upload_package_file')); ?></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="icon-x"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="am-insights_notice">
                        <?php echo __('admin/general.add_update_addon_warning'); ?>

                        </div>
                        <form method="post" id="addon-form" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="am-insights_content_inner" role="alert">
                                <div>
                                    <strong class="tb-block"><?php echo e(__('admin/general.server_requirements')); ?></strong>
                                    <ul class="tb-warning-list">
                                        <li>
                                            post_max_size = 512M
                                        </li>
                                        <li>
                                            upload_max_filesize = 512M
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <strong class="tb-block"><?php echo e(__('admin/general.current_server_values')); ?></strong>
                                    <ul class="tb-warning-list">
                                        <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                            'tk-successmsg' => $isPostMaxSizeValid,
                                            'tk-errormsg' => !$isPostMaxSizeValid
                                        ]); ?>">
                                            <i class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                'icon-check-circle' => $isPostMaxSizeValid,
                                                'icon-x-circle' => !$isPostMaxSizeValid
                                            ]); ?>"></i>
                                            post_max_size = <?php echo e($postMaxSize); ?>

                                        </li>
                                        <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                            'tk-successmsg' => $isUploadMaxFilesizeValid,
                                            'tk-errormsg' => !$isUploadMaxFilesizeValid
                                        ]); ?>">
                                            <i class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                'icon-check-circle' => $isUploadMaxFilesizeValid,
                                                'icon-x-circle' => !$isUploadMaxFilesizeValid
                                            ]); ?>"></i>
                                            upload_max_filesize = <?php echo e($uploadMaxFilesize); ?>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="am-insights_content_uploadfile">
                                <h6><?php echo e(__('admin/general.choose_file')); ?></h6>
                                <label for="file" class="tb-label">
                                    <div class="am-insights_content_uploadfile_icon">
                                        <i class="icon-upload-cloud"></i>
                                        <input type="file" name="file" onchange="updateFileName();" class="form-control" id="file" accept=".zip">
                                    </div>
                                    <p><?php echo e(__('admin/general.click_here_to_upload')); ?></p>
                                    <div wire:loading wire:target="file" style="display: none" class="tb-uploading">
                                        <span><?php echo e(__('settings.uploading')); ?></span>
                                    </div>
                                </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="tb-btn upload-addon-btn <?php if(!$isPostMaxSizeValid || !$isUploadMaxFilesizeValid): ?> tb-btn_disabled <?php endif; ?>" onclick="submitAddon()"><?php echo e(__('admin/general.install')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    function updateFileName(){
        const fileInput = document.getElementById('file');
        const fileName = fileInput.files[0].name;
        const paragraph = fileInput.parentElement.parentElement.querySelector('p');
        paragraph.innerHTML =  `<strong>${fileName}</strong>`;
    }
    function submitAddon(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const fileInput = document.getElementById('file');
        jQuery('.am-insights_content_uploadfile').find('.text-danger').remove();
        
        if (!fileInput.files.length > 0) {
            jQuery('.am-insights_content_uploadfile').append('<span class="text-danger"><?php echo e(__("admin/general.select_addon_file")); ?></span>');
            return false;
        }
        
        const formData = new FormData();
        formData.append('file', fileInput.files[0]);
        $.ajax({
            url: "<?php echo e(route('admin.packages.upload')); ?>",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                jQuery('.upload-addon-btn').addClass('am-btn_disable');
                jQuery('.tb-uploading').show();
            },
            complete: function(){
                jQuery('.upload-addon-btn').removeClass('am-btn_disable');
                jQuery('.tb-uploading').hide();
            },
            success: function(response){
                jQuery('#addNewPackageModal').modal('hide');
                if(response.success){
                    showAlert({
                        message: response.message,
                        type: 'success'
                    });
                    setTimeout(() => {
                        window.location.href = "<?php echo e(route('admin.packages.installed')); ?>";
                    }, 500);
               } else {
                    showAlert({
                        message: response.message,
                        type: 'error'
                    });
               }
            },
            error: function(xhr, status, error){
                let message = '';
                try{
                    let jsonResp = JSON.parse(xhr.responseText);
                    message = jsonResp?.message;
                }catch(e){
                    let jsonMatch = xhr.responseText.match(/{.*}/);
                    if(jsonMatch){
                        let jsonResp = JSON.parse(jsonMatch[0]);
                        message = jsonResp?.message;
                    } else {
                        message = '<?php echo e(__("admin/general.addon_file_upload_error")); ?>';
                    }
                }
                jQuery('.am-insights_content_uploadfile').append(`<span class="text-danger">${message}</span>`);
            }
        });
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/packages/manage-packages.blade.php ENDPATH**/ ?>