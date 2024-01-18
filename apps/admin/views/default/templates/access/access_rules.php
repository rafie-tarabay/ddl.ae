
<div class="card card-default mt-2">

    <div class="card-header">   
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="mb-0"><?php echo $access->access_id; ?> - <?php echo $access->identifier; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()."/list_records/".$type); ?>">الرجوع</a>                
            </div>            
        </div>
    </div>  
    
    <table class="table table-bordered table-hover table-sm m-0">                
        
        
        <tr>                        
            <td style="width: 150px;">القاعدة الأساسية</td>                
            <td>                    
                <b class="text-danger"><?php echo $access->access_master_rule == "allow" ? "السماح" : "المنع" ; ?></b>
            </td>                
        </tr>              
        
        <?php if($type == "token"){ ?>
        
            <tr>                        
                <td style="width: 150px;">token</td>                
                <td class="ltr">                    
                    <code><?php echo $access->token; ?></code>
                </td>                
            </tr>  
                
        <?php }elseif($type == "ip"){ ?>
                    
            <tr>                        
                <td style="width: 150px;">المستخدم</td>                
                <td>                    
                    <?php $access->access_u_id; ?> - <?php echo $access->access_u_id; ?>                        
                </td>                
            </tr>  
                                             
            <tr>                        
                <td style="width: 150px;">بداية من IP</td>                
                <td class="ltr">                    
                    <code><?php echo $access->range_start; ?></code>
                    <kbd><?php echo $access->int_start; ?></kbd>
                </td>                
            </tr>  
                            
            <tr>                        
                <td>حتى IP</td>                
                <td  class="ltr">                    
                    <code><?php echo $access->range_end; ?></code>
                    <kbd><?php echo $access->int_end; ?></kbd>
                </td>                
            </tr>  
        
        <?php }elseif($type == "country"){ ?>
        
            
            <tr>                        
                <td style="width: 150px;">الدولة</td>                
                <td>                    
                    <?php echo $access->country_code_ISO3; ?> - <?php echo $access->country_code_ISO2; ?>
                </td>                
            </tr>  
            
        <?php } ?>
                        

           
    </table>
                         
     
</div>


<br>

<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?> - <b class="text-danger"><?php echo $access->access_master_rule == "allow" ? "المنع" : "السماح" ; ?></b></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base.ctrl()."/add_rule/".$type."/".$access->access_id); ?>">إضافة قاعدة جديدة</a>                                
            </div>            
        </div>
    </div>     


    <table class="table table-bordered table-hover table-sm m-0">                
            
        <tr>                        
            <td class="text-center" style="width: 50px;">#</td>                
            <td style="width: 150px;">النوع</td>                
            <td>القيمة</td>                
            <td class="text-center" style="width: 150px;">تعديل</td>                
            <td class="text-center" style="width: 150px;">حذف</td>                
        </tr>               
                
        <?php foreach($rules as $rule){ ?>   
                             
            <tr>                        
                <td><?php echo $rule->rule_id;  ?></td>                
                <td><?php echo $rule->rule_rel_type;  ?></td>                
                <td><?php echo $rule->rule_rel_value; ?></td>                
                <td class="text-center"><a class="btn btn-sm btn-info" href="<?php echo base_url(admin_base.ctrl()."/edit_rule/".$rule->rule_id); ?>">تعديل</a></td>                
                <td class="text-center"><a class="btn btn-sm btn-danger sure" href="<?php echo base_url(admin_base.ctrl()."/delete_rule/".$rule->rule_id); ?>">حذف</a></td>                
            </tr>             

        <?php }  ?>

    </table>

</div>
        