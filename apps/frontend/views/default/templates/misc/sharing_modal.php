<?php    
    $title = "مكتبة دبي الرقمية ";
    $text = "مكتبة دبي الرقمية ".$url;
?>

<!-- Modal -->
<div class="modal fade" id="sharing_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo word("share") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">

                <div class="btn-group btn-group-sm sharing_icons">
                    <a target="_blank" class="twitter m-1" href="https://twitter.com/intent/tweet?text=<?php echo $text; ?>"><i class="fab fa-2x fa-twitter"></i></a>
                    <a target="_blank" class="facebook m-1" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"><i class="fab fa-2x fa-facebook"></i></a>
                    <a target="_blank" class="googleplus m-1" href="https://plus.google.com/share?url=<?php echo $url; ?>"><i class="fab fa-2x fa-google-plus"></i></a>
                    <a target="_blank" class="linkedin m-1" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>"><i class="fab fa-2x fa-linkedin"></i></a>                    
                    <a target="_blank" class="d-block d-sm-none whatsapp m-1" href="whatsapp://send?text=<?php echo $text; ?>"><i class="fab fa-2x fa-whatsapp"></i></a>                    
                </div>    
                
                    
                <br />
                
                <div class="mt-3">
                    <code><?php echo $url; ?></code>
                </div>
                                
                                            
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo word("hide_msg") ?></button>
            </div>
        </div>
    </div>
</div>