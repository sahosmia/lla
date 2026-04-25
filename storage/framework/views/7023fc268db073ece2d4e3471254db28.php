<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($bookings)): ?>
    <h3 style="font-size: 14px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e(__('courses::courses.sessions_detail')); ?></h3>
    <div style="background: #FAF8F5; padding: 16px 11px; border-radius: 8px; margin-top: 16px">
        <table style="width: 100%;">
            <thead>
                <tr>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">
                    <?php echo e($emailFor == 'tutor' 
                        ? (!empty(setting('_lernen.student_display_name')) ? setting('_lernen.student_display_name') : __('general.student')) 
                        : (!empty(setting('_lernen.tutor_display_name')) ? setting('_lernen.tutor_display_name') : __('general.tutor'))); ?>

                </th>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e(__('booking.subject')); ?></th>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e(__('calendar.date_time')); ?></th>
            </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php
                            $img  = $emailFor == 'student' ? $booking['tutorImg'] : $booking['studentImg'];
                            $name = $emailFor == 'student' ? $booking['tutorName'] : $booking['studentName'];
                        ?>
                        <td style="display: flex; align-items:center; gap: 10px; padding: 10px 20px;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($img) && Storage::disk(getStorageDisk())->exists($img)): ?>
                                <img style="width: 36px; height: 36px; border-radius: 50%;"  src="<?php echo e(resizedImage($img, 40, 40)); ?>" alt="<?php echo e($name); ?>">
                            <?php else: ?> 
                                <img style="width: 36px; height: 36px; border-radius: 50%;"  src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 40, 40)); ?>" alt="<?php echo e($name); ?>">
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <h6 style="font-size: 14px; font-weight: 400; color: #585858; line-height: 20px; margin: 0;"><?php echo e($name); ?></h6>
                        </td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><?php echo $booking['subjectName']; ?> </td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><span style="display: block;"><?php echo $booking['sessionTime']; ?></span></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($courses)): ?>
<h3 style="font-size: 14px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e(__('courses::courses.courses_detail')); ?></h3>
    <div style="background: #FAF8F5; padding: 16px 11px; border-radius: 8px; margin-top: 16px">
        <table style="width: 100%;">
            <thead>
                <tr>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e($emailFor == 'tutor' ? (setting('_lernen.student_display_name') ?? __('general.student')) : (setting('_lernen.tutor_display_name') ?? __('general.tutor'))); ?></th>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e(__('courses::courses.course_title')); ?></th>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isPaidSystem()): ?>
                    <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e(__('courses::courses.price')); ?></th>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php
                            $img  = $emailFor == 'student' ? $course['tutorImg'] : $course['studentImg'];
                            $name = $emailFor == 'student' ? $course['tutorName'] : $course['studentName'];
                        ?>
                        <td style="display: flex; align-items:center; gap: 10px; padding: 10px 20px;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($img) && Storage::disk(getStorageDisk())->exists($img)): ?>
                                <img style="width: 36px; height: 36px; border-radius: 50%;"  src="<?php echo e(resizedImage($img, 40, 40)); ?>" alt="<?php echo e($name); ?>">
                            <?php else: ?> 
                                <img style="width: 36px; height: 36px; border-radius: 50%;"  src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 40, 40)); ?>" alt="<?php echo e($name); ?>">
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <h6 style="font-size: 14px; font-weight: 400; color: #585858; line-height: 20px; margin: 0;"><?php echo e($name); ?></h6>
                        </td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><?php echo $course['courseTitle']; ?> </td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isPaidSystem()): ?>
                            <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><span style="display: block;"><?php echo formatAmount($course['coursePrice']); ?></span></td>    
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>    
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> 
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($subscriptions)): ?>
<h3 style="font-size: 14px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e(__('subscriptions::subscription.subscriptions_detail')); ?></h3>
    <div style="background: #FAF8F5; padding: 16px 11px; border-radius: 8px; margin-top: 16px">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e(__('subscriptions::subscription.subscription')); ?></th>
                    <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e(__('subscriptions::subscription.price')); ?></th>
                    <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;"><?php echo e(__('subscriptions::subscription.valid_till')); ?></th>
            </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><?php echo $subscription['subscriptionName'] . ' (' . __('subscriptions::subscription.'.$subscription['subscriptionPeriod']) . ')'; ?> </td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><span style="display: block;"><?php echo formatAmount($subscription['subscriptionPrice']); ?></span></td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><span style="display: block;"><?php echo Carbon\Carbon::parse($subscription['expires_at'])->format(setting('_general.date_format') ?? 'd M Y'); ?></span></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>    
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>    <?php /**PATH C:\Users\User\Desktop\well-known\resources\views/components/email/bookings.blade.php ENDPATH**/ ?>