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
        if(@$widget->widget_id){
            $func = "update_widget";            
        }else{
            $func = "insert_widget";            
        }    
    ?>


    <?php echo form_open_multipart(base_url(admin_base."partners/$func") , array("class" => "form-horizontal", "role" => "form")); ?>

        <div class="card-body">     
        
            <div class="form-group">
                <label>المكتبة</label>
                <select name="widget_sec_id" class="form-control">
                    <?php foreach($sections as $section){ ?>
                        <option value="<?php echo $section->sec_id ?>" <?php if(@$section->sec_id == @$sec_id || @$section->sec_id == @$widget->widget_sec_id ){ echo 'selected = "selected"'; } ?>><?php echo $section->title ?></option>
                    <?php } ?>
                </select>                
            </div>          
            
                     
            <div class="form-group">
                <label>اظهر العنوان</label>
                <select name="widget_show_title" class="form-control">
                    <option value="1" <?php if(@$widget->widget_show_title == 1 ){ echo 'selected = "selected"'; } ?>>نعم</option>
                    <option value="0" <?php if(@$widget->widget_show_title == 0 ){ echo 'selected = "selected"'; } ?>>لا</option>
                </select>                
            </div>              
            
            <div class="form-group">
                <label>العنوان بالعربي</label>
                <input  class="form-control" name="widget_title_ar" value="<?php echo @$widget->widget_title_ar; ?>" />
            </div>     
            
                                           
            <div class="form-group">
                <label>العنوان انجليزي</label>
                <input  class="form-control" name="widget_title_en" value="<?php echo @$widget->widget_title_en; ?>" />
            </div>
            
                     
            <div class="form-group">
                <label>متعدد العناصر</label>
                <select name="widget_multiple_items" class="form-control">
                    <option value="1" <?php if(@$widget->widget_multiple_items == 1 ){ echo 'selected = "selected"'; } ?>>نعم</option>
                    <option value="0" <?php if(@$widget->widget_multiple_items == 0 ){ echo 'selected = "selected"'; } ?>>لا</option>
                </select>                
            </div>              
                                                
            <div class="form-group">
                <label>أقصى عدد من العناصر</label>
                <input  class="form-control" name="widget_max_items" value="<?php echo @$widget->widget_max_items; ?>" />
            </div>     

            <div class="form-group">
                <label>سلايد</label>
                <select name="widget_slider" class="form-control">
                    <option value="1" <?php if(@$widget->widget_slider == 1 ){ echo 'selected = "selected"'; } ?>>نعم</option>
                    <option value="0" <?php if(@$widget->widget_slider == 0 ){ echo 'selected = "selected"'; } ?>>لا</option>
                </select>                
            </div>              

            <div class="form-group">
                <label>Grid CSS Class</label>
                <input  class="form-control" name="widget_grid_css_class" value="<?php echo @$widget->widget_grid_css_class ? $widget->widget_grid_css_class : "col-md-4"; ?>" />
            </div>     
            
            <div class="form-group">
                <label>Card CSS Class</label>
                <input  class="form-control" name="widget_card_css_class" value="<?php echo @$widget->widget_card_css_class ? $widget->widget_card_css_class : ""; ?>" />
            </div>     
            
                                           
            <div class="form-group">
                <label>الترتيب</label>
                <input  class="form-control" name="widget_order" value="<?php echo @$widget->widget_order; ?>" />
            </div>

        </div>    

        
        <input type="hidden" name="widget_id" value="<?php echo @$widget->widget_id; ?>" />

        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>

     