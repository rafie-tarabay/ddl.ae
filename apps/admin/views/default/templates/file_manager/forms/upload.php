<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">

            </div>            
        </div>
    </div>     


    <?php echo form_open_multipart(base_url(admin_base."file_manager/upload") , array("class" => "form-horizontal", "role" => "form")); ?>

        <div class="card-body">     
                                                         
            <div class="form-group">
                <label for="files" class="control-label">اختر الملفات</label>
                <input type="file" class="form-control" name="files[]" multiple />
            </div>

            
            <div class="form-group">
                <label class="control-label">الرفع إلى</label>
                <select name="location" class="form-control" >
                    <option value="do" selected="selected" >[&#10003;] Digital Ocean</option>
                    <option value="local" disabled="disabled">[&#10005;] Local</option>
                    <option value="both" disabled="disabled">[&#10005;] Local & Digital Ocean</option>
                </select>                
            </div> 
            
            <div class="form-group">
                <label class="control-label">Space</label>
                <select name="space" class="form-control" >
                    <option value="storage" selected="selected" >[&#10003;] ddl-storage-server</option>
                    <option value="temp" disabled="disabled">[&#10005;] ddl-temp</option>
                    <option value="downloads" disabled="disabled" >[&#10005;] ddl-downloads</option>
                    <option value="covers" disabled="disabled">[&#10005;] ddl-covers</option>
                </select>                
            </div>          
            
            <div class="form-group">
                <label class="control-label">folder</label>
                <input type="text" class="form-control ltr text-left" name="folder" readonly="readonly" value="<?php echo $upload_folder; ?>" />
            </div>                      
                     
        </div>    

        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="حفظ" />
        </div>             

    <?php echo form_close(); ?>        

</div>

     