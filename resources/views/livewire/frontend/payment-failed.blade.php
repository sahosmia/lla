<div class="am-checkout_section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 text-center">
                <div class="am-checkout_title">
                    <strong class="am-checkout_logo">
                        <x-application-logo />
                    </strong>
                    <h2>{{ __('payment.payment_failed_title') }}</h2>
                    <p>{{ __('payment.payment_failed_desc') }}</p>
                </div>
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                    <a href="{{ route('checkout') }}" class="am-btn">{{ __('payment.try_again') }}</a>
                    <a href="{{ url('/') }}" class="am-white-btn">{{ __('payment.back_to_home') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
