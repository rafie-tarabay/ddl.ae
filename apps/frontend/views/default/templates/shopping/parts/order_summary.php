    
<div class="card card-default">

    <div class="card-header">
        <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("order_summary") ?>
    </div>
        
    <?php if($order->order_status == "unpaid"){ ?>
               
        <div class="card-body"> 
          
            <?php echo form_open( base_url("payments/process/") , array("role" => "form",  "class"=>"inline check_submit", "release"=>"true" ,"id"=>"order_summary") ); ?>
                                
                <div class="form-group">                    
                    <label><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("total_price"); ?></label>                                                    
                    <div class="mb-3">
                        <span>$</span>
                        <span id="total_price"      class="<?php if($order->order_coupon) echo "discounted"; ?>"><?php echo $order->order_original_price; ?></span>
                        <span id="discounted_price" class="<?php if(!$order->order_coupon) echo "d-none"; ?>"><?php echo $order->order_total_price; ?></span>
                    </div>                                                            
                </div>                  
                                                
                <div class="form-group">                    
                    <label><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("have_coupon"); ?></label>                                                    
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-info" id="validate_coupon" type="button"><i class="fa fa-tag"></i> <?php echo word("validate_coupon") ?></button>
                        </div>                                                    
                        <input type="text" class="form-control ltr text-left no-shadow" id="coupon" name="coupon" value="<?php echo $order->order_coupon ?>" placeholder="<?php echo word("coupon_code"); ?>" >
                    </div>                                                            
                </div>                
                         
                <div class="form-group">
                    <label><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("payment_method"); ?></label>                                
                                    
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="driver" id="method_paypal" value="paypal" checked>
                        <label class="form-check-label" for="method_paypal">
                            Paypal باي بال
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="driver" id="method_card" value="card" disabled="disabled">
                        <label class="form-check-label" for="method_card">
                            بطاقة ائتمانية
                        </label>
                    </div>
                </div>

                <input type="hidden" name="order_id" id="order_id" value="<?php echo $order->order_id ?>" />
                
                <button type="submit" class="btn btn-success btn-block" id="pay_now"><i class="fa fa-check"></i> <?php echo word("pay_now") ?></button>                                            
                
            <?php echo form_close(); ?>
            
        </div>
    
    <?php }else{ ?>
    
        <div class="card-body"> 

            <div class="card-title text-muted"><?php echo word("order_id") ?></div>
            <h6><?php echo $order->order_id; ?></h6>
            
            <div class="card-title text-muted"><?php echo word("order_status") ?></div>
            <h6><?php echo word($order->order_status); ?></h6>            
            
            <div class="card-title text-muted"><?php echo word("date") ?></div>
            <h6><?php echo date("Y-m-d h:i A",$order->order_timestamp); ?></h6>
            
        </div>
    
    <?php } ?>    
    
</div> 


   
