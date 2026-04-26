<div class="am-event-list-page am-section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-section_title am-section_title_center">
                    <h2>Upcoming Training and Events</h2>
                    <p>Enhance your skills with our professional training sessions and events.</p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="cr-card">
                        <figure class="cr-image-wrapper" style="margin: 0;">
                            <a href="<?php echo e(route('events.detail', $event->id)); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->banner_image): ?>
                                    <img src="<?php echo e(Storage::url($event->banner_image)); ?>" alt="<?php echo e($event->title); ?>" class="cr-background-image" style="width: 100%; height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 100%; height: 200px; background: #eee; display: flex; align-items: center; justify-content: center;">No Image</div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </a>
                        </figure>
                        <div class="cr-course-card" style="padding: 20px; background: #fff; border: 1px solid #eee; border-top: 0;">
                            <h3 class="cr-course-title" style="font-size: 18px; margin-bottom: 10px; min-height: 54px;">
                                <a href="<?php echo e(route('events.detail', $event->id)); ?>"><?php echo e($event->title); ?></a>
                            </h3>
                            <div class="cr-course-features" style="display: flex; flex-direction: column; gap: 5px; margin-bottom: 15px;">
                                <div class="cr-info-item">
                                    <i class="am-icon-calender-duration"></i>
                                    <span>Date: <?php echo e($event->date_time); ?></span>
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
                                <a href="<?php echo e(route('events.detail', $event->id)); ?>" class="am-btn am-btn-outline">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="row">
            <div class="col-12">
                <?php echo e($events->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\User\Desktop\well-known\resources\views/livewire/frontend/events/event-list.blade.php ENDPATH**/ ?>