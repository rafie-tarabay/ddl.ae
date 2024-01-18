
<div id="trends">

    <div class="card card-default mt-4">
        <div class="card-header">
        
            <div class="row">
                <div class="col-md-4">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $title ?>
                </div>
                
                <div class="col-md-8 text-<?php echo OppAlign; ?>">    
                
                    <a class="btn btn-info btn-sm" href="<?php echo base_url(front_base."browse/now_reading") ?>"><?php echo word("now_reading") ?></a>                        
                    <a class="btn btn-info btn-sm" href="<?php echo base_url(front_base."browse/keywords_cloud") ?>"><?php echo word("keywords_cloud") ?></a>                        
                
                    <!-- Example single danger button -->
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo word($type."_trends") ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-<?php echo OppAlign; ?>">                     
                            <a class="dropdown-item" href="<?php echo base_url(front_base."browse/trends/users") ?>"><?php echo word("users_trends") ?></a>
                            <a class="dropdown-item" href="<?php echo base_url(front_base."browse/trends/guests") ?>"><?php echo word("guests_trends") ?></a>
                            <?php if(logged_in){ ?>
                                <a class="dropdown-item" href="<?php echo base_url(front_base."browse/trends/my") ?>"><?php echo word("my_trends") ?></a>
                            <?php } ?>
                        </div>
                    </div>            

                </div>
            </div>    
                
        </div>
        
        <div class="card-body">
            <?php echo word("trends_desc") ?>
        </div>
        
    </div>   

    <div class="row mt-4">
         <div class="col-md-12">
         <?php /* ?>
            <div class="list-group-item" >                    
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("top_viewed_dewies") ?>
            </div>     
           
            <img  class="img-fluid logo" src="<?php echo base_url("assets/images/cat_.png") ?>" />
            <?php */ ?>
        </div> 
        <div class="col-md-8">                                                                     
                             
            <div class="list-group">        
                <div class="list-group-item" >                    
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("top_viewed_titles") ?>
                </div>                
            </div>       
        
            <?php $this->load->view( style."/templates/browse/parts/book"  ,array("books" => $books ) ); ?>
            
        </div>
        
        <div class="col-md-4">
        
            <div class="list-group-item" >                    
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("top_viewed_dewies") ?>
            </div>    
        
            <?php $this->load->view( style."/templates/browse/parts/dewey" ,array("dewies" => $dewies) ); ?>
        </div>
    </div>
    
</div>