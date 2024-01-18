<script src="<?php echo no_protocol(base_url("assets/libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js")); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo no_protocol(base_url("assets/libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.css")); ?>">

<?php echo form_open( "users/submit_step_3" , array("role" => "form",  "class"=>"inline dynamic_form") ); ?>
       
    <div class="form-group">
        <label><?php echo word("username") ?><span class="text-danger">*</span></label>
        <small class="form-text text-muted mb-1 mt-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("username_desc"); ?></small>                  
        <input type="text" class="form-control req_field" name="username" placeholder="<?php echo word("username") ?>">
    </div>
                   
    <div class="form-group">
        <label><?php echo word("password") ?><span class="text-danger">*</span></label>
        <small class="form-text text-muted mb-1 mt-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("password_des"); ?></small>                  
        <input type="password" class="form-control req_field" name="password" placeholder="<?php echo word("password") ?>">      
    </div>      
    
    <div class="row">
    
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label><?php echo word("gender") ?><span class="text-danger">*</span></label>
                <select class="form-control req_field" name="gender">
                    <option value="male"><?php echo word("male") ?></option>
                    <option value="female"><?php echo word("female") ?></option>
                </select>
            </div>                         
        </div>
        
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label><?php echo word("date_of_birth") ?><span class="text-danger">*</span></label>
                <input type="text" class="form-control req_field ltr text-left datepicker" name="birthdate" placeholder="MM/DD/YYYY">
            </div>                
        </div>
    
    </div>
                           
    <div class="form-group">
        <label><?php echo word("address") ?><span class="text-danger">*</span></label>
        <input type="text" class="form-control req_field" name="billing_address" placeholder="<?php echo word("address") ?>">
    </div>
    
        
    <input type="hidden" name="reference" value="<?php echo $user->reference; ?>" />

    <div class="mb-2">
        <button type="submit" class="btn btn-info rounded-0"><?php echo word("next_step") ?></button>
    </div>       
    
<?php echo form_close(); ?>


<script>
    $( function() {
        $( ".datepicker" ).datepicker({
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "1930:<?php echo date("Y" , strtotime("-5 years")) ?>",
            defaultDate: "-20y"
        });
    } );
</script>