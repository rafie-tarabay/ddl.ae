<?php echo form_open_multipart( base_url("publishing/submit_request") , array("role" => "form",  "class"=>"inline check_submit check_agree", "release"=>"true") ); ?>

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

        <div class="list-group list-group-flush">

            <div class="list-group-item">

                <div class="row">     

                    <div class="col-12 col-sm-6">
                    
                        <label><?php echo word("author") ?> <span class="text-danger">*</span></label>
                        
                        <?php if($authors){ ?>
                            <?php foreach($authors as $author){ ?>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="author_<?php echo $author->author_id; ?>" value="<?php echo $author->author_id; ?>" name="authors[]">
                                        <label class="form-check-label" for="author_<?php echo $author->author_id; ?>"><?php echo $author->author_name ?> </label>
                                    </div>
                                </div>                             
                            <?php } ?>                                                           
                        <?php }else{ ?>
                            <h3 class="no-items"><?php echo word("no_authors") ?></h3>
                        <?php } ?>
                        
                        <div>
                            <a target="_blank" href="<?php echo base_url("publishing/add_author") ?>"><?php echo word("add_author") ?></a>
                        </div>
                                                                      
                    </div>
                    

                    <div class="col-12 col-sm-6">

                        <label><?php echo word("corporate") ?> <span class="text-danger">*</span></label>
                        
                        <?php if($corporates){ ?>
                            <?php foreach($corporates as $corp){ ?>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="corp_<?php echo $corp->corp_id; ?>" value="<?php echo $corp->corp_id; ?>" name="corporates[]">
                                        <label class="form-check-label" for="corp_<?php echo $corp->corp_id; ?>"><?php echo $corp->corp_name ?> </label>
                                    </div>
                                </div>                             
                            <?php } ?>                                                           
                        <?php }else{ ?>
                            <h3 class="no-items"><?php echo word("no_corporates") ?></h3>
                        <?php } ?>                            
                        
                        <div>
                            <a target="_blank" href="<?php echo base_url("publishing/add_corporate") ?>"><?php echo word("add_corporate") ?></a>
                        </div>
                                                        
                    </div>                                         
                        
                </div>

            </div>



            <div class="list-group-item bg-gray text-primary">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("material_details") ?> 
            </div>


            <div class="list-group-item">

                <div class="row">

                    <div class="col-12">
                        <div class="form-group">
                            <label for="material_title"><?php echo word("material_title") ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control req_field" id="material_title"  name="material_title">
                        </div>
                    </div>

                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label><?php echo word("material_type") ?> <span class="text-danger">*</span></label>
                            <select class="form-control req_field" name="material_type" >
                                <option value="article"><?php echo word("article") ?></option>
                                <option value="book"><?php echo word("book") ?></option>
                                <option value="audio"><?php echo word("audio") ?></option>
                            </select>   
                        </div>    
                    </div>    
      
                    <div class="col-12  col-sm-8">
                        <div class="form-group">
                            <label for="attach_file"><?php echo word("attach_file") ?> <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-primary fake-upload" type="button" data-placeholder="attach_file_placeholder" data-target="attach_file"><?php echo word("select_file") ?></button>
                                </div>
                                <input type="text" class="form-control req_field"  readonly="readonly"  id="attach_file_placeholder">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" title="DOC,DOCX,PDF,EPUB,MP3<br>MAX size: 100MB" rel="tooltip"><i class="fa fa-info-circle"></i></button>                                
                                </div>                            
                            </div>
                            <input type="file" name="attach_file" id="attach_file" class="d-none req_field" />
                        </div>         
                    </div>         

                </div>

            </div>  


            <div class="list-group-item bg-gray text-primary">
                <div><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("required_services") ?></div>
            </div>


            <div class="list-group-item">


                <label class="mt-2"><strong><?php echo word("you_can_select_multiservices") ?></strong></label>

                <div class="row mb-2">

                    <?php 
                        $i = 1; $j=1; 
                        $column_limit = 4;
                    ?>
                    <?php foreach($services as $service){  ?>
                                        
                        <?php if($i == 1) echo '<div class="col-12 col-sm-4  ">'; ?>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="service_<?php echo $service->service_id; ?>" value="<?php echo $service->service_name; ?>" name="services[]">
                                    <label class="form-check-label" for="service_<?php echo $service->service_id; ?>"><?php echo $service->title ?> </label>
                                </div>
                            </div>                    

                        <?php if($i == $column_limit || $j == count($services)) echo '</div>'; ?>

                        <?php $i = ($i == $column_limit) ? 1 : ( $i + 1 );?>
                
                    <?php $j++; } ?>
        
                </div>

            </div> 



            <div class="list-group-item bg-gray text-primary">
                <div><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("publish_details") ?></div>
            </div>

            <div class="list-group-item border-bottom-0">


                <div class="form-row mb-2">


                    <div class="col-12 col-sm-4">            

                        <div class="form-group">
                            <label><?php echo word("availablity") ?> <span class="text-danger">*</span></label>
                            <select class="form-control req_field" name="pricing" >
                                <option value="totaly-free"><?php echo word("totaly-free") ?></option>
                                <option value="one-year-free"><?php echo word("one-year-free") ?></option>
                                <option value="paid"><?php echo word("paid-mateial") ?></option>
                            </select>   
                        </div>                  
                             
                    </div>            

                    <div class="col-12 col-sm-4">
        
                        <div class="form-group">
                            <label><?php echo word("publish_via") ?> <span class="text-danger">*</span></label>
                            <select class="form-control req_field" name="publish_via" >
                                <option value="ddl"><?php echo word("ddl")." ( ".word("digital")." )" ?></option>
                                <option value="qindeel"><?php echo word("qindeel")." ( ".word("digital_and_printed")." )" ?></option>
                            </select>   
                        </div>  

                    </div>        



                    <div class="col-12 col-sm-4">
                               

                        <div class="form-group">
                            <label><?php echo word("copyrights_period") ?> <span class="text-danger">*</span></label>
                            <select class="form-control req_field" name="copyrights" >
                                <option value="3">3 <?php echo word("years") ?></option>
                                <option value="5">5 <?php echo word("years") ?></option>
                                <option value="7">7 <?php echo word("years") ?></option>
                            </select>   
                        </div> 
                          
                    </div>                        

                    
                    <div class="col-12">
                    
                        <div class="form-group">
                            <label for="comments"><?php echo word("comments") ?></label>
                            <textarea class="form-control" id="comments" name="comments" ></textarea>
                        </div>

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