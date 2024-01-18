<div class="card widget <?php echo isset($class) ? $class : ""; ?>">
    <a class="d-block text-info" href="<?php echo $card->content_rel_url1 ?>">
        <img class="card-img-top rounded-0" src="<?php echo $card->content_rel_image1."?v=".settings('refresh'); ?>"  alt="<?php echo word("image") ?>">
    </a>
    <?php if($card->content_rel_text1 && $card->content_rel_url1 && $card->content_rel_title1){ ?>
        <div class="card-body">
            <h5 class="card-title">
                <a class="d-block text-info" href="<?php echo $card->content_rel_url1 ?>">
                    <?php echo $card->content_rel_title1 ?>
                </a>
            </h5>        
            <p class="card-text"><?php echo $card->content_rel_text1 ?></p>        
        </div>
    <?php } ?>
</div>
