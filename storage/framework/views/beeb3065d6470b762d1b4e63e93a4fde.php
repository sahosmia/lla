<?php
    $logo = setting('_email.email_logo');
    $logoImg = !empty($logo[0]['path']) ? url(Storage::url($logo[0]['path'])) : asset('/demo-content/logo.webp');
?>
<img src="<?php echo e($logoImg); ?>" alt="<?php echo e(setting('_site.name') ?? config('app.name', __('general.app_name'))); ?>" <?php echo e($attributes); ?>>
<?php /**PATH C:\Users\User\Desktop\well-known\resources\views/components/email/logo.blade.php ENDPATH**/ ?>