
<?php if( $params["filters"] || $params["keywords"] ){  ?>     

    <?php         
        $filters = $params["filters"];     
        $kwds = $params["keywords"]; 
        $karr = array();           
        foreach($kwds as $kwd){
            $segment = word("about")." ".'<b>'.$kwd["value"].'</b> '.word("in").' <b>'.word($kwd["field"]).'</b>';
            if(count($karr)){
                $segment = word($kwd["operator"])." ".$segment;
            }
            $karr[] = $segment;                        
        }
        $keywords =  $karr ? join(' <span class="text-danger">/</span> ',$karr) : FALSE;    
    ?>    
    

    <div class="card-body applied_filters">

        <?php if($keywords){  ?>     

            <?php $url_query = $this->Search->build_query_exclude("keywords"); ?>

            <a class="d-inline-block single_parameter p-2 mb-1" title="<?php echo word("without") ?>" rel="tooltip" href="<?php echo base_url(front_base."results/metadata/multiple/?".$url_query) ?>">
                <i class="far fa-times-circle delete_icon"></i> 
                <?php echo word("search_keyword") ?>: <?php echo $keywords; ?>
            </a>                

        <?php } ?>

        
        <?php if($filters){  ?>     

            <?php  foreach($filters as $type => $contents){ ?>    
                                              
                <?php if($contents){  ?>     

                    <?php 
                        $url_query = $this->Search->build_query_exclude($type);
                        $title = $this->Search->GetFacetName($type);
                    ?>
                    <?php if($type && $title && $type != "keywords"){ ?>

                        <a class="d-inline-block single_parameter p-2 mb-1" title="<?php echo word("without") ?>" rel="tooltip"  href="<?php echo base_url(front_base."results/metadata/multiple/?".$url_query) ?>">
                            <i class="far fa-times-circle delete_icon"></i> 
                            <?php echo $title; ?> <span class="badge text-light"><?php echo count($contents) ?></span>
                        </a>                
                        
                    <?php } ?>

                <?php } ?>
            
            <?php } ?>
      
        <?php } ?>
            
    </div>  

<?php } ?>