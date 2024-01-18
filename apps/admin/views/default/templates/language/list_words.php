
<div class="row">
    <div class="col-md-12">   
        <div class="alert alert-danger alert-sm"><i class="fa fa-warning"></i> هذه الخاصية متقدمة , فضلاً لا تقوم بالتعديل أو الإضافة إلا إذا كنت تعرف ما تفعله</div>    
    </div>

    <div class="col-md-6 text-left">            
    <?php echo form_open(base_url(admin_base."language/search") , array("class" => " form-inline my-2 my-lg-0", "role" => "form")); ?>
        <div class="form-group">
            <input type="text" name="keyword" class="form-control input-sm" placeholder="البحث عن عبارة" value="<?php echo @$keyword; ?>">
        </div>
        <button class="btn btn-danger btn-sm"><i class="fa fa-search"></i></button>
    <?php echo form_close(); ?>                                    
    </div>  
    
</div>

<br />


        
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            
            <div class="col-md-6 no-padding text-left">
                <?php if(@$keyword){ ?>
                    <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/words") ?>" ><i class="fa fa-sort-alpha-asc"></i> جميع العبارات</a>                
                <?php } ?>
                            
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/add_word") ?>" ><i class="fa fa-plus"></i> أضف عبارة</a>
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/instructions") ?>" ><i class="fa fa-anchor"></i> الإرشادات</a>                                
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)) ?>" ><i class="fa fa-language"></i> اللغات</a>                
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."language/words?empty=1") ?>" >الكلمات الفارغة</a>                
            </div>                        
          
        </div>
    </div>    

    
        <div class="card-body">
                
        <?php if($words){ ?>
             <div class="row">
                <?php foreach($words as $word){ ?> 
                    <div class="col-sm-4">
                        <div class="single_word">
                            <h5 class="text-center ltr"><?php echo $word->word_alias; ?></h5>
                            <?php echo form_open(base_url(admin_base."language/update_word") , array("class" => "form edit_lang_word", "role" => "form")); ?>
                                <?php foreach(settings("langs") as $lang){ ?>
                                    <div class="input-group input-group-sm">
                                      <span class="input-group-addon" id="basic-addon1"><img src="<?php echo base_url(upload_base."langs/".$lang->lang_flag); ?>" /></span>
                                      <input spellcheck="true" style="<?php echo "direction:".$lang->lang_dir; ?>" type="text" name="word_<?php echo $lang->lang_alias; ?>" id="word_<?php echo $lang->lang_alias; ?>" class="form-control" placeholder="<?php echo $lang->lang_title; ?>" value="<?php echo stripslashes($word->{"word_".$lang->lang_alias}); ?>" autocomplete="off" />
                                    </div>                                
                                <?php } ?>
                                <div class="save_word">
                                    <input type="hidden" name="word_alias" id="word_alias" value="<?php echo $word->word_alias; ?>" />
                                    <a class="btn btn-danger btn-xs sure" href="<?php echo base_url(admin_base."language/delete_word/".$word->word_alias); ?>"><i class="fa fa-trash"></i></a>
                                    <button class="btn btn-primary btn-xs" type="submit"><i class="fa loading-icon"></i> حفظ</button>
                                </div>
                                
                            <?php echo form_close(); ?>                                    
                        </div>            
                    </div>    
                <?php } ?>
            </div>

        <?php }else{ ?>

            <div class="no_items text-center">لا يوجد عبارات</div>
        
        <?php } ?>



</div>

</div>

<script>
    <?php $_langs = array(); foreach(settings("langs") as $lang) $_langs[] = '"'.$lang->lang_alias.'"'; ?>
    <?php $_trans = array(); foreach(settings("langs") as $lang) $_trans[] = $lang->lang_alias.':""'; ?>
    var langs = [<?php echo join(",",$_langs); ?>];
    var trans = {<?php echo join(",",$_trans); ?>}; 
</script>