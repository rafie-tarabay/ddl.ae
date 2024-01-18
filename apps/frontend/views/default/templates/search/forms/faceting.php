<?php echo form_open( base_url(front_base."search/search_submit") , array("id"=>"search_faceting")) ?>

    <div id="faceting" class="bg-gray">

        <?php if($queries){ ?>
        
            <div class="options">

                <h3>
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i>
                    <?php echo word("queries") ?> 
                    <span class="badge badge-pill badge-info filter_counter"><?php echo count($queries); ?></span>
                </h3>          
            
                <?php $boxes = array(); ?>
                <?php $i=1; foreach($queries as $query){ ?>
                    
                    <?php 
                        $box_id  = gen_code(10);
                        $boxes[] = $box_id;
                    ?>
                
                    <div class="input-group">
                        
                        <?php if($i > 1){ ?>
                            <div class="input-group-prepend box_prefix">
                                <select name="<?php echo $box_id ?>_operator" class="form-control rounded-0">
                                    <?php foreach($this->search_gate->get_searchable_operators() as $operator){ ?>
                                        <option value="<?php echo $operator ?>" <?php if($operator == $query["operator"]) echo 'selected="selected"'; ?> >
                                            <?php echo word($operator); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php }else{ ?>
                          <div class="input-group-prepend">
                            <span class="input-group-text box_prefix" id="inputGroup-sizing-sm">عن</span>
                          </div>                        
                        <?php } ?>
                        
                        <input type="text" name="<?php echo $box_id ?>_keywords" class="form-control rounded-0" value='<?php echo $query["keywords"]; ?>' />
                                    
                        <div class="input-group-append">
                            <select name="<?php echo $box_id ?>_field" class="form-control rounded-0">
                                <?php foreach($this->search_gate->get_searchable_fields() as $field){ ?>
                                    <option value="<?php echo $field ?>" <?php if($field == $query["field"]) echo 'selected="selected"'; ?> >
                                        <?php echo word($field); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        
                        
                    </div>
                
                    <input type="hidden" name="boxes[]" value="<?php echo $box_id; ?>" />
                    
                    
                <?php $i++; } ?>
                

            </div>
            
        <?php } ?>
        

        <div class="options">
        
            <?php
                 $date_range = $this->search_gate->get_searchable_date_range();
                 $years = range($date_range["min"],$date_range["max"],1);
                 $from_selected = @$filters["date"]["from"];
                 $to_selected   = @$filters["date"]["to"];                 
            ?>                  
              
            <h3>
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("year_publication") ?>
                <?php if(@count($DateRange) == 2){  ?>
                    <span class="badge badge-pill badge-info filter_counter">1</span>
                <?php } ?>                
            </h3>                    
        
            <div class="input-group">
                                               
                <select class="pub_year" name="date[]">                        
                    <option value="0" ><?php echo word("all") ?></option>
                    <?php foreach($years as $y ){ ?>
                        <option value="<?php echo $y; ?>" <?php if($y == @$from_selected) echo 'selected="selected"' ?> ><?php echo $y; ?></option>
                    <?php } ?>
                </select>                
                &nbsp;  
                <label><?php echo word("to") ?></label>  
                &nbsp;         
                <select class="pub_year" name="date[]">
                    <option value="0" ><?php echo word("all") ?></option>
                    <?php foreach( array_reverse($years) as $y ){ ?>
                        <option value="<?php echo $y; ?>" <?php if($y == @$to_selected) echo 'selected="selected"' ?>><?php echo $y; ?></option>
                    <?php } ?>
                </select>  
                
            </div>
            
        </div>    
    
    
        <?php $i = 0; ?>
        
        <?php $non_allowed = array("publicationYear"); ?>
        
        <?php foreach($facets as $title => $contents){ ?>
        
            <?php if($contents && !in_array($title,$non_allowed)){ ?>       
       
                    <div class="options <?php if(count($contents) > 10) echo "with_more"; ?>">
                    
                        <h3>
                            <i class="fa fa-caret-<?php echo OppAlign; ?>"></i>
                            <?php echo word($title) ?> 
                            <?php if(@$filters[$title]){  ?>
                                <span class="badge badge-pill badge-info filter_counter"><?php echo count($filters[$title]); ?></span>
                            <?php } ?>
                        </h3>        
    
                        <?php $content_counter = 0; ?>            
                    
                        <?php foreach($contents as $content){ ?>
                                         
                            <?php if($content_counter == 5){ ?>
                                <div class="more_content" id="more_<?php echo $title ?>">
                            <?php } ?>

                            <?php       
                                $checked = "";
                                if(isset($filters[$title])){                                                                                                                                                             
                                    $checked =  in_array( $content["value"] ,  $filters[$title] ) ? 'checked="checked"' :"";
                                }
                            ?> 
                            
                            <div class="single_option">
                                <div class="form-check ">          
                                    <input class="form-check-input" type="checkbox" value="<?php echo $content["value"] ?>"  id="<?php echo $title."_".$content["value"] ?>" name="<?php echo $title.'[]' ?>" <?php echo @$checked; ?> >
                                    <label class="form-check-label" for="<?php echo $title."_".$content["value"] ?>">
                                        <?php echo $content["title"] ?>
                                        <span class="badge badge-pill badge-info"><?php echo $content["count"] ?></span>
                                    </label>
                                </div>                                                        
                            </div> 
                            
                            <?php $content_counter++; ?>

                        <?php } ?>
                        
                            
                        <?php if($content_counter > 5){ ?>
                            </div>
                            <div class="text-<?php echo MyAlign; ?>">
                                <button type="button" class="btn btn-link btn-sm show_more_content" data-id="<?php echo $title ?>"><?php echo word("more") ?></button>
                            </div>
                        <?php } ?>                        
                                                         
                             
                                        
                    </div>
                    
            <?php $i++; } ?>
            

        <?php } ?>                          

        

        <div class="options">

            <h3>
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("sort") ?>     
            </h3>                    
        
            <div class="input-group">                                               
                <select name="sort[]" id="sort_by">
                    <?php foreach($this->search_gate->get_searchable_sorts() as $_sort){ ?>
                        <option value="<?php echo $_sort ?>" <?php if($_sort == $sort) echo 'selected="selected"'; ?> >
                            <?php echo word($_sort); ?>
                        </option>
                    <?php } ?>
                </select>                
            </div>
            
        </div>         
        
    </div>
                  
    <div class="text-<?php echo OppAlign; ?> my-4">
        <button class="btn btn-block btn-success" type="submit"><?php echo word("update_search") ?></button>
    </div>

    
<?php echo form_close(); ?>

