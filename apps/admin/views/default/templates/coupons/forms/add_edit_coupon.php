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


    <?php echo form_open(base_url(admin_base.ctrl()."/".$method) , array("class" => "", "role" => "form")); ?>

        <div class="card-body">                   
                                     
            <div class="form-group">
                <label>كود الكوبون<span class="text-danger">*</span></label>
                <input class="form-control req_field" name="coupon_code" value="<?php echo @$coupon->coupon_code ?>" />
            </div>                

            
            <div class="alert alert-info">
                                                                              
                <div class="row">
         
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>نسبة الخصم<span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">%</span>
                              </div>
                              <input class="form-control req_field" name="coupon_percent" value="<?php echo @$coupon->coupon_percent ?>" />
                            </div>                                                
                        </div>                                        
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>بحد أقصى <span class="text-info">[اختياري]</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">USD</span>
                              </div>
                              <input class="form-control " name="coupon_max_amount" value="<?php echo @$coupon->coupon_max_amount ?>" />
                            </div>                                                                                                
                        </div>                                        
                    </div>   
                                        
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>الحد الأدنى للطلب <span class="text-info">[اختياري]</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">USD</span>
                              </div>
                              <input class="form-control " name="coupon_min_order" value="<?php echo @$coupon->coupon_min_order ?>" />
                            </div>                                                
                        </div>                                        
                    </div>                    
                                 
                </div>                                             
                                    
            </div>
                                  
            
            
            <div class="alert alert-success" >
                                                 
                <div class="form-group">
                    <label>أقصى عدد للاستخدام <span class="text-danger">[اختياري]</span></label>
                    <input class="form-control" name="coupon_limit" value="<?php echo @$coupon->coupon_limit ?>" />
                </div>                        
                                                         
                <div class="form-group">
                    <label>الحد الزمني للاستخدام <span class="text-danger">[اختياري]</span></label>
                    <input class="form-control" name="coupon_expire" value="<?php echo @$coupon->coupon_expire ?>" />
                </div>                                
                
            </div>                                
            
            <div class="alert alert-warning">
                                
                <div class="form-group">
                    <label>أرقام العضوية <span class="text-danger">[اختياري]</span></label>
                    <input class="form-control" name="coupon_u_ids" value="" />
                    <div class="alert alert-info small p-1">يتم الفصل بين أرقام العضوية بمسافة</div>
                </div>                
                                                                 
                <div class="form-group">
                    <label>referrer Contains <span class="text-danger">[اختياري]</span></label>
                    <input class="form-control" name="coupon_referrer" value="" />
                    <div class="alert alert-info small p-1">يتم وضع جزء من الرابط الخاص بالمصدر القادم منه المستخدم</div>
                </div>                                
     
     
                <div class="form-group">
                    <label>نوع الطلب <span class="text-danger">[اختياري]</span></label>
                    <select class="form-control req_field" name="coupon_order_type" id="coupon_order_type">
                        <option value="0">أي طلب</option>
                        <option value="digital_items">شراء الكتب</option>
                        <option value="packages">اشتراكات الحزم</option>
                    </select>
                </div>        
     
                <div class="d-none" id="packages_options">
                    <div class="form-group">
                        <label><i class="fa fa-caret-left"></i> الخطة المطبق عليها <span class="text-danger">[اختياري]</span></label>
                        <select class="form-control req_field" name="coupon_plan">
                            <option value="0">كل الخطط</option>
                            <option value="monthly">الشهرية</option>
                            <option value="yearly">السنوية</option>
                        </select>
                    </div>   
         
                    <div class="form-group">
                        <label><i class="fa fa-caret-left"></i> الحزم <span class="text-danger">[اختياري]</span></label>
                        <div class="mb-3"><small class="text-danger">لا تختر أي نوع ليتم التطبيق على الجميع</small></div>
                        <?php foreach($packages as $package){  ?>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pack_<?php echo $package->pack_id; ?>" value="<?php echo $package->pack_id; ?>" name="packs[]" <?php if(@$pack_id == $package->pack_id ) echo 'checked="checked"'; ?> >
                                    <label class="form-check-label" for="pack_<?php echo $package->pack_id; ?>"><?php echo $package->title ?> </label>
                                </div>
                            </div>                            
                        <?php } ?>                
                    </div>        
                </div>
                
            </div>
                                      
                
        </div>                    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>           

    <?php echo form_close(); ?>        


</div>


<script type="text/javascript">
$(document).ready(function() {

    $(document).on("change","#coupon_order_type",function(){
        var order_type = $(this).val();
        if(order_type == "packages"){
            $("#packages_options").removeClass("d-none");
        }else{
            $("#packages_options").addClass("d-none");
        } 
    }).change();
    
});
</script>