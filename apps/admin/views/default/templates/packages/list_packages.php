<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-primary" href="<?php echo base_url(admin_base."packages/add_book/") ?>">إضافة كتاب</a>                
                <a class="btn btn-success" href="<?php echo base_url(admin_base."packages/add_package/") ?>">إضافة حزمة</a>
            </div>            
        </div>
    </div> 


    <table class="table table-bordered table-striped m-0">                
                                    
        <tr>                        
            <td class="text-center" style="width: 100px;">رقم الحزمة</td>                
            <td class="text-center" style="width: 100px;">الترتيب</td>                
            <td>اسم الحزمة</td>                        
            <td class="text-center" style="width: 100px;">عدد</td>                
            <td class="text-center" style="width: 100px;">سعر شهري</td>                
            <td class="text-center" style="width: 100px;">سعر سنوي</td>                
        </tr>   
            
        <?php foreach($packages as $package){ ?>                        

            <tr>                        
                <td class="text-center"><?php echo $package->pack_id; ?></td>                
                <td class="text-center"><?php echo $package->pack_order; ?></td>                
                <td>
                    <a href="<?php echo base_url(admin_base."packages/view_package/".$package->pack_id) ?>">
                        <?php echo $package->title; ?>
                    </a>
                </td>                        
                <td class="text-center"><?php echo $package->pack_count; ?></td>                
                <td class="text-center"><?php echo $package->pack_price_monthly; ?> دولار</td>                
                <td class="text-center"><?php echo $package->pack_price_yearly; ?> دولار</td>                
            </tr>  

        <?php } ?>

    </table>
        
</div>
