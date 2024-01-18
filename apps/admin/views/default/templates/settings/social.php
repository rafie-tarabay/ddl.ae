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
    


    <?php echo form_open(base_url(admin_base."settings/update_social") , array("class" => "form-horizontal", "role" => "form")); ?>

        <div class="card-body">


            <h3><b>فيسبوك</b></h3>
            
            <div class="form-group">
                <label for="fb_link" class="col-lg-3 control-label">رابط صفحة الفيسبوك</label>
                <div class="col-lg-8">
                    <input autocomplete="off" class="form-control" name="fb_link" id="fb_link" value="<?php echo settings("fb_link"); ?>" />
                </div>
            </div>

            <h3><b>تويتر</b></h3>
            
            <div class="form-group">
                <label for="tw_link" class="col-lg-3 control-label">رابط حساب تويتر</label>
                <div class="col-lg-8">
                    <input autocomplete="off" class="form-control" name="tw_link" id="tw_link" value="<?php echo settings("tw_link"); ?>" />
                </div>
            </div>                    

            <h3><b>انستجرام</b></h3>
            
            <div class="form-group">
                <label for="instagram_link" class="col-lg-3 control-label">رابط حساب انستجرام</label>
                <div class="col-lg-8">
                    <input autocomplete="off" class="form-control" name="instagram_link" id="instagram_link" value="<?php echo settings("instagram_link"); ?>" />
                </div>
            </div>                    

           
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>




     