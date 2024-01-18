<div class="list-group list-group-flush">

    <?php foreach($items as $item){ ?>
    
        <?php 
            $id     = $item->item_id;
            $data   = json_decode($item->item_data);
            $title  = $data->title;
            $price  = $item->item_price;
            $cover  = $data->cover;
            
            switch ($item->item_type) {
               case "digital_item":
                    $item_url = base_url(front_base."book/".$id);
                    $type = word("title");
                 break;
               case "package":
                    $item_url = base_url(front_base."packages/view_package/".$id);
                    $type = word("package");
                 break;
            }            
        ?>
                                                
        <div class="list-group-item">
            <div class="row">
                <div class="col-12 col-sm-9">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $type; ?>: <a href="<?php echo $item_url ?>"><?php echo $title; ?></a>
                </div>
                <div class="col-12 col-sm-3 text-<?php echo OppAlign; ?>">
                    <button class="btn btn-sm btn-dark"><?php echo '$'.$price ?></button>                    
                    <?php if($order->order_status == "unpaid"){ ?>
                        <?php $delete_link = base_url("orders/remove_item/".$order->order_id."/".$id); ?>
                        <a href="<?php echo $delete_link; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> <?php echo word("delete") ?></a>                                    
                    <?php } ?>
                </div>           
            </div>     
        </div>    

    <?php } ?>

</div>  