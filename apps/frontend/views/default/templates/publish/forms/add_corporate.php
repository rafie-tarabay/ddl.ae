<?php echo form_open_multipart( base_url("publishing/submit_corporate") , array("role" => "form",  "class"=>"inline check_submit check_agree", "release"=>"true") ); ?>

    <div class="card card-default mt-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                      <h5 class="mt-1 mb-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $title; ?></h5>
                </div>
                <div class="col-md-6 text-<?php echo OppAlign; ?>">
                    <a class="btn btn-danger  btn-sm" href="<?php echo base_url("publishing") ?>"><?php echo word("self_publish") ?></a>
                </div>        
            </div>
        </div>


        <div class="card-body">

            <div class="row">         
            
                <div class="col-12 col-sm-6">

                    <div class="form-group">
                        <label for="corp_name"><?php echo word("corp_name") ?> (<?php echo word("in_arabic") ?>) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field rtl text-right" id="corp_name" name="corp_name" />
                    </div>

                </div>            
                
                <div class="col-12 col-sm-6">

                    <div class="form-group">
                        <label for="corp_name_en"><?php echo word("corp_name") ?> (<?php echo word("in_english") ?>) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field ltr text-left" id="corp_name_en" name="corp_name_en" />
                    </div>

                </div>
                          
                <div class="col-12 col-sm-6">

                    <div class="form-group">
                        <label for="corp_sub_unit"><?php echo word("sub_unit") ?> (<?php echo word("in_arabic") ?>) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field" id="corp_sub_unit" name="corp_sub_unit">
                    </div>

                </div>

                <div class="col-12 col-sm-6">

                    <div class="form-group">
                        <label for="corp_sub_unit_en"><?php echo word("sub_unit") ?> (<?php echo word("in_english") ?>) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field ltr text-left" id="corp_sub_unit_en" name="corp_sub_unit_en" />
                    </div>

                </div>
             

                <div class="col-12 col-sm-6">

                    <div class="form-group">
                        <label for="corp_meeting_loc"><?php echo word("meeting_loc") ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field" id="corp_meeting_loc" name="corp_meeting_loc" />
                    </div>

                </div>

                <div class="col-12 col-sm-6">

                    <div class="form-group">
                        <label for="corp_meeting_date"><?php echo word("meeting_date") ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field" id="corp_meeting_date" name="corp_meeting_date" />
                    </div>

                </div>
                       
            </div>

        </div> 
          
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                      
                    <div class="form-group mt-2 mb-0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="i_agree" value="1" name="i_agree">
                            <label class="form-check-label" for="i_agree"><?php echo word("i_agree_on") ?> <a href="<?php echo base_url("page/terms") ?>"><?php echo word("terms_conditions") ?></a></label>
                        </div>
                    </div>                       
                      
                </div>
                <div class="col-md-6 text-<?php echo OppAlign; ?>">
                    <button type="submit" class="btn btn-success"><?php echo word("submit") ?></button>
                </div>        
            </div>
        </div>
        
    </div>  

<?php echo form_close(); ?>


<br><br>