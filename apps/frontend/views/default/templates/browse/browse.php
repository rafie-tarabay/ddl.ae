<script src="<?php echo no_protocol(base_url("assets/libs/chart.js/chart.min.js?v=".settings('refresh'))); ?>"></script>                                
<script src="<?php echo no_protocol(base_url("assets/libs/chart.js/palette.js?v=".settings('refresh'))); ?>"></script>                                

<?php

    $total = $result["pagination"]["total"];

    $statistics = $result["facets"];

    $containers =array();
    $q= $_GET["q"];
    if($q=="subject")
    {
        $containers = array(
                    "dewies" => array(
                        "contents"=> $statistics["dewies"],
                        "title" => ["ar"=>word("dewies")]
                    ),
                   );
    }
    elseif($q=="lang")
    {
        $containers = array(
                    "langs" => array(
                        "contents"=> $statistics["langs"],
                        "title" => ["ar"=>word("langs")]
                    ),
                );
    }
    elseif($q=="source")
    {
        $containers = array(
                       "sources" => array(
                           "contents"=> $statistics["sources"],
                           "title" => ["ar"=>word("sources")]
                       ),
                   );

    }
    elseif($q=="publisher")
    {
        $containers = array(
                            "publishers" => array(
                                "contents"=> $statistics["publishers"],
                                "title" => ["ar"=> word("publisher")]
                            ),
                        );
    }
    elseif($q=="types")
    {
        $containers = array(
                            "bibs" => array(
                                "contents"=> $statistics["bibs"],
                                "title" => ["ar"=>word("bibs")]
                            ),
                        );
    }
    else
    {
        $containers = array(
            "dewies" => array(
                "contents"=> $statistics["dewies"],
                "title" => ["ar"=>word("dewies")]
            ),
            "langs" => array(
                "contents"=> $statistics["langs"],
                "title" => ["ar"=>word("langs")]
            ),
            "bibs" => array(
                "contents"=> $statistics["bibs"],
                "title" => ["ar"=>word("bibs")]
            ),
            "sources" => array(
                "contents"=> $statistics["sources"],
                "title" => ["ar"=>word("sources")]
            ),
            "publishers" => array(
                "contents"=> $statistics["publishers"],
                "title" => ["ar"=> word("publisher")]
            ),

        );
    }




    $Graphicaltype = array("dewies");

?>

<div class="mt-4" id="browse_page">



    <div class="card rounded-0 mb-4">

        <div class="card-body" style="width: 100%;">

            <div class="row">
            
                <div class="col-md-6">
                    <div class="text-center">
                        <h1><i class="far fa-file-alt text-info"></i></h1>
                        <h5 class="mt-0"><?php echo number_format($total,0,".",","); ?></h5>
                        <h5><?php echo word("titles") ?></h5>
                    </div>                
                </div>
                
                <div class="col-md-6">
                    <div class="text-center">
                        <h1><i class="far fa-file-pdf text-danger"></i></h1>
                        <h5 class="mt-0"><?php echo number_format( $total * 10.6 , 0 ,"." ,"," ); ?></h5>
                        <h5><?php echo word("digital_material") ?></h5>
                    </div>                 
                </div>                
            
            </div>
        
        </div>                
    </div>  


    <?php foreach($containers as $type => $container){ ?>    
        
        <?php if($container["contents"]){ ?>
        
            <?php if( in_array( $type , $Graphicaltype ) ){ ?>                                     
                <script>
                    var MyData = [];
                    var MyLabels = [];
                    var MyColors = [];
                    var TheLabel = '<?php echo $type; ?>';
                    var placement = 'chart_<?php echo $type; ?>';
                </script>                        
            <?php } ?>
            

            <div class="card rounded-0 mb-4">
                <div class="card-header rounded-0">
                    <h5 class="mb-0"><?php echo $container["title"]["ar"] ?></h5>                    
                </div> 
                
                <?php if( in_array( $type , $Graphicaltype ) ){ ?>           
                
                    <div class="card-body canvas-con" style="direction: rtl !important;">
                        <div class="canvas-con-inner">
                            <canvas dir="RTL" id="chart_<?php echo $type; ?>" style="direction: rtl !important;" ></canvas>
                        </div>
                        <div id="my-legend-con" class="legend-con mt-4"></div>
                    </div>                
                  
                <?php } ?>
            </div>  

            <div class="row">

                <?php foreach($container["contents"] as  $content){ ?>
                    <?php if( $content["count"] > 20){ ?>
                            
                        <?php if( in_array( $type , $Graphicaltype ) ){ ?>                 
                            <script>
                                MyData.push('<?php echo $content["count"]; ?>');
                                MyLabels.push('<?php echo $content["title"] ?>');
                            </script>                      
                        <?php } ?>
                    
                        <div class="col-12 col-md-3">
                            <div class="card rounded-0 mb-3">          
                                <div class="card-body text-center browse_item text-center">

                                    <div class="row no-gutters">
                                        <div class="col-6">
                                            <h3 class="text-info" rel="tooltip" title="<?php echo word("titles") ?>"><i class="far fa-file-alt"></i></h3>
                                            <h5><?php echo number_format($content["count"],0,".",",") ?></h5>
                                        </div>
                                        <div class="col-6">
                                            <h3 class="text-danger" rel="tooltip" title="<?php echo word("digital_material") ?>"><i class="far fa-file-pdf"></i></h3>
                                            <h5><?php echo number_format( ( $content["count"]  * 10.6 ) ,0,".",",") ?></h5>                                            
                                        </div>
                                    </div>
                                    <a class="d-block title" href="<?php echo base_url(front_base."search/results/1?".$type."=".$content["value"]) ?>">
                                        <?php echo $content["title"] ?>                                        
                                    </a>  
                                                              
                                </div>                     
                           </div>                               
                       </div>                               
                    <?php } ?>
                <?php } ?>

            </div>     
            
            <?php if( in_array( $type , $Graphicaltype ) ){ ?>             
                <script src="<?php echo no_protocol(base_url("assets/libs/chart.js/config.js?v=".settings('refresh'))); ?>"></script>                                            
            <?php } ?>
                        
        <?php } ?>

    <?php } ?>
          
</div>


<style type="text/css">

    .canvas-con {
        position: relative;
    }

    .legend-con ul {
        list-style: none;
        text-align: center;
    }

    .legend-con li {
        margin-bottom: 4px;        
        display: inline-block;
        margin:15px;    
    }

    .legend-con li span {
        display: inline-block;
    }

    .legend-con li span.chart-legend {
        width: 16px;
        height: 16px;
        margin-left: 8px;
        border-radius:8px !important;
        -webkit-border-radius:8px  !important;  
    }

</style>