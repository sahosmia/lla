<!DOCTYPE html>
<html>
   <head>
    <title> {{__('Paytm Payment Gateway')}}</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @php
            $action = ($mode == 'test' ? 'https://securegw-stage.paytm.in' : 'https://securegw.paytm.in');
        @endphp
      <script type="application/javascript" crossorigin="anonymous" src="{{ $action }}/merchantpgpui/checkoutjs/merchants/{{ $paytm_data['app_id'] }}.js"></script>
   </head>
   <body>


      <div class="container text-center">
      	{{ __('general.loading') }}
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                openJsCheckoutPopup('{{ $paytm_data['orderId'] }}','{{ $paytm_data['txnToken'] }}','{{ $paytm_data['amount'] }}');
            }, 1000);
        });

        function openJsCheckoutPopup(orderId, txnToken, amount) {
            var config = {
                "root": "",
                "flow": "DEFAULT",
                "data": {
                    "orderId": orderId,
                    "token": txnToken,
                    "tokenType": "TXN_TOKEN",
                    "amount": amount
                },
                "merchant": {
                    "redirect": true
                },
                "handler": {
                    "notifyMerchant": function(eventName, data) {
                    }
                }
            };

            if (window.Paytm && window.Paytm.CheckoutJS) {
                window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
                    window.Paytm.CheckoutJS.invoke();
                }).catch(function onError(error) {
                    console.error("error => ", error);
                });
            } else {
                console.error("Paytm CheckoutJS is not loaded yet.");
            }
        }
      </script>
   </body>
</html>
