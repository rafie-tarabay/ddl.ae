<?php if(@$fields["size"] == "small"){ ?>

    <div class="list-group-item">
        <div class="media">
            <img class="<?php echo locale == "ar" ? "ml-3" : "mr-3"; ?> img-thumbnail" src="<?php echo $fields["image_url"] ?>"  alt="<?php echo word("image") ?>" style="width:70px; height:70px;">
            <div class="media-body mt-2">
                <b class=""><?php echo @$fields["name"]; ?></b>
                <div class="mt-2 small"><?php echo @$fields["title"]; ?></div>
            </div>
        </div>    
    </div>    
    
<?php }elseif(@$fields["size"] == "large"){ ?>

    <?php if( @$fields["image_clickable_url"] ){ ?> 
        <a class="list-group-item lib-item person-widget" href="<?php echo @$fields["image_clickable_url"]; ?>" target="_blank" style="background-image: url('<?php //echo $fields["image_url"] ?>');">
    <?php }else{ ?>
        <div class="list-group-item lib-item person-widget" style="background-image: url('<?php //echo $fields["image_url"] ?>');">
    <?php } ?>
        
            <div class="photo">
               <img class="img-fluid" src="<?php echo $fields["image_url"] ?>"  alt="<?php echo word("image") ?>" />
            </div>
            
            <div class="content">
                <?php if( @$fields["wiki_url"] ){ ?> 
                    <div class="wikipedia">
                        <img src="<?php echo base_url("assets/images/wikipedia.png") ?>"  alt="<?php echo word("image") ?>" />
                    </div>
                <?php } ?>
            
                <div class="info">
                    <span class="name"><b><?php echo @$fields["name"]; ?></b></span><br>                  
                    <span class="title"><?php echo @$fields["title"]; ?></span><br>  
                    <span class="country"><b><?php echo @$fields["country"]; ?></b></span>
                </div>
            </div>
            
    <?php if( @$fields["image_clickable_url"] ){ ?> 
        </a>
    <?php }else{ ?>
        </div>
    <?php } ?>
    
<?php } ?>
    
    

