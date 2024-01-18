<div class="card card-default mt-4">

    <div class="card-body text-center">
    
        <h4><?php echo word("have_incomplete_orders") ?></h4>
    
        <a href="<?php echo base_url(front_base."orders") ?>" class="btn btn-success rounded-0"><?php echo word("orders") ?></a>                                                        
        <a href="<?php echo base_url(front_base."orders/cancel_unpaid_orders/".$type."/".$order->order_id) ?>" class="btn btn-danger rounded-0"><?php echo word("cancel_incomplete_orders") ?></a>        
    
    </div>

</div> 