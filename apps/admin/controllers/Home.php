<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct(); // getting base constructor
        if(!logged_in){ redirect(base_url(admin_base."admins/login")); exit; }
    }


    public function index(){
        
        $data = $this->cache->get("admin_dashboard");        
        if ( !$data ){          
            
            //// Access Expiry Notification
            $this->db->where("access_notif_date !=","0000-00-00")->where("access_notif_date <=",date("Y-m-d"));
            $to_expire["ips"]       = $this->db->where("access_expire >=",date("Y-m-d"))->count_all_results("free_access_ips");
            $this->db->where("access_notif_date !=","0000-00-00")->where("access_notif_date <=",date("Y-m-d"));
            $to_expire["countries"] = $this->db->where("access_expire >=",date("Y-m-d"))->count_all_results("free_access_countries");
            $this->db->where("access_notif_date !=","0000-00-00")->where("access_notif_date <=",date("Y-m-d"));
            $to_expire["tokens"]    = $this->db->where("access_expire >=",date("Y-m-d"))->count_all_results("free_access_tokens");
                  
            $data["data"]["counters"]["access"]["to_expire"] = $to_expire;              

            ///// Self publishing
            $data["data"]["counters"]["requests"] = $this->db->where("req_status","waiting_review")->count_all_results("publish_requests");
            $data["data"]["counters"]["authors"] = $this->db->where("author_status","waiting_review")->count_all_results("publish_authors");
            $data["data"]["counters"]["corporates"] = $this->db->where("corp_status","waiting_review")->count_all_results("publish_corporates");
            
            $this->cache->save("admin_dashboard", $data, 60*60*2);
        
        }
             
        $data["views"]["content"] = "home/home";                                
        $data["data"]["title"] = "الرئيسية";                

        $this->load->view(style.'/templates/main/core',$data);                   

    }



}
