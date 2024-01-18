

<div id="books_swiper_<?php echo $slider_id ?>" class="swiper-container books_swiper">
    <div class="swiper-wrapper">
    
        <?php foreach($books as $book){?>
                                                                                        
            <a href="<?php echo base_url(front_base.$book->content_rel_url1) ?>" class="bg-gray-dark swiper-slide single_book rounded-top " style="background-image:url('<?php echo base_url($book->content_rel_image1."?v=".settings('refresh')) ?>')" >
            
                <?php if(@$rating){ ?>
                
                    <div class="book_rating">
                        <?php for($i=1;$i<=5;$i++){ ?>
                            <?php if($book->content_rel_text1 >= $i ) {?>
                                <i class="fa fa-star text-warning"></i>
                            <?php }elseif($book->content_rel_text1 < $i && $book->content_rel_text1 > ($i-1) ){ ?>
                                <i class="fa fa-star-half-o fa-flip-horizontal text-warning"></i>
                            <?php }else{ ?>
                                <i class="fa fa-star text-secondary"></i>
                            <?php } ?>
                        <?php } ?>
                    </div>                  

                <?php } ?>
                                                    
            </a>

        <?php } ?>    

    </div>

    <div class="swiper-button swiper-button-next rounded-circle"><i class="fa fa-angle-<?php  echo MyAlign; ?>"></i></div>
    <div class="swiper-button swiper-button-prev rounded-circle"><i class="fa fa-angle-<?php echo OppAlign; ?>"></i></div>    
</div>



<script type="text/javascript">


    $(document).ready(function(){                                       
                      
        (function( $ ){
            $.fn.slides_runner = function(slider_id) {   

                var myswiper = new Swiper('#books_swiper_'+slider_id, {

                    slidesPerView : 'auto',
                    initialSlide : 2,
                    loop : true,
                    loopedSlides : 20,
                    centeredSlides : true,
                    
                    autoplay: {
                        delay: 2500,
                    },
                      
                    pagination: {
                        el: '#books_swiper_'+slider_id+' .swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '#books_swiper_'+slider_id+' .swiper-button-next',
                        prevEl: '#books_swiper_'+slider_id+' .swiper-button-prev' ,
                    },
                });

            };  
            
            
            
        })( jQuery );     


        $('#books_tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {                                    
            $().slides_runner("<?php echo $slider_id ?>")
        });                                              
        
        $().slides_runner("<?php echo $slider_id ?>")

    });

    

</script>
