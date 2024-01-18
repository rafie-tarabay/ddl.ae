<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base.ctrl()."/upload_file"); ?>">أضف ملف</a>                
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()); ?>">الرجوع</a>                
            </div>            
        </div>
    </div> 
    
    <div class="card-body">
        <b>اجمالي الملفات:</b> <code><?php echo $count; ?></code>
    </div>
    
</div>
    
<table class="table table-bordered table-hover table-sm m-0">                
                                
    <tr>                        
        <th class="text-center">اسم الملف</th>                
        <th class="text-center">بواسطة </th>                
        <th class="text-center">رابط DO</th>                
        <th class="text-center">رابط محلي</th>                
        <th class="text-center">الإمتداد</th>                
        <th class="text-center">الحجم</th>                
    </tr> 

    <?php foreach($records as $record){ ?>                        
                                                                         
        <tr>                        
            <td class="text-center">
                <?php echo $record->file_name ?><br>
                <code><?php echo date("Y-m-dh:i A",$record->file_timestamp) ?></code>
            </td>                
            <td class="text-center"><?php echo $record->admin_fullname ?></td>                
            <td class="text-center"><input type="text" value="<?php echo $record->file_DO_url ?>" class="form-control text-left ltr" /></td>                
            <td class="text-center"><input type="text" value="<?php echo $record->file_url ?>" class="form-control text-left ltr" /></td>                
            <td class="text-center"><?php echo $record->file_ext ?></td>                
            <td class="text-center"><?php echo round($record->file_size/1024,2); ?>MB</td>                
        </tr>  

    <?php } ?>

</table>
                             
         

<div class="text-center mt-4">
    <?php echo $pagination; ?>
</div>


     