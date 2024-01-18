<?php

if(isset($_GET["mobile_view"]) && $_GET["mobile_view"] == 0){
    $this->session->unset_userdata("mobile_view");
    $data["mobile_view"] = FALSE;
}else{
    $data["mobile_view"] =  ( isset($_GET["mobile_view"]) || $this->session->userdata("mobile_view") )  ? TRUE : FALSE;
}
  
$data["hide_layout"] = isset($views['hide_layout']) ? TRUE : FALSE ;

$data["site_contents"] = settings("site_contents");
$data["title"] = isset($views['title']) ? $views['title'] : FALSE;
$data["page_desc"] = isset($views['page_desc']) ? $views['page_desc'] : FALSE;
$data["page_keywords"] = isset($views['page_keywords']) ? $views['page_keywords'] : FALSE;
$data["page_image"] = isset($views['page_image']) ? $views['page_image'] : FALSE;
$data["biblo_type"] = isset($views['biblo_type']) ? $views['biblo_type'] : 'book';
$data['hide_search_menu'] = TRUE;
$this->load->view(design_path.'templates/main/header',$data);

$header = isset($views["header"]) ? $views["header"] : "inner";
//$this->load->view(design_path.'templates/main/headers/'.$header,$data);
                                                           
if(isset($views['content'])){
    $this->load->view(style.'/templates/'.$views['content'],$data); 
}elseif(isset($views['content_view'])){
    echo '<div class="mt-4">';
    echo $views['content_view'];
    echo '</div>';
}else if(isset($views['content_url'])){
    echo file_get_contents($views['content_url']); 
}

$footer = isset($views["footer"]) ? $views["footer"] : "inner";
$this->load->view(design_path.'templates/main/footers/'.$footer,$data);

$this->load->view(design_path.'templates/main/footer',$data);