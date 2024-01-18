<!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
<div class="<?php if (@$cart_btn == "inline") {
                echo "d-inline";
            } else {
                echo "d-block mt-1";
            } ?>">

    <?php
    $source = $book->getSource();

    $title = $book->getTitle();
    if (isset($hide_download)) {
        $url = base_url(front_base . "book/" . $book->getId());
    } else {
        $url = base_url(front_base . "book/read/" . $book->getId());
    }
    ?>

    <?php if (logged_in && ($book->isPurchased(@$purchases) || (free_access && $this->access->hasAccessOnItem($book)))) { ?>
        <div class="btn-group btn-group-sm">
            <a href="<?php echo $url . "?purchased=1"; ?>" class="btn btn-success"><i class="fa fa-download"></i></a>
            <a href="<?php echo $url . "?purchased=1"; ?>" class="btn btn-success"><?php echo word("view_content") ?></a>
        </div>
    <?php } elseif (logged_in && $book->isFree()) { ?>
        <div class="btn-group btn-group-sm">
            <a href="<?php echo $url; ?>" class="btn btn-success"><i class="fa fa-download"></i></a>
            <a href="<?php echo $url; ?>" class="btn btn-success"><?php echo word("free_download") ?></a>
        </div>

        <?php } elseif ($book->isFree()) { 
            // logged_in = true;
            ?>
        <div class="btn-group btn-group-sm">
            <a href="<?php echo $url; ?>" class="btn btn-success"><i class="fa fa-download"></i></a>
            <a href="<?php echo $url; ?>" class="btn btn-success"><?php echo word("free_download") ?></a>
        </div>
        
    <?php } elseif (!$book->isFree()) { ?>

        <div class="btn-group btn-group-sm cart_toggle" id="cart_widget_<?php echo $book->getId() ?>" data-id="<?php echo $book->getId() ?>">
            <?php if ($book->inCart()) { ?>
                <button class="btn btn-success no-shadow"><i class="fa fa-shopping-basket"></i></button>
                <button class="btn btn-success text no-shadow submit_button"><?php echo word("cart_remove"); ?></button>
                <button class="btn btn-success no-shadow"><?php echo $book->getFormattedPrice() ?></button>

            <?php } else { ?>
                <button class="btn btn-info no-shadow"><i class="fa fa-shopping-basket"></i></button>
                <button class="btn btn-info text no-shadow submit_button"><?php echo word("cart_add"); ?></button>
                <button class="btn btn-info no-shadow"><?php echo $book->getFormattedPrice() ?></button>

            <?php } ?>
        </div>
        <?php if ($source['id'] == 3) { ?>
            <button class="btn btn-success no-shadow " 
            style="margin-right:5px;height: 31px;font-size: 14px; display:none;" onclick="PrintBtn('<?php echo $book->getId();?>')">أطلب نسخة مطبوعة</button>
        <?php } ?>

    <?php } else { ?>
        <div class="btn-group btn-group-sm">
            <a href="<?php echo base_url("join"); ?>" class="btn btn-danger "><i class="fa fa-download"></i></a>
            <a href="<?php echo base_url("join"); ?>" class="btn btn-danger"><?php echo word("login_first") ?></a>
        </div>
    <?php } ?> 

</div>
  