<div class="card card-default mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title mb-0">كوبونات التخفيض</h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base."coupons/add_coupon/") ?>">إضافة كوبون</a>                
            </div>            
        </div>
    </div> 


    <table class="table table-bordered table-striped m-0">                
                                    
        <tr>                        
            <td class="text-center" style="width:50px;">#</td>                                     
            <td>كود الكوبون</td>                            
            <td class="text-center" style="width:100px;">نوع الطلب</td>                                     
            <td class="text-center" style="width:200px;">الشروط</td>                                     
            <td class="text-center" style="width:100px;">الحد الأدنى</td>                                     
            <td class="text-center" style="width:150px;">التخفيض</td>                                                 
            <td class="text-center" style="width:120px;">تاريخ الإنتهاء</td>
            <td class="text-center" style="width:100px;">الاستخدام</td>                         
            <td class="text-center" style="width:100px;">إلغاء</td>                         
        </tr>   
            
        <?php foreach($coupons as $coupon){ ?>                        

            <tr>                        
                
                <td class="text-center">
                    <?php echo $coupon->coupon_id; ?>
                </td>
                
                <td>
                    <?php if($coupon->coupon_disabled) echo '<i class="fa fa-times text-danger"></i>'; ?>
                    <?php echo $coupon->coupon_code; ?>
                </td>                
                                       
                <td class="text-center">
                    <?php echo $coupon->coupon_order_type ? word($coupon->coupon_order_type) : "ALL"; ?>
                </td>                
                                      
                <td>
                    <?php $conditions = json_decode($coupon->coupon_conditions); ?>
                    
                    <?php if($conditions){ ?>
                        <div class="ltr text-left">
                            <?php foreach($conditions as $type => $data){ ?>
                                <b class="text-danger"><?php echo $type; ?></b>: 
                                <?php if(is_array($data)){ ?>
                                    <?php echo join("-",$data); ?>
                                <?php }else{ ?>
                                    <?php echo $data; ?>
                                <?php } ?>
                                <br />
                            <?php } ?>
                        </div>
                    <?php }else{ ?>
                        <div class="text-center">بدون</div>
                    <?php } ?>
                    
                </td>                
                                
                <td  class="text-center">
                    <?php echo $coupon->coupon_min_order ? "USD".$coupon->coupon_min_order : "لا يوجد"; ?>
                </td>                
                
                <td class="text-center">
                    <div class="ltr"><?php echo "%".$coupon->coupon_percent.' / $'.$coupon->coupon_max_amount." max"; ?></div>
                </td>                                        
         
                <td class="text-center">
                    <?php
                        if($coupon->coupon_disabled){
                            echo '<i class="fa fa-times text-danger"></i> ملغي';
                        }elseif($coupon->coupon_expire && $coupon->coupon_expire < time()){
                            echo '<i class="fa fa-times text-danger"></i> منتهي';                            
                        }elseif($coupon->coupon_expire){
                            echo date("Y-m-d h:i A",$coupon->coupon_expire);
                        }else{
                            echo "بدون";
                        }
                    ?>
                </td>                                                          
                  
                <td class="text-center"><?php echo $coupon->coupon_usage_count."/".( $coupon->coupon_limit ? $coupon->coupon_limit : "&#8734;" ); ?></td>                  
         
                <td class="text-center">                
                    <?php if($coupon->coupon_disabled == 0){ ?>                    
                        <a class="btn btn-danger btn-xs sure" href="<?php echo base_url(admin_base."coupons/disable_coupon/".$coupon->coupon_id) ?>">إلغاء</a>                                                              
                    <?php }else{ ?>
                         ---
                    <?php } ?>
                </td>   
                
            </tr>  

        <?php } ?>

    </table>
        
</div>

