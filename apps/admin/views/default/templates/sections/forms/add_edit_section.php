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




    <?php 
        if(@$section->sec_id){
            $func = "update_section";            
        }else{
            $func = "insert_section";            
        }    
    ?>


    <?php echo form_open_multipart(base_url(admin_base."sections/$func") , array("class" => "form-horizontal", "role" => "form")); ?>

        <div class="card-body">     
        
                                    
            <div class="form-group">
                <label>Alias</label>
                <input  class="form-control" name="sec_alias" value="<?php echo @$section->sec_alias; ?>" />
                <div class="alert alert-info">حروف انجليزية بدون أي مسافات</div>
            </div>
                                    
            <div class="form-group">
                <label>الاسم عربي</label>
                <input  class="form-control" name="sec_title_ar" value="<?php echo @$section->sec_title_ar; ?>" />
            </div>     
            
                                           
            <div class="form-group">
                <label>الاسم انجليزي</label>
                <input  class="form-control" name="sec_title_en" value="<?php echo @$section->sec_title_en; ?>" />
            </div>

                                                
            <div class="form-group">
                <label>الوصف عربي</label>
                <input  class="form-control" name="sec_desc_ar" value="<?php echo @$section->sec_desc_ar; ?>" />
            </div>     
            
                                           
            <div class="form-group">
                <label>الوصف انجليزي</label>
                <input  class="form-control" name="sec_desc_en" value="<?php echo @$section->sec_desc_en; ?>" />
            </div>

                    
                                                
            <div class="form-group">
                <label>Cover ar</label>
                <input  class="form-control" name="sec_cover_ar" value="<?php echo @$section->sec_cover_ar; ?>" />
            </div>     
            
                                           
            <div class="form-group">
                <label>Cover en</label>
                <input  class="form-control" name="sec_cover_en" value="<?php echo @$section->sec_cover_en; ?>" />
            </div>

                        
                                           
            <div class="form-group">
                <label>الترتيب</label>
                <input  class="form-control" name="sec_order" value="<?php echo @$section->sec_order; ?>" />
            </div>

                                    
            <input type="hidden" name="sec_id" value="<?php echo @$section->sec_id; ?>" />
            
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>

     