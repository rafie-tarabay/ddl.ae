<div class="card bg-gray-light general_slider" id="gs_<?php echo $slider_id ?>">

    <div class="card-header bg-gray-dark rounded-0">
        <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $slider_title; ?>
    </div>
    
    <div class="card-body">
    
        <?php 
          $start = rand(1,8);
          $end = $start+ 4;
        ?>
                
        <div id="swiper_<?php echo $slider_id ?>" class="swiper-container">
            <div class="swiper-wrapper">
            
                <?php foreach($books as $book){?>
                    
                    <?php 
                        $cover_url = $book->content_rel_image1."?v=".settings('refresh');
                        if (filter_var($cover_url, FILTER_VALIDATE_URL) === FALSE && strpos($cover_url,"/")) {
                            $cover_url = base_url($cover_url);                            
                        }       
                        
                        $url = urldecode($book->content_rel_url1);
                        if (strpos($url,"http") === FALSE) {
                            $url = base_url(front_base.$url);                            
                        }       
                        
                                         
                    ?>
                                                                                                
                    <a href="<?php echo $url ?>" class="swiper-slide single_book rounded-top " style="background-image:url('<?php echo $cover_url; ?>')" ></a>

                <?php } ?>    

            </div>

            <div class="swiper-button swiper-button-next rounded-circle"><i class="fa fa-angle-<?php  echo MyAlign; ?>"></i></div>
            <div class="swiper-button swiper-button-prev rounded-circle"><i class="fa fa-angle-<?php echo OppAlign; ?>"></i></div>    
        </div>

    </div>
    
</div>        



<script type="text/javascript">


    $(document).ready(function(){                                       
                      
        var slider_id = '<?php echo $slider_id ?>';
        
        var myswiper = new Swiper('#swiper_'+slider_id, {

            slidesPerView : 'auto',
            initialSlide : 0,
            loop : false,
            loopedSlides : 20,
            centeredSlides : false,
            
              
            pagination: {
                el: '#swiper_'+slider_id+' .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '#swiper_'+slider_id+' .swiper-button-next',
                prevEl: '#swiper_'+slider_id+' .swiper-button-prev' ,
            },
        });

    });

    

</script>
