<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">

            </div>            
        </div>
    </div>         
    


    <?php echo form_open_multipart(base_url(admin_base."settings/update_main") , array("class" => "form-horizontal", "role" => "form")); ?>
  

        <div class="card-body">

        
            <div class="form-group">
                <label for="site_offline" class="col-lg-3 control-label">وضع الصيانة</label>
                <div class="col-lg-8">
                    <select name="site_offline" id="site_offline" class="form-control"  autocomplete="off">
                        <option value="0" <?php if(settings("site_offline") == 0 ){ echo 'selected = "selected"'; } ?>>لا</option>
                        <option value="1" <?php if(settings("site_offline") == 1 ){ echo 'selected = "selected"'; } ?>>نعم</option>                        
                    </select>                
                </div>
            </div>  
     
            <div class="form-group">
                <label for="lang_frontend" class="col-lg-3 control-label">اللغة الإفتراضية للموقع</label>
                <div class="col-lg-8">
                    <select name="lang_frontend" id="lang_frontend" class="form-control"  autocomplete="off">
                        <?php foreach(settings("langs") as $lang){ ?>
                            <option value="<?php echo @$lang->lang_alias; ?>" <?php if(@settings("lang_frontend") == @$lang->lang_alias ){ echo 'selected = "selected"'; } ?>><?php echo $lang->lang_title; ?></option>
                        <?php } ?>
                    </select>                
                </div>
            </div>    

           
              
                    
            <div class="form-group">
                <label for="refresh" class="col-lg-3 control-label">تحديث الكاش <i class="fa fa-info-circle" rel="tooltip" title="قم بوضع رمز عشوائى ليتم تحديث ملفات الموقع عند الزوار و التغلب على الكاش"></i></label>
                <div class="col-lg-8">
                    <input autocomplete="off" class="form-control" name="refresh" id="refresh" value="<?php echo settings("refresh"); ?>" />
                </div>
            </div>                        

                  
                   
                                                      
                  
             
                    
            <br /><hr /><br />                                
            <h3><b>Google services</b></h3>                                    
            
            <div class="form-group">
                <label for="google_analytic_enabled" class="col-lg-3 control-label">تفعيل Google analytic</label>
                <div class="col-lg-8">

                    <select name="google_analytic_enabled" id="google_analytic_enabled" class="form-control"  autocomplete="off">
                        <option value="1" <?php if(settings("google_analytic_enabled") == 1 ){ echo 'selected = "selected"'; } ?>>نعم</option>
                        <option value="0" <?php if(settings("google_analytic_enabled") == 0 ){ echo 'selected = "selected"'; } ?>>لا</option>
                    </select>                
                </div>
            </div>                                         
      

            <div class="form-group">
                <label for="google_analytic_id" class="col-lg-3 control-label">Google analytic ID</label>
                <div class="col-lg-8">
                    <input autocomplete="off" class="form-control" name="google_analytic_id" id="google_analytic_id" value="<?php echo settings("google_analytic_id"); ?>" />
                </div>
            </div>
     


        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>




     