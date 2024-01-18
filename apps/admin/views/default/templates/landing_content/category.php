<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base.ctrl()."/new_content/".$cat->cat_name); ?>">إضافة جديد</a>                
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()); ?>">التصنيفات</a>                
            </div>            
        </div>
    </div>     
</div>



<?php foreach($contents as $content){ ?>                        

    <div class="card card-default mt-2">

        <div class="card-header">   
            <h5 class=" mb-0 ">
                #  <code><?php echo $content->content_order; ?></code>     
            </h5>
        </div>  
        
        <div class="card-body">     

            <div class="media">
            
                <?php if($content->content_rel_image1){ ?>
                    <img class="mr-3 img-fluid ml-3" style="width:96px;"  src="<?php echo $content->content_rel_image1."?v=".settings('refresh'); ?>">
                <?php } ?>
                                
                <div class="media-body">
                    
                    <div class="row">
                                        
                        <div class="col-md-7">
                            <?php if(!is_null($content->content_rel_title1)){ ?>
                                <h5 class="mt-0"><?php echo $content->content_rel_title1 ?></h5>
                            <?php }elseif(!is_null($content->content_rel_text1)){ ?>
                                <h5 class="mt-0"><?php echo $content->content_rel_text1 ?></h5>
                            <?php } ?>
                            
                            <?php if(!is_null($content->content_rel_url1)){ ?>
                                <p><?php echo $content->content_rel_url1 ?></p>
                            <?php } ?>  
                        </div>
                        
                        <div class="col-md-5 text-left">
                            <a href="<?php echo base_url(admin_base.ctrl()."/delete_content/".$content->content_id); ?>" class="btn btn-sm btn-dark sure">حذف</a>
                            <a href="<?php echo base_url(admin_base.ctrl()."/edit_content/".$content->content_id); ?>" class="btn btn-sm btn-info">تحديث</a>                    
                            
                            <?php if($content->content_disabled == 1){ ?>
                                <a href="<?php echo base_url(admin_base.ctrl()."/content_toggle/".$content->content_id."/0"); ?>" class="btn btn-sm btn-success"> اظهار</a>                    
                            <?php }else{ ?>
                                <a href="<?php echo base_url(admin_base.ctrl()."/content_toggle/".$content->content_id."/1"); ?>" class="btn btn-sm btn-danger"> اخفاء</a>                    
                            <?php } ?>
                            
                        </div>                      
                        
                    </div>
                    
                            
                    
                </div>
            </div>        
        

        
        </div>    

    </div>


<?php } 



     