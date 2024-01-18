<script src="<?php echo no_protocol(base_url("assets/libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js")); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo no_protocol(base_url("assets/libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.css")); ?>">

<div class="card card-default mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 line-height-30">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("edit_profile") ?>
            </div>
            <div class="col-md-6 text-<?php echo OppAlign; ?> ">
                <a class="btn btn-success btn-sm" href="<?php echo base_url("profile"); ?>"><?php echo word("my_profile") ?> <i class="fa fa-arrow-<?php echo OppAlign; ?>"></i></a>
            </div>
        </div>        
    </div>

    <?php echo form_open_multipart( "profile/update_profile" , array("role" => "form",  "class"=>"inline check_submit", "release"=>"true") ); ?>

        <div class="card-body">
        
            <div class="row">
                
                <div class="col-12 col-md-9">
                
                    <div class="row">
                                  
                        <div class="col-12">
                            <div class="form-group">
                                <label for="u_fullname"><?php echo word("fullname") ?><span class="text-danger">*</span></label>
                                <input type="text" class="form-control req_field" id="u_fullname" name="u_fullname" value="<?php echo $user->u_fullname; ?>" />
                            </div>
                        </div>            
                                                      
                                                                            
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label><?php echo word("country") ?><span class="text-danger">*</span></label>
                                <select class="form-control req_field" name="country" id="countries">
                                    <?php foreach($countries as $c){ ?>
                                        <option data-phone-code="<?php echo $c->country_phone_code; ?>" data-phone-example="<?php echo $c->country_phone_example; ?>" <?php if($c->country_code_ISO3 == $user->u_country_code) echo 'selected="selected"'; ?> value="<?php echo $c->country_code_ISO3; ?>"><?php echo $c->{"country_name_".locale}; ?></option>
                                    <?php } ?>
                                </select>
                            </div>                               
                        </div>            
                                 
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label><?php echo word("national_id") ?></label>
                                <input type="text" class="form-control ltr text-left" name="u_emirates_id" id="u_emirates_id" value="<?php echo $user->u_emirates_id; ?>">
                            </div>                
                        </div>                        
                                                                
                                                                    
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="u_mobile"><?php echo word("mobile") ?><span class="text-danger">*</span></label>
                                <div class="input-group">            
                                    <?php if(style_dir == "ltr"){ ?>            
                                        <div class="input-group-prepend ltr text-left">
                                            <span class="input-group-text" id="basic-addon1">+<span id="mobile_country_code">971</span></span>
                                        </div>            
                                        <input type="text" class="form-control req_field ltr text-left" name="u_mobile" id="u_mobile" placeholder="52910XXXX" value="<?php echo $user->u_mobile ?>">                
                                    <?php }else{ ?>            
                                        <input type="text" class="form-control req_field ltr text-left" name="u_mobile" id="u_mobile" placeholder="52910XXXX" value="<?php echo $user->u_mobile ?>">            
                                        <div class="input-group-append ltr text-left">
                                            <span class="input-group-text" id="basic-addon1">+<span id="mobile_country_code">971</span></span>
                                        </div>                                        
                                    <?php } ?>
                                </div>
                            </div>
                        </div> 
                        
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label><?php echo word("gender") ?><span class="text-danger">*</span></label>
                                <select class="form-control req_field" name="u_gender" id="u_gender">
                                    <option value="male" <?php if($user->u_gender == "male") echo 'selected="selected"'; ?>><?php echo word("male") ?></option>
                                    <option value="female" <?php if($user->u_gender == "female") echo 'selected="selected"'; ?>><?php echo word("female") ?></option>
                                </select>
                            </div>                                 
                        </div>  
                                                
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label><?php echo word("date_of_birth") ?><span class="text-danger">*</span></label>
                                <input type="text" class="form-control req_field ltr text-left datepicker" name="u_birthdate" placeholder="MM/DD/YYYY" value="<?php echo $user->u_birthdate; ?>">
                            </div>                
                        </div>                        
    
                    </div>
                    
                      
                    <div class="alert alert-light border mt-3">
                        <h5 class="alert-heading"><i class="fa fa-info-circle"></i> <?php echo word("additional_info"); ?></h5>
                                                
                        <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo word("educational_level") ?><span class="text-danger">*</span></label>
                                    <select class="form-control req_field" name="educational_level">
                                        <?php foreach($edu_levels as $level){ ?>
                                            <option <?php if($level->level_name == $user->educational_level) echo 'selected="selected"'; ?> value="<?php echo $level->level_name ?>"><?php echo $level->{"level_title_".locale} ?></option>           
                                        <?php } ?>  
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo word("name_of_institution") ?><span class="text-danger">*</span></label>
                                    <input type="text" class="form-control req_field" name="educational_institute" placeholder="<?php echo word("name_of_institution") ?>" value="<?php echo $user->educational_institute ?>">
                                </div>
                            </div>


                            <div class="col-12 col-md-6">                        
                                <div class="form-group">
                                    <label><?php echo word("knowledge_area") ?><span class="text-danger">*</span></label>
                                    <select class="form-control req_field" name="knowledge_field">            
                                        <?php foreach($know_fields as $field){ ?>
                                            <option <?php if($field->field_dewey == $user->knowledge_field) echo 'selected="selected"'; ?> value="<?php echo $field->field_dewey ?>"><?php echo $field->field_dewey."- ".$field->{"field_title_".locale} ?></option>           
                                        <?php } ?>  
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-6">                            
                                <div class="form-group">
                                    <label><?php echo word("specialization") ?><span class="text-danger">*</span></label>
                                    <select class="form-control req_field" name="specialization">            
                                        <?php foreach($specials as $field){ ?>
                                            <option <?php if($field->field_dewey == $user->specialization) echo 'selected="selected"'; ?> value="<?php echo $field->field_dewey ?>"><?php echo $field->field_dewey."- ".$field->{"field_title_".locale} ?></option>           
                                        <?php } ?>  
                                    </select>
                                </div>    
                            </div>    
        
             
                        </div>                
                    
                    </div>
                
                    <div class="alert alert-light border mt-3">
                        <h5 class="alert-heading"><i class="fa fa-key"></i> <?php echo word("changing_password"); ?></h5>
                        <div class="row">

                            <div class="col-12 col-sm-6">

                                <div class="form-group">
                                    <label for="u_password"><?php echo word("password") ?></label>
                                    <input type="password" class="form-control" id="u_password" name="u_password" />
                                </div>

                            </div> 

                            <div class="col-12 col-sm-6">

                                <div class="form-group">
                                    <label for="u_password_again"><?php echo word("password_again") ?></label>
                                    <input type="password" class="form-control" id="u_password_again" name="u_password_again" />
                                </div>

                            </div> 

                        </div> 
                    </div>          
                
                
                </div>
                            
                <div class="col-12 col-md-3">            
                    
                    <img class="img-thumbnail img-fluid w-100" src="<?php echo user_photo($user); ?>"  alt="<?php echo word("image") ?>"/>

                    <div class="form-group mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary fake-upload" type="button" data-placeholder="u_photo_placeholder" data-target="u_photo"><?php echo word("select_file") ?></button>
                            </div>
                            <input type="text" class="form-control req_field" readonly="readonly" id="u_photo_placeholder">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" title="JPG,PNG,JPEG<br>Max.size: 512KB<br>Width: 128px<br>Height: 128px" rel="tooltip"><i class="fa fa-info-circle"></i></button>                                
                            </div>                                                                                                        
                        </div>                        
                        <input type="file" name="u_photo" id="u_photo" class="d-none" />
                    </div>                    
                    
                </div>
                                    

            </div>            
                    
        </div>
        
        
        <div class="card-footer text-<?php echo OppAlign; ?>">
            <button type="submit" class="btn btn-success"><?php echo word("edit") ?></button>
        </div>
        
  
    <?php echo form_close(); ?>


</div>
              
<script> 
    $( document ).ready(function() {               
        $("#countries").on("change",function(){
            var phone_code = $(this).find(':selected').data('phone-code');
            var phone_example = $(this).find(':selected').data('phone-example');
            $("#mobile_country_code").text(phone_code);
            $("#u_mobile").attr("placeholder",phone_example);
        }).change();
        
        
        $( function() {
            $( ".datepicker" ).datepicker({
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "1930:<?php echo date("Y" , strtotime("-5 years")) ?>",
                defaultDate: "-20y"
            });
        } );        
        
    });
    

    
</script>