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
                <label>عنوان القسم عربي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="section_title_ar" value="<?php echo @$section->section_title_ar ?>" />
            </div>                 
                                               
            <div class="form-group">
                <label>عنوان القسم انجليزي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="section_title_en" value="<?php echo @$section->section_title_en ?>" />
            </div>                 
                                        
            <div class="form-group">
                <label>وصف القسم  عربي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="section_desc_ar" value="<?php echo @$section->section_desc_ar ?>" />
            </div>                 
                                                            
            <div class="form-group">
                <label>وصف القسم  انجليزي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="section_desc_en" value="<?php echo @$section->section_desc_en ?>" />
            </div>                 
                                                      
            <div class="form-group">
                <label>الكلمات المفتاحية عربي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="section_keywords_ar" value="<?php echo @$section->section_keywords_ar ?>" />
            </div>                               
                                                                               
            <div class="form-group">
                <label>الكلمات المفتاحية انجليزي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="section_keywords_en" value="<?php echo @$section->section_keywords_en ?>" />
            </div>                               
                                        
            <div class="form-group">
                <label>الترتيب <span class="text-danger">*</span></label>
                <input class="form-control req_field" name="section_order" value="<?php echo @$section->section_order ?>" />
            </div>                 
              
                
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>           
        
                     
        <input type="hidden" name="section_id" id="section_id" value="<?php echo @$section->section_id; ?>" />        
                   

    <?php echo form_close(); ?>        



</div>


           