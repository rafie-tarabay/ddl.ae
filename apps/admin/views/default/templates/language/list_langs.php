
<div class="alert alert-danger alert-sm"><i class="fa fa-warning"></i> هذه الخاصية متقدمة , فضلاً لا تقوم بالتعديل أو الإضافة إلا إذا كنت تعرف ما تفعله</div>    
        
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            
            <div class="col-md-6 no-padding text-left">
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/add_lang") ?>" ><i class="fa fa-plus"></i> أضف لغة</a>                                                
                <a class="btn btn-danger btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/rebuild") ?>" ><i class="fa fa-refresh"></i> إعادة بناء الملفات</a>                
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/instructions") ?>" ><i class="fa fa-anchor"></i> الإرشادات</a>                                
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/words") ?>" ><i class="fa fa-sort-alpha-asc"></i> العبارات</a>                                
            </div>                        
          
        </div>
    </div>    

   
    <table class="table">
            <tr>
                <th width="70px" class="text-center">العلم</th>
                <th width="70px" class="text-center">الإتجاه</th>                
                <th width="90px" class="text-center">الإختصار</th>                
                <th>اللغة</th>                
                <th width="90px" class="text-center">رفع</th>                
                <th width="90px" class="text-center">تحميل</th>                
                <th width="100px" class="text-center">تعديل</th>
                <th width="100px" class="text-center">حذف</th>
            </tr>    
    
        <?php foreach(settings("langs") as $lang){ ?>       
            <tr>
                <td class="text-center"><img src="<?php echo base_url(upload_base."langs/".$lang->lang_flag); ?>" /></td>
                <td class="text-center"><i class="fa fa-<?php echo $lang->lang_dir == "rtl" ? "arrow-left":"arrow-right"; ?>"></i></td>                
                <td class="text-center"><b><?php echo $lang->lang_alias; ?></b></td>                
                <td>
                    <?php echo $lang->lang_title ?>
                    <?php if(settings("lang_frontend") == $lang->lang_alias){ ?>( <a href="<?php echo base_url(admin_base."settings"); ?>"><i class="fa fa-check text-success"></i> الإفتراضية</a> )<?php } ?>
                </td>                
                <td class="text-center"><a href="<?php echo base_url(admin_base."language/import/".$lang->lang_alias); ?>"><i class="fa fa-upload"></i></a></td>
                <td class="text-center"><a href="<?php echo base_url(admin_base."language/download/".$lang->lang_alias); ?>"><i class="fa fa-download"></i></a></td>
                <td class="text-center"><a href="<?php echo base_url(admin_base."language/edit_lang/".$lang->lang_alias); ?>"><i class="fa fa-pencil"></i> تعديل</a></td>
                <td class="text-center">
                    <?php if(settings("lang_frontend") !== $lang->lang_alias){ ?>
                        <a href="<?php echo base_url(admin_base."language/delete_lang/".$lang->lang_alias); ?>" class="text-danger sure"><i class="fa fa-trash"></i> حذف</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        
    </table>    

</div>

