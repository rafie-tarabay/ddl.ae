<div class="d-block rating_widget  text-center" id="rating_widget_<?php echo $book->getId() ?>">
    <?php $rated = $book->isRated(@$ratings); ?>
    <div class="btn-group  btn-group-sm">
        <?php for($i=1;$i<=5;$i++){ ?>                  
            <?php $activeBtn = @$rated->rating_value >= $i ? TRUE : FALSE; ?>
            <?php $class1 = $activeBtn ? "btn-default active" : "btn-default text-muted" ;?>
            <?php $class2 = $rated ? "btn-default text-muted" : "btn-default  text-muted" ;?>                    
            <button type="button" class="btn <?php echo $class1; ?> <?php echo $class2; ?> btn-sm no-shadow rate_book" data-id="<?php echo $book->getId() ?>"  data-value="<?php echo $i ?>" rel="tooltip" title="<?php echo $i."/5"; ?>"><i class="fa fa-star"></i></button>                
        <?php } ?>            
    </div>
</div>
