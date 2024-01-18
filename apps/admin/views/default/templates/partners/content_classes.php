<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base."partners/add_class/"); ?>">إضافة نوع</a>                
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()); ?>">الرجوع</a>                
            </div>            
        </div>
    </div> 

</div>

<br />
<div class="table-responsive">

    <table class="table table-light table-hover table-bordered" >
        
        <thead class="thead-light">
            <tr class="active">
                <th>نوع المحتوى</th>                
                <th width="70px" class="text-center">الحقول</th>                                
                <th width="70px" class="text-center">تعديل</th>                                
            </tr>
        </thead>


        <?php foreach($classes as $class){ ?>
        
            <tr>
                <td>                        
                    <?php echo $class->class_name; ?>
                </td>

                <td class="text-center">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url(admin_base."partners/class_fields/".$class->class_name) ?>">الحقول</a>
                </td>             
                
                <td class="text-center">                    
                    <a class="btn btn-info btn-sm" href="<?php echo base_url(admin_base."partners/edit_class/".$class->class_id) ?>">تعديل</a>
                </td>                                                   
              
            </tr>
            
        <?php } ?>


    </table>    
    
</div>