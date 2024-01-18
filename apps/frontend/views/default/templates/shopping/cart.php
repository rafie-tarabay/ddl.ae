<div class="card card-default mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="mt-1 mb-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("cart") ?></h5>
            </div>
            <div class="col-sm-6 text-<?php echo OppAlign; ?>">
                <a class="btn btn-sm btn-info" href="<?php echo base_url("orders") ?>"><i class="fa fa-shopping-bag"></i> <?php echo word("orders") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("payments") ?>"><i class="fa fa-receipt"></i> <?php echo word("payments") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("orders/purchases") ?>"><i class="fa fa-cubes"></i> <?php echo word("purchases") ?></a>
            </div>
        </div>        
        
    </div>            
</div> 

<div class="row mt-3">

    <?php if($items){ ?>
    
        <div class="col-12 col-sm-8">
            <div class="card card-default mb-4">
                <div class="card-header">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("shopping_cart") ?>
                </div>            
                
                <?php $this->load->view(style."/templates/shopping/parts/single_cart_item",array("items"=> $items)); ?>
                
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <?php echo word("number_items") ?>: <?php echo count($items); ?>
                        </div>
                        <div class="col-6 text-<?php echo OppAlign; ?>">                     
                            <?php echo word("final_total") ?>: $<?php echo $total_price ?>                        
                        </div>                        
                    </div>
                </div>
            </div>         
        </div>    

        <div class="col-12 col-sm-4">
            <?php $this->load->view(style."/templates/shopping/parts/cart_summary"); ?>
        </div>                

    <?php }else{ ?>    
    
        <div class="col-12">
        
            <div class="card card-default mt-4">
                <div class="card-body text-center">
                    <h1 class="no-items mb-3"><i class="fa fa-shopping-cart fa-4x"></i></h1>
                    <h3 class="no-items"><?php echo word("empty_shopping_cart") ?></h3>
                </div>
            </div>
            
        </div>

    <?php } ?>     
  

    
</div>
        