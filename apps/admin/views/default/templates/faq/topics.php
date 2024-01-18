<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base.ctrl()."/add_topic/".$section_id); ?>">إضافة جديد</a>                
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()); ?>">الرجوع</a>                
            </div>            
        </div>
    </div>  
    
    
    <div class="card-body">

        <table class="sites_table table table-bordered table-hover" >
            
            <tr class="active">
                <th>الموضوع</th>
                <th width="50px" class="text-center">تعديل</th>
                <th width="50px" class="text-center">حذف</th>
            </tr>

            <?php if($topics){ ?>
            
                <?php foreach($topics as $topic){ ?>
                
                    <tr>
                        <td>
                            <a href="<?php echo base_url(admin_base.ctrl()."/edit_topic/".$topic->topic_id); ?>">               
                                <?php echo $topic->topic_order; ?> - <?php echo $topic->topic_title_ar; ?>
                            </a>
                        </td>
                                        
                        <td class="text-center"><a href="<?php echo base_url(admin_base.ctrl()."/edit_topic/".$topic->topic_id); ?>">تعديل</a></td>
                        <td class="text-center"><a href="<?php echo base_url(admin_base.ctrl()."/delete_topic/".$topic->topic_id); ?>">حذف</a></td>
                    </tr>
                    
                <?php } ?>
            
            <?php }else{ ?>

                <tr>
                    <td  colspan="8">لا يوجد مواضيع</td>
                </tr>            
            
            <?php } ?>


        </table>               


     
    </div>
    
</div>    
       