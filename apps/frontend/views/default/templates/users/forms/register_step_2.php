<?php echo form_open( "users/submit_step_2" , array("role" => "form",  "class"=>"inline dynamic_form") ); ?>
            
    <?php if($user->email_verified == 0){ ?>        
        <div class="form-group">
            <label><?php echo word("confirmation_mail_code") ?><span class="text-danger">*</span></label>
            <input type="text" class="form-control req_field" name="email_code" placeholder="Confirmation Mail Code" value="<?php echo isset($_GET["code"]) ? $_GET["code"] : "";  ?>">
        </div>
    <?php } ?>
    

    <?php if($mobile_verify_required){ ?>        
        <div class="form-group">
        
            <div class="row">
                <div class="col">
                <label><?php echo word("confirmation_mobile_code") ?><span class="text-danger">*</span></label>
                </div>
                <div class="col text-<?php echo OppAlign; ?>">
                    <?php if($can_send_sms !== FALSE ){ ?>
                        <small id="code_resend_link" class="form-text text-muted">
                        <?php echo word("not_receive_code") ?> <a href="<?php echo base_url(front_base."users/request_sms/".$user->reference) ?>">يمكنك طلب الكود مرة أخرى</a>
                        </small>
                        <progress value="0" max="60" id="progressBar"></progress>                            
                    <?php } ?>                                               
                </div>                    
            </div>            

            <input type="text" class="form-control req_field" name="mobile_code" placeholder="Confirmation Mobile Code">
           
            
        </div>
    <?php } ?>
    
    <input type="hidden" name="reference" value="<?php echo $user->reference; ?>" />

    <div class="mb-2">
        <button type="submit" class="btn btn-info rounded-0"><?php echo word("confirm_data") ?></button>
    </div>       
    
<?php echo form_close(); ?>

<?php if($can_send_sms !== FALSE ){ ?>    
    <script> 
        $( document ).ready(function() {               
            
            var timeleft = '<?php echo is_integer($can_send_sms) ? ( 60 - $can_send_sms ) : 0 ?>';
            var downloadTimer = setInterval(function(){
              --timeleft;  
              document.getElementById("progressBar").value = 60 - timeleft;
              if(timeleft <= 0){
                clearInterval(downloadTimer);
                $("#progressBar").hide();
                $("#code_resend_link").show();
              }
            },1000);
            
        });
    </script>
<?php } ?>