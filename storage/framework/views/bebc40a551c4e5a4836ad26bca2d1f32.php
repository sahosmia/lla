<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($events->isNotEmpty()): ?>
        <div class="am-events-list row">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="cr-card">
                        <figure class="cr-image-wrapper" style="margin: 0;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->banner_image): ?>
                                <img src="<?php echo e(Storage::url($event->banner_image)); ?>" alt="<?php echo e($event->title); ?>" class="cr-background-image" style="width: 100%; height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div style="width: 100%; height: 200px; background: #eee; display: flex; align-items: center; justify-content: center;">No Image</div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </figure>
                        <div class="cr-course-card" style="padding: 20px; background: #fff; border: 1px solid #eee; border-top: 0;">
                            <h3 class="cr-course-title" style="font-size: 18px; margin-bottom: 10px; min-height: 54px;">
                                <?php echo e($event->title); ?>

                            </h3>
                            <div class="cr-course-features" style="display: flex; flex-direction: column; gap: 5px; margin-bottom: 15px;">
                                <div class="cr-info-item">
                                    <i class="am-icon-calender-duration"></i>
                                    <span>Date & Time: <?php echo e($event->date_time); ?></span>
                                </div>
                                <div class="cr-info-item">
                                    <i class="am-icon-video-v2"></i>
                                    <span>Mode: <?php echo e($event->mode); ?></span>
                                </div>
                                <div class="cr-info-item">
                                    <i class="am-icon-user-v2"></i>
                                    <span>Trainer: <?php echo e($event->trainer?->profile?->full_name ?? 'TBA'); ?></span>
                                </div>
                            </div>
                            <div class="cr-card_footer" style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="<?php echo e(route('events.detail', $event->id)); ?>" class="am-btn">Register Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php else: ?>
        <div class="am-no-record">
            <p>No upcoming events found.</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\Users\User\Desktop\well-known\resources\views/livewire/components/upcoming-events.blade.php ENDPATH**/ ?>