<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base.ctrl()."/add_record/".$type); ?>">إضافة جديد</a>                
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()); ?>">الرجوع</a>                
            </div>            
        </div>
    </div>     
</div>

<?php foreach($records as $record){ ?>   

    <?php $notifiable = $record->access_notif && ( $record->access_notif_date != "0000-00-00" && date("Y-m-d") >= $record->access_notif_date) ? TRUE : FALSE; ?>

    <div class="card  <?php echo $notifiable ? "border-danger text-danger" : "bg-light"; ?> mt-2">

        <div class="card-header">   
            <div class="row">
                <div class="col-sm-8 no-padding">                
                    <h5 class="mb-0"><?php echo $record->access_id; ?> - <?php echo $record->identifier; ?></h5>
                </div>
                <div class="col-sm-4  no-padding text-left">
                    <?php if(can("grant_access")){ ?>
                        <a class="btn btn-sm btn-info" href="<?php echo base_url(admin_base.ctrl()."/edit_record/".$type."/".$record->access_id); ?>">تعديل</a>                
                        <a class="btn btn-sm btn-danger" href="<?php echo base_url(admin_base.ctrl()."/delete_record/".$type."/".$record->access_id); ?>">حذف</a>                
                    <?php } ?>
                </div>            
            </div>
        </div>  
        
        <table class="table table-bordered table-hover table-sm m-0">                
            
            
                <tr>                        
                    <td style="width: 150px;">الصلاحية الرئيسية</td>                
                    <td class="ltr">                    
                        <b class="text-danger"><?php echo $record->access_master_rule == "allow" ? "السماح" : "المنع" ; ?></b> -
                        [ <a href="<?php echo base_url(admin_base.ctrl()."/rules/".$type."/".$record->access_id); ?>">القواعد الاستثنائية</a> ]
                    </td>                
                </tr>              
            
            <?php if($type == "token"){ ?>
            
                <tr>                        
                    <td style="width: 150px;">Token</td>                
                    <td class="ltr">                    
                        <code><?php echo $record->token; ?></code>
                    </td>                
                </tr>  
                                
                <tr>                        
                    <td style="width: 150px;">Group id</td>                
                    <td class="ltr">                    
                        <code><?php echo $record->group_id; ?></code> (<a href="<?php echo base_url(admin_base."access/view_group_tokens/".$record->group_id) ?>">view all</a>)
                    </td>                
                </tr>  
                    
            <?php }elseif($type == "ip"){ ?>
                        
                <tr>                        
                    <td style="width: 150px;">المستخدم</td>                
                    <td>                    
                        <?php echo $record->access_u_id; ?> - <?php echo $record->u_fullname; ?>                        
                    </td>                
                </tr>  
                                                 
                <tr>                        
                    <td style="width: 150px;">بداية من IP</td>                
                    <td class="ltr">                    
                        <code><?php echo $record->range_start; ?></code>
                        <kbd><?php echo $record->int_start; ?></kbd>
                    </td>                
                </tr>  
                                
                <tr>                        
                    <td>حتى IP</td>                
                    <td  class="ltr">                    
                        <code><?php echo $record->range_end; ?></code>
                        <kbd><?php echo $record->int_end; ?></kbd>
                    </td>                
                </tr>  
            
            <?php }elseif($type == "country"){ ?>
            
                
                <tr>                        
                    <td style="width: 150px;">الدولة</td>                
                    <td>                    
                        <?php echo $record->country_code_ISO3; ?> - <?php echo $record->country_code_ISO2; ?>
                    </td>                
                </tr>  
                
            <?php } ?>
                            
            <tr>                        
                <td>من تاريخ</td>                
                <td><?php echo $record->access_start; ?></td>                
            </tr>  
                            
            <tr>                        
                <td>إلى تاريخ</td>                
                <td><?php echo $record->access_expire; ?></td>                
            </tr>  
                                              
            <tr>                        
                <td>العدد المسموح</td>                
                <td><?php echo $record->access_limit; ?></td>                
            </tr>  
                            
            <tr>                        
                <td>الإستهلاك</td>                
                <td><?php echo $record->access_counter; ?></td>                
            </tr>                 
                                           
            <tr>                        
                <td>الحالة</td>                
                <td><?php echo $record->access_denied == 1 ? "متوقف" : "فعال"; ?></td>                
            </tr>  
               
        </table>
                             
         
    </div>


<?php }  ?>


<div class="text-center mt-4">
    <?php echo $pagination; ?>
</div>