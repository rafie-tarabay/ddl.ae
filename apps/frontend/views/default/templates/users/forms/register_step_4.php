<?php echo form_open( "users/submit_step_4" , array("role" => "form",  "class"=>"inline dynamic_form") ); ?>

                       
    <!-- // https://en.wikipedia.org/wiki/International_Standard_Classification_of_Education -->                       
    <div class="form-group">
        <label><?php echo word("educational_level") ?><span class="text-danger">*</span></label>
        <select class="form-control req_field" name="educational_level">
            <?php foreach($edu_levels as $level){ ?>
                <option value="<?php echo $level->level_name ?>"><?php echo $level->{"level_title_".locale} ?></option>           
            <?php } ?>  
        </select>
    </div>
    
                               
    <div class="form-group">
        <label><?php echo word("name_of_institution") ?><span class="text-danger">*</span></label>
        <input type="text" class="form-control req_field" name="educational_institute" placeholder="<?php echo word("name_of_institution") ?>">
    </div>
    
    <div class="form-group">
        <label><?php echo word("knowledge_area") ?><span class="text-danger">*</span></label>
        <select class="form-control req_field" name="knowledge_field">            
            <?php foreach($know_fields as $field){ ?>
                <option value="<?php echo $field->field_dewey ?>"><?php echo $field->field_dewey."- ".$field->{"field_title_".locale} ?></option>           
            <?php } ?>  
        </select>
    </div>
        
    <div class="form-group">
        <label><?php echo word("specialization") ?><span class="text-danger">*</span></label>
        <select class="form-control req_field" name="specialization">            
            <?php foreach($specials as $field){ ?>
                <option value="<?php echo $field->field_dewey ?>"><?php echo $field->field_dewey."- ".$field->{"field_title_".locale} ?></option>           
            <?php } ?>  
        </select>
    </div>

    <input type="hidden" name="reference" value="<?php echo $user->reference; ?>" />

    <div class="mb-2">
        <button type="submit" class="btn btn-info rounded-0"><?php echo word("finish") ?></button>
    </div>       
    
<?php echo form_close(); ?>