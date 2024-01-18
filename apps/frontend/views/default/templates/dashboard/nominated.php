<div class="mt-4">

    <div class="card card-default">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 line-height-30">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("user_panel") ?> <code>Beta</code>
                </div>
                <div class="col-md-6 text-<?php echo OppAlign; ?>">
                </div>
            </div>        
        </div>
    </div>

    <div class="mt-4">
    
        <div class="row">
                                                                                                         
            <div class="col-12 col-md-9">
              
                <div class="card card-default single_book">

                    <div class="card-header">
                        <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("recommended") ?>
                    </div>                
                </div>

                <div class="content_container text-<?php echo OppAlign; ?>">
                    <?php $this->load->view(style.'/templates/dashboard/parts/nominated_books' , array("books"=>$books) );   ?>
                </div>                    

            </div>
            
                        
            <div class="col-12 col-md-3">
            
                <div class="list-group">
                                        
                    <a class="list-group-item p-4 d-block text-center" href="<?php echo base_url(front_base."orders/purchases") ?>">
                        <h3><code><?php echo $purchases_count; ?></code></h3>
                        <h5><?php echo word("my_library") ?></h5>                    
                    </a>                
                    
                    <a class="list-group-item p-4 d-block text-center" href="<?php echo base_url(front_base."dashboard/favs") ?>">
                        <h3><code><?php echo $favs_count; ?></code></h3>
                        <h5><?php echo word("favourite") ?></h5>                    
                    </a>                  
                
                </div>
                
            </div>
            
        </div>
        
    </div>                                

    
    
    

</div>