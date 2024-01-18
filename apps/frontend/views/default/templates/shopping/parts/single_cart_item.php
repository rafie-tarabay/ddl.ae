<div class="list-group list-group-flush">

    <?php foreach($items as $item){ ?>
    
        <?php 
            $id     = $item["id"];
            $title  = $item["title"];
            $price  = $item["price"];
            $cover  = $item["cover"];
        ?>
                                                
        <div class="list-group-item">
            <div class="row">
                <div class="col-12 col-sm-9">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("title") ?>: <a href="<?php echo base_url(front_base."book/".$id) ?>"><?php echo $title; ?></a>
                </div>
                <div class="col-12 col-sm-3 text-<?php echo OppAlign; ?>">
                    <button class="btn btn-sm btn-dark"><?php echo '$'.$price ?></button>                    
                    <?php $url = base_url("cart/remove_item/".$id); ?>
                    <a href="<?php echo $url; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> <?php echo word("delete") ?></a>                
                </div>           
            </div>     
        </div>    

    <?php } ?>

</div>  