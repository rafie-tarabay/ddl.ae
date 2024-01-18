<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base."publishing/requests"); ?>"> طلبات النشر</a>                
            </div>            
        </div>
    </div> 
</div> 



<br />
<div class="table-responsive">

    <table class="table table-light table-hover table-bordered" >

        <?php if($authors = $request->authors){ ?>
            <tr>
                <td width="150px" class="text-center">المؤلفون</td>            
                <td>   
                    <?php foreach($authors as $author){ ?>                                       
                        <a class="d-block" target="_blank" href="<?php echo base_url(admin_base."publishing/view_author/".$author->author_id) ?>"><?php echo $author->author_name; ?> (<span class="text-dark"><?php echo word($author->author_status); ?></span>)  </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
               
        <?php if($corporates = $request->corporates){ ?>
            <tr>
                <td width="150px" class="text-center">الهيئات</td>            
                <td>   
                    <?php foreach($corporates as $corp){ ?>                                       
                        <a class="d-block" target="_blank" href="<?php echo base_url(admin_base."publishing/view_corp/".$corp->corp_id) ?>"><?php echo $corp->corp_name; ?> (<span class="text-dark"><?php echo word($corp->corp_status); ?></span>)</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
                
        <tr>
            <td width="150px" class="text-center">عنوان المادة</td>            
            <td><?php echo $request->req_material_title; ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">نوع المادة</td>            
            <td><?php echo word($request->req_material_type); ?></td>
        </tr>

        <tr>
            <td width="150px" class="text-center">الخدمات المطلوبة</td>            
            <td>
                <?php if($request->req_services){ ?>
                    <?php foreach($request->req_services as $service){ ?>
                        <div><i class="fa fa-caret-left"></i> <?php echo $service->service_title_ar; ?></div>
                    <?php } ?>
                <?php }else{ ?>
                    لا يوجد
                <?php } ?>
            </td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">الإتاحة</td>            
            <td><?php echo word($request->req_pricing); ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">النشر من خلال</td>            
            <td><?php echo word($request->req_publish_via); ?></td>
        </tr>
                
        <tr>
            <td width="150px" class="text-center">حقوق النشر</td>            
            <td><?php echo $request->req_copyrights; ?> سنوات</td>
        </tr>
                                 
        <tr>
            <td width="150px" class="text-center">تعليقات أخرى</td>            
            <td><?php echo $request->req_comments; ?></td>
        </tr>
                                                                                                                
        <tr>
            <td width="150px" class="text-center">الملف</td>            
            <td><a target="_blank" href="<?php echo $request->req_material_file ?>" >استعرض</a></td>
        </tr>
                

    </table>    
    
</div>



                               
<div class="card card-default">
    <?php echo form_open(base_url(admin_base."publishing/reject_request") , array("class" => "check_submit", "release" => "true")); ?>
    
        <div class="card-body">     
        
            <div class="form-group">
                <label>سبب الرفض في حالة الرفض</label>
                <input  class="form-control req_field" name="req_reject_reason" value="<?php echo $request->req_reject_reason; ?>" />
            </div>        
        
            <input type="hidden" name="req_id" value="<?php echo @$request->req_id; ?>" />
            
        </div>        
        
        <div class="card-footer">
            
            <div class="row">
                <div class="col-6">
                    
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            تحديث الحالة ( <?php echo word($request->req_status); ?> )
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?php echo base_url(admin_base."publishing/request_status/".$request->req_id."/processing") ?>" >جاري العمل على الطلب</a>
                            <a class="dropdown-item" href="<?php echo base_url(admin_base."publishing/request_status/".$request->req_id."/complete") ?>" >طلب منتهي</a>
                            <a class="dropdown-item" href="<?php echo base_url(admin_base."publishing/request_status/".$request->req_id."/canceled") ?>" >طلب ملغي</a>
                        </div>
                    </div>                    
                    
                </div>                
                <div class="col-6 text-left">                
                    <input class="btn btn-danger" type="submit" value="رفض الطلب" />
                </div>
            </div>
            
        </div>            
    
    <?php echo form_close(); ?>        
</div>