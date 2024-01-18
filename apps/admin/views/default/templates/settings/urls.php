<div class="alert alert-danger text-center">
    <i class="fa fa-warning text-danger"></i> تحذير هام : تغيير هذه الإعدادات يمكن أن يتسبب فى تعطل الموقع لذلك يجب التعامل معها بشكل حذر.
</div>


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
    
    <?php echo form_open(base_url(admin_base."settings/update_urls") , array("class" => "form-horizontal", "role" => "form")); ?>

        <div class="card-body">
           
            <div class="alert alert-info">
                <i class="fa fa-info-circle text-info"></i> القيم التى ستدخلها فى الخانات أدناه يجب أن تكون أسماء ملفات حقيقية موجوده على السيرفر
            </div>           
           
            <div class="form-group">                                                                      
                <label for="front_base" class="col-lg-3 control-label">ملف روابط الموقع</label>
                <div class="col-lg-8">
                    <input autocomplete="off" class="form-control ltr" name="front_base" id="front_base" placeholder="index.php" value="<?php echo settings("front_base"); ?>" />                    
                    <div class="alert alert-danger no-margin">            
                        إذا كنت تريد حذف ال index.php قم بتفريغ الخانة أعلاه ثم ضع الكود أدناه فى ملف ال <b>.htaccess</b> ثم قم بالضغط على <b>زر حفظ</b>
                    </div>
                    <blockquote class="text-left ltr">            
                        RewriteEngine On<br>
                        RewriteCond %{REQUEST_FILENAME} !-f<br>
                        RewriteCond %{REQUEST_FILENAME} !-d<br>
                        RewriteRule ^(.*)\?*$ index.php?/$1 [L,QSA]<br>
                    </blockquote>                    
                </div>
            </div>
                       
                       
           
            <div class="form-group">
                <label for="admin_base" class="col-lg-3 control-label">ملف روابط لوحة التحكم</label>
                <div class="col-lg-8">
                    <input autocomplete="off" class="form-control ltr" name="admin_base" id="admin_base"  placeholder="admin.php" value="<?php echo settings("admin_base"); ?>" />                    
                    <div class="alert alert-danger no-margin">            
                        لتغيير ملف لوحة التحكم يجب <b>أولاً</b> تحديث الخانة أعلاه ثم الضغط على <b>زر حفظ</b> ثم تحديث اسم الملف الموجود <b>على السيرفر</b> فى هذا المسار
                    </div>
                    <div class="alert alert-warning2 ltr">            
                        <?php echo base_url(admin_base); ?>
                    </div>
                </div>
            </div>                       
         
                            
            <hr />
            
            <div class="alert alert-info">
            
                فى حالة حدوث مشاكل يمكنك إستعادة الحالة الأولى للموقع بعمل الآتى :<br />
                
                <br>
                <b>تعديلات الملفات : </b><br />
                1- تسمية الملف الرئيسي <code>index.php</code><br />
                2- تسمية ملف لوحة التحكم <code>admin.php</code><br />
                
                <br>
                <b>تعديلات قاعدة البيانات جدول settings : </b><br />
                1- تغيير قيمة الخانة front_base إلى <div class="ltr inline"><kbd>index.php</kbd></div><br />
                2- تغيير قيمة الخانة admin_base إلى <div class="ltr inline"><kbd>admin.php</kbd></div>
                
            </div>
                            
                                   
        </div>                      


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>




     