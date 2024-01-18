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

    <div class="card ">
    
        <div class="card-header">
            <h2 class="card-title <?php echo $class; ?>">
                <i class="respond_icon <?php echo $icon." ".$class; ?>"></i>
                <?php echo $title; ?>
            </h2>
        </div>
        
        <div class="card-body">

            <h3 class="response-text text-center">
                <i class="fa fa-quote fa-quote-right"></i> <span class="<?php echo $class; ?>"><?php echo $message; ?></span> <i class="fa fa-quote fa-quote-left"></i>
            </h3>

        </div>
                    
        <?php if($button == 1){ ?>
            <div class="card-footer text-left">
               <a href="<?php echo $url; ?>" class="btn-lg <?php echo $btn_class; ?>"><?php echo @$btn_word ? $btn_word : "اضغط هنا للإنتقال"; ?> <i class="fa fa-chevron-circle-left"></i></a>
            </div>
        <?php } ?>    
    
    </div>


</div>

</div>