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
    
    <div class="card-body">
        <b>عدد مرات التحميل:</b> <code><?php echo $count; ?></code>
    </div>
    
</div>

<?php foreach($records as $record){ ?>                        

    <?php $data = json_decode($record->download_item_data) ?>

    <div class="card card-default mt-4">

        <div class="card-header">   
            <h5 class="mb-0"><a target="_blank" href="<?php echo base_url(front_base."book/".$record->download_item_id) ?>"><?php echo $data->title; ?></a></h5>
        </div>     
    
        <table class="table table-bordered table-hover table-sm m-0">                
                                        
            <tr>                        
                <td style="width: 150px;">رقم الوعاء</td>                
                <td colspan="2"><?php echo $record->download_item_id; ?></td>                
            </tr>              
            
            <?php if(!is_null($record->download_free_access)){ ?>
            
                <tr>                        
                    <td style="width: 150px;">الدخول المجاني</td>                
                    <td class="text-center" style="width: 50px;">                    
                        <?php echo $record->download_access_id; ?>
                    </td>
                    <td>                    
                        <a target="_blank" href="<?php echo base_url(admin_base."access/list_records/".$record->download_access_method) ?>">                            
                            <?php echo word("free_access_".$record->download_access_method); ?>
                        </a>
                    </td>                
                </tr>  
                          
            <?php }elseif(!is_null($record->download_free_material)){ ?>
                        
                <tr>                        
                    <td style="width: 150px;">كيفية الوصول</td>                
                    <td  colspan="2">محتوى مجاني</td>                
                </tr>                                      
                                      
            <?php }elseif(!is_null($record->download_purchased)){ ?>
            
                <tr>                        
                    <td style="width: 150px;">كيفية الوصول</td>                
                    <td  colspan="2">تم الشراء</td>                
                </tr>              
            
            <?php } ?>
                  
                                  
            <?php if(!is_null($record->download_u_id)){ ?>
            
                <tr>                        
                    <td style="width: 150px;">المستفيد</td>                
                    <td class="text-center" style="width: 50px;">                    
                        <?php echo $record->download_u_id; ?>
                    </td>                    
                    <td class="ltr">                    
                        <?php echo $record->user->u_fullname; ?>
                    </td>                
                </tr>  
                         
            <?php }else{ ?>
            
                <tr>                        
                    <td style="width: 150px;">المستفيد</td>                
                   
                    <td class="ltr" colspan="2">                    
                        زائر
                    </td>                
                </tr>              
            
            <?php } ?>
            
                            
            <tr>                        
                <td style="width: 150px;">السيشن</td>                
                <td colspan="2"><?php echo $record->download_session_id; ?></td>                
            </tr>  
                            
            <tr>                        
                <td>IP</td>                
                <td colspan="2"><?php echo $record->download_ip; ?></td>                
            </tr>  
                                              
            <tr>                        
                <td>الدولة</td>                
                <td colspan="2"><?php echo $record->download_country; ?></td>                
            </tr>  
                            
            <tr>                        
                <td>التاريخ</td>                
                <td colspan="2"><?php echo date("Y-m-d h:i A",$record->download_timestamp); ?></td>                
            </tr>                 
                                           
            <tr>                        
                <td>عدد المرات</td>                
                <td colspan="2"><?php echo $record->download_counts; ?></td>                
            </tr>  
                                                          
            <tr>                        
                <td>الملفات</td>                
                    <td class="text-center" style="width: 50px;">                    
                        <?php echo count($data->urls); ?>
                    </td>                      
                <td>
                    <?php foreach($data->urls as $url){ ?>
                        <div><a target="_blank" href="<?php echo $url ?>"><?php echo $url ?></a></div>
                    <?php } ?>
                </td>                
            </tr>  
               
        </table>
                             
         
    </div>


<?php } ?>

<div class="text-center mt-4">
    <?php echo $pagination; ?>
</div>


     