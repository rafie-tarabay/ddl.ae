<div class="row mt-4">

    <div class="col-12 col-md-8">
        
        <div class="card">
            
            <div class="card-header">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("login") ?>
            </div>
            
            <div class="card-body">
                            
                <?php echo form_open( base_url("users/login_submit") , array("role" => "form",  "class"=>"inline dynamic_form") ); ?>
                       
                    <div class="form-group">
                        <label><?php echo word("e_mail") ?> <?php echo word("or") ?> <?php echo word("username") ?><span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field" name="username" placeholder="<?php echo word("e_mail") ?>/ <?php echo word("username") ?>">
                    </div>
                                   
                    <div class="form-group">
                        <label><?php echo word("password") ?> <span class="text-danger">*</span></label>
                        <input type="password" class="form-control req_field" name="password" placeholder="<?php echo word("password") ?>">      
                    </div>      
                          
                    <div class="mb-2">
                        <button type="submit" class="btn btn-info rounded-0"><?php echo word("login") ?></button>
                    </div>       
                    
                <?php echo form_close(); ?>
                        
            </div>
        
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
                <a href="<?php echo base_url("faq") ?>"><?php echo word("fags") ?></a>
                <?php echo word("learn_more") ?>
                        
            </div>
            
            <div class="list-group list-group-flush">
                <a class="list-group-item" href="<?php echo base_url("join") ?>"><?php echo word("register") ?></a>                
                <a class="list-group-item" href="<?php echo base_url("forget-password") ?>"><?php echo word("reset_password") ?></a>
            </div>
        
        </div>
        
    </div>
    
</div>

          