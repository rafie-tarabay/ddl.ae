<div class="card card-default">
    
    <div class="card-header">
        <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("order_details") ?>
    </div>
    
    <div class="card-body">
        
        <?php if(logged_in == FALSE){ ?>                    
            <div class="card-title text-muted"><?php echo word("not_loggedin") ?></div>

            <div class="mb-2">
                <a href="<?php echo base_url(front_base."login") ?>" class="btn btn-success rounded-0"><?php echo word("login") ?></a>                                                        
                <a href="<?php echo base_url(front_base."join") ?>" class="btn btn-info rounded-0"><?php echo word("register") ?></a>                                                        
            </div>             
            
        <?php }else{ ?>
            
            <div class="card-title text-muted"><?php echo word("full_name") ?></div>
            <h6><?php echo fullname; ?></h6>
            
            <div class="card-title text-muted"><?php echo word("e_mail") ?></div>
            <h6><?php echo email; ?></h6>
            
        <?php } ?>              
        
    </div>

</div>



     
<?php if(logged_in){ ?>        
    <div class="card card-default mt-3">
        <div class="card-body text-center">   
            <a href="<?php echo base_url("orders/cart_order"); ?>" class="btn btn-success btn-block"><i class="fa fa-check"></i> <?php echo word("create_order") ?></a>                                            
        </div>
    </div> 
<?php } ?>


   
