<div class="alert alert-danger"><i class="fa fa-warning"></i> هذه الخاصية متقدمة , فضلاً لا تقوم بالتعديل أو الإضافة إلا إذا كنت تعرف ما تفعله</div>

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
    


    <?php echo form_open( base_url(admin_base."language/insert_word") , array("class" => "check_submit" ,"release"=>"true" ,"role" => "form") ); ?>

        <div class="card-body">                                                                          
           
            <div class="form-group">
                <label for="word_alias">مميز العبارة <span class="text-danger">( بالإنجليزية فقط )</span></label>
                <input type="text" class="form-control req_field ltr" id="word_alias" name="word_alias" />
                <div class="alert alert-info">                
                    لا توجد به مسافات و يمكن أن يحتوى على [ حروف إنجليزية  ]  [ أرقام  ]  [ - أو _  ] فقط لا غير, غير مكرر أو مستخدم من قبل فى كلمة أخرى                 
                </div>                
            </div>
            
  
            <?php foreach(settings("langs") as $lang){ ?>
                <div class="form-group">
                    <label><?php echo $lang->lang_title; ?></label>
                    <div class="input-group input-group-sm">
                      <span class="input-group-addon" id="basic-addon1"><img src="<?php echo base_url(upload_base."langs/".$lang->lang_flag); ?>" /></span>
                      <input spellcheck="true" style="<?php echo "direction:".$lang->lang_dir; ?>" type="text" name="word_<?php echo $lang->lang_alias; ?>" id="word_<?php echo $lang->lang_alias; ?>" class="form-control" placeholder="<?php echo $lang->lang_title; ?>"  autocomplete="off" />
                    </div>                                
                </div>
            <?php } ?>         

        </div>
        
        <div class="card-footer"  style="text-align: left;">
            <button type="submit" class="btn btn-success">حفظ</button>
        </div>

    <?php echo form_close(); ?>

</div>



