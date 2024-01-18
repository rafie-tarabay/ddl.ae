<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newpage extends MY_Controller {

    public function __construct() {
       
        parent::__construct(); // getting base constructor
    }    


    public function index(){                 
        
        $exclude = array();
        
        $this->load->model("logs_analyzer");
        $data["data"]["latest_logs"] = $this->logs_analyzer->get_latest_reading_logs(5);                 
        
        $content = $this->base->site_content(FALSE);

        $data["data"]["content"] = $content;        
        
        $data["data"]["search_url"] = base_url(front_base."/newSearch/home");               
        $data["data"]["page_name"] = "landing";
        
        $data["views"]["full_width"] = TRUE;
        $data["views"]["header"] = 'landing';           
        $data["views"]["footer"] = 'landing';           
        $data["views"]["content"] = 'newpage/landing';  
            
        $this->load->view(design_path.'/templates/main/core',$data);  

    }  
    
    
    public function dashboard(){            
        $url = logged_in == TRUE ? front_base."dashboard" : "login";        
        redirect(base_url($url));
    }



}
