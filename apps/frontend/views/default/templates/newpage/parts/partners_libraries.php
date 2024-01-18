<div class="row text-center mt-4" id="special_lib_widget">

    <?php

    $libs = $content["widgets"]["partners_libraries"];
    $libraries = array();
        foreach($libs as $lib){
            //if($lib->content_rel_title2 == "main"){
            //    $libraries["main"] = $lib;
            //}else{
                $libraries["small"][] = $lib;
            //}
        }

    ?>

    <!--div class="col-md-4">
        <?php if($lib = $libraries["main"]){ ?>
            <a class="special_library large" href="<?php echo $lib->content_rel_url1; ?>" target="_blank">
                <img class="img-fluid rounded" src="<?php echo base_url($lib->content_rel_image1); ?>"  alt="<?php echo word("image") ?>"/>
            </a>        
        <?php } ?>
    </div-->                                  

    <div class="col-md-12">    
        
        <div class="row">

            <?php foreach($libraries["small"] as $lib){ ?>
                <div class="<?php echo $lib->content_rel_text1 ? $lib->content_rel_text1 : "col-md-4"; ?> ">
                    <?php if($lib->content_rel_url2 != "disabled"){ ?>
                        <a class="special_library small" href="<?php echo $lib->content_rel_url1; ?>" target="_blank">                    
                            <img class="img-fluid rounded" src="<?php echo base_url($lib->content_rel_image1); ?>"  alt="<?php echo word("image") ?>"/>
                        </a>
                    <?php }else{ ?>
                        <a class="special_library small" title="<?php echo word("soon"); ?>" rel="tooltip" target="_blank">                    
                            <img class="img-fluid rounded" src="<?php echo base_url($lib->content_rel_image1); ?>"  alt="<?php echo word("image") ?>"/>
                        </a>
                    <?php }?>                        
                </div>
            <?php } ?>                 

        </div>    
    
    </div>

</div>