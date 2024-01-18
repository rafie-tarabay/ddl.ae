<div class="mt-4">

    <div class="card card-default">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 line-height-30">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("my_profile") ?>
                </div>
                <div class="col-md-6 text-<?php echo OppAlign; ?> ">
                    <?php if(u_id == $user->u_id){ ?>
                        <a class="btn btn-success btn-sm" href="<?php echo base_url("profile/edit"); ?>"><i class="fa fa-pencil-alt"></i> <?php echo word("edit") ?></a>
                    <?php } ?>
                </div>
            </div>        
        </div>
    </div>
    
    
    <div class="mt-4">
    
        <div class="row">
            
            <div class="col-12 col-md-4">
            
                <div class="card card-default">
                
                    <div class="card-body">
                    
                        <img class="img-thumbnail img-fluid w-100" src="<?php echo user_photo($user); ?>"  alt="<?php echo word("image") ?>"/>
                    
                    </div>
                
                </div>
            
            </div>
                                
            <div class="col-12 col-md-8">
            
                <div class="card card-default">
                
                    <div class="card-body">
                                        
                        <div class="list-group list-group-flush">
                            
                            <div class="list-group-item">
                                <?php echo word("full_name") ?>: <?php echo $user->u_fullname; ?>
                            </div>
                            
                            <div class="list-group-item">
                                <?php echo word("date_of_birth") ?>: <?php echo $user->u_birthdate; ?>
                            </div>
                            
                            <div class="list-group-item">
                                <?php echo word("country") ?>: <?php echo $user->country->country_name_ar; ?>
                            </div>                                                        
                                                             
                            <?php if(@$user->knowledge_field){ ?>                                                                        
                                <div class="list-group-item">
                                    <?php echo word("knowledge_area") ?>: <?php echo $user->knowledge_field->field_title_ar; ?>
                                </div>                                                        
                            <?php } ?>
                                                                                                    
                            <?php if(@$user->specialization){ ?>                                                                        
                                <div class="list-group-item">
                                    <?php echo word("specialization") ?>: <?php echo $user->specialization->field_title_ar; ?>
                                </div>                                                        
                            <?php } ?>
                                     
                            <?php if(@$user->educational_institute){ ?>                                                                        
                                <div class="list-group-item">
                                    <?php echo word("educational_institute") ?>: <?php echo $user->educational_institute; ?>
                                </div>                                                                                              
                            <?php } ?>
                                                        
                            <div class="list-group-item">
                                <?php echo word("registration_date") ?>: <?php echo date("Y-m-d",$user->u_reg_time); ?>
                            </div>                                                        
                                                                                    
                            <div class="list-group-item">
                                <?php echo word("last_activity") ?>: <?php echo date("Y-m-d",$user->u_lastvisit); ?>
                            </div>                                                        
                            
                        </div>                    
                    
                    </div>  
                
                </div>
            
            </div>
            
        </div>
    
    </div>
    

</div>