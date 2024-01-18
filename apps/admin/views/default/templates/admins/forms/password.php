        
    
<div class="alert alert-info">
    <i class="fa fa-warning"></i> لا يوجد إجبار على طريقة كتابة كلمة المرور و لكن كنصيحة يجب أن تكون كلمة المرور قوية وعشوائية وتحتوى على حروف و رموز و أرقام
</div>
    


<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo $title; ?></h3>
    </div>         

                                                                                                                  
    <?php echo form_open_multipart(base_url(admin_base."admins/update_password") , array("class" => "form-horizontal check_submit" , "release"=>"true" , "role" => "form")); ?>

        <div class="card-body">

            <div class="form-group">
                <label for="old_password" class="col-lg-3 control-label">كلمة المرور الحالية</label>
                <div class="col-lg-8">
                    <input type="password" class="form-control req_field" name="old_password" id="old_password" />
                </div>
            </div>         

            <div class="form-group">
                <label class="col-lg-3 control-label" for="u_password">كلمة المرور الجديدة </label>
                <div class="col-lg-8">
                    <div class="input-group">
                      <input type="password" class="form-control req_field" name="new_password" id="new_password" placeholder="كلمة المرور الجديدة" autocomplete="off" />
                      <div class="input-group-prepend" title="إظهار / إخفاء" rel="tooltip">
                          <div class="input-group-text">                      
                              <input type="checkbox" class="toggle_password" data-target="new_password" autocomplete="off" />
                          </div>                      
                      </div>                      
                    </div><!-- /input-group -->                                        
                    <div class="alert alert-warning2">يجب أن تكون 6 حروف على الأقل و تأكد من كتابتها بشكل صحيح و غير قابل للتخمين</div>
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
