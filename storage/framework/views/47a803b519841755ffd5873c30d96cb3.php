<ul class="am-userperinfo_tab">
    <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-active'=> $activeRoute == 'tutor.bookings.subjects']); ?>">
        <a href="<?php echo e(route('tutor.bookings.subjects')); ?>" wire:navigate.remove>
            <?php echo e(__('subject.subject_title')); ?>

        </a>
    </li>
    <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-active'=> in_array($activeRoute, ['tutor.bookings.manage-sessions','tutor.bookings.session-detail'])]); ?>">
        <a href="<?php echo e(route('tutor.bookings.manage-sessions')); ?>" wire:navigate.remove>
            <?php echo e(__('calendar.title')); ?>

        </a>
    </li>
    <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-active'=> $activeRoute == 'tutor.bookings.upcoming-bookings']); ?>">
        <a href="<?php echo e(route('tutor.bookings.upcoming-bookings')); ?>" wire:navigate.remove>
            <?php echo e(__('calendar.upcoming_bookings')); ?>

        </a>
    </li>
</ul><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/tutor/manage-sessions/tabs.blade.php ENDPATH**/ ?>