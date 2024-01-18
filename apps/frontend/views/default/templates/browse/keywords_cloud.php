<div class="card card-default mt-4">
    <div class="card-header">
    
        <div class="row">
            <div class="col-md-4">
                <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $title ?>
            </div>
            
            <div class="col-md-8 text-<?php echo OppAlign; ?>">    

                <div class="btn-group btn-group-sm" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo word("keywords_cloud") ?>
                    </button>                    

                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo base_url(front_base."browse/keywords_cloud/title") ?>"><?php echo word("keywords_cloud")." - ".word("title") ?></a>                        
                        <a class="dropdown-item" href="<?php echo base_url(front_base."browse/keywords_cloud/title/1") ?>"><?php echo word("keywords_cloud")." - ".word("title")." - ".word("words") ?></a>                        
                        <a class="dropdown-item" href="<?php echo base_url(front_base."browse/keywords_cloud/content") ?>"><?php echo word("keywords_cloud")." - ".word("content") ?></a>                        
                        <a class="dropdown-item" href="<?php echo base_url(front_base."browse/keywords_cloud/content/1") ?>"><?php echo word("keywords_cloud")." - ".word("content")." - ".word("words") ?></a>                        
                        <a class="dropdown-item" href="<?php echo base_url(front_base."browse/keywords_cloud/subjects") ?>"><?php echo word("keywords_cloud")." - ".word("subjects") ?></a>                        
                        <a class="dropdown-item" href="<?php echo base_url(front_base."browse/keywords_cloud/subjects/1") ?>"><?php echo word("keywords_cloud")." - ".word("subjects")." - ".word("words") ?></a>                        
                        <a class="dropdown-item" href="<?php echo base_url(front_base."browse/keywords_cloud/author") ?>"><?php echo word("keywords_cloud")." - ".word("authors") ?></a>                        
                    </div>
                </div>            
            
                <a class="btn btn-info btn-sm" href="<?php echo base_url(front_base."browse/now_reading") ?>"><?php echo word("now_reading") ?></a>                        
            
                <a class="btn btn-info btn-sm" href="<?php echo base_url(front_base."browse/trends") ?>"><?php echo word("trends") ?></a>
                

            </div>
        </div>    
            
    </div>
    
    <div class="card-body">
        <?php echo word("keywords_cloud_notice") ?>    
    </div>

</div> 

<div id="keywords_cloud" class="mt-4">    
    
    <?php 
        //$last  = end($logs); 
       // $first = reset($logs); 
        
       // $min = $last["count"];
       // $max = $first["count"];

       // $pace = ( $max - $min ) / 6;
        
       // $staps = range($min,$max, $pace );
        
        //prntf($staps);
        $div_class  = 7;
    ?>

    <?php foreach($logs as $log){   ?>

        <?php 
            // if($log["count"] < $staps[1]){
            //     $div_class  = 1;
            // }elseif($log["count"] < $staps[2]){
            //     $div_class  = 2;
            // }elseif($log["count"] < $staps[3]){
            //     $div_class  = 3;
            // }elseif($log["count"] < $staps[4]){
            //     $div_class  = 4;                
            // }elseif($log["count"] < $staps[5]){
            //     $div_class  = 5;  
            // }elseif($log["count"] < $staps[6]){
            //     $div_class  = 6;                                  
            // }else{
            //     $div_class  = 7;
            // }            
        ?>

        <div class="keyword keyword_<?php echo $div_class; ?>" title="<?php echo $log->count ?>" rel="tooltip">
        <?php 
        $search = str_replace(' ','+',$log->word);
        ?>
            
            <a class="pointer" href='<?php echo base_url('search/results/1?queries=or|all|"'.$search.'"'); ?>' target="_blank" >
             
             
                <?php echo word_limiter($log->word,6,".."); ?>
            </a>
        </div>

    <?php } ?>

</div>