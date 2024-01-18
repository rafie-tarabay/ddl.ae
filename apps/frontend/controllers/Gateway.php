<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gateway extends MY_Controller {


    public function __construct(){
        parent::__construct();           
    }    

    public function index($token = NULL){

        $access = FALSE;

        /// Token        
        $token = !$token || is_null($token) ? $this->input->post_get("token",TRUE) : $token ;
        
        
        if($token){   
            /// Check Token Access
            $access = $this->access->token($token);
        }else{

            //Check Proxy 
            
            if(!$access)
            {
                $ip =  $this->input->get('ip');
                $access = $this->access->proxy($ip); 
            }
            // Check IP ACCESS 
            if(!$access){             
                $access = $this->access->ip($this->access->ip_int);        
            }    
            // Check country ACCESS
            if(!$access){        
                $access = $this->access->country($this->access->ip_int);        
            }

        }        
        

        if($this->access->error){
             
            $this->show_error();
        }else{
             
            $free_access = $this->session->userdata("free_access");
            $customer = $this->session->userdata("customerSession");      
            
            if(@$customer["id"]){            
                /// logging
                $log = array(
                    "action" => "activate_free_access",
                    "u_id" => $customer["id"],
                    "rel_id" => $free_access["access_id"],
                    "rel_text" => $free_access["method"],
                );   
                $this->access->log_action($log);
                /// logging         
            }      
            
            $back_url = $this->session->userdata("back_url");
            $this->base->response_page(word("success"),"success",word("free_access_activated"),1,$back_url);      
        }
       
    }


    private function show_error(){
        if(!is_null($this->access->error) && $this->access->error !== TRUE){
            $this->base->response_page(word("error"),"error",$this->access->error);    
        }else{
            $this->base->response_page(word("error"),"error",word("access_denied"));    
        }        
    }    

    public function expired(){    
        $this->base->response_page(word("access_expired"),"info",word("free_access_expired"),1);              
    }   

    public function free_access(){
        
        $this->session->set_userdata("back_url",go_back());   

        $data["views"]["title"] = word("free_access");
        $data["views"]["full_width"] = TRUE;
        $data["views"]["header"] = 'inner';           
        $data["views"]["footer"] = 'inner';           
        $data["views"]["content"] = 'access/freeaccess';  

        $this->load->view(design_path.'/templates/main/core',$data);             

    }



    public function exit_free_access(){    
        $this->session->unset_userdata("free_access");          
        $this->expired();        
    }


}