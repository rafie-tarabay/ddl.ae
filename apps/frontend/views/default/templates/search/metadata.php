<div id="search_results">
                              
    <?php 
        $total = $pagination["total"]; 
        $limit = $pagination["limit"]; 
        $from  = $pagination["page"];     
        $rest  = $pagination["rest"]; 
        
        $counters = array();  
        $counters["from"] = $limit * $page - ($limit - 1);
        $counters["to"]   = $rest ? $limit * $page : $total;

    ?>

    <div class="row">
    
        <?php if($books){ ?>
                
            <div class="col-12">                
                <div class="card card-default mt-4 mb-3">
                    <div class="card-header">
                        <div class="row line-height-35 no-gutters">
                            <div class="col-12 col-sm-4 text-lg-<?php echo MyAlign; ?> text-center">
                                <button class="btn btn-primary share_results" data-loaded="0" data-url="<?php echo urldecode( current_url()."?".$_SERVER['QUERY_STRING'] ); ?>"><i class="far fa-share-square"></i> <?php echo word("share_search") ?></button>
                            </div>                                        
                            <div class="col-12 col-sm-8 text-lg-<?php echo OppAlign; ?> text-center"> 
                                <div class="mt-2 mt-sm-0 mb-2 mb-sm-0  small_mobile">
                                    <?php echo $pagination["links"];?>
                                </div> 
                            </div>                        
                        </div>
                    </div>
                    <?php //$this->load->view(style."/templates/search/parts/applied_filters",array("results"=> $results)); ?>
                </div>                
            </div>
            
            <div class="col-12 col-sm-8">

                            
                <div class="small bg-gray mb-3" id="sorting_bar">
                
                    <div class="row">
                    
                        <div class="col-md-8">
                        
                            <i class="fa fa-caret-<?php echo OppAlign; ?> text-primary"></i>
                            
                            <u><?php echo $counters["from"]; ?></u>
                            -
                            <u><?php echo $counters["to"]; ?></u>
                            <?php echo word("from_total") ?>: 
                            <u><?php echo $total; ?></u>
                            <?php echo word("title") ?> <?php echo word("and") ?>
                            <u><?php echo  round( $total * 10.6 ) ; ?></u>
                            <?php echo word("digital_material") ?>.                        
                        
                        </div>
                        
                        <div class="col-md-4 text-<?php echo OppAlign; ?>">
                        
                            <label class="m-0"><i class="fas fa-sort-alpha-up" id="sort-loading"></i> <?php echo word("results_order") ?></label>  

                            <select id="sort_by_selector">                                                                    
                                <option value="publication_year" <?php if($sort == "none") echo 'selected="selected"' ?>><?php echo word("no_sort") ?></option>                                                            
                                <option value="publication_year" <?php if($sort == "publication_year") echo 'selected="selected"' ?>><?php echo word("date_publication") ?></option>                                                            
                                <option value="title" <?php if($sort == "title") echo 'selected="selected"' ?>><?php echo word("title") ?></option>                                                            
                                <option value="author" <?php if($sort == "author") echo 'selected="selected"' ?>><?php echo word("author") ?></option>                            
                                <option value="publisher" <?php if($sort == "publisher") echo 'selected="selected"' ?>><?php echo word("publisher") ?></option>                            
                                <!--
                                <option value="score" <?php if($sort == "score") echo 'selected="selected"' ?>><?php echo word("relevant") ?></option>                                                            
                                -->
                            </select>                             
                                               
                        </div>            
                    
                    </div>
                    

                    
                </div>  
            
            
                <?php $this->load->view(style."/templates/search/parts/single_book_modern",array("books"=> $books , "keywords"=>$keywords)); ?>
                
                                              
                <div class="mt-4 mb-4">
                    <?php if($pagination["links"]){ ?>
                        <div class="bg-gray border px-3 py-3 text-<?php echo OppAlign; ?>">
                            <?php echo $pagination["links"];?>
                        </div>
                    <?php } ?>
                </div>            
                
            </div>    

            <div class="col-12 col-sm-4">            
                <?php 
                    $params = array(
                        "facets"=>$facets,
                        "keywords"=>$keywords,
                        "filters"=>$filters,
                        "queries"=>$queries,
                    );
                    $this->load->view(style."/templates/search/forms/faceting", $params ); 
                ?>
            </div>                
                             
        <?php }else{ ?>    
        
            <div class="col-12">
            
                <div class="card card-default mt-4">
                    <div class="card-body text-center">
                        <h1 class="no-items mb-3"><i class="fa fa-exclamation-circle fa-4x"></i></h1>
                        <h3 class="no-items"><?php echo word("no_results") ?></h3>
                    </div>
                </div>
                
            </div>
    
        <?php } ?>   
        
    </div>
              
</div>    
    
          

<blockquote class="ltr text-<?php echo OppAlign; ?>">
    <?php //echo prnt($results["searchParameters"],FALSE); ?>
</blockquote>
    
