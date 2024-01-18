<?php $book = $journal; ?>

<?php if($book && is_object($book) && @$book->hasData()){ ?>

    <?php //prnt($book->getRelatedPartsLink()); ?>

    <?php $meta = $book->metadata; ?>
    <?php $link = base_url(front_base.'book/'.$book->getId()); ?>

    <div class="card card-default book_hor mt-4">

        <div class="card-body">

            <div class="media media-responsive">
                
                <div class="align-self-start image-container">                        
                    <a href="<?php echo  $link ?>" title="<?php echo $book->getTitle(); ?>">
                        <img class=" img-thumbnail img-fluid cover d-inline-block" src="<?php echo $book->getFileCover("thumb") ?>"  alt="<?php echo word("cover")." ".word_limiter($book->getTitle(),4,""); ?>" />
                    </a>                           
                </div>
                
                <div class="media-body ">                    

                    <div class="row">
                    
                        <div class="col-12 col-md-7">
      
                            <div class="mb-2 mt-md-0 mt-3 text-center text-md-<?php echo MyAlign; ?>">
                                <h1 class="title">
                                    <a href="<?php echo  $link ?>" title="<?php echo $book->getTitle(); ?>"><?php echo $book->getTitle(); ?></a>
                                </h1>
                            </div>    
                            
                            <?php if($book->hasAuthor()){ ?>
                                <h5 class="mt-1"><?php echo word("author") ?>: <?php echo $book->getAuthorLink(); ?></h5>
                            <?php } ?>

                            <?php if( $book->hasPublisher() ){ ?>                
                                <h5 class="mt-1"><?php echo word("publisher") ?>: <?php echo $book->getPublisherLink(); ?> </h5>                    
                            <?php } ?>                                                         
                                                        
                        </div>
                        
                        <div class="col-12 col-md-5"> 
                            <div class="text-center text-md-<?php echo OppAlign; ?>">    
                                <div class="d-inline-block">
                                    <div class="mb-2">
                                        <?php $this->load->view(style.'/templates/books/parts/fav_widget',array("book"=>$book, "favs"=>@$favs)); ?>                                            
                                    </div>
                                    <div class="mb-2">
                                        <?php //$this->load->view(style.'/templates/books/parts/rating_widget',array("book"=>$book, "ratings"=>@$ratings)); ?>            
                                    </div>
                                    <div class="mb-2 text-center">
                                        <?php $this->load->view(style.'/templates/books/parts/cart_widget',array("book"=>$book, "purchases"=> @$purchases)); ?>            
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>                    
                                                                                               
                </div>
                                
            </div> 
            
        </div>   
        

        <div class="card-footer">
            <?php $this->load->view(style.'/templates/books/parts/issues' , array("books"=>$issues) );   ?>
        </div>

        
    </div>
    


<?php } ?>


<?php if($pagination){ ?>
    <div class="bg-gray border px-3 py-3 text-<?php echo OppAlign; ?>">
        <?php echo $pagination;?>
    </div>
<?php } ?>