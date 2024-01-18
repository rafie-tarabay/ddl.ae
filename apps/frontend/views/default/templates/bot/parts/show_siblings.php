<div class="div">
    <?php foreach($siblings as $sibling){ ?>    
        <div class="d-inline-block">
            <?php echo form_open( base_url("bot/reply") ); ?>    
                <button class="btn btn-success" type="submit"><?php echo $sibling->node_title_ar ?></button>  
                <input type="hidden" name="node_name" value="<?php echo $node->node_name; ?>" />
                <input type="hidden" name="target_node" value="<?php echo $sibling->node_name; ?>" />
            <?php echo form_close(); ?>    
        </div>
    <?php } ?>
</div>