<?php $this->load->view(style.'/templates/main/header',$data); ?>


<?php
if(isset($views['content'])){
    $this->load->view(style.'/templates/'.$views['content'],$data); 
}elseif(isset($views['content_view'])){
    echo '<div class="mt-4">';
    echo $views['content_view'];
    echo '</div>';
}
 ?>                        


<?php $this->load->view(style.'/templates/main/footer',$data);