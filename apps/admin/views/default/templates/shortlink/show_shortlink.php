<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()); ?>">الرجوع</a>                                
            </div>            
        </div>
    </div> 
    
    <div class="card-body text-center">

        <h4 class="ltr"><?php echo $shortlink; ?></h4>     
        <h1 class="text-danger">=</h1>     
        <h4 class="ltr"><?php echo $link; ?></h4>             
    
    </div>
    
</div>