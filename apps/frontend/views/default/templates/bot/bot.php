<br><br>
<div class="container text-center" style="max-width: 750px;">

    
    <div class="">
        <div class="row">
            <div class="col-6 text-right">
                <a class="btn btn-danger" href="<?php echo base_url("bot/startover") ?>">ابدأ من جديد !</a>
            </div>
            <div class="col-6 text-left">
                <a class="btn btn-info" href="<?php echo base_url("bot/goback") ?>">رجوع</a>
            </div>            
        </div>
    </div>  

    <div class="mt-5 mb-5">   
        <h4><?php echo $node->node_statement_ar ?></h4>    
    </div>
    <div>
        <?php echo $response; ?>
    </div>
  
    
</div>


