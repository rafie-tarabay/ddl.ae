<div class="card card-default mt-4" id="join_wizard">
    
    <div class="card-header text-center">
        <div class="row no-gutters">            
            <div class="col-12 col-md-3 <?php if($step != "step_1") echo "d-md-block d-none"; ?>">
                <div class="step_box <?php echo $step == "step_1" ? 'active text-info' : "text-muted d-md-block d-none"; ?>">
                    <h5><?php echo word("first_step") ?></h5>
                    <h6><?php echo word("first_step_desc") ?></h6>
                </div>
            </div>
            <div class="col-12 col-md-3 <?php if($step != "step_2") echo "d-md-block d-none"; ?>">
                <div class="step_box <?php echo $step == "step_2" ? 'active text-info' : "text-muted d-md-block d-none"; ?>">
                    <h5><?php echo word("second_step") ?></h5>
                    <h6><?php echo word("second_step_desc") ?></h6>
                </div>            
            </div>            
            <div class="col-12 col-md-3 <?php if($step != "step_3") echo "d-md-block d-none"; ?>">
                <div class="step_box <?php echo $step == "step_3" ? 'active text-info' : "text-muted d-md-block d-none"; ?>">
                    <h5><?php echo word("third_step") ?></h5>
                    <h6><?php echo word("third_step_desc") ?></h6>
                </div>
            </div>
            <div class="col-12 col-md-3 <?php if($step != "step_4") echo "d-md-block d-none"; ?>">
                <div class="step_box <?php echo $step == "step_4" ? 'active text-info' : "text-muted d-md-block d-none"; ?>">
                    <h5><?php echo word("fourth_step") ?></h5>
                    <h6><?php echo word("fourth_step_desc") ?></h6>
                </div>                        
            </div>                        
        </div>
    </div>
    
    <div class="card-body">
    
        <?php if($step == "step_1"){ ?>
            
            <?php $this->load->view(style.'/templates/users/forms/register_step_1'); ?>            
            
        <?php }else{ ?>
        
            <div class="row">
                
                <div class="col-12 col-md-8">
                    <?php $this->load->view(style.'/templates/users/forms/register_'.$step); ?>
                </div>
                
                <div class="col-12 col-md-4">

                    <div class="list-group">
                        <div class="list-group-item bg-gray">
                            
                            <label class="text-muted small"><?php echo word("first_name") ?></label>
                            <h6><?php echo $user->first_name; ?></h6>
                            
                            <label class="text-muted small"><?php echo word("last_name") ?></label>
                            <h6><?php echo $user->last_name; ?></h6>
                                                        
                            <label class="text-muted small"><?php echo word("country") ?></label>
                            <h6><?php echo $user->country_name_ar; ?></h6>
                            
                            <label class="text-muted small"><?php echo word("e_mail") ?></label>                            
                            <h6>
                                <i class="fas <?php echo $user->email_verified ? 'fa-check text-success' : 'fa-exclamation-circle text-warning'; ?>"></i>
                                <?php echo $user->email; ?>
                            </h6>
                                                    
                            <?php if(!is_null($user->mobile)){ ?>
                                <label class="text-muted small">mobile_number</label>
                                <h6>
                                    <i class="fas <?php echo !$user->mobile_verified && $user->country == "ARE" ? 'fa-exclamation-circle text-warning' : 'fa-check text-success'; ?>"></i>
                                    <code>+<?php echo $user->country_phone_code; ?></code> <?php echo $user->mobile; ?>
                                </h6>                  
                            <?php } ?>
                            
                        </div>
                    </div>

                </div>
                
            </div>
            
        <?php } ?>
        
    </div>
    
</div>
