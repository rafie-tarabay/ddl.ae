<?php if(@$fields["cover_image_url"]){ ?>
    <div class="list-group-item p-0 m-0 rounded">
        <?php if(@$fields["cover_clickable_url"]){ ?>
            <a href="<?php echo @$fields["cover_clickable_url"] ?>">
                <img class="img-fluid  m-0 w-100" src="<?php echo $fields["cover_image_url"] ?>"  alt="<?php echo word("image") ?>" />
            </a>
        <?php }else{ ?>
                <img class="img-fluid  m-0 w-100" src="<?php echo $fields["cover_image_url"] ?>"  alt="<?php echo word("image") ?>" />
        <?php } ?>
    </div>
<?php } ?>

<div class="list-group-item line-height-30">

    <?php if($fields["title"]){ ?>
        <div><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <b><?php echo $fields["title"]; ?></b></div>
    <?php } ?>
    
    <div class="mt-2">
        <?php echo $fields["content"]; ?>
    </div>

    <?php if($fields["source_url"] && $fields["source_name"] ){ ?>
        <div class="mt-2">
            <i class="fa fa-link"></i> <a target="_blank" href="<?php echo $fields["source_url"]; ?>"><?php echo $fields["source_name"]; ?></a>
        </div>
    <?php } ?>

</div>