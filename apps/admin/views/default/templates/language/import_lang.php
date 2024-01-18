<div class="alert alert-danger"><i class="fa fa-warning"></i> هذه الخاصية متقدمة , فضلاً لا تقوم بالتعديل أو الإضافة إلا إذا كنت تعرف ما تفعله</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            
            <div class="col-md-6 no-padding text-left">        
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)) ?>" ><i class="fa fa-language"></i> اللغات</a>                
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/words") ?>" ><i class="fa fa-sort-alpha-asc"></i> العبارات</a>                                
            </div>                        
          
        </div>
    </div>   
    


    <?php echo form_open_multipart( base_url(admin_base."language/upload") , array("role" => "form") ); ?>

        <div class="card-body">                                                                          

            <div class="alert alert-warning2"><i class="fa fa-warning"></i> ينصح بأخذ نسخه إحتياطية من الملف الحالي قبل إستبداله [ <a href="<?php echo base_url(admin_base."language/download/".$lang->lang_alias); ?>"><i class="fa fa-download"></i> تحميل نسخة إحتياطية</a> ]</div>
        
            <div class="form-group">
                <label for="file" class="control-label">اختر الملف<span class="mandatory">*</span></label>
                <div class="media no-margin">
                    <div class="media-body">                                     
                        <div class="file-container btn btn-primary" rel="tooltip" title="يجب أن يكون الملف بإمتداد .json فقط">
                            <small class="tahoma-font">اختيار ملف لغة [ <?php echo $lang->lang_title; ?> ]</small>
                            <input type="file" name="file" id="file" autocomplete="off" />                                
                        </div>
                    </div>
                </div>                    
            </div>    
                   
        </div>
        
        <input type="hidden" name="lang_alias" id="lang_alias" value="<?php echo $lang->lang_alias; ?>" autocomplete="off" />                                
        
        <div class="card-footer"  style="text-align: left;">
            <button type="submit" class="btn btn-success">رفع</button>
        </div>

    <?php echo form_close(); ?>

</div>



