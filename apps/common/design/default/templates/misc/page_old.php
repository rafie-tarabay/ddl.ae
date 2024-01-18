<div class="page-heading bordered">
    <div class="row">
        <div class="col-md-8">
            <div class="page-title"><i class="fa fa-file-text"></i> <?php echo $page->page_title; ?></div>
        </div>
        <div class="col-md-4 text-<?php echo OppAlign; ?>">
            <a class="btn btn-success" href="<?php echo base_url(front_base."help") ?>"><?php echo word("help_center") ?></a>
            <a class="btn btn-primary" href="<?php echo base_url(front_base."faq") ?>"><?php echo word("back") ?> <i class="fa fa-arrow-left"></i></a>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-8">

        <?php $page_text =  ($page->page_text); ?>
        <?php $page_text = str_replace('<img ','<img class="img-responsive img-thumbnail" ',$page_text); ?>
        <?php $page_text = str_replace("<a ",'<a rel="nofollow" ',$page_text);     ?>
        <?php 
        preg_match_all('/href="(.*?)"/s',$page_text,$found);
        foreach($found as $f) {
            $page_text = str_replace($f,"xx",$page_text);
        }
        ?>        
            
        <div class="panel panel-default help_pages">
            <div class="panel-body page_content">
                <article><?php echo //$page_text; ?></article>
            </div>
        </div>  

    </div>

    <div class="col-md-4">

        <div class="list-group">
                    
        
            <?php foreach($pages as $_page){ ?>
                <a href="<?php echo base_url(front_base."page/".$_page->page_alias); ?>" class="list-group-item <?php if($page->page_alias == $_page->page_alias) echo "active"; ?>">
                    <h5 class="list-group-item-heading"><i class="fa fa-th-large"></i> <?php echo $_page->page_title; ?></h5>
                </a>
            <?php } ?>
            
            
        </div>

    </div>    

</div>




