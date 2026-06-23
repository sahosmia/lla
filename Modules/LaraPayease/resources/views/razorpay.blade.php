<html>
<head>
    <title>{{__('Razorpay')}}</title>
</head>
<body>
<div class="stripe-payment-wrapper">
    <div class="srtipe-payment-inner-wrapper">
        <form name="razorpayform" action="{{$data['route']}}" method="POST" >
            <input type="hidden" name="order_id" value="{{ $data['order_id'] }}" />
            <input type="hidden" name="subscription_id" value="{{ $data['subscription_id'] }}" />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
            <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        </form>
    </div>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    (function(){
    "use strict";
        var options = {
            "key": "{{ $data['public_key'] }}",
            "amount": "{{ $data['price'] }}",
            "currency": "{{ $data['currency'] }}",
            "name": "{{ $data['name'] }}",
            "description": "{{ $data['description'] }}",
            "order_id": "{{ $data['order_id'] }}",
            "prefill":{
                "email": "{{ $data['email'] }}"
            },
            "theme": {
                "color": "#F37254"
            }
        };
        options.handler = function(response) {
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.razorpayform.submit();
        };
        options.theme.image_padding = false;
        options.modal = {
            ondismiss: function() {
                window.location.href = "{{ $data['cancel_url'] }}"
            },
            escape: true,
            backdropclose: false
        };
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function(response) {
            alert(response.error.code);
            alert(response.error.description);
            alert(response.error.source);
            alert(response.error.step);
            alert(response.error.reason);
            alert(response.error.metadata.order_id);
            alert(response.error.metadata.payment_id);
        });
        rzp1.open();

    })();
</script>
</body>
</html>
