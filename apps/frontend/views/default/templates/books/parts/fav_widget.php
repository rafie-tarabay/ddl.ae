<div class="d-block fav_widget text-center" id="fav_widget_<?php echo $book->getId() ?>">
    <?php if($book->isFaved(@$favs)){ ?>
        <button type="button" class="btn btn-danger btn-sm no-shadow fav_book" data-removable="<?php echo isset($removable) ? 1 : 0 ?>" data-id="<?php echo $book->getId() ?>"><?php echo word("fav_remove"); ?></button>
    <?php }else{ ?>
        <button type="button" class="btn btn-default btn-sm no-shadow fav_book" data-removable="<?php echo isset($removable) ? 1 : 0 ?>" data-id="<?php echo $book->getId() ?>"><?php echo word("fav_add"); ?></button>
    <?php } ?>
</div>      