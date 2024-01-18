<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-info" href="<?php echo base_url(admin_base."users"); ?>">كافة المستخدمين</a>                
            </div>            
        </div>
    </div> 

</div>


<div class="card card-default mt-4">

    <div class="card-header">   
        <h5 class="mb-0"><a target="_blank" ><?php echo $record->u_fullname; ?></a></h5>
    </div>     

    <table class="table table-bordered table-hover table-sm m-0">                
                                    
        <tr>                        
            <td style="width: 150px;">رقم المستخدم</td>                
            <td><?php echo $record->u_id; ?></td>                
        </tr>              
                                                       
        <tr>                        
            <td>المعرف</td>                
            <td><?php echo $record->u_username; ?></td>                
        </tr>              
                                                                     
        <tr>                        
            <td>البريد الإلكتروني</td>                
            <td><?php echo $record->u_email; ?></td>                
        </tr>              
                                                                                       
        <tr>                        
            <td>الموبايل</td>                
            <td><?php echo $record->u_mobile; ?></td>                
        </tr>              
                                          
        <tr>                        
            <td>تاريخ التسجيل</td>                
            <td><?php echo date("Y-m-d h:i A",$record->u_reg_time); ?></td>                
        </tr>                 
                                         
        <tr>                        
            <td>آخر تواجد</td>                
            <td><?php echo date("Y-m-d h:i A",$record->u_lastvisit); ?></td>                
        </tr>                 
                                       
        <tr>                        
            <td>الدولة</td>                
            <td><?php echo $record->u_country_code; ?></td>                
        </tr>  
          
    </table> 
    ?>
     
</div>


     