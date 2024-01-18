<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(!logged_in || can("view_users") == FALSE ){ redirect(base_url(admin_base."admins/login")); exit; }
    }    

    public function index(){

        $count = $this->db->count_all_results("users"); 

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"users/index/",3);            

        $this->db->join("users_data","u_id = data_u_id","left"); 
        $this->db->limit($per_page, $pagination["page"]); 
        $this->db->order_by("u_id","DESC");
        $records = $this->db->get("users")->result();


        $data["data"]["pagination"] = $pagination["links"];

        $data["data"]["count"] = $count;
        $data["data"]["records"] = $records;
        $data["views"]["content"] = 'users/list_all';   
        $data["data"]["title"] = "المستخدمين";

        $this->load->view(style.'/templates/main/core',$data);            

    }

    public function show_user($u_id){

        $this->db->where("u_id",$u_id);
        $record = $this->db->limit(1)->get("users")->row();

        $data["data"]["record"] = $record;
        $data["views"]["content"] = 'users/show_user';   
        $data["data"]["title"] = "عرض بيانات المستخدم";

        $this->load->view(style.'/templates/main/core',$data);            

    }


    public function search_temp_user(){

        $email = trim($this->input->post("email"));

        if($email){

            $this->db->where("email",$email);
            $count = $this->db->count_all_results("users_temp"); 

            $per_page = 20;                                    
            $pagination = $this->base->paginate_me($count,$per_page,"users/index/",3);            

            $this->db->where("email",$email);
            $this->db->order_by("temp_id","DESC");
            $records = $this->db->get("users_temp")->result();
            
            $data["data"]["pagination"] = $pagination["links"];

            $data["data"]["count"] = $count;
            $data["data"]["records"] = $records;
   
        }  
        
        $data["views"]["content"] = 'users/forms/search_temp_user';   
        $data["data"]["title"] = "البحث عن مستخدم مؤقت";

        $this->load->view(style.'/templates/main/core',$data);           

    }


}