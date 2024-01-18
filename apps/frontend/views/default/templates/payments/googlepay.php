<div class="mt-4 text-center">

    <div class="mb-4 mt-4">
        <h3><?php echo word("usd"); ?> <?php echo $order->order_total_price; ?></h3>
    </div>

    <div id="container"></div>
</div>


<script>

    const baseRequest = {
        apiVersion: 2,
        apiVersionMinor: 0
    };

    const allowedCardNetworks = ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "VISA"];

    const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];

    const tokenizationSpecification = {
        type: 'PAYMENT_GATEWAY',
        parameters: {
            'gateway': 'example',
            'gatewayMerchantId': 'exampleGatewayMerchantId'
        }
    };

    const baseCardPaymentMethod = {
        type: 'CARD',
        parameters: {
            allowedAuthMethods: allowedCardAuthMethods,
            allowedCardNetworks: allowedCardNetworks
        }
    };

    const cardPaymentMethod = Object.assign(
        {},
        baseCardPaymentMethod,
        {
            tokenizationSpecification: tokenizationSpecification
        }
    );

    let paymentsClient = null;

    function getGoogleIsReadyToPayRequest() {
        return Object.assign(
            {},
            baseRequest,
            {
                allowedPaymentMethods: [baseCardPaymentMethod]
            }
        );
    }

    function getGooglePaymentDataRequest() {
        const paymentDataRequest = Object.assign({}, baseRequest);
        paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
        paymentDataRequest.emailRequired = true;
        paymentDataRequest.shippingAddressRequired = true;
        paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
        paymentDataRequest.merchantInfo = {
            // @todo a merchant ID is available for a production environment after approval by Google
            // See {@link https://developers.google.com/pay/api/web/guides/test-and-deploy/integration-checklist|Integration checklist}
            // merchantId: '01234567890123456789',
            merchantName: 'Example Merchant'
        };
        return paymentDataRequest;
    }

    function getGooglePaymentsClient() {
        if ( paymentsClient === null ) {
            paymentsClient = new google.payments.api.PaymentsClient({environment: 'TEST'});
        }
        return paymentsClient;
    }

    function onGooglePayLoaded() {
        const paymentsClient = getGooglePaymentsClient();
        paymentsClient.isReadyToPay(getGoogleIsReadyToPayRequest())
        .then(function(response) {
            if (response.result) {
                addGooglePayButton();
                // @todo prefetch payment data to improve performance after confirming site functionality
                // prefetchGooglePaymentData();
            }
        })
        .catch(function(err) {
            // show error in developer console for debugging
            console.error(err);
        });
    }

    function addGooglePayButton() {
        const paymentsClient = getGooglePaymentsClient();
        const button =
        paymentsClient.createButton({onClick: onGooglePaymentButtonClicked});
        document.getElementById('container').appendChild(button);
    }

    function getGoogleTransactionInfo() {
        return {
            currencyCode: 'AED',
            totalPriceStatus: 'FINAL',
            // set to cart total
            totalPrice: '<?php echo $order->order_total_price; ?>'
        };
    }

    function prefetchGooglePaymentData() {
        const paymentDataRequest = getGooglePaymentDataRequest();
        // transactionInfo must be set but does not affect cache
        paymentDataRequest.transactionInfo = {
            totalPriceStatus: 'NOT_CURRENTLY_KNOWN',
            currencyCode: 'USD'
        };
        const paymentsClient = getGooglePaymentsClient();
        paymentsClient.prefetchPaymentData(paymentDataRequest);
    }

    function onGooglePaymentButtonClicked() {
        const paymentDataRequest = getGooglePaymentDataRequest();
        paymentDataRequest.transactionInfo = getGoogleTransactionInfo();

        const paymentsClient = getGooglePaymentsClient();
        paymentsClient.loadPaymentData(paymentDataRequest)
        .then(function(paymentData) {
            // handle the response
            processPayment(paymentData);
        })
        .catch(function(err) {
            // show error in developer console for debugging
            console.error(err);
        });
    }

    function processPayment(paymentData) {

        /*
        //{
        //    "apiVersion": 2,
        //    "apiVersionMinor": 0,
        //    "paymentMethodData": {
        //        "type": "CARD",
        //        "description": "Visa •••• 1234",
        //        "info": {
        //            "cardNetwork": "VISA",
        //            "cardDetails": "1234"
        //        },
        //        "tokenizationData": {
        //            "type": "PAYMENT_GATEWAY",
        //            "token": "examplePaymentMethodToken"
        //        }
        //    },
        //    "shippingAddress": {        
        //
        //    }
        //}        
        */

        paymentToken = paymentData.paymentMethodData.tokenizationData.token;
        
        console.log(paymentToken);
    }

</script>

<script async src="https://pay.google.com/gp/p/js/pay.js" onload="onGooglePayLoaded()"></script>
