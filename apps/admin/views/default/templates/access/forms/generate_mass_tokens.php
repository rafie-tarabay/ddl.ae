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


    <?php echo form_open(base_url(admin_base.ctrl()."/generate_tokens") , array("class" => "check_submit", "release" => "true")); ?>

        <div class="card-body">                   
        
            <div class="form-group">
                <label>اسم السجل <span class="text-danger">*</span></label>
                <input class="form-control req_field" name="identifier" value="" placeholder="مثال: جامعة الإمارات" />
            </div>                                       
        
            <div class="form-group">
                <label>Tokens count<span class="text-danger">*</span></label>
                <input type="text" class="form-control req_field ltr text-left" name="count" value="" placeholder="Example: 10">
            </div>  
                           
            <div class="form-group">
                <label>Token group id<span class="text-danger">*</span></label>
                <input type="text" class="form-control req_field ltr text-left" name="group_id" value="" placeholder="Example: UAEU">
            </div>  
                     
              
            <div class="row">
            
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>يبدأ من</label>
                        <input type="text" class="form-control ltr text-left datepicker" maxlength="10" name="access_start" id="access_start" placeholder="MM/DD/YYYY">
                    </div>                                               
                </div>
                
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>ينتهي في</label>
                        <input type="text" class="form-control ltr text-left datepicker" maxlength="10" name="access_expire" id="access_expire" placeholder="MM/DD/YYYY">
                    </div>                
                </div>
            
            </div>          
                                                
            <div class="form-group">
                <label>العدد المسموح للتحميلات</label>
                <input class="form-control ltr text-left" name="access_limit" value="" />
            </div>                           
     
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>           
        
    <?php echo form_close(); ?>        



</div>

