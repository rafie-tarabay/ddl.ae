<div class="list-group-item p-0 m-0 rounded">
    <?php if(@$fields["clickable_link"]){ ?>
        <a href="<?php echo @$fields["clickable_link"] ?>">
            <img class="img-fluid <?php echo @$fields["img_class"] ?> m-0 w-100" src="<?php echo $fields["url"] ?>"  alt="<?php echo word("image") ?>" />
        </a>
    <?php }else{ ?>
            <img class="img-fluid <?php echo @$fields["img_class"] ?> m-0 w-100" src="<?php echo $fields["url"] ?>"  alt="<?php echo word("image") ?>" />
    <?php } ?>
</div>