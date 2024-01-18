<div class="card card-default mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="mt-1 mb-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("payments") ?></h5>
            </div>
            <div class="col-sm-6 text-<?php echo OppAlign; ?>">
                <a class="btn btn-sm btn-info" href="<?php echo base_url("cart") ?>"><i class="fa fa-shopping-basket"></i> <?php echo word("cart") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("orders") ?>"><i class="fa fa-shopping-bag"></i> <?php echo word("orders") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("orders/purchases") ?>"><i class="fa fa-cubes"></i> <?php echo word("purchases") ?></a>
            </div>
        </div>        
        
    </div>            
</div> 

<?php if($payments){ ?>
    
    
    <div class="list-group mt-3">
    
        <div class="list-group-item bg-gray">
            
            <div class="row">
                <div class="col-md-6"><?php echo word("payment_data") ?></div>
                <div class="col-md-2 text-center"><?php echo word("payment_method") ?></div>
                <div class="col-md-2 text-center"><?php echo word("payment_status") ?></div>
                <div class="col-md-2 text-center"><?php echo word("date") ?></div>
            </div>
        
        </div>        
    
        <?php foreach($payments as $payment){ ?>
        
            <div class="list-group-item">
                
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?php echo base_url("orders/show_order/".$payment->payment_order_id) ?>">
                            <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("order") ?> #<?php echo $payment->payment_order_id ?>
                        </a>                                       
                        <br>
                        <?php echo word("ref_id") ?>: <code><?php echo $payment->payment_ref_id; ?></code>
                    </div>
                    <div class="col-md-2 text-center">
                        <?php echo word($payment->payment_method); ?>
                    </div>                    
                    <div class="col-md-2 text-center">
                        <?php echo word($payment->payment_status); ?>
                    </div>
                    <div class="col-md-2 text-center">
                        <span class="timeago" rel="tooltip" title="<?php echo date("Y-m-d h:i A",$payment->payment_timestamp); ?>"><?php echo date("c",$payment->payment_timestamp); ?></span>
                    </div>
                </div>
            
            </div>
        
        <?php } ?>
    
    </div>

            

<?php }else{ ?>        

    <div class="card card-default mt-4">
        <div class="card-body text-center">
            <h1 class="no-items mb-3"><i class="fa fa-shopping-cart fa-4x"></i></h1>
            <h3 class="no-items"><?php echo word("no_payments") ?></h3>
        </div>
    </div>

<?php } ?>     

