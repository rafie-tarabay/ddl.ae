
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo $title; ?></h3>
    </div>         

                                                                                                                  
    <?php echo form_open_multipart(base_url(admin_base."admins/update_profile") , array("class" => "form-horizontal check_submit" , "release"=>"true" , "role" => "form")); ?>

        <div class="card-body">

            <div class="form-group">
                <label for="admin_email" class="col-lg-3 control-label">البريد <span class="text-danger">*</span></label>
                <div class="col-lg-8">
                    <input type="email" class="form-control req_field" name="admin_email" id="admin_email" value="<?php echo $admin->admin_email ?>" autocomplete="off"  />
                </div>
            </div>                         
            
            <div class="form-group">
                <label for="admin_email" class="col-lg-3 control-label">البريد الشخصي <span class="text-danger">*</span></label>
                <div class="col-lg-8">
                    <input type="email" class="form-control req_field" name="admin_personal_email" id="admin_personal_email" value="<?php echo $admin->admin_personal_email ?>" autocomplete="off"  />
                </div>
            </div>              
                    
            <div class="form-group">
                <label for="admin_signature" class="col-lg-3 control-label">التوقيع <span class="text-danger">*</span></label>
                <div class="col-lg-8">
                    <textarea class="form-control elastic" name="admin_signature" id="admin_signature"><?php 
                    
                        if($admin->admin_signature){
                            echo $admin->admin_signature;
                        }else{
                            echo "<b>".$admin->admin_fullname."</b> \r ".$admin->admin_title." \r".word("site_title")."\r";
                        }
                    
                    ?></textarea>
                </div>
            </div>              
        
            <div class="form-group">
                <label for="admin_password" class="col-lg-3 control-label">ادخل كلمة المرور الحالية لتأكيد الهوية</label>
                <div class="col-lg-8">
                    <input type="password" class="form-control req_field" name="admin_password" id="admin_password" autocomplete="off"  />
                </div>
            </div>         
                   
                       
            <?php if(settings("enable_login_pincode") == 1){ ?>
            
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="pincode">رمز الحماية</label>
                    <div class="col-lg-8">
                        <input type="password" class="form-control req_field" name="pincode" id="pincode" placeholder="رمز الحماية" autocomplete="off" />
                    </div>
                </div>                
                
            <?php } ?>                      
                   
 
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>
