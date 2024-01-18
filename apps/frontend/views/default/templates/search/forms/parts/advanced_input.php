<?php $box_id = gen_hash(10); ?>

<div class="search_box removable-<?php echo @$removable ? 1 : 0; ?> <?php if(!@$primary) echo "secondry"; ?>" id="box_<?php echo $box_id; ?>" data-id="<?php echo $box_id; ?>">

    <div class="input-group input-group-lg"  >

        <input type="hidden" name="boxes[]" value="<?php echo $box_id; ?>" />

        
        <?php if(@$primary == TRUE){ ?>
            <div class="input-group-prepend">
                <span class="input-group-text basic-addon rounded-0"><?php echo word("search") ?></span>
            </div>  
        <?php }else{ ?>
            <div class="input-group-prepend">                      

                <button type="button" class="btn btn_show_options rounded-0 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="search_operator_label"></span>
                </button>

                <div class="z-1000">
                    <div class="dropdown-menu box_options rounded-0 dropdown-menu-<?php echo MyAlign; ?>" data-flip="false">
                    
                        <?php foreach($searchables["operators"] as $oper_var){ ?>
                            <?php 
                                $selected = "";
                                if(@$oper_var == "or"){                        
                                    $selected =  'checked="checked"';
                                }
                            ?>
                            <div class="dropdown-item">
                                <div class="form-check">
                                    <input  id="<?php echo $box_id."-".$oper_var ?>" value="<?php echo $oper_var ?>" 
                                            data-box="<?php echo $box_id; ?>"  data-title="<?php echo word($oper_var) ?>"
                                            <?php echo @$selected ?> class="form-check-input search_operator_selector" type="radio" name="<?php echo $box_id ?>_operator"
                                    >
                                    <label class="form-check-label" for="<?php echo $box_id."-".$oper_var ?>"><?php echo word($oper_var) ?></label>
                                </div>
                            </div>                                                                       
                        <?php } ?>                                                                                  
                    </div>                                    
                </div>                                    

            </div>
        <?php } ?>

                        
        <input type="text" class="form-control rounded-0" id="<?php echo $box_id ?>_keywords" name="<?php echo $box_id ?>_keywords" aria-label="<?php echo word("looking_for") ?>" autofocus="true" spellcheck="true">
                         
        
        
        <div class="input-group-prepend clearfix" id="box_<?php echo $box_id; ?>">                      

            <button type="button" class="btn btn_show_options rounded-0 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="match_label"></span>
            </button>

            <div class="z-1000">            
                <div class="dropdown-menu box_options dropdown-menu-<?php echo OppAlign; ?> rounded-0" data-flip="false">
               
     
                    <?php foreach($searchables["matches"] as $match){ ?>
                        <div class="dropdown-item">
                            <div class="form-check">
                                <input <?php if($match == "partial") echo 'checked="checked"'; ?> id="<?php echo $box_id."-".$match ?>" value="<?php echo $match ?>"
                                    data-box="<?php echo $box_id; ?>" data-title="<?php echo word($match) ?>"
                                    <?php echo @$selected ?> class="form-check-input match_selector" type="radio" name="<?php echo $box_id ?>_match" />
                                <label class="form-check-label" for="<?php echo $box_id."-".$match ?>"><?php echo word($match) ?></label>
                            </div>
                        </div>                                                                       
                    <?php } ?>   
                                                                                                                               
                </div>             
            </div>                                   

        </div>
                
        
        <div class="input-group-prepend clearfix" id="box_<?php echo $box_id; ?>">                      

            <button type="button" class="btn btn_show_options rounded-0 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="search_for_label"></span>
            </button>

            <div class="z-1000">            
                <div class="dropdown-menu box_options dropdown-menu-<?php echo OppAlign; ?> rounded-0" data-flip="false">
                
                    <?php foreach($searchables["fields"] as $opt_var){ ?>
                        <?php 
                            $selected = FALSE;
                            if(@$search_for){
                                $selected = ($opt_var == @$search_for) ? 'checked="checked"' : "";
                            }elseif(@$opt_var == "title"){                        
                                $selected =  'checked="checked"';
                            }
                        ?>
                        <div class="dropdown-item">
                            <div class="form-check">
                                <input data-box="<?php echo $box_id; ?>" data-title="<?php echo word($opt_var) ?>"
                                    id="<?php echo $box_id."-".$opt_var ?>" value="<?php echo $opt_var ?>" 
                                    <?php echo @$selected ?> class="form-check-input search_for_selector" type="radio" name="<?php echo $box_id ?>_field"
                                >
                                <label class="form-check-label" for="<?php echo $box_id."-".$opt_var ?>"><?php echo word($opt_var) ?></label>
                            </div>
                        </div>                            
                    <?php } ?>                                                                                  
                </div>             
            </div>                                   

        </div>  
        
        
        
        <div class="input-group-append add_field_container">
            <button class="btn btn-warning rounded-0" type="button" id="add_field"><i class="fa fa-plus"></i></button>    
        </div>    
        
        <div class="input-group-append remove_field_container">
            <button class="btn btn-danger rounded-0 remove_field" data-id="<?php echo $box_id; ?>" type="button"><i class="fa fa-trash-alt"></i></button>
        </div>             

    </div>  
    
</div>  