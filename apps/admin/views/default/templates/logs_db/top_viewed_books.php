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

</div>

<table class="table table-bordered table-hover table-sm m-0">                
              
    <tr>                        
        <td class="text-center" style="width: 150px;">Book id</td>                
        <td>Book Title</td>                
        <td class="text-center" style="width: 150px;">Repeats</td>                
    </tr>   

    <?php foreach($records as $record){ ?>                        

        <?php $data = json_decode($record->log_rel_text); ?>                                                                       
                  
        <tr>                        
            <td class="text-center"><?php echo $record->log_rel_id; ?></td>                
            <td><a target="_blank" href="<?php echo base_url("book/".$record->log_rel_id); ?>"><?php echo $data->title; ?></a></td>                
            <td class="text-center"><?php echo $record->repeats ?></td>                
        </tr>  

    <?php } ?>

</table>


