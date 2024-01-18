<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-primary btn-sm pull-left" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/add_page") ?>" ><i class="fa fa-plus"></i> أضف جديد</a>
            </div>            
        </div>
    </div>     


    <div class="card-body">


        <table class="sites_table table table-bordered table-hover" >
            
            <tr class="active">
                <th>الصفحة</th>
                <th width="50px" class="text-center">تعديل</th>
                <th width="50px" class="text-center">حذف</th>
            </tr>
        
            <?php if($pages){ ?>
        
            <?php foreach($pages as $page){ ?>
            
                <tr>
                    <td>  
                        <a href="<?php echo base_url(admin_base.ctrl()."/edit_page/".$page->page_id); ?>">               
                            <?php echo $page->page_order; ?> - <?php echo $page->page_title_ar; ?>
                        </a>
                        <br />
                        <code><?php echo $page->page_alias; ?></code>
                    </td>
                                    
                    <td class="text-center"><a href="<?php echo base_url(admin_base."pages/edit_page/".$page->page_id); ?>">تعديل</a></td>
                    <td class="text-center"><a href="<?php echo base_url(admin_base."pages/delete_page/".$page->page_id); ?>">حذف</a></td>
                </tr>
                
            <?php } ?>
            
            <?php }else{ ?>

                <tr>
                    <td  colspan="8">لا يوجد صفحات</td>
                </tr>            
            
            <?php } ?>


        </table>    

       
       
    </div>
    
    
    <?php if(@$pagination){ ?>
        <div class="card-footer">
            <?php echo @$pagination; ?>
        </div>
    <?php } ?>   
    
</div>
   