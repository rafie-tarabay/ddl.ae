<?php
    $books = json_decode($books);
?>

<div class="row">
    <?php foreach($books->data as $b){ ?>  
        
        <?php $book = $b->productMetadata; ?>      
        <div class="col-md-4">
            <div class="card mb-3">
                <img class="card-img-top" style="height: 300px; overflow:hidden;" src="<?php echo fetch_cover($book->files->file_cover,"thumb") ?>"  alt="<?php echo word("cover")." ".word_limiter($book->title,4,""); ?>">
                <div class="card-body" style="height: 85px; overflow:hidden;">
                    <p class="card-text"><a target="_blank" href="<?php echo $book->biblo_id ?>"><?php echo clean_title_chars($book->title) ?></a></p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
