<?php if($dewies){ ?>
    
    <div class="list-group mt-3">
        
        <?php if($dewies){ ?>
        
            <?php foreach($dewies as $dewey){ ?>

                <?php if(@$dewey["number"] && @$dewey["title"]){ ?>
                                                                                
                    <div class="list-group-item  align-items-center <?php if(@$selected_dewey == $dewey["number"]) echo "active"; ?>">   
                    <?php $dewey_ = substr($dewey["number"],0,1)*100; ?>                 
                        <div class="row">
                            <div class="col-md-8 text-<?php echo MyAlign; ?>">                            
                                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <a href="<?php echo base_url(front_base."search/results/?dewies=".$dewey_) ?>"><?php echo $dewey["title"]; ?></a>                                            
                            </div>
                            <div class="col-md-4 text-<?php echo OppAlign; ?>">
                                <span class="badge badge-primary badge-pill "><i class="fa fa-eye"></i> <?php echo number_format($dewey["repeats"]); ?></span>
                               
                                <a target="_blank" href="<?php echo base_url(front_base."search/results/?dewies=".$dewey_) ?>"><i class="fa fa-search"></i></a>
                            </div>
                        
                        </div>
                    </div>

                <?php } ?>    
                            
                
            <?php } ?>
        
        <?php } ?>

    </div>
    
<?php } 