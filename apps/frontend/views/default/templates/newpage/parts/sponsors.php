<div id="sponsors" >    
    <!--<h3>الرعاة</h3>-->
    <?php foreach($sponsors as $sponsor){?>                
        <div class="single_sponsor rounded ">
            <img class="img-responsive" src="<?php echo base_url($sponsor->content_rel_image1."?v=".settings('refresh')) ?>"  alt="<?php echo word("image") ?>">
        </div>
    <?php } ?>
</div>