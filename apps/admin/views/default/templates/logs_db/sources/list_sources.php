<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()."/refresh_source_revenues/"); ?>">تحديث العوائد</a>
            </div>            
        </div>
    </div>     


    <table class="sites_table table table-bordered table-hover " >
        
        <tr class="active">
            <th>المصدر</th>
            <th width="150px" class="text-center">عوائد الشراء الفردي</th>            
            <?php if(can("view_sources") == "all"){ ?>
                <th width="120px" class="text-center">اجمالي</th>
                <th width="120px" class="text-center">مجانية</th>            
            <?php } ?>
            <th width="140px" class="text-center">دخول مجاني</th>
            <th width="120px" class="text-center">مشتراه</th>            
            <th width="120px" class="text-center">الحالة</th>                        
        </tr>

        <?php foreach($sources as $source){ ?>
        
            <tr>
                <td>  
                    <a href="<?php echo base_url(admin_base.ctrl()."/source_statistics/".$source->id); ?>">               
                        <?php echo $source->id; ?> - <?php echo $source->title_ar; ?>
                    </a>
                </td>

                <td class="text-center">
                    <?php echo $source->revenues; ?>
                </td>                 
                
                <?php if(can("view_sources") == "all"){ ?>
                    <td class="text-center">
                        <?php echo $source->count; ?>
                    </td>            
                    
                    <td class="text-center">
                        <?php echo $source->count_free_material; ?>
                    </td> 
                <?php } ?>           
                
                <td class="text-center">
                    <?php if($source->count_free_access){ ?>
                        <b class="text-danger"><?php echo $source->count_free_access; ?></b>
                    <?php }else{ ?>
                        <?php echo $source->count_free_access; ?>
                    <?php } ?>
                </td>            
                
                <td class="text-center">
                    <?php if($source->count_purchased){ ?>
                        <b class="text-danger"><?php echo $source->count_purchased; ?></b>
                    <?php }else{ ?>
                        <?php echo $source->count_purchased; ?>
                    <?php } ?>                
                </td>                                                            
                                
                <td class="text-center">
                    <?php if(can("control_sources")){ ?>
                        <?php if($source->disabled){ ?>
                            <a class="btn btn-sm btn-light border" href="<?php echo base_url(admin_base.ctrl()."/toggle_source/".$source->id."/0"); ?>"><i class="fa fa-times text-danger"></i> تفعيل</a>
                        <?php }else{ ?>
                            <a class="btn btn-sm btn-light border" href="<?php echo base_url(admin_base.ctrl()."/toggle_source/".$source->id."/1"); ?>"><i class="fa fa-check text-success"></i> إيقاف</a>
                        <?php } ?>                
                    <?php }else{ ?>                
                        <?php if($source->disabled){ ?>
                            <a class="btn btn-sm btn-light border"><i class="fa fa-times text-danger"></i> موقوف</a>
                        <?php }else{ ?>
                            <a class="btn btn-sm btn-light border"><i class="fa fa-check text-success"></i> فعال</a>
                        <?php } ?>                                    
                    <?php } ?>
                </td>                                                            
                
            </tr>
            
        <?php } ?>
        

    </table>    
       


</div>
   