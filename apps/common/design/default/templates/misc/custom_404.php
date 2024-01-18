<div class="container">

    <div class="page404">

        <div class="row">
        
            <div class="col-12 col-sm-4">
            
                <img class="img-fluid" src="<?php echo base_url("assets/images/404_icon.png") ?>" />

            </div>

            <div class="col-12 col-sm-8">
                <div class="page_text">
                    <h1 class="text-primary">404</h1>
                    <h2 class="text-dark nice-font"><?php echo word("page_404") ?></h2>
                    <h4 class="text-muted"><?php echo word("page_404_des") ?></h4>
                    <div class="mt-4">
                        <a class="btn btn-primary btn-lg border-0" href="<?php echo base_url() ?>"><i class="fa fa-home"></i> <?php echo word("home") ?></a>
                        <a class="btn btn-warning btn-lg border-0" href="<?php echo base_url("page/contact") ?>"><i class="fa fa-at"></i> <?php echo word("contact_us") ?> </a>
                        <a class="btn btn-link btn-lg border-0" href="<?php echo go_back(base_url()) ?>"><?php echo word("back") ?></a>
                    </div>
                </div>
            </div>            

        </div>

    </div>

</div>