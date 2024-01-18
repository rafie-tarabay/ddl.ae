<div class="mt-4">

    <div class="card card-default">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 line-height-30">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("favourite") ?><code>Beta</code>
                </div>
                <div class="col-md-6 text-<?php echo OppAlign; ?>">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url(front_base."dashboard"); ?>"><?php echo word("user_panel") ?></a>
                </div>
            </div>        
        </div>
    </div>

    <div class="mt-4">
            
        <?php if($books){ ?>
            
            <div class="row mt-3 grid">
                
                <?php foreach($books as $book){ ?>
                
                    <?php if($book && is_object($book) && @$book->hasData()){ ?>
                
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
            
        <?php } ?>
    
    
    </div>           
    
    
    <div class="text-center mt-4">
        <?php echo $pagination; ?>                 
    </div>    


</div>