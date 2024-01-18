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
                                                                     
        <?php echo form_open(base_url(admin_base."shortlinks/shorten") , array("class" => "form-horizontal m-0", "role" => "form")); ?>
        
            <div class="form-group">
                <label>الرابط</label>
                <input type="text" class="form-control ltr text-left" name="url">
            </div>        
            
            <div class="form-group">
                <label>compaign</label>
                <input type="text" class="form-control ltr text-left" name="utm_campaign" value="<?php echo "compaign_".date("Y-m") ?>">
            </div>                    
                    
            <div class="form-group">
                <label>medium</label>
                <input type="text" class="form-control ltr text-left" name="utm_medium" value="">
            </div>                    
                                
            <div class="form-group">
                <label>source</label>
                <input type="text" class="form-control ltr text-left" name="utm_source" value="">
            </div>                    
        
            <div class="text-left">
                <button class="btn btn-primary" type="submit">تقصير الرابط</button>                
            </div>
        
        <?php echo form_close(); ?>       
    
    </div>
    
</div>