<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-primary btn-sm pull-left" href="<?php echo base_url(admin_base.ctrl()."/add_section") ?>" ><i class="fa fa-plus"></i> أضف قسم</a>
                <a class="btn btn-primary btn-sm pull-left" href="<?php echo base_url(admin_base.ctrl()."/add_topic") ?>" ><i class="fa fa-plus"></i> أضف موضوع</a>
            </div>            
        </div>
    </div>     


    <div class="card-body">


        <table class="sites_table table table-bordered table-hover" >
            
            <tr class="active">
                <th>القسم</th>
                <th width="50px" class="text-center">تعديل</th>
                <th width="50px" class="text-center">حذف</th>
            </tr>
        
            <?php if($sections){ ?>
            
                <?php foreach($sections as $section){ ?>
                
                    <tr>
                        <td>
                            <a href="<?php echo base_url(admin_base.ctrl()."/section/".$section->section_id); ?>">               
                                <?php echo $section->section_order; ?> - <?php echo $section->section_title_ar; ?>
                            </a>
                        </td>
                                        
                        <td class="text-center"><a href="<?php echo base_url(admin_base.ctrl()."/edit_section/".$section->section_id); ?>">تعديل</a></td>
                        <td class="text-center"><a href="<?php echo base_url(admin_base.ctrl()."/delete_section/".$section->section_id); ?>">حذف</a></td>
                    </tr>
                    
                <?php } ?>
            
            <?php }else{ ?>

                <tr>
                    <td  colspan="8">لا يوجدأقسام</td>
                </tr>            
            
            <?php } ?>


        </table>    

       
       
    </div>
    
</div>
   