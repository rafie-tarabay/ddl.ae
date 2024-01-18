<script src="https://www.paypal.com/sdk/js?intent=authorize&currency=USD&client-id=<?php echo $client_id ?>"></script>


<div class="mt-4 text-center">
    
    <div class="mb-4 mt-4">
        <h3><?php echo word("usd"); ?> <?php echo $order->order_total_price; ?></h3>
    </div>

    <div id="paypal-button-container"></div>
</div>

<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $order->order_total_price; ?>',
                        invoice_id: '<?php echo $order->order_id; ?>',
                    }
                }]
            });
        },

        onApprove: function(data, actions) {

            // Authorize the transaction
            actions.order.authorize().then(function(authorization) {

                // Get the authorization id
                var authorizationID = authorization.purchase_units[0].payments.authorizations[0].id          

                nice_alert("loading",'<?php echo word("processing_transaction") ?>');

                // Call your server to save the transaction

                $.post(front_base+'payments/paypal_capture', {
                    csrf_token : csrf_token,
                    order_id : '<?php echo $order->order_id; ?>',
                    invoice_id : data.orderID,
                    auth_id : authorizationID,
                    }, function(my_data) {                    
                        var data  = jQuery.parseJSON(my_data);                        
                        if(data.alert){
                            nice_alert(data.status,data.alert);
                        }                        
                        if(data.url){
                            setTimeout("location.href='"+data.url+"'", 1000);   
                        }                        
                });           

            });
        }
    }).render('#paypal-button-container');    

    
</script>