<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8">                
                <h3 class="panel-title"><?php echo $title; ?></h3>
            </div>

            <div class="col-sm-4 text-left">                
                <a class="btn btn-success" href="<?php echo base_url(admin_base."landing_content/new_content/"); ?>">إضافة جديد</a>                
                <a class="btn btn-success" href="<?php echo base_url(admin_base."landing_content/pull_original_images/"); ?>">سحب الصور الأصلية</a>                
            </div>
     
        </div>                                         
    </div>     
</div>  


<div class="row mt-4">
    <?php foreach($cats as $cat){ ?>
        <div class="col-md-3"> 
            <div class="card mb-4">
                <div class="card-body">
                    <a href="<?php echo base_url(admin_base."landing_content/category/".$cat->cat_name) ?>"><?php echo $cat->cat_title ?></a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>