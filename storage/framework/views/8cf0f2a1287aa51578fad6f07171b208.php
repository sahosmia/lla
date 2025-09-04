<div class="am-allnotifications" wire:ignore.self>
    <div class="am-allnotifications_content">
        <div class="am-allnotifications_title">
            <h2><?php echo e(__('general.notifications')); ?></h2>
            <!--[if BLOCK]><![endif]--><?php if(auth()->user()->unreadNotifications->isNotEmpty()): ?>
                <span wire:click="markAllAsRead"> <i class="am-icon-check-circle02"></i> <?php echo e(__('general.mark_all_as_read')); ?></span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <!--[if BLOCK]><![endif]--><?php if($notifications->isNotEmpty()): ?>
            <ul class="am-notificationslist">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <div class="am-notificationslist_item <?php if(!empty($notification->read_at)): ?> am-seen <?php endif; ?>">
                            <div class="am-notify-msg">
                                <!--[if BLOCK]><![endif]--><?php if(!empty(setting('_general.notification_image'))): ?>
                                    <figure>
                                        <img src="<?php echo e(url(Storage::url(setting('_general.notification_image')[0]['path']))); ?>" alt="icon">
                                    </figure>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="am-notifyuser-detail">
                                    <h5><?php echo e($notification->data['subject'] ?? ''); ?></h5>
                                    <p><?php echo $notification->data['content'] ?? ''; ?></p>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($notification->data['has_link']) && !empty($notification->data['link_target']) && !empty($notification->data['link_text'])): ?>
                                        <a href="javascript:;" wire:click.prevent="markAsRead('<?php echo e($notification->id); ?>', '<?php echo e($notification->data['link_target']); ?>')" class="am-btn"><?php echo e($notification->data['link_text']); ?></a>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <span><?php echo e(parseToUserTz($notification->created_at)->shortAbsoluteDiffForHumans()); ?></span>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if(empty($notification->read_at)): ?>
                                <div class="am-checkbox am-custom-tooltip" wire:click.prevent="markAsRead('<?php echo e($notification->id); ?>')">
                                    <input type="checkbox" id="notification-mark" name="notification">
                                    <label for="notification-mark"></label>
                                    <span class="am-tooltip-text"><?php echo e(__('general.mark_as_read')); ?></span>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </ul>
            <?php if(auth()->user()->notifications()->count() > $perPage): ?>
                <div class="am-loadmore" wire:loading.class="am-loadmore_loading">
                    <button class="am-btn" wire:click="loadMore" wire:loading.attr="disabled" wire:loading.class="am-btn_disable"><?php echo e(__('general.load_more')); ?></button>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php else: ?>
                <div class="am-notify-caughtup">
                    <h4><?php echo e(__('general.all_caught_up')); ?></h4>
                    <span><?php echo e(__('general.no_notification_desc')); ?></span>
                </div>
         <?php endif; ?><!--[if ENDBLOCK]><![endif]-->   
    </div>
</div><?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/common/notifications.blade.php ENDPATH**/ ?>