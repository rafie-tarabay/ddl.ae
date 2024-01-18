<nav class="navbar navbar-expand-lg navbar-light bg-light" id="cats-navbar">
    <div class="container no-glutter">

        <div class=" navbar-collapse" id="navbarNav">
            <ul class="navbar-nav text-<?php echo MyAlign; ?> text-sm-center list-inline">
                
                <?php foreach($site_contents["nav"]["categories"] as $c){ ?>            
                    <li class="nav-item list-inline-item <?php echo $c->content_rel_text1 ?>">
                        <a class="nav-link" href="<?php echo base_url($c->content_rel_url1) ?>">
                            <?php if($c->content_rel_image1){ ?>                                                    
                                <img src="<?php echo base_url($c->content_rel_image1); ?>" />
                            <?php }else{ ?>
                                <?php echo word($c->content_rel_title1); ?>
                            <?php } ?>
                        </a>
                    </li>                    
                <?php } ?>                    

            </ul>
        </div>
    </div>
</nav>