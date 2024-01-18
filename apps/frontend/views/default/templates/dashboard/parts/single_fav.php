<?php if($books){ ?>
    
    <div class="row mt-3 grid">
        
        <?php foreach($books as $book){ ?>
        
            <?php if($book->hasData()){ ?>
        
                <?php $meta = $book->metadata; ?>
        
                <div class="col-12 col-md-6 col-lg-3 mb-3 grid-item" id="fav_<?php echo $book->getId(); ?>">
                    
                    <div class="card small_book">                        
                        <div class="card-body text-center">   
                                                                         
                            <a class="cover" href="<?php echo base_url(front_base."book/".$book->getId()) ?>">
                                <img class="img-fluid" src="<?php echo $book->getFileCover("thumb") ?>"  alt="<?php echo word("cover")." ".word_limiter($book->getTitle(),4,""); ?>">                                                
                            </a>
                                                        
                            <h5 class="card-title book_title"><a href="<?php echo base_url(front_base."book/".$book->getId()) ?>"><?php echo $book->getTitle(); ?></a></h5>
                            
                            <div class="card-text book_author"><?php echo $book->getAuthorLink(); ?></div>                            
                                                
                            <div class="mb-3">
                                <?php $this->load->view(style.'/templates/books/parts/fav_widget',array( "book"=>$book ,"removable"=>TRUE)); ?>  
                            </div>
                                                                  
                            <?php $this->load->view(style.'/templates/books/parts/cart_widget',array("hide_download"=>TRUE , "book"=>$book )); ?>                                        
                            
                        </div>
                                              
                    </div>                        
                            
                </div>
            
            <?php } ?>    
            
        <?php } ?>

    </div>
    
<?php }