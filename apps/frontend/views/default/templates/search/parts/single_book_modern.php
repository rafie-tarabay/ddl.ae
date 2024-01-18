<?php foreach($books as $book){ ?>


    <?php if($book && is_object($book) && @$book->hasData()){ ?>

        <?php 
            $meta = $book->metadata;
            $link = base_url(front_base.'book/'.$book->getId()); 
            $isJournal = FALSE;
            $isMaster = FALSE;
            
            if($book->isJournal() && $book->hasIssues()){
                //$link = base_url(front_base.'journal/'.$book->getId()); 
                $isJournal = TRUE;       
            }                                 
            $keywords = str_replace('"',"",$keywords);
        ?>        
            

        <div class="card card-default single_book book_main" id="book_<?php echo $book->getId(); ?>" data-id="<?php echo $book->getId(); ?>">
        
            <div class="card-body">
                
                <span class="badge book_data_timer" id="timer_<?php echo $book->getId(); ?>"><i class="fas fa-spin fa-circle-notch"></i> <span class="txt">5</span></span>
                
                <div class="media media-responsive">
                    <?php if($book->getFileCover("thumb")==''){ ?>
                        <div class="align-self-start image-container">                        
                            <a href="<?php echo  $link ?>" title="<?php echo $book->getTitle(); ?>">
                                <img class=" img-thumbnail img-fluid cover d-inline-block" alt="<?php echo word("image") ?>" />
                            </a>                           
                        </div>
                    <?php }else{?>
                        
                        <div class="align-self-start image-container">                        
                            <a href="<?php echo  $link ?>" title="<?php echo $book->getTitle(); ?>">
                                <img class=" img-thumbnail img-fluid cover d-inline-block" src="<?php echo $book->getFileCover("thumb"); ?>" alt="<?php echo word("image") ?>"  style="background-image: none !important;" />
                            </a>                           
                        </div>
                    <?php } ?>
                    
                    <div class="media-body ">                    

                        <div class="row">
                        
                            <div class="col-12 col-md-7">
          
                                <div class="mb-2 mt-md-0 mt-3 text-center text-md-<?php echo MyAlign; ?>">
                                    <h1 class="title">
                                        <?php if($isJournal){ ?>
                                            <i class="fa fa-clone text-danger" title="<?php echo word("journal"); ?>" rel="tooltip"></i>
                                        <?php } ?>
                                        <a href="<?php echo $link ?>" title="<?php echo $book->getTitle(); ?>"><?php echo highlighter( $book->getTitle() ,  $keywords ); ?></a>
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
                                        <div class="">
                                            <?php $this->load->view(style.'/templates/books/parts/fav_widget',array("book"=>$book, "favs"=>@$favs)); ?>                                            
                                        </div>

                                        <div class="mt-1 text-center">
                                            <?php $this->load->view(style.'/templates/books/parts/cart_widget',array("book"=>$book, "purchases"=> @$purchases )); ?>                                                                                                    
                                        </div>
                                        
                                        <div class="mt-1 text-center">
                                            <?php $this->load->view(style.'/templates/books/parts/addons_widget',array("journal_btns"=>"block" , "chapters_btns"=>"block" )); ?>            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>                    
                                                                                                   
                    </div>
                                    
                </div> 
                
            </div>
        
            <div class="card-footer">
            

                <?php $slug1 = $book->getTitle() ?>
                <?php $link = site_url('/book/' . $book->getId() . '/' ) ?>

                <div class="row visible-sm-block hidden-sm hidden-xs">
                    
                    <div class="col-md-4">
                    
                        <?php if( $book->getbibloType() ){ ?>                
                            <p class="mt-0 mb-0">
                                <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("biblotype") ?>: 
                                <?php echo $book->getbibloTypeLink(); ?>   
                            </p>
                        <?php } ?>                    

                        
                        <?php if( $book->hasSubjects() ){ ?>                
  
                            <p class="mt-0 mb-0">
                                <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("subjects") ?>                                        
                            </p>
                            <?php foreach($book->getSubjectsLinks() as $links){ ?>                                                            
                                <p><?php echo join(", ",$links); ?></p>                                                            
                            <?php } ?>                            
        
                        <?php } ?>  

                    </div>
                    
                    <div class="col-md-4">
                
                        <?php if( $book->hasClassifications() ){ ?>                
                            <p class="mt-0 mb-0">
                            <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("classification") ?>: 
                            <?php echo $book->getClassificationsLinks(); ?>
                            </p>
                        <?php } ?> 
                    
                        <?php if( $book->hasSource() ){ ?>                
                            <p class="mt-0 mb-0">
                                <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("sources") ?>: 
                                <?php echo $book->getSourceLink(); ?>
                            </p>
                        <?php } ?> 
        
                    </div>
                    
                    
                    <div class="col-md-4">
                                                                          
                        <?php if( $book->hasLanguage() ){ ?>                
                            <p class="mt-0 mb-0">
                                <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("language") ?>: 
                                <?php echo $book->getLanguageLink(); ?>
                            </p>
                        <?php } ?>                    
                        
                        <?php if( $book->hasPublicationYear() ){ ?>                
                            <p class="mt-0 mb-0">
                                <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("date") ?>:
                                <?php echo $book->getPublicationYearLink(); ?>
                            </p>
                        <?php } ?>                          
   
                        <?php if($book->getIsbn()){ ?>                            
                            <p class="mt-0 mb-0">
                                <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("isbn") ?>: 
                                <?php echo $book->getIsbn(); ?>
                            </p>          
                        <?php } ?>                              
                              
                        <?php if($book->getNumberOfPages()){ ?>
                            <p class="mt-0 mb-0">
                                <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo $book->getNumberOfPages(); ?>
                            </p>
                        <?php } ?>
                        
                        <?php if($book->getNumberOfWords()){ ?>
                            <p class="mt-0 mb-0">
                                <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo $book->getNumberOfWords(); ?> 
                            </p>
                        <?php } ?>
                        
                        <?php if($book->getFormattedFormat()){ ?>
                            <p class="mt-0 mb-0">
                                <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo $book->getFormattedFormat(); ?>
                            </p>
                        <?php } ?>
                        
                        <?php if($book->getReadingTime()!=""){ ?>
                            <p class="mt-0 mb-0">
                                <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo $book->getReadingTime(); ?>
                            </p>
                        <?php } ?>
  
                    </div>
                    
                    
                    <?php if(u_id == 2){ ?>
                        <div class="col-md-12">
                            <hr />
                            <div class="row">
                                <div class="col-md-4">
                                    ID: <code><?php echo $book->getId(); ?></code>
                                </div>
                                <div class="col-md-4 text-<?php echo OppAlign; ?>">
                                    Score: <code><?php echo $book->getScore(); ?></code>
                                </div>                    
                                <div class="col-md-4 text-<?php echo OppAlign; ?>">
                                    <a class="btn btn-danger sure" target="_blank" href="<?php echo base_url(front_base."fixes/purger/".$book->getId()) ?>">Remove Record</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                </div>
                
            
            </div>
      
        </div>   


    <?php } ?>    
      
    
<?php }