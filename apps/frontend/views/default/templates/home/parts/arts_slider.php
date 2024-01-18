<div id="arts_slider" class="carousel slide" data-ride="carousel">

    <div class="carousel-inner">

        <?php $i = 1; foreach($arts as $art){ ?>
    
            <a href="#" class="carousel-item <?php if($i == 1) echo 'active'; ?>" style="background-image: url('<?php echo base_url($art->content_rel_image1."?v=".settings('refresh')) ?>');">                    
                <div class="carousel-caption">
                    <div class="row">
                        <div class="col-4">
                            <h4 class="art_title_caption"><?php echo word("name_artwork") ?></h4>
                            <p class="art_title"><?php echo $art->content_rel_title1 ?></p>
                        </div>
                        <div class="col-8">
                            <h4 class="art_artist_name"><?php echo $art->content_rel_title2 ?></h4>
                            <p class="art_location"><?php echo $art->content_rel_text1 ?></p>
                        </div>
                    </div>
                    <img class="art_location_logo" src="<?php echo base_url($art->content_rel_image2."?v=".settings('refresh')) ?>" alt="<?php echo word("image") ?>">
                </div>                   
            </a>
            
        <?php $i++; } ?>

    </div>

    <a class="swiper-button swiper-button-prev rounded-circle carousel-control carousel-control-next" href="#arts_slider" role="button" data-slide="prev">
        <i class="fa fa-angle-<?php echo OppAlign; ?>" aria-hidden="true"></i>
    </a>

    <a class="swiper-button swiper-button-next rounded-circle carousel-control carousel-control-prev" href="#arts_slider" role="button" data-slide="next">        
        <i class="fa fa-angle-<?php echo MyAlign; ?>" aria-hidden="true"></i>
    </a>

</div>


<script type="text/javascript">
    $('#arts_slider').carousel({
      interval: false
    });       
</script>