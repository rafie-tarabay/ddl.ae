<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(!logged_in){ redirect(base_url(admin_base."admins/login")); exit; }        
    }    
    
    public function index(){
        
        $keywords = $this->input->post("keywords");
        $for = $this->input->post("for");
        
        if($for == "admin_logs"){
            redirect(base_url(admin_base."admins/view_logs/0/0/".$keywords));                  
        }
        
        
    }

    
}