<?php if($mobile_view == FALSE && $hide_layout == FALSE){ ?>
    <div class="container">    
        <?php if(!isset($advanced_search) && !isset($hide_simple_search)){ ?>
            <?php $this->load->view(design_path.'templates/main/headers/forms/normal_search'); ?>            
        <?php } ?>    
                        
        <?php if(!isset($hide_cats)){ ?>
            <?php $this->load->view(design_path.'templates/main/headers/parts/cats'); ?>
        <?php } ?>    
    </div>
<?php } ?>
         
<div <?php if($hide_layout == FALSE){ ?> class="container" id="main-container" <?php } ?> >