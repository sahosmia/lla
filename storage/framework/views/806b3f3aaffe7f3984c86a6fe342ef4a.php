<!doctype html>
<html class="no-js" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?> dir="rtl" <?php endif; ?>>
<?php
    $info       = Auth::user();
    $siteTitle  = setting('_general.site_name') ?: env('APP_NAME');
?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> <?php echo e(__('general.adminpanel_title')); ?> | <?php echo e($siteTitle); ?></title>
        <?php if (isset($component)) { $__componentOriginal82e3f864bb766fbb95cb0a10b750823c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82e3f864bb766fbb95cb0a10b750823c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.favicon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('favicon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82e3f864bb766fbb95cb0a10b750823c)): ?>
<?php $attributes = $__attributesOriginal82e3f864bb766fbb95cb0a10b750823c; ?>
<?php unset($__attributesOriginal82e3f864bb766fbb95cb0a10b750823c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82e3f864bb766fbb95cb0a10b750823c)): ?>
<?php $component = $__componentOriginal82e3f864bb766fbb95cb0a10b750823c; ?>
<?php unset($__componentOriginal82e3f864bb766fbb95cb0a10b750823c); ?>
<?php endif; ?>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <?php echo app('Illuminate\Foundation\Vite')([
            'public/css/bootstrap.min.css',
            'public/admin/css/themify-icons.css',
            'public/admin/css/fontawesome/all.min.css',
            'public/css/select2.min.css',
            'public/css/mCustomScrollbar.min.css',
            'public/admin/css/feather-icons.css',
        ]); ?>
        <?php echo $__env->yieldPushContent('styles'); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('admin/css/main.css')); ?>">
        <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo e(asset('admin/css/rtl.css')); ?>"
            <?php if(\Nwidart\Modules\Facades\Module::has('forumwise') && \Nwidart\Modules\Facades\Module::isEnabled('forumwise')): ?>
                <link rel="stylesheet" type="text/css" href="<?php echo e(asset('modules/forumwise/css/rtl.css')); ?>">
            <?php endif; ?>
        <?php endif; ?>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    </head>
    <body class="tb-bodycolor <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?> am-rtl <?php endif; ?>">
        <div class="tb-mainwrapper">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.sidebar', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-177061254-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <div class="tb-subwrapper">
                <header class="am-header">
                <?php echo e(Breadcrumbs::render()); ?>

                    <div class="tb-dropdoenwrap">
                        <div class="tb-logowrapper tb-icontoggler">
                            <?php if(!empty($info) ): ?>
                                <div class="tb-adminheadwrap">
                                    <strong class="tb-adminhead__img" id="adminImage">
                                        <?php if(!empty($info->profile?->image) && Storage::disk(getStorageDisk())->exists($info->profile?->image)): ?>
                                        <img src="<?php echo e(resizedImage($info->profile?->image,34,34)); ?>" alt="<?php echo e($info->profile?->short_name); ?>" />
                                        <?php else: ?>
                                            <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($info->profile?->image); ?>">
                                        <?php endif; ?>
                                    </strong>
                                </div>

                            <?php endif; ?>
                            <div class="tb-dropdownlist">
                                <div class="tb-dropdownmenu-inner">
                                    <strong class="tb-adminhead__img" id="adminImage">
                                        <?php if(!empty($info->profile?->image) && Storage::disk(getStorageDisk())->exists($info->profile?->image)): ?>
                                        <img src="<?php echo e(resizedImage($info->profile?->image,34,34)); ?>" alt="<?php echo e($info->profile?->image); ?>" />
                                        <?php else: ?>
                                            <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($info->profile?->image); ?>">
                                        <?php endif; ?>
                                    </strong>
                                    <div class="tb-adminuserinfo">
                                        <h6><?php echo e($info->profile?->full_name); ?></h6>
                                        <span ><?php echo e(__('general.active_status')); ?></span>
                                    </div>
                                </div>
                                <ul >
                                    <li class="">
                                        <a href="<?php echo e(route('admin.profile')); ?>">
                                            <i class="icon-user"></i> <?php echo e(__('sidebar.profile')); ?>

                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('/')); ?>" target="_blank">
                                            <i class="ti-new-window"></i> <?php echo e(__('general.view_site')); ?>

                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(route('admin.clear-cache')); ?>">
                                            <i class="ti-brush"></i> <?php echo e(__('sidebar.clear-cache')); ?>

                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="javascript:void(0)" onclick="checkQueue()">
                                            <i class="ti-check-box"></i> Check queue
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(route('logout')); ?>" class="tb-logout">
                                            <i class="ti-power-off"></i> <?php echo e(__('sidebar.logout')); ?>

                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="tb-adminwrapper">
                    <div class="tb-db-dashboard_box">
                        <div class="tb-db-dashboard_box_wrap">
                            <div class="tb-db-dashboard_box_wrap_inner">
                                <div class="tb-menumanagement_wrap">
                                    <?php echo $__env->yieldContent('content'); ?>
                                    <?php if(!empty($slot)): ?>
                                    <?php echo e($slot); ?>

                                    <?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal13a4d234756c16032caa3e2834ca83d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal13a4d234756c16032caa3e2834ca83d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal13a4d234756c16032caa3e2834ca83d8)): ?>
