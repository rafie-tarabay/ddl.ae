<div class="card bg-light" id="events_widget">

    <div class="card-header bg-gray-dark rounded-0 head nice-font">
        <div class="row">
            <div class="col col-xs"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("events") ?></div>
            <div class="col col-xs controls">            
                <button type="button" class="btn btn-sm btn-dark ticker_up"><i class="fa fa-angle-up"></i></button>
                <button type="button" class="btn btn-sm btn-dark ticker_down"><i class="fa fa-angle-down"></i></button>            
            </div>
        
        </div>
    </div>
    
    <div class="list-group rounded-0 list-group-flush ticker_items" >
    
        <div class="innerWrap">
            <?php foreach($events as $event){ ?>
                <div class="list-group-item single_event rounded-0 list-group-item-action flex-column align-items-start ">
                    <span class="badge badge-light event_loc float-<?php echo OppAlign; ?>"><i class="fa fa-map-marker-alt"></i> <?php echo $event->content_rel_title2 ?></span>                    
                    <h5 class="mb-1 event_title">
                        <span class="event_name"><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo $event->content_rel_title1 ?></span>
                    </h5>
                    <?php if($event->content_rel_text1 && $event->content_rel_text2){ ?>
                        <p class="date"><?php echo word("from") ?> <?php echo $event->content_rel_text1 ?> <?php echo word("to") ?> <?php echo $event->content_rel_text2 ?></p>
                    <?php }else{ ?>
                        <p class="date"><?php echo $event->content_rel_text1 ?></p>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        
    </div>

</div>



<script type="text/javascript">

    $(document).ready(function(){
    
        $('#events_widget  .ticker_items').easyTicker({
            direction: 'up',
            easing: 'swing',
            speed: 'slow',
            interval: 10000,
            height: 'auto',
            visible: 2,
            mousePause: 1,
            controls: {
                up: $("#events_widget").find(".ticker_up"),
                down: $("#events_widget").find(".ticker_down"),
            }
        });          
                      
    });

</script>