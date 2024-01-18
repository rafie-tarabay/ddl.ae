<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <?php $sec_id = @$sec_id ? $sec_id : $widget->widget_sec_id ?>
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()."/widgets/".$sec_id); ?>">الرجوع</a>                                
            </div>            
        </div>
    </div> 




    <?php 
        if(@$item->item_id){
            $func = "update_item";            
        }else{
            $func = "insert_item";            
        }    
    ?>


    <?php echo form_open_multipart(base_url(admin_base."partners/$func") , array("class" => "check_submit form-horizontal", "release" => "true")); ?>

        <div class="card-body">     
            
            <?php $langs = array("ar","en"); ?>     
            
            <?php foreach($fields as $f){ ?>
            
                <div class="row">
                 
                <?php foreach($langs as $lang){ ?>     
                    
                    <?php 
                        $myfield = @$myfields[$f->f_name]; 
                        $val = @$myfield->{"field_value_".$lang}; 
                    ?>
                    
                    <div class="col-md-6">
                        
                        <div class="form-group">                                                                              
                            <label><?php echo $f->f_name ?></label>
                            <?php if($f->f_element == "input"){ ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $lang; ?></span>
                                    </div>
                                    <input  class="form-control <?php if($f->f_required) echo "req_field"; ?>" name="<?php echo $f->f_name."[".$lang."]" ?>" value="<?php echo $val ? $val : "" ?>" />
                                </div>                                 
                            <?php }elseif($f->f_element == "textarea" || $f->f_element == "editor"){ ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $lang; ?></span>
                                    </div>
                                    <textarea class="form-control <?php if($f->f_required) echo "req_field"; ?> <?php if($f->f_element == "editor") echo "editor"; ?>" name="<?php echo $f->f_name."[".$lang."]" ?>"><?php echo $val ?></textarea>
                                </div>  
                                
                            <?php }elseif($f->f_element == "select"){ ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $lang; ?></span>
                                    </div>
                                    <?php $selects = explode("#x#",$f->f_selectables); ?>
                                    <select name="<?php echo $f->f_name."[".$lang."]" ?>" class="form-control <?php if($f->f_required) echo "req_field"; ?>">
                                        <?php foreach($selects as $select){ ?>
                                            <?php if($select){ ?>
                                                <option value="<?php echo $select; ?>"><?php echo $select; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>                
                            <?php } ?>
                            
                        </div>     
                    
                    </div>
                                     
                <?php } ?> 
                
                </div>
                
            <?php } ?> 

                                           
            <div class="form-group">
                <label>الترتيب</label>
                <input  class="form-control" name="item_order" value="<?php echo @$item->item_order; ?>" />
            </div>
            
            
        </div>    

        <input type="hidden" name="item_id" value="<?php echo @$item->item_id; ?>" />
        <input type="hidden" name="item_class" value="<?php echo @$class; ?>" />        
        <input type="hidden" name="item_widget_id" value="<?php echo @$widget->widget_id; ?>" />                
        <input type="hidden" name="widget_sec_id" value="<?php echo @$widget->widget_sec_id; ?>" />

        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>

     