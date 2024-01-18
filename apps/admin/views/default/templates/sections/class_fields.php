<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base."sections/add_class_field/".$class); ?>">إضافة حقل</a>                
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()."/content_classes"); ?>">الرجوع</a>                                
            </div>            
        </div>
    </div> 

</div>

<br />
<div class="table-responsive">

    <table class="table table-light table-hover table-bordered" >
        
        <thead class="thead-light">
            <tr class="active">
                <th>الحقل</th>                
                <th width="70px">إلزامي</th>                
                <th width="70px" class="text-center">تعديل</th>                                
                <th width="70px" class="text-center">حذف</th>                                
            </tr>
        </thead>


        <?php foreach($fields as $field){ ?>
        
            <tr>
                <td>                        
                    <?php echo $field->f_order." - ".$field->f_name; ?>
                </td>
                
                <td width="70px">                        
                    <?php echo $field->f_required ? "نعم" : "لا"; ?>
                </td>

                <td class="text-center">                    
                    <a class="btn btn-info btn-sm" href="<?php echo base_url(admin_base."sections/edit_class_field/".$field->f_id) ?>">تعديل</a>
                </td>                                            
                                
                <td class="text-center">                    
                    <a class="btn btn-danger btn-sm" href="<?php echo base_url(admin_base."sections/delete_class_field/".$field->f_id) ?>">حذف</a>
                </td>            
              
            </tr>
            
        <?php } ?>


    </table>    
    
</div>