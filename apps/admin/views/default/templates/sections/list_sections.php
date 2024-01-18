<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <?php if( can("edit_sections_classes") ){ ?>
                    <a class="btn btn-danger" href="<?php echo base_url(admin_base."sections/content_classes/"); ?>">أنواع المحتوى</a>                
                <?php } ?>
                <a class="btn btn-success" href="<?php echo base_url(admin_base."sections/add_section/"); ?>">إضافة مكتبة</a>                
            </div>            
        </div>
    </div> 

</div>

<br />
<div class="table-responsive">

    <table class="table table-light table-hover table-bordered" >
        
        <thead class="thead-light">
            <tr class="active">
                <th>المكتبة</th>                
                <th width="70px" class="text-center">المحتوى</th>                                
                <th width="70px" class="text-center">تعديل</th>                                
            </tr>
        </thead>


        <?php foreach($sections as $section){ ?>
        
            <tr>
                <td>                        
                    <?php echo $section->sec_order." - ".$section->title; ?>
                    <br>
                    <code><?php echo $section->sec_alias; ?></code>
                </td>

                <td class="text-center">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url(admin_base."sections/widgets/".$section->sec_id) ?>">المحتوى</a>
                </td>             
                
                <td class="text-center">                    
                    <a class="btn btn-info btn-sm" href="<?php echo base_url(admin_base."sections/edit_section/".$section->sec_id) ?>">تعديل</a>
                </td>                                                   
              
            </tr>
            
        <?php } ?>


    </table>    
    
</div>