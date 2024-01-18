<div class="container">

    <?php 

        switch ($type) {
            case "error":
                $alert = "danger";
                $icon = "fa fa-times-circle";
                $class = "text-danger";
                $btn_class = "btn btn-danger";
                break;
            case "success":
                $alert = "success";
                $icon = "fa fa-check-circle";
                $class = "text-success";       
                $btn_class = "btn btn-success";         
                break;
            case "info":
                $alert = "info";
                $icon = "fa fa-info-circle";
                $class = "text-info";          
                $btn_class = "btn btn-info";      
                break;
        }

    ?>



    <br /><br /><br />

    <div class="response_alert nice-font-2">
    
        <div class="card card-default">
        
            <div class="card-header <?php echo $class; ?>">
                <h4>
                    <i class="respond_icon <?php echo $icon." ".$class; ?>"></i> <?php echo $title; ?>
                </h4>
            </div>
            
            <div class="card-body">

                <h4 class="response-text d-block text-center">
                    <i class="fa fa-quote fa-quote-<?php echo MyAlign ?>"></i> <span class="<?php echo $class; ?>"><?php echo $message; ?></span> <i class="fa fa-quote fa-quote-<?php echo OppAlign ?>"></i>
                </h4>

            </div>
                        
            <?php if($button == 1){ ?>
                <div class="card-footer text-<?php echo OppAlign; ?>">
                   <a href="<?php echo $url; ?>" class="btn-lg <?php echo $btn_class; ?>"><?php echo @$btn_word ? $btn_word : word("click_here_navigate"); ?> <i class="fa fa-chevron-circle-<?php echo OppAlign ?>"></i></a>
                </div>
            <?php } ?>    
        
        </div>


    </div>

</div>
 <script>
 $(document).ready(function(){
    window.location.replace("http://ddl.ae");

 });
 </script>