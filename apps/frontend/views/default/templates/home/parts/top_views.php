<style>
    .image-parent {
        max-width: 40px;
    }
</style>
<?php 
 if(isset($top_views) &&!empty($top_views)){?>
<div class="card bg-light" id="ads"  >

    <div class="card-header bg-gray-dark head nice-font">
        <div class="row no-gutters">
            <a href="<?php echo base_url(front_base . "browse/trends/guests") ?>" target="_blank" class="text-dark">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> &nbsp; <?php echo word("most_watched_titles"); ?>
            </a>
        </div>
    </div>


    <div class="list-group list-group-flush " style=" max-height: 300px;
    margin-bottom: 10px;
    overflow:scroll;
    -webkit-overflow-scrolling: touch;">
        <?php 
         
               
        foreach ($top_views['filters']['ids'] as $book_id) {

            

            $book = array_filter(
                $top_views['results'],
                function ($e) use ($book_id) {
                    return $e->metadata['biblo_id'] == $book_id;
                }
            );
            if (!$book) {
                continue;
            }
            $book = array_values($book)[0];
            
        ?>
            <div class="list-group-item p-2 d-flex w-100 justify-content-between">
                <div class="small flex-column">
                    <a target="_blank" href="<?php echo base_url(front_base . "book/" . $book->getId()) ?>">
                        <i class="fa fa-caret-left text-info"></i> <?php echo  $book->getTitle(); ?>
                        <span class="badge badge-primary badge-pill"  ><i class="fa fa-eye"></i> <?php echo $top_views['views'][$book_id]['repeats'];?></span>
                </div>
                <div class="image-parent">

                    <img src="<?php echo $book->getFileCover() ?>" class="img-fluid" alt="<?php echo  $book->getTitle(); ?>">
                </div>
                </a>
            </div>
        <?php } ?>

    </div>


</div>

<?php } ?>