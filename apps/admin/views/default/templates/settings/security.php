<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">

            </div>            
        </div>
    </div>                                             
                                                                                                    


    <?php echo form_open(base_url(admin_base."settings/update_security") , array("class" => "form-horizontal check_submit", "release"=>"true",  "role" => "form")); ?>

        <div class="card-body">
           
            <h3><b>حماية لوحة التحكم</b></h3>                  

            <div class="form-group">
                <label for="enable_login_pincode" class="col-lg-3 control-label">تفعيل رمز الحماية <i class="fa fa-info-circle" rel="tooltip" title="يطلب عند تسجيل الدخول إلى لوحة التحكم بالإضافة لكلمة المرور واسم المستخدم"></i></label>
                <div class="col-lg-8">

                    <select name="enable_login_pincode" id="enable_login_pincode" class="form-control"  autocomplete="off">
                        <option value="1" <?php if(settings("enable_login_pincode") == 1 ){ echo 'selected = "selected"'; } ?>>نعم</option>
                        <option value="0" <?php if(settings("enable_login_pincode") == 0 ){ echo 'selected = "selected"'; } ?>>لا</option>
                    </select>                
                </div>
            </div>             
            
            <div class="form-group">
                <label for="login_pincode" class="col-lg-3 control-label">رمز الحماية</label>
                <div class="col-lg-8">
                    <input autocomplete="off" class="form-control" name="login_pincode" id="login_pincode"  value="<?php echo settings("login_pincode"); ?>" />
                    <div class="alert alert-danger">فى حالة فقد هذا الرمز فإنه لا يمكن إستعادته إلا من خلال التعديل المباشر فى قاعدة البيانات</div>
                </div>
            </div>
            
            <hr />
           
            <h3><b>الحماية من السبام Recaptcha <i class="fa fa-info-circle" rel="tooltip" title="أرقام وحروف مكتوبة بشكل عشوائى للحماية من السبام فى التعليقات و غيرها"></i></b></h3>                  
                  
             <a style="font-family: tahoma;" href="https://www.google.com/recaptcha" target="_blank">احصل على مفاتيح الكباتشا من هنا</a>
             <br /><br />
             
            <div class="form-group">                                                            
                <label for="enable_recaptcha" class="col-lg-3 control-label">تفعيل Recaptcha</label>
                <div class="col-lg-8">

                    <select name="enable_recaptcha" id="enable_recaptcha" class="form-control"  autocomplete="off">
                        <option value="1" <?php if(settings("enable_recaptcha") == 1 ){ echo 'selected = "selected"'; } ?>>نعم</option>
                        <option value="0" <?php if(settings("enable_recaptcha") == 0 ){ echo 'selected = "selected"'; } ?>>لا</option>
                    </select>                
                </div>
            </div>                 
                  
            <div class="form-group">
                <label for="recaptcha_site_key" class="col-lg-3 control-label">recaptcha site key</label>
                <div class="col-lg-8">
                    <input autocomplete="off" class="form-control" name="recaptcha_site_key" id="recaptcha_site_key" value="<?php echo settings("recaptcha_site_key"); ?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label for="recaptcha_secret_key" class="col-lg-3 control-label">recaptcha secret key</label>
                <div class="col-lg-8">
                    <input autocomplete="off" class="form-control" name="recaptcha_secret_key" id="recaptcha_secret_key" value="<?php echo settings("recaptcha_secret_key"); ?>" />
                </div>
            </div>                
              
           
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>

     



<script>
    $(document).ready(function(){ 
    
            var enable_pin;
            
            var enable_recaptcha;
            
            
            $("#enable_login_pincode").change(function(){
                
                enable_pin = $("#enable_login_pincode").val();
                if(enable_pin == 1){
                    $("#login_pincode").addClass("req_field green_border red_border ");
                }else if(enable_pin == 0){
                    $("#login_pincode").removeClass("req_field green_border red_border");
                }
                                
            }).change();                
            
            $("#enable_recaptcha").change(function(){
                
                enable_recaptcha = $("#enable_recaptcha").val();
                if(enable_recaptcha == 1){
                    $("#recaptcha_site_key").addClass("req_field green_border red_border ");
                    $("#recaptcha_secret_key").addClass("req_field green_border red_border ");
                }else if(enable_recaptcha == 0){
                    $("#recaptcha_site_key").removeClass("req_field green_border red_border");
                    $("#recaptcha_secret_key").removeClass("req_field green_border red_border");
                }
                                
            }).change();                       
        
    });    
</script>


       
     