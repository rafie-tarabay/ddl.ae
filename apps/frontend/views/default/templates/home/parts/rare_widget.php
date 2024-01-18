<div class="card bg-light rounded" id="rare_widget">

 
    
    <div class="list-group rounded list-group-flush ticker_items" >
    
        <div class="innerWrap text-center">
            <?php foreach($items as $item){ ?>
                <!-- <a  href="<?php echo base_url(front_base.$item->content_rel_url1) ?>" class="list-group-item d-block"> -->
                <!-- <a  href="#" class="list-group-item d-block"> -->
                    <img class="rounded" src="<?php echo base_url($item->content_rel_image1."?v=".settings('refresh')) ?>"  alt="<?php echo word("image") ?>"/>
                <!-- </a> -->
            <?php } ?>
        </div>
        
    </div>
    
    <div class="card-footer rounded-0 head text-center">       
        <h4><?php echo $list_title; ?></h4>
        <div class="controls">            
            <button type="button" class="btn btn-sm btn-dark ticker_up"><i class="fa fa-angle-up"></i></button>
            <button type="button" class="btn btn-sm btn-dark ticker_down"><i class="fa fa-angle-down"></i></button>            
        </div>        
    </div>      

</div>



<script type="text/javascript">

    $(document).ready(function(){
    
        $('#rare_widget .ticker_items').easyTicker({
            direction: 'down',
            easing: 'swing',
            speed: 'slow',
            interval: 10000,
            height: 'auto',
            visible: 1,
            mousePause: 1,
            controls: {
                up: $("#rare_widget").find(".ticker_up"),
                down: $("#rare_widget").find(".ticker_down"),
            }
        });          
                      
    });

</script>


       