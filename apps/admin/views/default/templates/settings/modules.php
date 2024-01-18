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
    


    <?php echo form_open(base_url(admin_base."settings/update_modules") , array("class" => "form-horizontal", "role" => "form")); ?>

        <div class="card-body">

            <div class="form-group">
                <label for="enable_header_socials" class="col-lg-3 control-label">أيكونات التواصل بالهيدر</label>
                <div class="col-lg-8">

                    <select name="enable_header_socials" id="enable_header_socials" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_header_socials == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_header_socials == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div> 
            
            <div class="form-group">
                <label for="enable_lang_switch" class="col-lg-3 control-label">زر تغيير اللغة</label>
                <div class="col-lg-8">

                    <select name="enable_lang_switch" id="enable_lang_switch" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_lang_switch == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_lang_switch == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                     


            
            <div class="form-group">
                <label for="enable_navbar" class="col-lg-3 control-label">الناف بار</label>
                <div class="col-lg-8">

                    <select name="enable_navbar" id="enable_navbar" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_navbar == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_navbar == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>   
            
            
            <div class="form-group">
                <label for="enable_news" class="col-lg-3 control-label">الأخبار و السليدر</label>
                <div class="col-lg-8">

                    <select name="enable_news" id="enable_news" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_news == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_news == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                       
            

            <div class="form-group">
                <label for="enable_promos" class="col-lg-3 control-label">كلمات البرومو</label>
                <div class="col-lg-8">

                    <select name="enable_promos" id="enable_promos" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_promos == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_promos == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>        
            
            
            <div class="form-group">
                <label for="enable_projects" class="col-lg-3 control-label">المشاريع projects</label>
                <div class="col-lg-8">

                    <select name="enable_projects" id="enable_projects" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_projects == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_projects == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                      
                             
            
            <div class="form-group">
                <label for="enable_partners" class="col-lg-3 control-label">الشركاء partners</label>
                <div class="col-lg-8">

                    <select name="enable_partners" id="enable_partners" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_partners == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_partners == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>       
            
                             
            
            <div class="form-group">
                <label for="enable_clients" class="col-lg-3 control-label">العملاء clients</label>
                <div class="col-lg-8">

                    <select name="enable_clients" id="enable_clients" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_clients == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_clients == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                        
                                
            
            
            <div class="form-group">
                <label for="enable_products" class="col-lg-3 control-label">المنتجات products</label>
                <div class="col-lg-8">

                    <select name="enable_products" id="enable_products" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_products == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_products == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>     
            
            <div class="form-group">
                <label for="enable_serials" class="col-lg-3 control-label">الأرقام المسلسلة للمنتجات</label>
                <div class="col-lg-8">
                    <select name="enable_serials" id="enable_serials" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_serials == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_serials == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                 
                               
            
            
            <div class="form-group">
                <label for="enable_events" class="col-lg-3 control-label">الأحداث Events</label>
                <div class="col-lg-8">

                    <select name="enable_events" id="enable_events" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_events == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_events == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                       
            
            
            <div class="form-group">
                <label for="enable_videos" class="col-lg-3 control-label">الفديوهات Videos</label>
                <div class="col-lg-8">

                    <select name="enable_videos" id="enable_videos" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_videos == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_videos == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div> 
            
            
            <div class="form-group">
                <label for="enable_photos" class="col-lg-3 control-label">الصور photos</label>
                <div class="col-lg-8">

                    <select name="enable_photos" id="enable_photos" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_photos == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_photos == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>            
            
            
            <div class="form-group">
                <label for="enable_social_widgets" class="col-lg-3 control-label">التواصل Social widgets</label>
                <div class="col-lg-8">

                    <select name="enable_social_widgets" id="enable_social_widgets" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_social_widgets == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_social_widgets == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                                                           
            

            <div class="form-group">
                <label for="enable_contact_info" class="col-lg-3 control-label">الدخول لصفحة الإتصال بنا</label>
                <div class="col-lg-8">

                    <select name="enable_contact_info" id="enable_contact_info" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_contact_info == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_contact_info == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                        
            
            <div class="form-group">
                <label for="enable_guestbook" class="col-lg-3 control-label">سجل الزوار  guestbook</label>
                <div class="col-lg-8">

                    <select name="enable_guestbook" id="enable_guestbook" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_guestbook == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_guestbook == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                         
            

            <div class="form-group">
                <label for="enable_branches" class="col-lg-3 control-label">فروع الشركة</label>
                <div class="col-lg-8">

                    <select name="enable_branches" id="enable_branches" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_branches == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_branches == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                       
                              
                    
            <div class="form-group">
                <label for="enable_support" class="col-lg-3 control-label">نظام تذاكر الدعم الفنى</label>
                <div class="col-lg-8">

                    <select name="enable_support" id="enable_support" class="form-control"  autocomplete="off">
                        <option value="1" <?php if($settings->enable_support == 1 ){ echo 'selected = "selected"'; } ?>>مفعل</option>
                        <option value="0" <?php if($settings->enable_support == 0 ){ echo 'selected = "selected"'; } ?>>معطل</option>
                    </select>                
                </div>
            </div>                        

        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>




     