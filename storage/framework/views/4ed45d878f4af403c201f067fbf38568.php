<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['pageTitle'=>null, 'page'=>null, 'pageDescription'=>null, 'pageKeywords'=>null, 'metaImage'=>null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['pageTitle'=>null, 'page'=>null, 'pageDescription'=>null, 'pageKeywords'=>null, 'metaImage'=>null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if(!empty($og_tags)): ?>
    <?php $__currentLoopData = $og_tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(str_starts_with($key, 'twitter:')): ?>
            <meta name="<?php echo e($key); ?>" content="<?php echo e($value); ?>">
        <?php else: ?>
            <meta property="<?php echo e($key); ?>" content="<?php echo e($value); ?>">
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php
    $siteTitle = setting('_general.site_name');
    $seoSettings = setting('_front_page_settings');
    $pageId = $page->id ?? null;
    $seoData = collect($seoSettings['seo_settings'] ?? [])->firstWhere('page_id', $pageId);
    $routeName = request()->routeIs('find-tutors') || request()->path() == 'search-courses' || request()->path() == 'blogs' ? request()->route()->getName() : null;
 
    $customSeoData = collect($seoSettings['seo_settings'] ?? [])->firstWhere('page_id', $routeName);
?>

<?php if( !empty($page->title) || !empty($seoData['seo_title']) || !empty($customSeoData['seo_title']) ): ?>
    <?php if(!empty($seoData['seo_title'])): ?>
        <title><?php echo $seoData['seo_title']; ?></title>
        <meta property="og:title" content="<?php echo $seoData['seo_title']; ?>">
        <meta property="twitter:title" content="<?php echo $seoData['seo_title']; ?>">
    <?php elseif(!empty($customSeoData['seo_title'])): ?>
        <title><?php echo $customSeoData['seo_title']; ?></title>
        <meta property="og:title" content="<?php echo $customSeoData['seo_title']; ?>">
        <meta property="twitter:title" content="<?php echo $customSeoData['seo_title']; ?>">
    <?php else: ?>
        <title><?php echo $page->title; ?></title>
        <meta property="og:title" content="<?php echo $page->title; ?>">
        <meta property="twitter:title" content="<?php echo $page->title; ?>">
    <?php endif; ?>
<?php elseif( !empty($pageTitle) || !empty($seoData['seo_title']) || !empty($customSeoData['seo_title']) ): ?>
    <?php if(!empty($seoData['seo_title'])): ?>
        <title><?php echo e($siteTitle); ?> | <?php echo $seoData['seo_title']; ?></title>
        <meta property="og:title" content="<?php echo $seoData['seo_title']; ?>">
        <meta property="twitter:title" content="<?php echo $seoData['seo_title']; ?>">
    <?php elseif(!empty($customSeoData['seo_title'])): ?>
        <title><?php echo e($siteTitle); ?> | <?php echo $customSeoData['seo_title']; ?></title>
        <meta property="og:title" content="<?php echo $customSeoData['seo_title']; ?>">
        <meta property="twitter:title" content="<?php echo $customSeoData['seo_title']; ?>">
    <?php else: ?>
        <title><?php echo e($siteTitle); ?> | <?php echo $pageTitle; ?></title>
        <meta property="og:title" content="<?php echo $pageTitle; ?>">
        <meta property="twitter:title" content="<?php echo $pageTitle; ?>">
    <?php endif; ?>
<?php else: ?>
    <title><?php echo e($siteTitle); ?> | <?php echo e(__('tutor.tutors_tutors')); ?></title>
    <meta property="og:title" content="<?php echo e(__('tutor.tutors_tutors')); ?>">
    <meta property="twitter:title" content="<?php echo e(__('tutor.tutors_tutors')); ?>">
<?php endif; ?>
<?php if( !empty($pageDescription) || !empty($seoData['seo_description']) || !empty($customSeoData['seo_description']) ): ?>
    <?php if(!empty($seoData['seo_description'])): ?>
        <meta name="description" content="<?php echo e(Str::limit(strip_tags($seoData['seo_description']), 160)); ?>">
        <meta property="og:description" content="<?php echo e(Str::limit(strip_tags($seoData['seo_description']), 160)); ?>">
        <meta property="twitter:description" content="<?php echo e(Str::limit(strip_tags($seoData['seo_description']), 160)); ?>">
    <?php elseif(!empty($customSeoData['seo_description'])): ?>
        <meta name="description" content="<?php echo e(Str::limit(strip_tags($customSeoData['seo_description']), 160)); ?>">
        <meta property="og:description" content="<?php echo e(Str::limit(strip_tags($customSeoData['seo_description']), 160)); ?>">
        <meta property="twitter:description" content="<?php echo e(Str::limit(strip_tags($customSeoData['seo_description']), 160)); ?>">
    <?php else: ?>
        <meta name="description" content="<?php echo e(Str::limit(strip_tags($pageDescription), 160)); ?>">
        <meta property="og:description" content="<?php echo e(Str::limit(strip_tags($pageDescription), 160)); ?>">
        <meta property="twitter:description" content="<?php echo e(Str::limit(strip_tags($pageDescription), 160)); ?>">
    <?php endif; ?>
<?php endif; ?>
<?php if( !empty($metaImage)): ?>
    <link rel="image_src" href="<?php echo e(asset($metaImage)); ?>" />
<?php endif; ?>
<?php if( !empty($pageKeywords) || !empty($seoData['seo_keywords']) || !empty($customSeoData['seo_keywords']) ): ?>
    <?php if(!empty($seoData['seo_keywords'])): ?>
        <meta name="keywords" content="<?php echo e($seoData['seo_keywords']); ?>" />
        <meta property="og:keywords" content="<?php echo e($seoData['seo_keywords']); ?>" />
        <meta property="twitter:keywords" content="<?php echo e($seoData['seo_keywords']); ?>" />
    <?php elseif(!empty($customSeoData['seo_keywords'])): ?>
        <meta name="keywords" content="<?php echo e($customSeoData['seo_keywords']); ?>" />
        <meta property="og:keywords" content="<?php echo e($customSeoData['seo_keywords']); ?>" />
        <meta property="twitter:keywords" content="<?php echo e($customSeoData['seo_keywords']); ?>" />
    <?php else: ?>
        <meta name="keywords" content="<?php echo e($pageKeywords); ?>" />
        <meta property="og:keywords" content="<?php echo e($pageKeywords); ?>" />
        <meta property="twitter:keywords" content="<?php echo e($pageKeywords); ?>" />
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/components/meta-content.blade.php ENDPATH**/ ?>