<?php echo form_open_multipart( base_url("publishing/submit_author") , array("role" => "form",  "class"=>"inline check_submit check_agree", "release"=>"true") ); ?>

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
                        <label for="author_name"><?php echo word("fullname") ?> (<?php echo word("in_arabic") ?>) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field rtl text-right" id="author_name" name="author_name" />
                    </div>

                </div>            
                
                <div class="col-12 col-sm-6">

                    <div class="form-group">
                        <label for="author_name_en"><?php echo word("fullname") ?> (<?php echo word("in_english") ?>) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field ltr text-left" id="author_name_en" name="author_name_en" />
                    </div>

                </div>

                <div class="col-12  col-sm-6">

                    <div class="form-group">
                        <label for="author_email"><?php echo word("email") ?> <span class="text-danger">*</span></label>
                        <input type="email" class="form-control req_field" id="author_email" name="author_email">
                    </div>

                </div>

                <div class="col-12  col-sm-6">

                    <div class="form-group">
                        <label for="author_mobile"><?php echo word("mobile") ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field ltr text-left" id="author_mobile" name="author_mobile" />
                    </div>

                </div>
             

                <div class="col-12">

                    <div class="form-group">
                        <label for="author_address"><?php echo word("address") ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field" id="author_address" name="author_address" />
                    </div>

                </div>

                <div class="col-12  col-sm-4">

                    <div class="form-group">
                        <label for="author_job_title"><?php echo word("job_title") ?> </label>
                        <input type="text" class="form-control" id="author_job_title" name="author_job_title" />
                    </div>

                </div>

                <div class="col-12  col-sm-8">

                    <div class="form-group">
                        <label for="author_company"><?php echo word("company") ?> </label>
                        <input type="text" class="form-control" id="author_company" name="author_company" />
                    </div>

                </div>

                <div class="col-12  col-sm-4">

                    <div class="form-group">
                        <label for="author_nationality"><?php echo word("nationality") ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control req_field" id="author_nationality" name="author_nationality" />
                    </div>

                </div>                

                <div class="col-12  col-sm-8">

                    <div class="form-group">
                        <label for="national_id"><?php echo word("national_id") ?> <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary fake-upload" type="button" data-placeholder="national_id_placeholder" data-target="national_id"><?php echo word("select_file") ?></button>
                            </div>
                            <input type="text" class="form-control req_field" readonly="readonly" id="national_id_placeholder">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" title="JPG,PNG,JPEG,PDF<br>MAX size: 2MB" rel="tooltip"><i class="fa fa-info-circle"></i></button>                                
                            </div>                                                                                                        
                        </div>                        
                        <input type="file" name="national_id" id="national_id" class="d-none req_field" />
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