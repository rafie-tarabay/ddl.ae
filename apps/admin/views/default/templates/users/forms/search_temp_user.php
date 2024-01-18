<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-6 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-6  no-padding text-left">
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()); ?>">المستخدمين</a>                
            </div>            
        </div>
    </div> 

</div>


<div class="card card-default mt-4">


    <?php echo form_open_multipart(base_url(admin_base.ctrl()."/search_temp_user") , array("class" => "", "role" => "form")); ?>

        <div class="card-body">                   

            <div class="form-group">
                <label>البريد <span class="text-danger">*</span></label>
                <input class="form-control req_field" name="email" value="" />
            </div>  

        </div>

        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="بحث" />
        </div>           


    <?php echo form_close(); ?>        


</div>


<?php if(@$records){ ?>

    <?php foreach($records as $record){ ?>                        

        <div class="card card-default mt-4">

            <div class="card-header">                
                <h5 class="mb-0"><a target="_blank" href="<?php echo base_url(front_base."/join/".$record->step."/".$record->reference) ?>" >رابط استكمال التسجيل</a></h5>
            </div>     
        
            <table class="table table-bordered table-hover table-sm m-0">                
                                             
                <tr>                        
                    <td>الاسم الأول</td>                
                    <td><?php echo $record->first_name; ?></td>                
                </tr>              
                                                               
                <tr>                        
                    <td>الاسم الأخير</td>                
                    <td><?php echo $record->last_name; ?></td>                
                </tr>              
                                                                             
                <tr>                        
                    <td>البريد الإلكتروني</td>                
                    <td><?php echo $record->email; ?></td>                
                </tr>              
                                                                                               
                <tr>                        
                    <td>كود تفعيل البريد</td>                
                    <td><?php echo $record->email_code; ?></td>                
                </tr>              
                                                  
                <tr>                        
                    <td>رقم الخطوة</td>                
                    <td><?php echo $record->step; ?></td>                
                </tr>                 
                                                 
                <tr>                        
                    <td>انتهاء التسجيل</td>                
                    <td><?php echo $record->completed ? "نعم" : "لا"; ?></td>                
                </tr>                 
                                               
                <tr>                        
                    <td>التاريخ</td>                
                    <td><?php echo date("Y-m-d h:i A",$record->timestamp); ?></td>                
                </tr>  
                  
            </table>
                                 
             
        </div>


    <?php } ?>

    <div class="text-center mt-4">
        <?php echo $pagination; ?>
    </div>

<?php } ?>