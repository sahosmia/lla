<div wire:ignore.self class="modal fade am-complete-popup" id="confirm-complete-popup" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="am-modal-body">
                <span data-bs-dismiss="modal" class="am-closepopup">
                    <i class="am-icon-multiply-01"></i>
                </span>
                <div class="am-deletepopup_icon confirm-icon">
                    <span>
                        <i class="am-icon-check-circle06"></i>
                    </span>
                </div>
                <div class="am-deletepopup_title">
                    <h3><?php echo e(__('calendar.confirm_complete_title')); ?></h3>
                    <p><?php echo e(__('calendar.confirm_complete_desc', ['day' => setting('_lernen.complete_booking_after_days') ?? 3])); ?></p>
                </div>
                <div class="am-deletepopup_btns">
                    <a href="javascript:void(0);" class="am-btn am-btnsmall am-cancel" wire:click.prevent="closeCompletePopup"><?php echo e(__('calendar.btn_cancel_complete')); ?></a>
                    <a href="javascript:void(0);" wire:click.prevent="completeBooking" class="am-btn am-btn-del am-confirm-yes"><?php echo e(__('calendar.btn_confirm_complete')); ?></a>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/components/completion.blade.php ENDPATH**/ ?>