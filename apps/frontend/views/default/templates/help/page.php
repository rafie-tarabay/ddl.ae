<div class="mt-4">


    <div class="card card-default mb-4">
        <div class="card-header">            
            <div class="row">
                <div class="col-md-8">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $page->page_title ?>        
                </div>
                <div class="col-md-4 text-<?php echo OppAlign; ?>">
                    <a class="btn btn-info  btn-sm" href="<?php echo base_url("faq/"); ?>"><?php echo word("faqs") ?></a>
                </div>
            </div>             
        </div>
    </div>


    <div class="row">
  
        <div class="col-md-4">

            <div class="list-group">
                <?php foreach($pages as $p){ ?>
                    <a class="list-group-item" href="<?php echo base_url("page/".$p->page_alias); ?>"><?php echo $p->page_title; ?></a>
                <?php } ?>
            </div>
        
        </div>
        
        <div class="col-md-8">

            <?php $page_text =  html_entity_decode($page->page_text); ?>
            <?php $page_text = str_replace('<img ','<img class="img-responsive img-thumbnail" alt="image"',$page_text); ?>
            <?php $page_text = str_replace("<a ",'<a rel="nofollow" ',$page_text);     ?>
            <?php $page_text = find_and_encode_urls_query($page_text);     ?>

            <div class="card card-default">
                <div class="card-body line-height-30">
                    <article><?php echo $page_text; ?></article>
                </div>
            </div>          


        </div>        

    </div>

</div>