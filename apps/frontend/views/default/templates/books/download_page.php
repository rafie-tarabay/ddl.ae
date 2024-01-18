<script src="<?php echo base_url(APPFOLDER."views/".style."/assets/js/download_page.js?v=".settings('refresh')); ?>"></script>                                

<br><br><br>

<div class="mt-4 text-center">

    <h1 id="file_loading"><i class="loading_icon fas fa-spin fa-circle-notch fa-3x"></i></h1>
        
    <div class="mt-4">
        <h5 id="msg1" ><?php echo word("please_wait") ?></h5>
    </div>
    
    <div class="mt-2">
        <small id="msg2"><?php echo word("being_processed") ?></small>
    </div>
        
    <div class="mt-2">
        <small id="msg3"></small>
    </div>
    
</div>

<input type="hidden" id="encrypted_string" value="<?php echo $encrypted_string ?>">

