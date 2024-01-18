<div class="list-group-item p-0">

    <?php if($fields["type"] == "youtube"){ ?>
        <div class="embed-responsive embed-responsive-4by3">
            <iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/<?php echo $fields["youtube_code"]; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    <?php }else{ ?>
    
    <?php } ?>

</div>