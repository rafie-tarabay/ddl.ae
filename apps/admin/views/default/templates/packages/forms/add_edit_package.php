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


    <?php echo form_open(base_url(admin_base.ctrl()."/".$method) , array("class" => "", "role" => "form")); ?>

        <div class="card-body">                   
                          
            <div class="form-group">
                <label>عنوان الحزمة عربي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="pack_title_ar" value="<?php echo @$package->pack_title_ar ?>" />
            </div>    
            
            <div class="form-group">
                <label>عنوان الحزمة انجليزي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="pack_title_en" value="<?php echo @$package->pack_title_en ?>" />
            </div>                          
                   
            <div class="form-group">
                <label>وصف الحزمة عربي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="pack_desc_ar" value="<?php echo @$package->pack_desc_ar ?>" />
            </div>                 
                   
            <div class="form-group">
                <label>وصف الحزمة انجليزي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="pack_desc_en" value="<?php echo @$package->pack_desc_en ?>" />
            </div>                 
                                                    
            <div class="form-group">
                <label>السعر الشهري<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="pack_price_monthly" value="<?php echo @$package->pack_price_monthly ?>" />
            </div>   
                            
            <div class="form-group">
                <label>السعر السنوي<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="pack_price_yearly" value="<?php echo @$package->pack_price_yearly ?>" />
            </div>
                                        
            <div class="form-group">
                <label>الترتيب <span class="text-danger">*</span></label>
                <input class="form-control req_field" name="pack_order" value="<?php echo @$package->pack_order ?>" />
            </div>                 
                          
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>           
        
                     
        <input type="hidden" name="pack_id" id="pack_id" value="<?php echo @$package->pack_id; ?>" />        
                   

    <?php echo form_close(); ?>        


</div>
