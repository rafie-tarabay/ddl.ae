<?php echo form_open( "users/submit_step_1" , array("role" => "form",  "class"=>"inline dynamic_form") ); ?>
            
    <div class="form-group">
        <label><?php echo word("first_name") ?><span class="text-danger">*</span></label>
        <input type="text" class="form-control req_field" name="first_name" placeholder="<?php echo word("first_name") ?>">
    </div>

    <div class="form-group">
        <label><?php echo word("last_name") ?><span class="text-danger">*</span></label>
        <input type="text" class="form-control req_field" name="last_name" placeholder="<?php echo word("last_name") ?>">
    </div>

    <div class="form-group">
        <label><?php echo word("country") ?><span class="text-danger">*</span></label>
        <select class="form-control req_field" name="country" id="countries">
            <?php foreach($countries as $c){ ?>
                <option data-phone-code="<?php echo $c->country_phone_code; ?>" data-phone-example="<?php echo $c->country_phone_example; ?>" <?php if($c->country_code_ISO3 == $country) echo 'selected="selected"'; ?> value="<?php echo $c->country_code_ISO3; ?>"><?php echo $c->{"country_name_".locale}; ?></option>
            <?php } ?>
        </select>
    </div>               
                       
    <div class="form-group">
        <label><?php echo word("e_mail") ?><span class="text-danger">*</span></label>
        <input type="email" class="form-control req_field ltr text-<?php echo OppAlign; ?>" name="email" placeholder="name@example.com">
    </div>
               
    <div class="form-group">
        <label><?php echo word("mobile_number") ?><span class="text-danger">*</span></label>
        
        <div class="input-group mb-3">            
            <?php if(style_dir == "ltr"){ ?>            
                <div class="input-group-prepend ltr text-left">
                    <span class="input-group-text" id="basic-addon1">+<span id="mobile_country_code">971</span></span>
                </div>            
                <input type="text" class="form-control req_field ltr text-left" name="mobile" id="mobile" placeholder="52910XXXX">                
            <?php }else{ ?>            
                <input type="text" class="form-control req_field ltr text-left" name="mobile" id="mobile" placeholder="52910XXXX">            
                <div class="input-group-append ltr text-left">
                    <span class="input-group-text" id="basic-addon1">+<span id="mobile_country_code">971</span></span>
                </div>                                        
            <?php } ?>
        </div>        
    </div>
    
    <div class="mb-2">
        <button type="submit" class="btn btn-info rounded-0"><?php echo word("next_step") ?></button>
    </div>       
    
<?php echo form_close(); ?>


<script> 
    $( document ).ready(function() {               
        $("#countries").on("change",function(){
            var phone_code = $(this).find(':selected').data('phone-code');
            var phone_example = $(this).find(':selected').data('phone-example');
            $("#mobile_country_code").text(phone_code);
            $("#mobile").attr("placeholder",phone_example);
        });
    });
    
</script>