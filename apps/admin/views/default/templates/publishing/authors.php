<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base."publishing/"); ?>">النشر الذاتي</a>                
            </div>            
        </div>
    </div> 

</div>

<br />
<div class="table-responsive">

    <table class="table table-light table-hover table-bordered" >
        
        <thead class="thead-light">
            <tr class="active">
                <th>اسم المؤلف</th>                
                <th width="250px" class="text-center">بواسطة</th>                
                <th width="150px" class="text-center">الحالة</th>                                
                <th width="100px" class="text-center">تعديل</th>                                
            </tr>
        </thead>


        <?php foreach($records as $record){ ?>
        
            <tr>
                <td>                        
                    <b><?php echo $record->author_name; ?></b>
                </td>
                
                <td class="text-center">                        
                    <a href="<?php echo base_url(admin_base."users/show_user/".$record->u_id) ?>" ><?php echo @$record->u_fullname; ?></a>
                </td>

                
                <td class="text-center">
                    <?php echo word($record->author_status) ?>
                </td>             
                
                <td class="text-center">                    
                    <a class="btn btn-info btn-sm" href="<?php echo base_url(admin_base."publishing/view_author/".$record->author_id) ?>">البيانات</a>
                </td>                                                   
              
            </tr>
            
        <?php } ?>


    </table>    
    
</div>