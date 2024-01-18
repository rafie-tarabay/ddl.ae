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

    <div class="card-body line-height-30">
        
        <div class="row">
            <div class="col-md-4">
                <b>عدد مرات البحث:</b> <code><?php echo $count; ?></code>
            </div>
            <div class="col-md-8 text-left">
            
                <?php echo form_open_multipart(base_url(admin_base.ctrl()."/remove_search_log") , array("class" => "form-inline m-0", "role" => "form")); ?>
                
                    <input type="text" class="form-control mt-0 form-control-sm" name="keywords" placeholder="كلمات البحث">
                    &nbsp;
                    <select class="form-control mt-0 form-control-sm" name="field">
                        <option value="all">ALL</option>
                        <option value="log_title_keywords">title</option>
                        <option value="log_author_keywords">author</option>
                        <option value="log_publisher_keywords">publisher</option>
                        <option value="log_content_keywords">content</option>
                        <option value="log_series_keywords">series</option>
                        <option value="log_subjects_keywords">subjects</option>
                    </select>
                    &nbsp;
                    <button type="submit" class="btn btn-danger mt-0 btn-sm">حذف سجلات البحث</button>                
                    
                <?php echo form_close(); ?>        
            
            </div>
        </div>
        
    </div>

</div>

<?php foreach($records as $record){ ?>                        

    <div class="card card-default mt-4">

        <div class="card-header">   
            <h5 class="mb-0"><?php echo date("Y-m-d h:i A",$record->log_timestamp); ?></h5>
        </div>     

        <table class="table table-bordered table-hover table-sm m-0">                

            <?php if(!is_null($record->log_title_keywords)){ ?>                            
                <tr>                        
                    <td style="width: 150px;">العنوان</td>                
                    <td colspan="2"><?php echo $record->log_title_keywords; ?></td>                
                </tr>                             
            <?php } ?>

            <?php if(!is_null($record->log_author_keywords)){ ?>                            
                <tr>                        
                    <td style="width: 150px;">المؤلف</td>                
                    <td colspan="2"><?php echo $record->log_author_keywords; ?></td>                
                </tr>  
            <?php } ?>

            <?php if(!is_null($record->log_content_keywords)){ ?>                                                        
                <tr>                        
                    <td>المحتوى</td>                
                    <td colspan="2"><?php echo $record->log_content_keywords; ?></td>                
                </tr>  
            <?php } ?>

            <?php if(!is_null($record->log_series_keywords)){ ?>                                                                          
                <tr>                        
                    <td>السلسلة</td>                
                    <td colspan="2"><?php echo $record->log_series_keywords; ?></td>                
                </tr> 
            <?php } ?>

            <?php if(!is_null($record->log_subjects_keywords)){ ?>                                                                                       
                <tr>                        
                    <td>الموضوع</td>                
                    <td colspan="2"><?php echo $record->log_subjects_keywords; ?></td>                
                </tr>  
            <?php } ?>

            <?php if(!is_null($record->log_bibloType_filters)){ ?>                                                                                       
                <tr>                        
                    <td>نوع المحتوى</td>                
                    <td colspan="2"><?php echo $record->log_bibloType_filters; ?></td>                
                </tr>  
            <?php } ?>

            <?php if(!is_null($record->log_subjects_filters)){ ?>                                                                                       
                <tr>                        
                    <td>الموضوعات</td>                
                    <td colspan="2"><?php echo $record->log_subjects_filters; ?></td>                
                </tr>  
            <?php } ?>

            <?php if(!is_null($record->log_sources_filters)){ ?>                                                                                       
                <tr>                        
                    <td>المصادر</td>                
                    <td colspan="2"><?php echo $record->log_sources_filters; ?></td>                
                </tr>  
            <?php } ?>

            <tr>                        
                <td style="width: 150px;">السيشن</td>                
                <td colspan="2"><?php echo $record->log_session; ?></td>                
            </tr>  

            <tr>                        
                <td>IP</td>                
                <td colspan="2"><?php echo $record->log_ip; ?></td>                
            </tr>  

            <tr>                        
                <td>الدولة</td>                
                <td colspan="2"><?php echo $record->log_country; ?></td>                
            </tr>  

        </table>


    </div>


<?php } ?>

<div class="text-center mt-4">
    <?php echo $pagination; ?>
</div>


