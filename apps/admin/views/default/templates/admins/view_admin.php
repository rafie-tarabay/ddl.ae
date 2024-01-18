<div class="card">
    <div class="card-header">
        
        <div class="row">
            <div class="col-sm-4 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-8  no-padding text-left">                       
                <?php if(can("edit_admin_data")){ ?>
                    <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."admins/edit_admin/".$admin->admin_id) ?>"> تعديل البيانات</a>
                <?php } ?>
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."admins/") ?>"> المشرفين</a>
            </div>            
        </div>
                        
    </div>   


    <div class="list-group">

        <div class="list-group-item">
            البريد: <?php echo $admin->admin_email ?>
        </div>                         
    
        <div class="list-group-item">
            البريد الشخصي: <?php echo $admin->admin_personal_email ?>
        </div>                         
    
        <div class="list-group-item">
            الاسم الحقيقي: <?php echo $admin->admin_fullname ?>
        </div>         
               
            
        <div class="list-group-item">
            اسم المستخدم: <?php echo $admin->admin_username ?>
        </div>         
               
                    
        <div class="list-group-item">
            اللقب: <?php echo $admin->admin_title ?>
        </div>         
 
    </div>
    

    <div class="list-group">

        <div class="list-group-item">
            <h4>الصلاحيات</h4>
        </div>
        
        <?php foreach($perms as $key => $val){ ?>  
            <?php if(!in_array($key,array("perm_admin_id","ban_admins","edit_admin_perms","edit_admin_data"))){ ?>            
                <div class="list-group-item">

                    <h4 class="no-margin">
                        <i class="fa <?php echo $val == 0 ? 'fa-times text-danger' : "fa-check text-success"; ?>"></i>
                        <?php echo $key ?>
                    </h4>

                </div>  
            <?php } ?>         
        <?php } ?>         
 
    </div>    

</div>