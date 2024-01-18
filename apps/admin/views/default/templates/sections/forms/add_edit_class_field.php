<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()."/content_classes"); ?>">الرجوع</a>                                
            </div>            
        </div>
    </div> 




    <?php 
        if(@$field->f_id){
            $func = "update_class_field";            
        }else{
            $func = "insert_class_field";            
        }    
    ?>


    <?php echo form_open_multipart(base_url(admin_base."sections/$func") , array("class" => "form-horizontal", "role" => "form")); ?>

        <div class="card-body">     
        
                                    
            <div class="form-group">
                <label>Field Name</label>
                <input  class="form-control" name="f_name" value="<?php echo @$field->f_name; ?>" />
                <div class="alert alert-info">حروف انجليزية بدون أي مسافات</div>
            </div>

            <div class="form-group">
                <label>Mandatory</label>
                <select name="f_required" class="form-control">
                    <option value="1" <?php if(@$field->f_required == 1 ){ echo 'selected = "selected"'; } ?>>نعم</option>
                    <option value="0" <?php if(@$field->f_required == 0 ){ echo 'selected = "selected"'; } ?>>لا</option>
                </select>                
            </div>          
                                  

            <div class="form-group">
                <label>نوع الحقل</label>
                <select name="f_element" class="form-control">
                    <option value="input" <?php if(@$field->f_element == "input" ){ echo 'selected = "selected"'; } ?>>input</option>
                    <option value="textarea" <?php if(@$field->f_element == "textarea" ){ echo 'selected = "selected"'; } ?>>textarea</option>                    
                    <option value="editor" <?php if(@$field->f_element == "editor" ){ echo 'selected = "selected"'; } ?>>editor</option>                    
                    <option value="select" <?php if(@$field->f_element == "select" ){ echo 'selected = "selected"'; } ?>>select</option>                    
                </select>                
            </div>          
                                  
            <div class="form-group">
                <label>خيارات Select</label>
                <input  class="form-control" name="f_selectables" value="<?php echo @$field->f_selectables; ?>" />
                <div class="alert alert-info">افصل بين الخيارات بعلامة#x#</div>
            </div>
                                    
            <div class="form-group">
                <label>ترتيب الحقل</label>
                <input  class="form-control" name="f_order" value="<?php echo @$field->f_order; ?>" />
            </div>
                                  
                                  
            <input type="hidden" name="f_class_name" value="<?php echo @$field->f_class_name ? $field->f_class_name : $class; ?>" />
            <input type="hidden" name="f_id" value="<?php echo @$field->f_id; ?>" />
            

        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>

     