<script src="<?php echo no_protocol(base_url("assets/libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js")); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo no_protocol(base_url("assets/libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.css")); ?>">

<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base.ctrl()); ?>">رجوع</a>                
            </div>            
        </div>
    </div>     


    <?php echo form_open_multipart(base_url(admin_base.ctrl()."/".$method) , array("class" => "", "role" => "form")); ?>

        <div class="card-body">                   
                          
            <div class="form-group">
            
                <label>نوع القاعدة <span class="text-danger">*</span></label>
                
                <select class="form-control req_field" name="rule_rel_type">
                    
                    <optgroup label="بيانات السجلات">
                        <option <?php if(@$rule->rule_rel_type == "biblo_id" ){ echo 'selected = "selected"'; } ?> value="biblo_id">biblo_id رقم الكتاب</option>
                        <option <?php if(@$rule->rule_rel_type == "classification_id" ){ echo 'selected = "selected"'; } ?> value="classification_id">classification_id رقم التصنيف</option>
                        <option <?php if(@$rule->rule_rel_type == "source_id" ){ echo 'selected = "selected"'; } ?> value="source_id">source_id رقم المصدر</option>
                        <option <?php if(@$rule->rule_rel_type == "author_id" ){ echo 'selected = "selected"'; } ?> value="author_id">author_id رقم المؤلف</option>
                        <option <?php if(@$rule->rule_rel_type == "publisher_id" ){ echo 'selected = "selected"'; } ?> value="publisher_id">publisher_id رقم الناشر</option>
                        <option <?php if(@$rule->rule_rel_type == "years_range" ){ echo 'selected = "selected"'; } ?> value="years_range">years_range حيز سنوات النشر</option>
                    </optgroup>
                    
                    <optgroup label="بيانات المستخدم">
                        <option <?php if(@$rule->rule_rel_type == "ip_range" ){ echo 'selected = "selected"'; } ?> value="ip_range">ip_range نطاق آي بي</option>
                        <option <?php if(@$rule->rule_rel_type == "day_hours" ){ echo 'selected = "selected"'; } ?> value="day_hours">day_hours ساعات معينة بالنهار</option>
                        <option <?php if(@$rule->rule_rel_type == "week_days" ){ echo 'selected = "selected"'; } ?> value="week_days">week_days أيام معينة بالاسبوع</option>
                        <option <?php if(@$rule->rule_rel_type == "month_days" ){ echo 'selected = "selected"'; } ?> value="month_days">month_days أيام معينة بالشهر</option>
                        <option <?php if(@$rule->rule_rel_type == "u_ids" ){ echo 'selected = "selected"'; } ?> value="u_ids">u_ids مستخدمين محددين</option>
                    </optgroup>
                    
                </select>
                
            </div>                 
              
            <div class="form-group">
                <label>ال IDs  المطلوب تطبيق القاعدة عليها<span class="text-danger">*</span></label>
                <textarea class="form-control req_field ltr text-left" name="rule_rel_value"><?php echo @$rule->rule_rel_value ? $rule->rule_rel_value : ""; ?></textarea>
                <div class="alert alert-info">يتم الفصل بينها بعلامة الشرطة <b>-</b></div>
            </div>  

        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>           
        
                     
        <input type="hidden" name="type" id="type" value="<?php echo @$type; ?>" />        
        <input type="hidden" name="access_id" id="access_id" value="<?php echo @$access_id; ?>" />        
        <input type="hidden" name="rule_id" id="rule_id" value="<?php echo @$rule->rule_id; ?>" />        
                   

    <?php echo form_close(); ?>        



</div>

   