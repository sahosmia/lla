<div class="am-event-detail-page am-section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="am-event-content">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->banner_image): ?>
                        <img src="<?php echo e(Storage::url($event->banner_image)); ?>" alt="<?php echo e($event->title); ?>" class="img-fluid rounded mb-4" style="width: 100%; max-height: 400px; object-fit: cover;">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <h1><?php echo e($event->title); ?></h1>
                    <div class="am-event-meta mt-3 mb-4 d-flex gap-4">
                        <span><i class="am-icon-calender-duration"></i> <?php echo e($event->date_time); ?></span>
                        <span><i class="am-icon-video-v2"></i> <?php echo e($event->mode); ?></span>
                    </div>
                    <hr>
                    <div class="am-event-description mt-4">
                        <h3>About this Event</h3>
                        <p>This is a professional training session titled "<?php echo e($event->title); ?>".</p>
                        <!-- Add more description if available in database later -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="am-event-sidebar mb-4 p-4 border rounded shadow-sm bg-white">
                    <h4>Event Details</h4>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-3">
                            <strong>Trainer:</strong><br>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->trainer?->profile?->image): ?>
                                    <img src="<?php echo e(Storage::url($event->trainer->profile->image)); ?>" width="40" height="40" class="rounded-circle" alt="">
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div>
                                    <span><?php echo e($event->trainer?->profile?->full_name ?? 'TBA'); ?></span><br>
                                    <small class="text-muted"><?php echo e($event->trainer?->profile?->tagline); ?></small>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <strong>Mode:</strong><br>
                            <span><?php echo e($event->mode); ?></span>
                        </li>
                        <li class="mb-3">
                            <strong>Date:</strong><br>
                            <span><?php echo e($event->date_time); ?></span>
                        </li>
                    </ul>
                </div>
                
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('frontend.events.event-registration', ['event' => $event]);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-744820775-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\User\Desktop\well-known\resources\views/livewire/frontend/events/event-detail.blade.php ENDPATH**/ ?>