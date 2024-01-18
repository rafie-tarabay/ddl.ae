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
                <label>القسم <span class="text-danger">*</span></label>
                <select class="form-control req_field" name="topic_section_id">
                    <?php foreach($sections as $section){ ?>
                        <option <?php if(@$section->section_id == @$section_id || @$section->section_id == @$topic->topic_section_id ){ echo 'selected = "selected"'; } ?> value="<?php echo $section->section_id ?>"><?php echo $section->section_title_ar ?></option>
                    <?php } ?>
                </select>
            </div>  
            
            <div class="form-group">
                <label>عنوان الموضوع عربي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="topic_title_ar" value="<?php echo @$topic->topic_title_ar ?>" />
            </div>    
            
            <div class="form-group">
                <label>عنوان الموضوع انجليزي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="topic_title_en" value="<?php echo @$topic->topic_title_en ?>" />
            </div>                          
                   
            <div class="form-group">
                <label>وصف الموضوع عربي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="topic_desc_ar" value="<?php echo @$topic->topic_desc_ar ?>" />
            </div>                 
                   
            <div class="form-group">
                <label>وصف الموضوع انجليزي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="topic_desc_en" value="<?php echo @$topic->topic_desc_en ?>" />
            </div>                 
                                                    
            <div class="form-group">
                <label>الكلمات المفتاحية عربي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="topic_keywords_ar" value="<?php echo @$topic->topic_keywords_ar ?>" />
            </div>   
                            
            <div class="form-group">
                <label>الكلمات المفتاحية انجليزي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="topic_keywords_en" value="<?php echo @$topic->topic_keywords_en ?>" />
            </div> 
                                                            
            <div class="form-group">
                <label>المحتوى عربي<span class="text-danger">*</span></label>
                <textarea class="form-control editor" name="topic_text_ar"><?php echo @$topic->topic_text_ar ?></textarea>
            </div>       
                                             
            <div class="form-group">
                <label>المحتوى انجليزي<span class="text-danger">*</span></label>
                <textarea class="form-control editor" name="topic_text_en"><?php echo @$topic->topic_text_en ?></textarea>
            </div>                 
              
                                        
            <div class="form-group">
                <label>الترتيب <span class="text-danger">*</span></label>
                <input class="form-control req_field" name="topic_order" value="<?php echo @$topic->topic_order ?>" />
            </div>                 
                          
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>           
        
                     
        <input type="hidden" name="topic_id" id="topic_id" value="<?php echo @$topic->topic_id; ?>" />        
                   

    <?php echo form_close(); ?>        



</div>
