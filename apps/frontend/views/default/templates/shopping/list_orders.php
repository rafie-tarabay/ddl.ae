<?php if($orders){ ?>

    <div class="card card-default mt-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5 class="mt-1 mb-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("orders") ?></h5>
                </div>
                <div class="col-sm-6 text-<?php echo OppAlign; ?>">                    
                <a class="btn btn-sm btn-info" href="<?php echo base_url("cart") ?>"><i class="fa fa-shopping-basket"></i> <?php echo word("cart") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("payments") ?>"><i class="fa fa-receipt"></i> <?php echo word("payments") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("orders/purchases") ?>"><i class="fa fa-cubes"></i> <?php echo word("purchases") ?></a>
                </div>
            </div>        
            
        </div>            
    </div> 

    <div class="list-group mt-3">
    
        <div class="list-group-item bg-gray">
            
            <div class="row">
                <div class="col-md-6"><?php echo word("order_id") ?></div>
                <div class="col-md-2 text-center"><?php echo word("order_type") ?></div>
                <div class="col-md-2 text-center"><?php echo word("order_status") ?></div>
                <div class="col-md-2 text-center"><?php echo word("date") ?></div>
            </div>
        
        </div>        
    
        <?php foreach($orders as $order){ ?>
        
            <div class="list-group-item">
                
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?php echo base_url("orders/show_order/".$order->order_id) ?>">
                            <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("order") ?> #<?php echo $order->order_id ?>
                        </a>                                       
                        <?php if($order->order_status == "unpaid"){ ?>
                            &nbsp;-&nbsp; 
                            [ <a href="<?php echo base_url(front_base."orders/cancel_unpaid_orders") ?>"><?php echo word("cancel") ?></a> ]
                        <?php } ?>
                        
                    </div>
                    <div class="col-md-2 text-center">
                        <?php echo word($order->order_type); ?>
                    </div>                    
                    <div class="col-md-2 text-center">
                        <?php echo word($order->order_status); ?>
                    </div>
                    <div class="col-md-2 text-center">
                        <span class="timeago" rel="tooltip" title="<?php echo date("Y-m-d h:i A",$order->order_timestamp); ?>"><?php echo date("c",$order->order_timestamp); ?></span>
                    </div>
                </div>
            
            </div>
        
        <?php } ?>
    
    </div>

            

<?php }else{ ?>        

    <div class="card card-default mt-4">
        <div class="card-body text-center">
            <h1 class="no-items mb-3"><i class="fa fa-shopping-cart fa-4x"></i></h1>
            <h3 class="no-items"><?php echo word("no_orders") ?></h3>
        </div>
    </div>

<?php } ?>     

