<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">

            </div>            
        </div>
    </div>     

    
    <?php 
        if(@$page->page_id){
            $func = "update_page";            
        }else{
            $func = "insert_page";            
        }    
    ?>


    <?php echo form_open_multipart(base_url(admin_base."pages/$func") , array("class" => "form-horizontal", "role" => "form")); ?>

        <div class="card-body">     
        
            <div class="form-group">
                <label for="page_alias" class="control-label">مميز للصفحة <span class="text-danger">( بالإنجليزية فقط )</span></label>
                <input  class="form-control" name="page_alias" id="page_alias" value="<?php echo @$page->page_alias; ?>" />
                <div class="alert alert-warning">
                
                    <b>يجب إتباع الشروط الآتيه عند كتابة مميز الصفحة :</b>
                    <ul style="padding:10px;">
                        <li>يمكن أن يحتوى على [ حروف إنجليزية  ]  [ أرقام  ]  [ - أو _  ] فقط لا غير</li>
                        <li>لا توجد به مسافات</li>
                        <li>غير مكرر أو مستخدم من قبل فى صفحة أخرى</li>                    
                    </ul>
                    
                    <b>مثال : our-services</b>
                
                </div>                    
            </div>
                                  
                                    
            <div class="form-group">
                <label for="page_title_ar" class="control-label">عنوان الصفحة عربي</label>
                <input  class="form-control" name="page_title_ar" id="page_title_ar" value="<?php echo @$page->page_title_ar; ?>" />
            </div>
                                                        
            <div class="form-group">
                <label for="page_title_en" class="control-label">عنوان الصفحة إنجليزي</label>
                <input  class="form-control" name="page_title_en" id="page_title_en" value="<?php echo @$page->page_title_en; ?>" />
            </div>
                    
            <div class="form-group">
                <label for="page_desc_ar" class="control-label">وصف الصفحة عربي</label>
                <input  class="form-control" name="page_desc_ar" id="page_desc_ar" value="<?php echo @$page->page_desc_ar; ?>" />
            </div>
                    
            <div class="form-group">
                <label for="page_desc_en" class="control-label">وصف الصفحة إنجليزي</label>
                <input  class="form-control" name="page_desc_en" id="page_desc_en" value="<?php echo @$page->page_desc_en; ?>" />
            </div>

            <div class="form-group">
                <label for="page_keywords_ar" class="control-label">الكلمات المفتاحية عربي</label>
                <input  class="form-control" name="page_keywords_ar" id="page_keywords_ar" value="<?php echo @$page->page_keywords_ar; ?>" />
            </div>            
            
            <div class="form-group">
                <label for="page_keywords_en" class="control-label">الكلمات المفتاحية إنجليزي</label>
                <input  class="form-control" name="page_keywords_en" id="page_keywords_en" value="<?php echo @$page->page_keywords_en; ?>" />
            </div>            
            
            <div class="form-group">
                <label for="page_text_ar" class="control-label">محتوى الصفحة عربي</label>
                <textarea class="form-control editor" name="page_text_ar" id="page_text_ar"><?php echo @$page->page_text_ar; ?></textarea>
            </div>
                        
            <div class="form-group">
                <label for="page_text_en" class="control-label">محتوى الصفحة إنجليزي</label>
                <textarea class="form-control editor" name="page_text_en" id="page_text_en"><?php echo @$page->page_text_en; ?></textarea>
            </div>
            


            <div class="form-group">
                <label for="page_listed" class="control-label">ظهور</label>
                <select name="page_listed" id="page_listed" class="form-control"  >
                    <option value="1" <?php if(@$page->page_listed == 1 ){ echo 'selected = "selected"'; } ?>>نعم</option>
                    <option value="0" <?php if(@$page->page_listed == 0 ){ echo 'selected = "selected"'; } ?>>لا</option>
                </select>                
            </div>          
                                            
            <div class="form-group">
                <label for="page_order" class="control-label">ترتيب الصفحة</label>
                <input  class="form-control" name="page_order" id="page_order" value="<?php echo @$page->page_order; ?>" />
            </div>
                                                   

            <input type="hidden" name="page_id" value="<?php echo @$page->page_id; ?>" />
            

        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>

     