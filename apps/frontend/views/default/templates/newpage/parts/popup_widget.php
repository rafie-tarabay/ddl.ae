<?php if(!@$popup->content_rel_text1 || ( time() > strtotime(@$popup->content_rel_text1) ) ){ ?>
    <div class="modal fade" id="popup_widget_modal" tabindex="-1" role="dialog" aria-labelledby="popup_widget_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title nice-font"><?php echo $popup->content_rel_title1; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>            
                <div class="modal-body p-0">
                    <img class="img-fluid" src="<?php echo $popup->content_rel_image1."?v=".settings('refresh'); ?>"  alt="<?php echo word("image") ?>"/>
                </div>
            </div>
        </div>
    </div>

    <?php if( $this->session->userdata("disablePopupWidget") !== TRUE){ ?>
        <script type="text/javascript">
        $( document ).ready(function() {
            $('#popup_widget_modal').modal('show');
            $('#popup_widget_modal').on('hidden.bs.modal', function (e) {
                  $.post(base_url+"misc/disablePopupWidget", {
                    csrf_token : csrf_token,
                    }, function(my_data) {    
                }); 
            });
        });
        </script>
    <?php } ?>      
     
<?php } ?>