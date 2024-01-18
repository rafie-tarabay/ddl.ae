<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base."publishing/authors"); ?>"> المؤلفون</a>                
            </div>            
        </div>
    </div> 
</div> 



<br />
<div class="table-responsive">

    <table class="table table-light table-hover table-bordered" >

        <tr>
            <td width="150px" class="text-center">اسم المؤلف</td>            
            <td><?php echo $author->author_name; ?></td>
        </tr>
               
        <tr>
            <td width="150px" class="text-center">الاسم بالإنجليزية</td>            
            <td><?php echo $author->author_name_en; ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">البريد</td>            
            <td><?php echo $author->author_email; ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">الجوال</td>            
            <td><?php echo $author->author_mobile; ?></td>
        </tr>

        <tr>
            <td width="150px" class="text-center">الجنسية</td>            
            <td><?php echo $author->author_nationality; ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">العنوان</td>            
            <td><?php echo $author->author_address; ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">الوظيفة</td>            
            <td><?php echo $author->author_job_title; ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">الشركة</td>            
            <td><?php echo $author->author_company; ?></td>
        </tr>
                                                                                                                
        <tr>
            <td width="150px" class="text-center">الهوية</td>            
            <td><a target="_blank" href="<?php echo $author->author_id_doc ?>" >استعرض</a></td>
        </tr>
                

    </table>    
    
</div>



                               
<div class="card card-default">
    <?php echo form_open(base_url(admin_base."publishing/reject_author") , array("class" => "check_submit", "release" => "true")); ?>
    
        <div class="card-body">     
        
            <div class="form-group">
                <label>سبب الرفض في حالة الرفض</label>
                <input  class="form-control req_field" name="author_reject_reason" value="<?php echo $author->author_reject_reason; ?>" />
            </div>        
        
            <input type="hidden" name="author_id" value="<?php echo @$author->author_id; ?>" />
            
        </div>        
        
        <div class="card-footer">
            
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-success" href="<?php echo base_url(admin_base."publishing/accept_author/".$author->author_id) ?>" >قبول المؤلف</a>
                </div>                
                <div class="col-6 text-left">                
                    <input class="btn btn-danger" type="submit" value="رفض المؤلف" />
                </div>
            </div>
            
        </div>            
    
    <?php echo form_close(); ?>        
</div>