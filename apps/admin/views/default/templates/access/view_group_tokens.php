<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base.ctrl()); ?>">رجوع</a>                
            </div>            
        </div>
    </div>     


    <?php echo form_open(base_url(admin_base.ctrl()."/view_group_tokens") , array("class" => "check_submit", "release" => "true")); ?>

        <div class="card-body">                   
       
            <div class="form-group">
                <label>Token group id<span class="text-danger">*</span></label>
                <input type="text" class="form-control req_field ltr text-left" name="group_id" value="<?php echo @$group_id; ?>" placeholder="Example: UAEU">
            </div>  
           
        </div>    


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="عرض" />
        </div>           
        
    <?php echo form_close(); ?>        

</div>

<?php if($tokens){ $i =1; ?>

    <table class="table table-bordered table-striped ltr text-left">
        <tr>
            <td style="width: 50px;" class="text-center">#</td>
            <td>Token</td>
            <td>Usage</td>
            <td>Token Expiry</td>
        </tr>
        <?php foreach($tokens as $token){ ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $token->token ?></td>
                <td><?php echo $token->access_counter ?></td>
                <td><?php echo $token->access_expire ?></td>
            </tr>
        <?php $i++; } ?>
    </table>
    
<?php } ?>
