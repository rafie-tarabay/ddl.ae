<?php if($books){ ?>
    
    <div class="row mt-3 grid">
   
        <?php foreach($books as $b){ ?>
            
            <?php $book = @$b["data"] ?>

            <?php if($book && is_object($book) && @$book->hasData()){ ?>

                <?php $meta = $book->metadata; ?>
        
                <div class="col-12 col-md-4 mb-3 grid-item">

                    <div class="card small_book">                        
                        <div class="card-body text-center">   
                                                                         
                            <a class="cover" href="<?php echo base_url(front_base."book/".$book->getId()) ?>">
                                <img class="img-fluid" src="<?php echo $book->getFileCover("thumb") ?>"  alt="<?php echo word("cover")." ".word_limiter($book->getTitle(),4,""); ?>">                                                
                            </a>
                                                        
                            <h5 class="card-title book_title"><a href="<?php echo base_url(front_base."book/".$book->getId()) ?>"><?php echo $book->getTitle(); ?></a></h5>
                            
                            <div class="card-text book_author"><?php echo $book->getAuthorLink(); ?></div>                            
                                                
                            <span class="badge badge-primary badge-pill"><i class="fa fa-eye"></i>
                                    <?php echo number_format($b["repeats"]); ?></span>                                      
                        </div>
                                                              
                    </div>                        
                            
                </div>


            <?php } ?>    
                        
            
        <?php } ?>

    </div>
    
<?php } 