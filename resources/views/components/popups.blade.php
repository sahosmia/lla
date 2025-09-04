 <!-- Show success toast -->
 <div class="toast-container position-fixed start-50 translate-middle-x">
    <div id="am-themetoastid" class="am-themetoast toast" role="alert" aria-live="assertive" aria-atomic="true">
        <span class="am-toast-icon"></span>
        <h6> </h6>
    </div>
</div>
<!-- Delete modal -->
<div class="modal fade am-deletepopup" id="confirm-popup" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="am-modal-body">
                <span data-bs-dismiss="modal" class="am-closepopup">
                    <i class="am-icon-multiply-01"></i>
                </span>
                <div class="am-deletepopup_icon delete-icon">
                    <span><i class="am-icon-trash-02"></i></span>
                </div>
                <div class="am-deletepopup_icon warning-icon">
                    <span>
                        <i class="am-icon-exclamation-01"></i>
                    </span>
                </div>
                <div class="am-deletepopup_icon confirm-icon">
                    <span>
                        <i class="am-icon-check-circle06"></i>
                    </span>
                </div>
                <div class="am-deletepopup_title">
                    <h3>{{ __('general.confirm') }}</h3>
                    <p>{{ __('general.confirm_content') }}</p>
                </div>
                <div class="am-deletepopup_btns">
                    <a href="javascript:void(0);" class="am-btn am-btnsmall am-cancel" data-bs-dismiss="modal">{{ __('general.no') }}</a>
                    <a href="javascript:void(0);" class="am-btn am-btn-del am-confirm-yes">{{ __('general.yes') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
