<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base.ctrl()."/add_link"); ?>">تقصير رابط</a>                
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()); ?>">الرجوع</a>                                
            </div>            
        </div>
    </div> 
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <b>عدد الروابط:</b> <code><?php echo $count; ?></code>
            </div>
            <div class="col-md-6 text-left">
                
                <?php echo form_open(base_url(admin_base."shortlinks/search") , array("class" => "form-horizontal m-0", "role" => "form")); ?>
                
                    <div class="input-group">
                        <input type="text" class="form-control" name="keywords" value="<?php echo $keywords; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">بحث</button>
                        </div>
                    </div>                    
                
                <?php echo form_close(); ?>        
                
            </div>        
        </div>

    </div>
        

    <table class="table table-bordered table-hover table-sm mt-2 mb-2">                
                                    
        <tr>                        
            <td class="text-center" style="width: 150px;">الرابط القصير</td>                
            <td class="text-center" style="width: 150px;">عدد الزيارات</td>                
            <td>الرابط الأصلي</td>                
        </tr>  

        <?php foreach($records as $record){ ?>                        
            <tr>                        
                <td class="text-center"><a target="_blank" href="http://link.ddl.ae/<?php echo $record->hash ?>"><?php echo $record->hash ?></a></td>                
                <td class="text-center"><?php echo $record->hits ?></td>                
                <td class="text-left ltr"><?php echo urldecode($record->url) ?></td>                
            </tr>  
        <?php } ?>
                       
    </table>


  
    
</div>
                   
    
<div class="text-center mt-4">
    <?php echo $pagination; ?>
</div>


     