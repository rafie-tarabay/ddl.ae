<?php echo form_open( base_url("bot/reply") ); ?>    
<div class="input-group">
    <input type="text" class="form-control" placeholder="ما هو اسمك؟" name="name" value="" />
    <div class="input-group-append">                                            
        <button class="btn btn-success" type="submit">أرسل</button>
    </div>      
</div>    
<input type="hidden" name="node_name" value="<?php echo $node->node_name; ?>" />
<?php echo form_close(); ?>