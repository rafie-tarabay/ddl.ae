<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()."/content_classes"); ?>">الرجوع</a>                                
            </div>            
        </div>
    </div> 




    <?php 
        if(@$class->class_id){
            $func = "update_class";            
        }else{
            $func = "insert_class";            
        }    
    ?>


    <?php echo form_open_multipart(base_url(admin_base."partners/$func") , array("class" => "form-horizontal", "role" => "form")); ?>

        <div class="card-body">     
        
                                    
            <div class="form-group">
                <label>Class Alias</label>
                <input  class="form-control" name="class_name" value="<?php echo @$class->class_name; ?>" />
                <div class="alert alert-info">حروف انجليزية بدون أي مسافات</div>
            </div>

            <input type="hidden" name="class_id" value="<?php echo @$class->class_id; ?>" />
            
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        



</div>

     