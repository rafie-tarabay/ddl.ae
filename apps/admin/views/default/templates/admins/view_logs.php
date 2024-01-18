
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4 no-padding text-left">                

                <a class="btn btn-success" href="<?php echo base_url(admin_base."admins/view_logs/$admin_id/".date("Y-m-d")) ?>">اليوم</a>
                <a class="btn btn-success" href="<?php echo base_url(admin_base."admins/view_logs/$admin_id/".date("Y-m-d",strtotime("yesterday"))) ?>">الأمس</a>
                <a class="btn btn-success" href="<?php echo base_url(admin_base."admins/view_logs/$admin_id/".date("Y-m-d",strtotime("-2 days"))) ?>">أول امس</a>
                
                <?php if( ( $date && $date != "0000-00-00"  )  || $admin_id){ ?>  
                    <a class="btn btn-success" href="<?php echo base_url(admin_base."admins/view_logs") ?>">الكل</a>
                <?php } ?>
                
            </div>        
        </div>
    </div>         
    
    <?php if($logs){ ?>
    
        <div class="table-responsive">
                               
            <table class="table table-striped">
            
                <tr>
                    <th>نوع السجل</th>                
                    <th class="text-center">id #1</th>                
                    <th class="text-center">id #2</th>                
                    <th class="text-center">المدير</th>                
                    <th class="text-center">التاريخ</th>                
                </tr>        
            
                <?php foreach($logs as $log){ ?>
                              
                    <tr>
                    
                        <td>
                            <?php echo $log->log_type; ?>
                            <br />
                            <span class="text-danger small"><?php echo $log->log_action ?></span>
                        </td>
                                                                
                        <td class="text-center">
                            <?php echo $log->log_rel_id; ?>
                        </td>
                                                                                                  
                        <td class="text-center">
                            <?php echo $log->log_rel_id2; ?>
                        </td>
         
                        <td class="text-center">
                            <a href="<?php echo base_url(admin_base."admins/view_logs/".$log->admin_id) ?>"><?php echo $log->admin_fullname ?></a>
                        </td>

                        <td class="text-center">
                            <?php echo date("Y-m-d",$log->log_timestamp) ?>
                                <br />
                            <?php echo date("h:i A",$log->log_timestamp) ?>
                        </td>  
                                            
                    </tr>
                    
                    <?php if($log->log_rel_text){ ?>
                    
                        <tr>
                            <td colspan="5">
                                <div class="well" style="height: 100px; overflow: auto;">
                                    <?php 
                                        print_r(json_decode($log->log_rel_text));
                                        if($log->log_rel_text2){
                                            echo "<br>";
                                            print_r(json_decode($log->log_rel_text2));
                                        }
                                    ?>
                                </div>
                            </td>                        
                        </tr>
                    
                    <?php } ?>
                         
                <?php } ?>  
                
            </table>
            
        </div>

    <?php }else{ ?>
        <div class="card-body no-items">
            لا يوجد سجلات
        </div>
    <?php } ?>  

    <div class="card-footer text-center">
        <?php echo $pagination; ?>
    </div>       
    
</div>