<?php $attributes = $__attributesOriginal13a4d234756c16032caa3e2834ca83d8; ?>
<?php unset($__attributesOriginal13a4d234756c16032caa3e2834ca83d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal13a4d234756c16032caa3e2834ca83d8)): ?>
<?php $component = $__componentOriginal13a4d234756c16032caa3e2834ca83d8; ?>
<?php unset($__componentOriginal13a4d234756c16032caa3e2834ca83d8); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($component)) { $__componentOriginalca0bc53ae8373aafddb365784b8dbd81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalca0bc53ae8373aafddb365784b8dbd81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.popups','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.popups'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalca0bc53ae8373aafddb365784b8dbd81)): ?>
<?php $attributes = $__attributesOriginalca0bc53ae8373aafddb365784b8dbd81; ?>
<?php unset($__attributesOriginalca0bc53ae8373aafddb365784b8dbd81); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalca0bc53ae8373aafddb365784b8dbd81)): ?>
<?php $component = $__componentOriginalca0bc53ae8373aafddb365784b8dbd81; ?>
<?php unset($__componentOriginalca0bc53ae8373aafddb365784b8dbd81); ?>
<?php endif; ?>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                jQuery(document).on("click", '.update-section-settings', function(event){                
                    let _this = jQuery(this);
                    let smtpSettingsUrl         = "<?php echo e(!isDemoSite() && Route::has('admin.update-smtp-settings') ? route('admin.update-smtp-settings') : null); ?>";
                    let broadcastingSettingsUrl = "<?php echo e(!isDemoSite() && Route::has('admin.update-broadcasting-settings') ? route('admin.update-broadcasting-settings') : null); ?>";
                    let pusherSettingsUrl       = "<?php echo e(!isDemoSite() && Route::has('admin.update-pusher-settings') ? route('admin.update-pusher-settings') : null); ?>";
                    let reverbSettingsUrl       = "<?php echo e(!isDemoSite() && Route::has('admin.update-reverb-settings') ? route('admin.update-reverb-settings') : null); ?>";

                    if(smtpSettingsUrl && $('#smtp_setting').hasClass('active')) {
                        setTimeout(function() {
                            $.ajaxSetup({
                                headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: smtpSettingsUrl,
                                method: 'post',
                                success: function(data){
                                    _this.find('.spinner-border').addClass('d-none');
                                    showAlert({
                                        message     : data.message,
                                        type        : data.success ? 'success' : 'error',
                                        title       : data.success ? <?php echo json_encode(__('admin/general.success'), 15, 512) ?> : <?php echo json_encode(__('admin/general.error'), 15, 512) ?>,
                                        autoclose   : 4000,
                                    });
                                }
                            });
                        }, 1000);  
                    }

                    if(broadcastingSettingsUrl && $('#_broadcasting_setting').hasClass('active')) {
                        setTimeout(function() {
                            $.ajaxSetup({
                                headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: broadcastingSettingsUrl,
                                method: 'post',
                                success: function(data){
                                    _this.find('.spinner-border').addClass('d-none');
                                    showAlert({
                                        message     : data.message,
                                        type        : data.success ? 'success' : 'error',
                                        title       : data.success ? <?php echo json_encode(__('admin/general.success'), 15, 512) ?> : <?php echo json_encode(__('admin/general.error'), 15, 512) ?>,
                                        autoclose   : 4000,
                                    });
                                }
                            });
                        }, 1000);  
                    }
                    
                    if(pusherSettingsUrl && $('#_broadcasting_setting').hasClass('active')) {
                        setTimeout(function() {
                            $.ajaxSetup({
                                headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: pusherSettingsUrl,
                                method: 'post',
                                success: function(data){
                                    _this.find('.spinner-border').addClass('d-none');
                                    showAlert({
                                        message     : data.message,
                                        type        : data.success ? 'success' : 'error',
                                        title       : data.success ? <?php echo json_encode(__('admin/general.success'), 15, 512) ?> : <?php echo json_encode(__('admin/general.error'), 15, 512) ?>,
                                        autoclose   : 4000,
                                    });
                                }
                            });
                        }, 1000);  
                    }

                    if(reverbSettingsUrl && $('#_broadcasting_setting').hasClass('active')) {
                        setTimeout(function() {
                            $.ajaxSetup({
                                headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: reverbSettingsUrl,
                                method: 'post',
                                success: function(data){
                                    _this.find('.spinner-border').addClass('d-none');
                                    showAlert({
                                        message     : data.message,
                                        type        : data.success ? 'success' : 'error',
                                        title       : data.success ? <?php echo json_encode(__('admin/general.success'), 15, 512) ?> : <?php echo json_encode(__('admin/general.error'), 15, 512) ?>,
                                        autoclose   : 4000,
                                    });
                                }
                            });
                        }, 1000);  
                    }

                    let s3SettignsUrl   = `<?php echo e(!isDemoSite() && 
                                                \Nwidart\Modules\Facades\Module::has('s3konnect') &&
                                                \Nwidart\Modules\Facades\Module::isEnabled('s3konnect') &&
                                                Route::has('s3konnect.settings') ? route('s3konnect.settings') : null); ?>`;
                    if(jQuery('#_storage').hasClass('active') && s3SettignsUrl) {
                        setTimeout(function() {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    url: s3SettignsUrl,
                                    method: 'post',
                                    success: function(data){
                                        _this.find('.spinner-border').addClass('d-none');
                                        showAlert({
                                            message     : data.message,
                                            type        : data.success ? 'success' : 'error',
                                            title       : data.success ? <?php echo json_encode(__('s3konnect::s3konnect.success'), 15, 512) ?> : <?php echo json_encode(__('s3konnect::s3konnect.error'), 15, 512) ?>,
                                            autoclose   : 4000,
                                            redirectUrl : data.success ? location.href : false,
                                        });
                                    }
                                });
                            }, 1000);
                    }

                    let DoSpaceSettignsUrl   = `<?php echo e(!isDemoSite() && 
                                                \Nwidart\Modules\Facades\Module::has('spacekonnect') &&
                                                \Nwidart\Modules\Facades\Module::isEnabled('spacekonnect') &&
                                                Route::has('spacekonnect.dospace-settings') ? route('spacekonnect.dospace-settings') : null); ?>`;
                    if(jQuery('#_space-tab').hasClass('active') && DoSpaceSettignsUrl) {
                        setTimeout(function() {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    url: DoSpaceSettignsUrl,
                                    method: 'post',
                                    success: function(data){
                                        _this.find('.spinner-border').addClass('d-none');
                                        showAlert({
                                            message     : data.message,
                                            type        : data.success ? 'success' : 'error',
                                            title       : data.success ? <?php echo json_encode(__('spacekonnect::spacekonnect.success'), 15, 512) ?> : <?php echo json_encode(__('spacekonnect::spacekonnect.error'), 15, 512) ?>,
                                            autoclose   : 4000,
                                            redirectUrl : data.success ? location.href : false,
                                        });
                                    }
                                });
                            }, 1000);
                    }

                    if(jQuery('#social_login-tab').hasClass('active')) {
                        setTimeout(function() {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    url: `<?php echo e(route('admin.update-social-login-settings')); ?>`,
                                    method: 'post',
                                    success: function(data){
                                        _this.find('.spinner-border').addClass('d-none');
                                        showAlert({
                                            title       : data.success ? <?php echo json_encode(__('admin/general.success_title'), 15, 512) ?> : <?php echo json_encode(__('admin/general.error_title'), 15, 512) ?>,
                                            message     : data.message,
                                            type        : data.success ? 'success' : 'error',
                                            autoclose   : 4000,
                                            redirectUrl : data.success ? location.href : false,
                                        });
                                    }
                                });
                            }, 1000);
                    }

                    if(jQuery(this).attr('data-form') != '_theme-form') {
                        return false;
                    }
                    
                    upadateSassStyle(_this);
                   
                });
                jQuery(document).on("click", '.btn.btn-danger', function(event){
                    if ($('#_theme').hasClass('active')){
                        setTimeout(function() {
                            upadateSassStyle(jQuery('.reset-section-settings'), redirect = location.href,);
                        }, 300);
                    }
                });
            });
            function upadateSassStyle(_this, redirect = false){
                setTimeout(function() {
                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "<?php echo e(url('admin/update-sass-style')); ?>",
                        method: 'post',
                        success: function(data){
                            _this.find('.spinner-border').addClass('d-none');
                            showAlert({
                                message     : data.message,
                                type        : data.success ? 'success' : 'error',
                                title       : data.success ? <?php echo json_encode(__('admin/general.success'), 15, 512) ?> : <?php echo json_encode(__('admin/general.error'), 15, 512) ?>,
                                autoclose   : 4000,
                                redirectUrl : redirect,
                            });
                        }
                    });
                }, 300); 
            }
            function checkQueue(){
                $.ajax({
                    url: "<?php echo e(route('admin.check-queue')); ?>",
                    method: 'get',
                    success: function(data){
                        Livewire.dispatch('showAlertMessage', {
                            type: data.success ? 'success' : 'error',
                            title: data.success ? '<?php echo e(__("general.success_title")); ?>' : '<?php echo e(__("general.error_title")); ?>',
                            message: data.message
                        });
                    },
                    error: function(xhr){
                        Livewire.dispatch('showAlertMessage', {
                            type: 'error',
                            title: '<?php echo e(__("general.error_title")); ?>',
                            message: 'Server error or queue not reachable.'
                        });
                    }
                });
            }

        </script>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

        <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('js/select2.min.js')); ?> "></script>
        <script defer src="<?php echo e(asset('js/mCustomScrollbar.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('js/main.js')); ?>"></script>
        <script defer src="<?php echo e(asset('js/admin-app.js')); ?>"></script>
        <?php if(session('success')): ?>
            <script>
                setTimeout(function() {
                    showAlert({
                        message     : "<?php echo e(session('success')); ?>",
                        type        : 'success', 
                        title       : <?php echo json_encode(__('admin/general.success'), 15, 512) ?>,
                        autoclose   : 4000,
                    });
                }, 100);
            </script>
        <?php endif; ?>
            <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
    </html>



<?php /**PATH D:\Sahos\Laravel\lla\resources\views/layouts/admin-app.blade.php ENDPATH**/ ?>