<div class="list-group-item">
    
    <?php if($fields["desc"]){ ?>
        <div class="mt-2">
            <p><?php echo $fields["desc"] ?></p>
        </div>
    <?php } ?>        
    
    <div>
        <img class="img-fluid rounded img-thumbnail" src="<?php echo $fields["image_url"] ?>"  alt="<?php echo word("image") ?>"/>
    </div>            
    
    <div class="mt-2">
        <?php if($fields["android_title"] && $fields["android_url"]){ ?>
            <a target="_blank" href="<?php echo @$fields["android_url"] ?>" class="btn btn-info"><?php echo @$fields["android_title"]; ?></a>
        <?php } ?>
        
        <?php if($fields["ios_title"] && $fields["ios_url"]){ ?>
            <a target="_blank" href="<?php echo @$fields["ios_url"] ?>" class="btn btn-success"><?php echo @$fields["ios_title"]; ?></a>
        <?php } ?>        
        
    </div>
    
</div>