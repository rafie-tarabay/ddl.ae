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



    <?php echo form_open(base_url(admin_base."settings/update_email") , array("class" => "form-horizontal check_submit", "role" => "form", "release" => "true") ); ?>

    <div class="card-body">

        <div class="alert alert-warning2">عند تغيير أي بريد يجب التأكد من أن بيانات ال SMTP الخاصة به متوفره في ملف ال models/mail.php</div>

        <div class="form-group">
            <label for="site_email" class="col-lg-3 control-label">بريد الموقع <span class="text-danger">*</span> </label>
            <div class="col-lg-8">
                <input type="email" autocomplete="off" class="form-control req_field" name="site_email" id="site_email" value="<?php echo settings("site_email"); ?>" />
            </div>
        </div>
                 

    </div>    


    <div class="card-footer" style="text-align: left;">
        <button class="btn btn-success" type="submit">حفظ</button>
    </div>             

    <?php echo form_close(); ?>        

</div>




