<div class="d-block" id="social_icons_widget_<?php echo $book->getId() ?>">
    <?php 
        $url = 'https:'.base_url(front_base."book/".$book->getId());
         
        $title = $book->getTitle();
        $text = $book->getTitle()." ".$url;
    ?>
    <div class="btn-group btn-group-sm sharing_icons">
        <a target="_blank" class="twitter m-1" href="https://twitter.com/intent/tweet?text=<?php echo $text; ?>"><i class="fab fa-2x fa-twitter"></i></a>
        <a target="_blank" class="facebook m-1" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"><i class="fab fa-2x fa-facebook"></i></a>
        <a target="_blank" class="googleplus m-1" href="https://plus.google.com/share?url=<?php echo $url; ?>"><i class="fab fa-2x fa-google-plus"></i></a>
        <a target="_blank" class="linkedin m-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>"><i class="fab fa-2x fa-linkedin"></i></a>
    </div>
</div>