<?php if (! ($breadcrumbs->isEmpty())): ?>
    <ol class="am-breadcrumb">
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if(!is_null($breadcrumb->url) && !$loop->last): ?>
                <li><a href="<?php echo e($breadcrumb->url); ?>" wire:navigate.remove><?php echo e($breadcrumb->title); ?></a></li>
                <li>
                    <em>/</em>
                </li>
            <?php else: ?>
                <li class="active"><span><?php echo e($breadcrumb->title); ?></span></li>
            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
<?php endif; ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/header/breadcrumbs.blade.php ENDPATH**/ ?>