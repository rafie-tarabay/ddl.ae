<script src="<?php echo base_url(APPFOLDER."views/".style."/assets/js/orders.js?v=".settings('refresh')); ?>"></script>                                

<div class="card card-default mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="mt-1 mb-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("show_order") ?></h5>
            </div>
            <div class="col-sm-6 text-<?php echo OppAlign; ?>">
                <?php if($order->order_status == "unpaid"){ ?>
                    <a class="btn btn-sm btn-danger" href="<?php echo base_url(front_base."orders/cancel_unpaid_orders") ?>"><?php echo word("cancel") ?></a>
                <?php } ?>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("cart") ?>"><i class="fa fa-shopping-basket"></i> <?php echo word("cart") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("orders") ?>"><i class="fa fa-shopping-bag"></i> <?php echo word("orders") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("payments") ?>"><i class="fa fa-receipt"></i> <?php echo word("payments") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("orders/purchases") ?>"><i class="fa fa-cubes"></i> <?php echo word("purchases") ?></a>
            </div>
        </div>        
        
    </div>            
</div> 

<div class="row mt-3">

    <?php if($items = $order->items){ ?>
    
        <div class="col-12 col-sm-8">
            <div class="card card-default mb-4">
                <div class="card-header">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("order_items") ?>
                </div>            
                
                <?php $this->load->view(style."/templates/shopping/parts/single_order_item",array("items"=> $items)); ?>
                
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <?php echo word("number_items") ?>: <?php echo count($order->items); ?>
                        </div>
                        <div class="col-6 text-<?php echo OppAlign; ?>">                     
                            <?php echo word("final_total") ?>: $<?php echo $order->order_total_price ?>                        
                        </div>                        
                    </div>
                </div>                

            </div>         
        </div>    

        <div class="col-12 col-sm-4">
            <?php $this->load->view(style."/templates/shopping/parts/order_summary"); ?>
        </div>                

    <?php }else{ ?>    
    
        <div class="col-12">
        
            <div class="card card-default mt-4">
                <div class="card-body text-center">
                    <h1 class="no-items mb-3"><i class="fa fa-shopping-cart fa-4x"></i></h1>
                    <h3 class="no-items"><?php echo word("empty_order") ?></h3>
                </div>
            </div>
            
        </div>

    <?php } ?>     
  

    
</div>
        