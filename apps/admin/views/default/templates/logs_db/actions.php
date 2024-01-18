<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()); ?>">الرجوع</a>                
            </div>            
        </div>
    </div> 

</div>

<?php foreach($records as $record){ ?>                        

    <div class="card card-default mt-4">

        <div class="card-header">   
            <h5 class="mb-0"><?php echo date("Y-m-d h:i A",$record->log_timestamp); ?></h5>
        </div>     

        <table class="table table-bordered table-hover table-sm m-0">                
                      
            <tr>                        
                <td style="width: 150px;">نوع الحدث</td>                
                <td colspan="2"><?php echo $record->log_action; ?> <?php if(!is_null($record->log_type)) echo " - ".$record->log_type; ?></td>                
            </tr>                             

            <?php if($users){ ?>                            
                <tr>                        
                    <td style="width: 150px;">ID المستخدم</td>                
                    <td colspan="2"><?php echo $record->log_u_id; ?></td>                
                </tr>  
            <?php } ?>

            <?php if(!is_null($record->log_rel_id)){ ?>                            
                <tr>                        
                    <td style="width: 150px;">ID مرتبط</td>                
                    <td colspan="2"><?php echo $record->log_rel_id; ?></td>                
                </tr>  
            <?php } ?>

            <?php if(!is_null($record->log_rel_id2)){ ?>                                                        
                <tr>                        
                    <td>ID مرتبط</td>                
                    <td colspan="2"><?php echo $record->log_rel_id2; ?></td>                
                </tr>  
            <?php } ?>

            <?php if(!is_null($record->log_rel_text)){ ?>                                                                          
                <tr>                        
                    <td>نص مرتبط</td>                
                    <td colspan="2"><?php echo $record->log_rel_text; ?></td>                
                </tr> 
            <?php } ?>
                       
            <tr>                        
                <td style="width: 150px;">السيشن</td>                
                <td colspan="2"><?php echo $record->log_session; ?></td>                
            </tr>  

            <tr>                        
                <td>IP</td>                
                <td colspan="2"><?php echo $record->log_ip; ?></td>                
            </tr>  

            <tr>                        
                <td>الدولة</td>                
                <td colspan="2"><?php echo $record->log_country; ?></td>                
            </tr>  

        </table>


    </div>


<?php } ?>

<div class="text-center mt-4">
    <?php echo $pagination; ?>
</div>


