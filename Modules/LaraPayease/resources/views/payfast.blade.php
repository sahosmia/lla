<html>
<head>
    <title> {{__('Payfast Payment Gateway')}}</title>
</head>
<body>
<div class="stripe-payment-wrapper">
    <div class="srtipe-payment-inner-wrapper">
        @php
            $action = $mode == 'test' ? 'https://sandbox.payfast.co.za/eng/process' : 'https://www.payfast.co.za/eng/process' ;
        @endphp
        <form id="payfast-pay-form" action="{{ $action }}" method="post">
            @foreach($payfast_data as $field_name => $value)
                @if (!empty($value) || $value === 0)
                    <input type="hidden" name="{{$field_name}}"  value="{{$value}}"/>
                @endif
            @endforeach
        </form>
        <div class="btn-wrapper">
            <button id="payment_submit_btn" type="submit">Redirecting please wait...</button>
        </div>
    </div>
</div>

<script>
    (function($){
        "use strict";
        var submitBtn = document.getElementById('payment_submit_btn');
        document.addEventListener('DOMContentLoaded',function (){
            document.getElementById('payfast-pay-form').submit();
        },false);
    })();
</script>
</body>
</html>
