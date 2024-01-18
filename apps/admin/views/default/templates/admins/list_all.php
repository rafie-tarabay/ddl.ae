
<div class="table-responsive">

    <table class="table table-light table-hover table-bordered" >
        
        <thead class="thead-light">
            <tr class="active">
                <th width="20px" class="text-center">#</th>
                <th>اسم المستخدم</th>
                <th class="text-center">اسم المستخدم</th>
                <th class="text-center">البريد</th>
                <th class="text-center">آخر تواجد</th>                
                
                <?php if(can("edit_admin_data")){ ?>
                    <th width="50px" class="text-center">تعديل</th>                
                <?php } ?>
                        
                <?php if(can("view_admin_logs")){ ?>
                    <th width="50px" class="text-center">السجلات</th>                
                <?php } ?>
                
                <th width="70px" class="text-center">الحالة</th>                
                
            </tr>
        </thead>


        <?php foreach($admins as $admin){ ?>
        
            <tr>
                <td class="text-center">    
                    <?php echo $admin->admin_id; ?>
                </td>
                <td>                        
                    <a href="<?php echo base_url(admin_base."admins/view_admin/".$admin->admin_id) ?>">
                        <?php echo $admin->admin_fullname; ?>
                    </a>
                    <?php if($admin->admin_id == admin_id){ ?><span class="badge">أنت</span><?php } ?>
                    <br />
                    <?php echo $admin->admin_title; ?>
                </td>
                <td class="text-center">
                    <?php echo $admin->admin_username; ?>
                </td>
                <td class="text-center">
                    <?php echo $admin->admin_email; ?>
                    <br />
                    <?php echo $admin->admin_personal_email; ?>
                </td>
                <td class="text-center"><?php echo $admin->admin_last_visit ? date("Y-m-d h:i A",$admin->admin_last_visit) : "لم يتواجد من قبل"; ?></td>                    
                
                <?php if(can("edit_admin_data")){ ?>
                    <td class="text-center"><a class="btn btn-success btn-xs" href="<?php echo base_url(admin_base."admins/edit_admin/".$admin->admin_id) ?>">تعديل</a></td>                                            
                <?php } ?>                    
                            
                <?php if(can("view_admin_logs")){ ?>
                    <td class="text-center"><a class="btn btn-info btn-xs" href="<?php echo base_url(admin_base."admins/view_logs/".$admin->admin_id) ?>">السجلات</a></td>                                            
                <?php } ?>                    
                
                <td class="text-center">                            
                    <?php if($admin->admin_banned == 0){ ?>
                        <span class="text-success"><i class="fa fa-check"></i> فعال</span>
                    <?php }else{ ?>
                        <span class="text-danger"><i class="fa fa-times"></i> موقوف</span>
                    <?php } ?>
                </td>         

            </tr>
            
        <?php } ?>


    </table>    
    
</div>