<div class="mt-4" id="free_access">

    <div class="jumbotron line-height-30">
      <h4 class="mb-3"><?php echo word("free_access") ?></h4>
      <h5 class="lead"><?php echo word("free_access_des") ?></h5>
    </div>

    <?php if(free_access){ ?>
    
        <?php $fa = $this->session->userdata("free_access"); ?>

        <div class="card">
            
            <div class="card-header">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("congratulations") ?>
            </div>
            
            <div class="card-body line-height-30">                
                
                <p>
                <?php echo word("have_free") ?>             
                    <br />                
                    <?php echo word("method_used") ?> <b><?php echo word("free_access_".$fa["method"]); ?></b>
                    <br />                        
                </p>
                
                <div class="mb-2">
                    <a class="btn btn-info rounded-0" href="<?php echo base_url(front_base."search"); ?>"><?php echo word("start_searching") ?></a>
                    <a href="<?php echo base_url(front_base."gateway/exit_free_access") ?>" class="btn btn-danger rounded-0"><?php echo word("stop_free_access") ?></a>                                                        
                                            
                </div>
                
            </div>

        </div>    
    
    
    <?php }else{ ?>

        <div class="card">
            
            <div class="card-header">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("first_method") ?>: <?php echo word("access_code") ?>
            </div>
            
            <div class="card-body line-height-30">
                            
                <?php if(logged_in && u_id){ ?>                            
                
                    <?php echo form_open( "access" , array("role" => "form",  "class"=>"inline check_submit", "release"=>"true") ); ?>
                           
                        <div class="form-group">
                            <label><?php echo word("place_code") ?><span class="text-danger">*</span></label>
                            <input type="text" class="form-control req_field" name="token" placeholder="<?php echo word("place_code") ?>">
                        </div>
                                                                   
                        <div class="mb-2">
                            <button type="submit" class="btn btn-info rounded-0"><?php echo word("free_access") ?></button>
                        </div>       
                        
                    <?php echo form_close(); ?>
                    
                <?php }else{ ?>
                        
                    <p>
                    <?php echo word("login_code_des") ?>
                    </p>
                                    
                    <div class="mb-2">
                        <a href="<?php echo base_url(front_base."login") ?>" class="btn btn-success rounded-0"><?php echo word("login") ?></a>                                                        
                        <a href="<?php echo base_url(front_base."join") ?>" class="btn btn-info rounded-0"><?php echo word("register") ?></a>                                                        
                    </div>  
                
                <?php } ?>
                        
            </div>

        </div>

        

        <div class="card mt-4">
            
            <div class="card-header">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("second_method") ?>: <?php echo word("ip_address_access") ?>
            </div>
            
            <div class="card-body line-height-30">
                            
                <p>
                <?php echo word("ip_address_is") ?> <code><?php echo $this->access->ip; ?></code>
                    <br />
                    <?php echo word("ip_number_des") ?>
                </p>

                <div class="mb-2">
                    <a href="<?php echo base_url("access") ?>" type="submit" class="btn btn-info rounded-0"><?php echo word("free_access") ?></a>
                </div>                
                        
            </div>

        </div>
        
        
        <div class="card mt-4">
            
            <div class="card-header">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("third_method") ?>: <?php echo word("country_access") ?>
            </div>
            
            <div class="card-body line-height-30">

                            
                <?php if(logged_in && u_id){ ?>                            
                
                    <p>
                    <?php echo word("country_free_access") ?>
                        <br>
                        <?php echo word("follow_announce") ?>
                    </p>

                    <div class="mb-2">
                        <a href="<?php echo base_url("access") ?>" type="submit" class="btn btn-info rounded-0"><?php echo word("free_access") ?></a>
                    </div>  
                    
                <?php }else{ ?>
                    
                    <p>
                    <?php echo word("country_free_des") ?>
                    </p>
                                    
                    <div class="mb-2">
                        <a href="<?php echo base_url(front_base."login") ?>" class="btn btn-success rounded-0"><?php echo word("login") ?></a>                                                        
                        <a href="<?php echo base_url(front_base."join") ?>" class="btn btn-info rounded-0"><?php echo word("register") ?></a>                                                        
                    </div>  
                
                <?php } ?>            
            
              
                 
            </div>
            
        </div>

    <?php } ?>
    

</div>
