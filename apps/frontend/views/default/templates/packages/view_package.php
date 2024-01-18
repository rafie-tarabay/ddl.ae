<div class="card card-default mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title  mb-0"><?php echo word("package")." - ".$package->title ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-info" href="<?php echo base_url("packages"); ?>"><?php echo word("packages"); ?></a>                
            </div>            
        </div>
    </div> 

</div>

<?php if($books){ ?>
    
    <div class="row mt-3 grid">
   
        <?php foreach($books as $book){ ?>

            <?php if($book && is_object($book) && @$book->hasData()){ ?>

                <?php $meta = $book->metadata; ?>
        
                <div class="col-12 col-md-4 col-lg-3 mb-3 grid-item">

                    <div class="card small_book">                        
                        <div class="card-body text-center">   
                                                                         
                            <a class="cover" href="<?php echo base_url(front_base."book/".$book->getId()) ?>">
                                <img class="img-fluid" src="<?php echo $book->getFileCover("thumb") ?>"  alt="<?php echo word("image") ?>">                                                
                            </a>
                                                        
                            <h5 class="card-title book_title"><a href="<?php echo base_url(front_base."book/".$book->getId()) ?>"><?php echo $book->getTitle(); ?></a></h5>
                            
                            <div class="card-text book_author"><?php echo $book->getAuthorLink(); ?></div>                            

                        </div>
                                                              
                    </div>                        
                            
                </div>


            <?php } ?>    
                        
            
        <?php } ?>

    </div>
    
<?php } ?>

