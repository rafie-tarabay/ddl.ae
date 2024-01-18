<div class="card card-default mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="mt-1 mb-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("purchases") ?></h5>
            </div>
            <div class="col-sm-6 text-<?php echo OppAlign; ?>">                    
            <a class="btn btn-sm btn-info" href="<?php echo base_url("cart") ?>"><i class="fa fa-shopping-basket"></i> <?php echo word("cart") ?></a>
            <a class="btn btn-sm btn-info" href="<?php echo base_url("orders") ?>"><i class="fa fa-shopping-bag"></i> <?php echo word("orders") ?></a>
            <a class="btn btn-sm btn-info" href="<?php echo base_url("payments") ?>"><i class="fa fa-receipt"></i> <?php echo word("payments") ?></a>
            </div>
        </div>        
        
    </div>            
</div> 

<?php if($purchases){ ?>
    
    <div class="list-group mt-3">
       

        <div class="card card-default mb-4">

            <div class="list-group list-group-flush">

                <?php foreach($purchases as $item){ ?>
                
                    <?php 
                        $id     = $item->item_id;
                        $data   = json_decode($item->item_data);
                        $title  = $data->title;
                        $price  = $item->item_price;
                        $cover  = $data->cover;
                        
                        switch ($item->item_type) {
                           case "digital_item":
                                $item_url = base_url(front_base."book/".$id."/?purchased=1");
                                $type = word("title");
                             break;
                           case "package":
                                $item_url = base_url(front_base."packages/view_package/".$id."/?purchased=1");
                                $type = word("package");
                             break;
                        }                        
                    ?>
                                                            
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-12 col-sm-9">
                                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $type ?>: <a href="<?php echo $item_url ?>"><?php echo $title; ?></a>
                            </div>
                            <div class="col-12 col-sm-3 text-<?php echo OppAlign; ?>">
                                <button class="btn btn-sm btn-dark"><?php echo '$'.$price ?></button>                    
                            </div>           
                        </div>     
                    </div>    

                <?php } ?>

            </div>  
            <div class="card-footer text-center">
                <?php echo $pagination; ?>
            </div>                

        </div>
    
    </div>

            

<?php }else{ ?>        

    <div class="card card-default mt-4">
        <div class="card-body text-center">
            <h1 class="no-items mb-3"><i class="fa fa-shopping-cart fa-4x"></i></h1>
            <h3 class="no-items"><?php echo word("no_purchases") ?></h3>
        </div>
    </div>

<?php } ?>     

