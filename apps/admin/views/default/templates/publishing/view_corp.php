<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base."publishing/corporates"); ?>"> الهيئات</a>                
            </div>            
        </div>
    </div> 
</div> 



<br />
<div class="table-responsive">

    <table class="table table-light table-hover table-bordered" >

        <tr>
            <td width="150px" class="text-center">اسم الهيئة</td>            
            <td><?php echo $corp->corp_name; ?></td>
        </tr>
               
        <tr>
            <td width="150px" class="text-center">الاسم بالإنجليزية</td>            
            <td><?php echo $corp->corp_name_en; ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">الوحدة الفرعية</td>            
            <td><?php echo $corp->corp_sub_unit; ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">الوحدة بالإنجليزية</td>            
            <td><?php echo $corp->corp_sub_unit_en; ?></td>
        </tr>

        <tr>
            <td width="150px" class="text-center">مكان الانعقاد</td>            
            <td><?php echo $corp->corp_meeting_loc; ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">تاريخ الانعقاد</td>            
            <td><?php echo $corp->corp_meeting_date; ?></td>
        </tr>


    </table>    
    
</div>



                               
<div class="card card-default">
    <?php echo form_open(base_url(admin_base."publishing/reject_corp") , array("class" => "check_submit", "release" => "true")); ?>
    
        <div class="card-body">     
        
            <div class="form-group">
                <label>سبب الرفض في حالة الرفض</label>
                <input  class="form-control req_field" name="corp_reject_reason" value="<?php echo $corp->corp_reject_reason; ?>" />
            </div>        
        
            <input type="hidden" name="corp_id" value="<?php echo @$corp->corp_id; ?>" />
            
        </div>        
        
        <div class="card-footer">
            
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-success" href="<?php echo base_url(admin_base."publishing/accept_corp/".$corp->corp_id) ?>" >قبول الهيئة</a>
                </div>                
                <div class="col-6 text-left">                
                    <input class="btn btn-danger" type="submit" value="رفض الهيئة" />
                </div>
            </div>
            
        </div>            
    
    <?php echo form_close(); ?>        
</div>