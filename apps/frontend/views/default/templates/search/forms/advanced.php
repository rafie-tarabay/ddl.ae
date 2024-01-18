<script src="<?php echo no_protocol(base_url("assets/libs/multiselect/js/bootstrap-multiselect.js?v=".settings('refresh'))); ?>"></script>                                
<link rel="stylesheet" type="text/css" href="<?php echo no_protocol(base_url("assets/libs/multiselect/css/bootstrap-multiselect.css?v=".settings('refresh'))); ?>">
<script src="<?php echo base_url(APPFOLDER."views/".style."/assets/js/advanced_search.js?v=".settings('refresh')); ?>"></script>                                


<?php echo form_open( base_url(front_base."search/search_submit") , array("method" => "POST",  "class"=>"inline check_submit" , "release"=>"true" ,  "id"=>"advanced_form")); ?>

    <div class="list-group">

        <div id="advanced_inputs">
                   
            <?php 
                $data = array(
                    "primary"=>TRUE,
                    "default"=>"title",
                    "removable"=>FALSE
                ); 
            ?>

            <?php $this->load->view(style."/templates/search/forms/parts/advanced_input",$data); ?>


            <?php 
                $data = array(
                    "primary"=>FALSE,
                    "default"=>"content",
                    "removable"=>TRUE
                ); 
            ?>        
            <?php $this->load->view(style."/templates/search/forms/parts/advanced_input",$data); ?>
            
        </div>
    
       
        <div class="list-group-item">

            <div class="row">
                
                <div class="col-12 col-sm-3">


                    <div class="form-group">
                        <label for="bibs"><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("biblotype") ?></label>
                        <select class="form-control multiselect" multiple="multiple" size="6" name="bibs[]" id="bibs">                        
                            <?php  foreach($searchables["bibs"] as $id => $value){ ?>
                                <option value="<?php echo $id; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>            
                    </div>
            
                    
                    
                </div>   
                
                <div class="col-12 col-sm-3">
                
                    <div class="form-group">
                        <label for="dewies"><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("classification") ?></label>
                        <select class="form-control multiselect" multiple="multiple" size="6" name="dewies[]" id="dewies">
                            <?php foreach($searchables["dewies"] as $id => $title){ ?>
                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                            <?php } ?>
                        </select>            
                    </div>                    
                      
                
                </div>   
                      
                <div class="col-12 col-sm-3">
                    
                    <div class="form-group">
                        <label for="sources"><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("sources") ?></label>
                        <select class="form-control multiselect" multiple="multiple" size="6" name="sources[]" id="sources">
                            <?php foreach($searchables["sources"] as $id => $title){ ?>
                            <?php if($id!=15) { ?> <option value="<?php echo $id; ?>"><?php echo $title; ?></option><?php } ?>
                            <?php } ?>
                        </select>            
                    </div>                   
                
                </div>
                                          
                <div class="col-12 col-sm-3">
                    
                    <div class="form-group">
                        <label for="formats"><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("filestypes") ?></label>
                        <select class="form-control multiselect" multiple="multiple" size="6" name="formats[]" id="formats">
                            <?php foreach($searchables["formats"] as $item){ ?>
                                <option value="<?php echo $item; ?>"><?php echo word($item."_file"); ?></option>
                            <?php } ?>
                        </select>            
                    </div>                   
                
                </div>
                    

            </div>
            
        </div>
        

        <div class="list-group-item">

            <div class="row">
                 
                <div class="col-12 col-sm-4">

                    <div class="form-group">
                        <label for="prices"><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("price") ?></label>
                        <select class="form-control" name="prices[]" id="prices">
                            <option selected="selected" value="0"><?php echo word("all") ?></option>
                            <?php foreach($searchables["prices"] as $item){ ?>
                                <option value="<?php echo $item ?>"><?php echo word($item) ?></option>
                            <?php } ?>                            
                        </select>   
                    </div> 

                </div>
                
                <div class="col-12 col-sm-4">

                    <div class="form-group">
                        <label for="dates"><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("time_period") ?></label>
              
                        <div class="row  text-center">
                            <div class="col-6">
                                <input type="text" class="pub_year form-control inline" name="date[]" placeholder="<?php echo word("from") ?>" />                        
                            </div>
                            <div class="col-6">
                                <input type="text" class="pub_year form-control inline" name="date[]" placeholder="<?php echo word("to") ?>" />                        
                            </div>
                        </div>      
                    </div>
                                
                </div>
                
            </div>
                
                
                
        </div>    
                
        <div class="list-group-item">

            <div class="row">
                 
                <div class="col-12 col-sm-4">

                    <div class="form-group">
                        <label><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo word("results_order") ?></label>  
                        <select class="form-control" name="sort[]">                                
                            <option selected="selected"><?php echo word("no_sort") ?></option>
                            <?php foreach($searchables["sorts"] as $item){ ?>
                                <option value="<?php echo $item; ?>"><?php echo word($item) ?></option>
                            <?php } ?>
                        </select>   
                    </div> 

                </div>
                     
            </div>
                
                
                
        </div>    
                
        <div class="list-group-item">
                
                <button type="submit" class="btn btn-block btn-info" id="search_btn"><i class="a fa fa-search"></i> <?php echo word("search") ?></button>        

        </div>        

    </div>        
    

<?php echo form_close(); ?>


<br><br><br>