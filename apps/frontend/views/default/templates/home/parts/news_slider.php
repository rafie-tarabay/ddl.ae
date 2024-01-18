<div class="card bg-light" id="news_widget">

    <div class="card-header bg-gray-dark rounded-0 head nice-font">
        <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("news") ?>
    </div>
    
    <div class="list-group rounded-0">

        <div id="news_slider" class="carousel slide  " data-ride="carousel">
            
            <ol class="carousel-indicators">
                <?php $i = 0; foreach($news as $n){ ?>
                <li data-target="#news_slider" data-slide-to="<?php echo $i ?>" class="<?php if($i == 0) echo 'active'; ?>"></li>
                <?php $i++; } ?>
            </ol>
            
            <div class="carousel-inner">
            
                <?php $i = 0; foreach($news as $n){ ?>
                    
                    <div class="carousel-item <?php if($i == 0) echo 'active'; ?>">   
                    
                        <div class="card card-default border-0 rounded text-white">
                            <div class="card-body p-0 " style="background-image:url('<?php echo base_url($n->content_rel_image1."?v=".settings('refresh')) ?>');">
                                <div class="card-img-overlay border-0 black_gradient2">
                                    <div class="card-content">
                                        <h5 class="card-title news_title"><a href="<?php echo $n->content_rel_url1 ?>"><?php echo $n->content_rel_title1 ?></a></h5>
                                        <p class="card-text news_date"><?php echo $n->content_rel_text2 ?></p>
                                        <!--
                                        <p class="card-text news_desc d-md-block d-none"><?php echo $n->content_rel_text1 ?></p>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>                
                    
                    
                    </div>
                
                <?php $i++; } ?>


            </div>

            
        </div>



        <script type="text/javascript">
            $('#news_slider').carousel({
                interval: false
            });        
        </script>
        
        
    </div>

</div>