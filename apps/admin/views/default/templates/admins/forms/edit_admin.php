<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-4 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-8  no-padding text-left">                       
                <a class="btn btn-primary btn-sm pull-left" href="<?php echo base_url(admin_base."admins/") ?>"> المشرفين</a>
            </div>            
        </div>
    </div>         

                                                                                                                  
    <?php echo form_open(base_url(admin_base."admins/update_admin_data") , array("class" => "check_submit" , "release"=>"true" , "role" => "form")); ?>

        <div class="card-body">

            <div class="form-group">
                <label for="admin_email" class="control-label">البريد</label>
                <input type="email" class="form-control req_field" name="admin_email" id="admin_email" value="<?php echo $admin->admin_email ?>" autocomplete="off"  />
            </div>                         
        
            <div class="form-group">
                <label for="admin_personal_email" class="control-label">البريد الشخصي</label>
                <input type="email" class="form-control req_field" name="admin_personal_email" id="admin_personal_email" value="<?php echo $admin->admin_personal_email ?>" autocomplete="off"  />
            </div>                         
        
            <div class="form-group">
                <label for="admin_fullname" class="control-label">الاسم الحقيقي</label>
                <input type="text" class="form-control req_field" name="admin_fullname" id="admin_fullname" autocomplete="off" value="<?php echo $admin->admin_fullname ?>" />
            </div>                            
                
            <div class="form-group">
                <label for="admin_username" class="control-label">اسم المستخدم</label>
                <input type="text" class="form-control req_field" name="admin_username" id="admin_username" autocomplete="off" value="<?php echo $admin->admin_username ?>" />
            </div>                            
                        
            <div class="form-group">
                <label for="admin_title" class="control-label">اللقب</label>
                <input type="text" class="form-control" name="admin_title" id="admin_title" autocomplete="off" value="<?php echo $admin->admin_title ?>" />
            </div>         
                   
        
            <div class="form-group">
                <label for="admin_password" class="control-label">كلمة المرور الجديدة</label>
                <input type="text" class="form-control" name="admin_password" id="admin_password" autocomplete="off"  />
            </div>         
            
            <div class="form-group">
                <label for="admin_signature" class="control-label">التوقيع <span class="text-danger">*</span></label>
                <textarea class="form-control elastic" name="admin_signature" id="admin_signature"><?php 
                
                    if($admin->admin_signature){
                        echo $admin->admin_signature;
                    }else{
                        echo "<b>".$admin->admin_fullname."</b> \r ".$admin->admin_title." \r".word("site_title")."\r";
                    }
                
                ?></textarea>
            </div>               

            <?php if(can("ban_admins")){ ?>         
              
                <div class="form-group">
                    <label for="admin_banned" class="control-label">حالة الحساب</label>
                    <select class="form-control" name="admin_banned" id="admin_banned" autocomplete="off">
                        <option <?php if($admin->admin_banned == 0) echo 'selected="selected"'; ?> value="0" >فعال</option>
                        <option <?php if($admin->admin_banned == 1) echo 'selected="selected"'; ?> value="1" >موقوف</option>
                    </select>
                </div>         
                       
            <?php } ?>                                                                
        

            <hr />                  

                       
            <?php if(settings("enable_login_pincode") == 1){ ?>
            
                <div class="alert alert-danger">
                    <label class="control-label" for="pincode">رمز الحماية</label>
                    <input type="password" class="form-control req_field" name="pincode" id="pincode" placeholder="رمز الحماية" autocomplete="off" />
                </div>                
                
            <?php } ?>                      
                   
 
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

        
        <input type="hidden" name="admin_id" value="<?php echo $admin->admin_id ?>" />
        
    <?php echo form_close(); ?>        



</div>


<?php if(can("edit_admin_perms")){ ?>

    <br><br>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">تعديل صلاحيات مشرف</h3>
        </div>         

                                                                                                                      
        <?php echo form_open(base_url(admin_base."admins/update_admin_perms") , array("class" => "check_submit" , "release"=>"true" , "role" => "form")); ?>


            <div class="list-group">
                    
                <?php foreach($perms as $key => $val){ ?>  
                    <?php if(!in_array($key,array("perm_admin_id","ban_admins","edit_admin_perms","edit_admin_data"))){ ?>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-xs-6 col-sm-10">
                                    <h4 class="no-margin">
                                        <i class="fa <?php echo $val == 0 ? 'fa-times text-danger' : "fa-check text-success"; ?>"></i>
                                        <?php echo $key ?>
                                    </h4>
                                </div>
                                <div class="col-xs-6 col-sm-2 text-left">
                                    <?php if( in_array( $key , array("view_sources") ) ){ ?>
                                        <input type="text" class="form-control"  name="<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $val; ?>" autocomplete="off" />
                                    <?php }else{ ?>
                                        <select class="form-control"  name="<?php echo $key ?>" id="<?php echo $key ?>" autocomplete="off">                            
                                            <option <?php if($val == 0) echo 'selected="selected"'; ?> value="0" >لا</option>
                                            <option <?php if($val == 1) echo 'selected="selected"'; ?> value="1" >نعم</option>                                                                
                                        </select>                                    
                                    <?php } ?>
                                </div>
                            </div>
                        </div>                            
                    <?php } ?>  
                <?php } ?>  
            
          
                <?php if(settings("enable_login_pincode") == 1){ ?>
                
                
                    <div class="alert alert-danger">
                        <label class="control-label" for="pincode">رمز الحماية</label>
                        <input type="password" class="form-control req_field" name="pincode" id="pincode" placeholder="رمز الحماية" autocomplete="off" />
                    </div>                
                    
                <?php } ?>                      
                           
     
            </div>    


            <div class="card-footer" style="text-align: left;">
                <input class="btn btn-success" type="submit" value="حفظ" />
            </div>             

            <input type="hidden" name="admin_id" value="<?php echo $admin->admin_id ?>" />
            
        <?php echo form_close(); ?>        



    </div>

<?php } ?>
