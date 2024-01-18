
<div style="margin:auto; max-width: 450px;">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo $title; ?></h3>
        </div>         


        <?php echo form_open(base_url(admin_base."admins/login_submit") , array("role" => "form" , "class"=>"check_submit" , "release"=>"true")); ?>
                
            <div class="card-body">

                <div class="form-group">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" class="form-control req_field" name="username" id="username" placeholder="إسم المستخدم" autocomplete="off" />
                </div>
                
                <div class="form-group">
                    <label for="u_password">كلمة المرور</label>

                    <div class="input-group">
                      <input type="password" class="form-control req_field" name="password" id="password" placeholder="كلمة المرور" autocomplete="off" />

                      <div class="input-group-prepend" title="إظهار / إخفاء" rel="tooltip">
                          <div class="input-group-text">                      
                              <input type="checkbox" class="toggle_password" data-target="password" autocomplete="off" />
                          </div>                      
                      </div>                                            
                                         
                    </div><!-- /input-group -->                                        
                </div>                   
                
                <?php if(settings("enable_login_pincode") == 1){ ?>
                
                    <div class="form-group">
                        <label for="pincode">رمز الحماية</label>
                        <input type="password" class="form-control req_field" name="pincode" id="pincode" placeholder="رمز الحماية" autocomplete="off" />
                    </div>                
                    
                <?php } ?>

            </div>
            
            <div class="card-footer text-left">
                <button type="submit" class="btn btn-sm btn-danger">تسجيل الدخول</button> 
            </div>
            
        <?php echo form_close(); ?>
        
    </div>
    <!--
    <div class="row">
        <div class="col-sm-6 no-padding">
            <a href="<?php echo base_url(admin_base."users/recovery"); ?>"><i class="fa fa-key"></i> استعادة كلمة المرور</a>        
        </div>
        
        <div class="col-sm-6 text-left no-padding">

        </div>
    </div>    
    -->
    
    
</div>