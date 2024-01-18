<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            
            <div class="col-md-6 no-padding text-left">        
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)) ?>" ><i class="fa fa-language"></i> اللغات</a>                
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/words") ?>" ><i class="fa fa-sort-alpha-asc"></i> العبارات</a>                                
            </div>                        
          
        </div>
    </div>   
    
    <?php 
        if(@$lang->lang_alias){
            $func = "update_lang";            
        }else{
            $func = "insert_lang";            
        }    
    ?>


    <?php echo form_open_multipart(base_url(admin_base."language/$func") , array("class" => "form", "role" => "form")); ?>

        <div class="card-body">
        
            <div class="form-group">     
                <label>الإسم المختصر للغة <span class="mandatory">*</span> <span class="text-danger">( بالإنجليزية فقط )</span></label>
                <input type="text" name="lang_alias" style="direction: ltr;"  value="<?php echo @$lang->lang_alias; ?>" class="form-control"/>                        
                <div class="alert alert-info">                
                    أقصى عدد للحروف : 3 حروف فقط .. مثال : en , ar , fr ,ru
                </div>                  
            </div>        
        
        
            <div class="form-group">     
                <label>اسم اللغة <span class="mandatory">*</span> <span class="text-danger">( يظهر فى الرئيسية )</span></label>
                <input type="text" name="lang_title" value="<?php echo @$lang->lang_title; ?>" class="form-control"/>                                        
            </div>          


            <div class="form-group">     
                <label>إتجاه اللغة <span class="mandatory">*</span></label>
                <select name="lang_dir" autocomplete="off" class="form-control">
                    <option value="ltr" <?php if(@$lang->lang_dir == "ltr"){ echo 'selected = "selected"';  }?> >من اليسار لليمين</option>
                    <option value="rtl" <?php if(@$lang->lang_dir == "rtl"){ echo 'selected = "selected"';  }?> >من اليمين لليسار</option>
                </select>
            </div>            

            <div class="form-group">     
                <label class="control-label">علم اللغة <span class="mandatory">*</span></label>
                <input type="text" name="lang_flag" style="direction: ltr;"  value="<?php echo @$lang->lang_flag; ?>" class="form-control"/>                        
                <div class="alert alert-info">                
                    اسم الملف الخاص بعلم اللغة الموجود فى المسار <code><?php echo upload_base."langs/"; ?></code>
                </div>                  
            </div>  
                    

            <input type="hidden" name="old_alias" value="<?php echo @$lang->lang_alias; ?>" />
            

        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>
