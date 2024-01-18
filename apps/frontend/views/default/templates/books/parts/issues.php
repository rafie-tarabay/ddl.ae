<?php if($books){ ?>
    
    <div class="row mt-3 grid">
        
        <?php foreach($books as $book){ ?>

            <?php if($book && is_object($book) && @$book->hasData()){ ?>

                <?php $meta = $book->metadata; ?>
        
                <div class="col-12 col-md-6 col-lg-3 mb-3 grid-item">

                    <div class="card small_book">                        
                        <div class="card-body text-center">   
                                                                         
                            <a class="cover" href="<?php echo base_url(front_base."book/".$book->getId()) ?>">       
                                <img class="img-fluid" src="<?php echo $book->getFileCover("thumb") ?>"  alt="<?php echo word("cover")." ".word_limiter($book->getTitle(),4,""); ?>" >                                                
                            </a>
                                                        
                            <h5 class="card-title book_title issues"><a style="height: 100px" href="<?php echo base_url(front_base."book/".$book->getId()) ?>"><?php echo $book->getTitle(); ?></a></h5>
                                      
                            
                        </div>
                                                              
                    </div>                        
                            
                </div>


            <?php } ?>    
                        
            
        <?php } ?>

    </div>
    
<?php } 