<?php //prnt($fields , FALSE); ?>
<div class="list-group mt-3 mb-3">
    <?php foreach( $fields as $field ){ ?>
        <?php if($field->hasLabel == TRUE ){ ?>
            <div class="list-group-item">
                
                <!--
                <code class="float-<?php echo OppAlign; ?>"><?php echo $field->tag ?></code>
                -->
                <div class="small text-muted"><?php echo $field->tagLabel_ar ?></div>
                <?php echo $field->tagValue_ar; ?>        
            </div>
        <?php } ?>
    <?php } ?>
</div>