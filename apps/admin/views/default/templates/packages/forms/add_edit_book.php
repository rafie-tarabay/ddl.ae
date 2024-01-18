<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base.ctrl()); ?>">رجوع</a>                
            </div>            
        </div>
    </div>     


    <?php echo form_open(base_url(admin_base.ctrl()."/".$method) , array("class" => "", "role" => "form")); ?>

        <div class="card-body">                   
            
            <?php if($method == "insert_book"){ ?>                                        
                <div class="form-group">
                    <label>Book ID<span class="text-danger">*</span></label>
                    <input class="form-control req_field" name="book_id" value="<?php echo @$book->book_id ?>" />
                </div>                
            
                <div class="form-group">
                    <label>الحزم<span class="text-danger">*</span></label>
                    <?php foreach($packages as $package){  ?>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pack_<?php echo $package->pack_id; ?>" value="<?php echo $package->pack_id; ?>" name="packs[]" <?php if(@$pack_id == $package->pack_id ) echo 'checked="checked"'; ?> >
                                <label class="form-check-label" for="pack_<?php echo $package->pack_id; ?>"><?php echo $package->title ?> </label>
                            </div>
                        </div>                            
                    <?php } ?>                
                </div>        
            <?php }else{ ?>        
                <input type="hidden" name="book_id" value="<?php echo @$book->book_id ?>" />
                <input type="hidden" name="book_package_id" value="<?php echo @$book->book_package_id ?>" />    
            <?php } ?>
                      
            <div class="form-group">
                <label>الترتيب <span class="text-danger">*</span></label>
                <input class="form-control req_field" name="book_order" value="<?php echo @$book->book_order ?>" />
            </div>                 
                          
        </div>    
        
        


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>           

    <?php echo form_close(); ?>        


</div>
