<script src="<?php echo no_protocol(base_url("assets/libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js")); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo no_protocol(base_url("assets/libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.css")); ?>">

<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base.ctrl()); ?>">رجوع</a>                
            </div>            
        </div>
    </div>     


    <?php echo form_open_multipart(base_url(admin_base.ctrl()."/".$method) , array("class" => "", "role" => "form")); ?>

        <div class="card-body">                   
                          
            <div class="form-group">
                <label>اسم السجل <span class="text-danger">*</span></label>
                <input class="form-control req_field" name="identifier" value="<?php echo @$access->identifier ?>" />
            </div>                 
              

            <?php if($type == "token"){ ?>
            
                <div class="form-group">
                    <label>Token <span class="text-danger">*</span></label>
                    <input type="text" class="form-control req_field ltr text-left" name="token" value="<?php echo @$access->token ? $access->token : gen_hash(15); ?>">
                </div>  
                                
                <div class="form-group">
                    <label>Token group<span class="text-danger">*</span></label>
                    <input type="text" class="form-control req_field ltr text-left" name="group_id" value="<?php echo @$access->group_id ? $access->group_id : "individual"; ?>">
                </div>  
                    
            <?php }elseif($type == "ip"){ ?>
                                      
                <div class="row">
                
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>بداية من IP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control req_field ltr text-left" maxlength="15" name="range_start" id="range_start" value="<?php echo @$access->range_start ?>">
                        </div>                                               
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>حتى IP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control req_field ltr text-left" maxlength="15" name="range_end" id="range_end"  value="<?php echo @$access->range_end ?>">
                        </div>                
                    </div>
                
                </div>  
                
                <div class="form-group">
                    <label>ID المستخدم <span class="text-danger">*</span></label>
                    <input type="text" class="form-control req_field ltr text-left" name="access_u_id" value="<?php echo @$access->access_u_id ? $access->access_u_id : 0; ?>">
                </div>                  
                                         

            
            <?php }elseif($type == "country"){ ?>
            

                <div class="row">
                
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>كود ISO3 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control req_field ltr text-left" maxlength="3" name="country_code_ISO3"  value="<?php echo @$access->country_code_ISO3 ?>">
                        </div>                                               
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>كود ISO2 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control req_field ltr text-left" maxlength="2" name="country_code_ISO2"   value="<?php echo @$access->country_code_ISO2 ?>">
                        </div>                
                    </div>
                
                </div>               
            
                
            <?php } ?>
                                       
              
              
            <div class="row">
            
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>يبدأ من</label>
                        <input type="text" class="form-control ltr text-left datepicker" maxlength="10" name="access_start" id="access_start" placeholder="MM/DD/YYYY">
                    </div>                                               
                </div>
                
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>ينتهي في</label>
                        <input type="text" class="form-control ltr text-left datepicker" maxlength="10" name="access_expire" id="access_expire" placeholder="MM/DD/YYYY">
                    </div>                
                </div>
            
            </div>          
                        
                        
            <div class="form-group">
                <label>العدد المسموح</label>
                <input class="form-control" name="access_limit" value="<?php echo @$access->access_limit ?>" />
            </div>                 
                                      
                        
            <div class="form-group">
                <label>القاعدة الأساسية <span class="text-danger">*</span></label>
                <select class="form-control req_field" name="access_master_rule">
                    <option <?php if(@$access->access_master_rule == "allow" ){ echo 'selected = "selected"'; } ?> value="allow">السماح</option>
                    <option <?php if(@$access->access_master_rule == "deny" ){ echo 'selected = "selected"'; } ?> value="deny">المنع</option>
                </select>
                <div class="alert alert-danger">
                    إذا كانت القاعدة الأساسية هي السماح فإن القواعد المرتبطة بهذا ال Access ID هي استثناءات أي منع
                </div>
            </div>            
                     
                     
            <div class="alert alert-warning">
                <div class="form-group">
                    <label>تفعيل تنبيه الإدارة <span class="text-danger">[يجب ان يكون هناك تاريخ محدد للبدء والإنتهاء]</span></label>
                    <select class="form-control req_field" name="access_notif" id="access_notif">
                        <option <?php if(@$access->access_notif == 0 ){ echo 'selected = "selected"'; } ?> value="0">لا</option>
                        <option <?php if(@$access->access_notif == 1 ){ echo 'selected = "selected"'; } ?> value="1">نعم</option>                        
                    </select>
                </div>  
                
                <div class="d-none" id="access_notif_rule_container">
                
                    <div class="form-group">
                        <label>قاعدة التنبيه <span class="text-danger">*</span></label>
                        <select class="form-control req_field" name="access_notif_rule" id="access_notif_rule">
                            <option <?php if(@$access->access_notif_rule === "0.25" ){ echo 'selected = "selected"'; } ?> value="0.25">الربع الأخير من المدة</option>
                            <option <?php if(@$access->access_notif_rule === "0.5" ){ echo 'selected = "selected"'; } ?> value="0.5">النصف الأخير من المدة</option>
                            <option <?php if(@$access->access_notif_rule === "-1 month" ){ echo 'selected = "selected"'; } ?> value="-1 months">قبل شهر</option>
                            <option <?php if(@$access->access_notif_rule === "-2 months" ){ echo 'selected = "selected"'; } ?> value="-2 months">قبل شهرين</option>
                            <option <?php if(@$access->access_notif_rule === "-3 months" ){ echo 'selected = "selected"'; } ?> value="-3 months">قبل 3 شهور</option>
                            <option <?php if(@$access->access_notif_rule === "-1 week" ){ echo 'selected = "selected"'; } ?> value="-1 week">قبل أسبوع</option>
                        </select>
                    </div>                  
                                
                    <?php if($access->access_notif_date){ ?>
                        <div class="form-group">
                            <label>التنبيه الحالي</label>
                            <div class="text-danger"><?php echo $access->access_notif_date; ?></div>
                        </div>                  
                    <?php } ?>
                
                </div>
                                
            </div>
                                           
                        
            <div class="form-group">
                <label>فعال <span class="text-danger">*</span></label>
                <select class="form-control req_field" name="access_denied">
                    <option <?php if(@$access->access_denied == 0 ){ echo 'selected = "selected"'; } ?> value="0">نعم</option>
                    <option <?php if(@$access->access_denied == 1 ){ echo 'selected = "selected"'; } ?> value="1">لا</option>
                </select>
            </div>            
     
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>           
        
                     
        <input type="hidden" name="type" id="type" value="<?php echo @$type; ?>" />        
        <input type="hidden" name="access_id" id="access_id" value="<?php echo @$access->access_id; ?>" />        
                   

    <?php echo form_close(); ?>        



</div>




<script>
    $( function() {
        $( ".datepicker" ).datepicker({
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            yearRange: "<?php echo date("Y") ?>:<?php echo date("Y" , strtotime("+5 years")) ?>",
            dateFormat: "yy-mm-dd"
        });
        <?php @$access_start = $access->access_start ? $access->access_start : date("Y-m-d") ?>
        $( "#access_start" ).datepicker( "setDate", "<?php echo @date("Y-m-d",strtotime($access_start)) ?>" );
        
        <?php @$access_expire = $access->access_expire ? $access->access_expire : date("Y-m-d", strtotime( date("Y-m-d")." +1 day")) ?>
        $( "#access_expire"   ).datepicker( "setDate", "<?php echo @date("Y-m-d",strtotime($access_expire)) ?>"   );
    } );


    $( document ).ready(function() {
        
        $("#access_notif").on("change",function(){
            var access_start = $("#access_start").val();
            var access_expire = $("#access_expire").val();
            var access_notif = $(this).val();
            if(access_notif == 1 && access_start && access_expire){
                $("#access_notif_rule_container").removeClass("d-none");
            }else{
                $("#access_notif_rule_container").addClass("d-none");
                $(this).val(0);
            }
        }).change();
        
    });
    
</script>     

