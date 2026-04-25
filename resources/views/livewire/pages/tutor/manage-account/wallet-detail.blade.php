<div class="am-userearningwrap" >
    <div class="am-title_wrap">
        <div class="am-title">
            <h2>{{ __('tutor.my_earning') }}</h2>
            <p>{{ __('tutor.description') }}</p>
        </div>
    </div>
    <div class="am-userearning">
        <div class="am-userearning_item">
            <div class="am-userearning_head">
                <span class="am-earn-income">
                    <i class="am-icon-time-3"></i>
                </span>
            </div>
            <div class="am-userearning_footer">
                <strong>{!! formatAmount($earnedAmount, true) !!}</strong>
                <span>{{ __('tutor.earned_income') }}</span>
            </div>
        </div>
        <div class="am-userearning_item">
            <div class="am-userearning_head">
                <span class="am-fund-withdraw">
                    <i class="am-icon-invoices-01"></i>
                </span>
            </div>
            <div class="am-userearning_footer">
                <strong>{!! formatAmount($withdrawalBalance['completed_withdrawals'], true) !!}</strong>
                <span>{{ __('tutor.funds_withdraw') }}</span>
            </div>
        </div>
        <div class="am-userearning_item">
            <div class="am-userearning_head">
                <span class="am-pending-amount">
                    <i class="am-icon-time-1"></i>
                </span>
            </div>
            <div class="am-userearning_footer">
                <strong>{!! formatAmount($pendingFunds, true) !!}</strong>
                <span>{{ __('tutor.pending_amount') }}</span>
            </div>
        </div>
        <div class="am-userearning_item">
            <div class="am-userearning_head">
                <span class="am-wallet-funds">
                    <i class="am-icon-time-2"></i>
                </span>
            </div>
            <div class="am-userearning_footer">
                <strong>{!! formatAmount($walletBalance, true) !!}</strong>
                <span>{{ __('tutor.wallet_funds') }}</span>
            </div>
        </div>
        <div class="am-userearning_item">
            <div class="am-userearning_head">
                <span class="am-pending-withdraws">
                    <i class="am-icon-atm-card-01"></i>
                </span>
            </div>
            <div class="am-userearning_footer">
                <strong>{!! formatAmount($withdrawalBalance['pending_withdrawals'], true) !!}</strong>
                <span>{{ __('tutor.pending_withdraw_amount') }}</span>
            </div>
        </div>
    </div>
</div>
