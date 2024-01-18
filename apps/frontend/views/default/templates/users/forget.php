<div class="row mt-4">

    <div class="col-12 col-md-8">  
        
        <div class="card">
            
            <?php if($step == 1){ ?>
            
                <div class="card-header">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("forget_password") ?>
                </div>
                
                <div class="card-body">
                                
                    <?php echo form_open( base_url("users/forget_password_submit") , array("role" => "form",  "class"=>"inline dynamic_form") ); ?>
                           
                        <div class="form-group">
                            <label><?php echo word("e_mail") ?><span class="text-danger">*</span></label>
                            <input type="email" class="form-control req_field" name="email" placeholder="<?php echo word("e_mail") ?>">
                        </div>

                        <div class="mb-2">
                            <button type="submit" class="btn btn-info rounded-0"><?php echo word("next_step") ?></button>
                        </div>       
                        
                    <?php echo form_close(); ?>
                            
                </div>
            
            <?php }elseif($step == 2){ ?>
            
            
                <div class="card-header">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("reset_password") ?>
                </div>
                
                <div class="card-body">
                                
                    <?php echo form_open( base_url("users/reset_password_submit") , array("role" => "form",  "class"=>"inline dynamic_form") ); ?>
              
                        <div class="form-group">
                        
                            <div class="row">
                                <div class="col">
                                <label><?php echo word("password_code") ?><span class="text-danger">*</span></label>
                                </div>
                                <div class="col text-<?php echo OppAlign; ?>">
                                    <small class="form-text text-muted">
                                    <?php echo word("no_code") ?>  <a href="<?php echo base_url(front_base."forget-password/") ?>"><?php echo word("no_code_req") ?> </a>
                                    </small>
                                </div>                    
                            </div>            

                            <input type="text" class="form-control req_field" name="code" value="<?php echo isset($code) ? $code : "";  ?>" placeholder="<?php echo word("password_code") ?>" autocomplete="off">
                           
                            
                        </div>                        
                                                                                  
                        <div class="form-group">
                            <label><?php echo word("new_password") ?> <span class="text-danger">*</span></label>
                            <small class="form-text text-muted mb-1 mt-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("password_des") ?></small>                  
                            <input type="password" class="form-control req_field" name="new_password" placeholder="<?php echo word("new_password") ?>">      
                        </div> 

                        <div class="mb-2">
                            <button type="submit" class="btn btn-info rounded-0"><?php echo word("save") ?></button>
                        </div>       
                        
                    <?php echo form_close(); ?>
                            
                </div>            
            
            
            <?php } ?>
        
        </div>
        

    </div>
    
    <div class="col-12 col-md-4">
    
        <div class="card">
            
            <div class="card-header">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("welcome_msg") ?>
            </div>
            
            <div class="card-body line-height-30">
                
            <?php echo word("another_welcome") ?>
                <br>
                <?php echo word("first_visit") ?>
                <a href="<?php echo base_url("faq") ?>"><?php echo word("faqs") ?></a>
                <?php echo word("learn_more") ?>
                        
            </div>
            
            <div class="list-group list-group-flush">
                <a class="list-group-item" href="<?php echo base_url("join") ?>"><?php echo word("register") ?></a>                
                <a class="list-group-item" href="<?php echo base_url("login") ?>"><?php echo word("login") ?></a>
            </div>
        
        </div>
        
    </div>    

</div>