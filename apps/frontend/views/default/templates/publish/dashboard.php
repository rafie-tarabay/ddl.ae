<div class="card card-default mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                  <h5 class="mt-1 mb-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $title; ?></h5>
            </div>
            <div class="col-md-6 text-<?php echo OppAlign; ?>">
                <a class="btn btn-success  btn-sm" href="<?php echo base_url("publishing/add_corporate") ?>"><i class="fa fa-university"></i> <?php echo word("add_corporate") ?></a>
                <a class="btn btn-success  btn-sm" href="<?php echo base_url("publishing/add_author") ?>"><i class="fa fa-user"></i> <?php echo word("add_author") ?></a>
                <a class="btn btn-info btn-sm" href="<?php echo base_url("publishing/create") ?>"><?php echo word("add_publish_request") ?></a>            
            </div>        
        </div>
    </div>
</div>

<div class="row">
    
    <div class="col-md-4">
            
        <div class="card card-default mt-3">
            <div class="card-header">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("publish_requests"); ?>
            </div>
            <?php if($requests){ ?>
                
                <div class="list-group">
                    
                    <?php foreach($requests as $request){ ?>
                        
                        <div class="list-group-item line-height-30">
                            <div>
                                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <b><?php echo word("title"); ?></b>: <?php echo $request->req_material_title ?>
                            </div>                            
                            <div>
                                <span class="small text-info"><?php echo word($request->req_status) ?></span>
                            </div>                                                
                        </div>
                    
                    <?php } ?>
                    
                </div>
                            
            <?php }else{ ?>
                <div class="card-body text-center">
                    <h3 class="text-muted"><?php echo word("no_requests"); ?></h3>
                    <a class="btn btn-info" href="<?php echo base_url("publishing/create") ?>"><?php echo word("add_publish_request") ?></a>
                </div>
            <?php } ?>
        </div>    
    
    </div>
    
    <div class="col-md-4">
    
        <div class="card card-default mt-3">
            <div class="card-header">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("authors_list"); ?>
            </div>
            <?php if($authors){ ?>
                
                <div class="list-group">
                    
                    <?php foreach($authors as $author){ ?>
                        
                        <div class="list-group-item line-height-30">                                
                            <div>
                                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <b><?php echo word("name"); ?></b>: <?php echo $author->author_name; ?>
                            </div>
                            <div>
                                <span class="small text-info"><?php echo word($author->author_status) ?></span>
                            </div>
                        </div>
                    
                    <?php } ?>
                    
                </div>
                            
            <?php }else{ ?>
                <div class="card-body text-center">
                    <h3 class="text-muted"><?php echo word("no_authors"); ?></h3>
                    <a class="btn btn-success" href="<?php echo base_url("publishing/add_author") ?>"><?php echo word("add_author") ?></a>
                </div>
            <?php } ?>
        </div>       
    
    </div>    

    

    <div class="col-md-4">
    
        <div class="card card-default mt-3">
            <div class="card-header">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("corps_list"); ?>
            </div>
            <?php if($corporates){ ?>
                
                <div class="list-group">
                    
                    <?php foreach($corporates as $corp){ ?>
                        
                        <div class="list-group-item line-height-30">                        
                            <div>
                                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i>  <b><?php echo word("corp_name"); ?></b>: <?php echo $corp->corp_name; ?>
                            </div>                            
                            <div>
                                <span class="small text-info"><?php echo word($corp->corp_status) ?></span>
                            </div>                        
                        </div>
                    
                    <?php } ?>
                    
                </div>
                            
            <?php }else{ ?>
                <div class="card-body text-center">
                    <h3 class="text-muted"><?php echo word("no_corporates"); ?></h3>
                    <a class="btn btn-success" href="<?php echo base_url("publishing/add_corporate") ?>"><?php echo word("add_corporate") ?></a>
                </div>
            <?php } ?>
        </div>       
    
    </div>    
    
    
</div>