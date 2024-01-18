<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base."landing_content/"); ?>">التصنيفات</a>                
            </div>            
        </div>
    </div>     


    <?php echo form_open_multipart(base_url(admin_base.ctrl()."/".$method) , array("class" => "", "role" => "form")); ?>

        <div class="card-body">                   
              
            <div class="form-group">
                <label for="news_for" class="control-label">التصنيف</label>
                <select name="content_cat" id="content_cat" class="form-control"  >
                    <?php foreach($cats as $cat){ ?>
                        <option value="<?php echo $cat->cat_name; ?>" <?php if(@$cat->cat_name == @$content->content_cat || @$cat->cat_name == @$cat_name ){ echo 'selected = "selected"'; } ?>><?php echo $cat->cat_title ?></option>
                    <?php } ?>
                </select>                
            </div>               
            
            <?php foreach($fields as $field){ ?>
            
                <?php if(!in_array($field , array("content_id","content_cat"))){ ?>  
                              
                    <div class="form-group">
                        <label for="<?php echo $field ?>" class="control-label"><?php echo $field ?></label>
                        <?php if(strpos($field , "text") === FALSE){ ?>
                            
                            <?php if( strpos($field , "image") || strpos($field , "url") ){ ?>
                                <input class="form-control" style="direction: ltr; text-align: left;" name="<?php echo $field ?>" value='<?php echo @$content->{$field} ?>' />
                            <?php }else{ ?>
                                <input class="form-control" name="<?php echo $field ?>" value='<?php echo @$content->{$field} ?>' />
                            <?php } ?>
                            
                        <?php }else{ ?>
                            <textarea  class="form-control" name="<?php echo $field ?>" ><?php echo @$content->{$field} ?></textarea>
                        <?php } ?>
                    </div>                           

                <?php } ?>
            
            <?php } ?>         

        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>           
        
                     
        <input type="hidden" name="content_id" id="content_id" value="<?php echo @$content->content_id; ?>" />        
                   

    <?php echo form_close(); ?>        



</div>

     