
<?php if($book->isJournal() && $book->hasIssues()){ ?>
    <div class="<?php if(@$journal_btns == "block"){ echo "d-block mt-1"; }else{ echo "d-inline"; } ?>">
        <?php $link = base_url(front_base.'journal/'.$book->getId()); ?>
        <a class="btn btn-mauve btn-sm" href="<?php echo $link ?>"><?php echo word("journal_issues") ?></a>        
    </div>    
<?php } ?>     
    
<?php if($book->isJournal() && $parent_id = $book->getParentId()){ ?>
    <div class="<?php if(@$journal_btns == "block"){ echo "d-block mt-1"; }else{ echo "d-inline"; } ?>">
        <?php $link = base_url(front_base.'journal/'.$parent_id);  ?>
        <a class="btn btn-mauve btn-sm" href="<?php echo $link ?>"><?php echo word("journal_issues") ?></a>        
    </div>    
<?php } ?>     
    
<?php if($book->isChapter() && $parent_id = $book->getParentId()){ ?>        
    <div class="<?php if(@$chapters_btns == "block"){ echo "d-block mt-1"; }else{ echo "d-inline"; } ?>">
        <?php $link = base_url(front_base.'book/'.$parent_id);  ?>
        <a class="btn btn-mauve btn-sm" href="<?php echo $link ?>"><?php echo word("full_book") ?></a>
    </div>    
<?php } ?>     

