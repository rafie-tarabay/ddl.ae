<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller {

    public function __construct() {
        parent::__construct(); // getting base constructor
        if(!logged_in && !$this->router->method != "index"){ redirect(base_url()); die(); }
        $this->load->model("user");
        $this->load->model("country"); 
    }

    public function index($username = username){

        if($username){

            $user = $this->user->get_user_by_field($username,"u_username",TRUE);
            
            if($user){

                $data["data"]["user"] = $user;

                $data["views"]["title"] = word("my_profile")." - ".$user->u_fullname;
                $data["views"]["full_width"] = TRUE;
                $data["views"]["header"] = 'inner';           
                $data["views"]["footer"] = 'inner';           
                $data["views"]["content"] = 'profile/profile';  

                $this->load->view(design_path.'/templates/main/core',$data);           
                
            }else{
                $this->base->response_page(word("error"),"info",word("user_not_found"),1);              
            }

        }else{
            $this->base->response_page(word("error"),"info",word("user_not_found"),1);              
        }

    }    


    public function edit_profile(){

        $user = $this->user->get_user_by_field(u_id);

        if($user){

            $edu_levels = $this->user->get_educational_levels();
            $know_fields = $this->user->get_dewey(1);
            $specials = $this->user->get_dewey(2);
            $countries = $this->country->fetch_all();                                        

            $data["data"]["user"] = $user;
            $data["data"]["countries"] = $countries;
            $data["data"]["edu_levels"] = $edu_levels;        
            $data["data"]["know_fields"] = $know_fields;        
            $data["data"]["specials"] = $specials;  
            $data["views"]["title"] = word("edit_profile") ;
            $data["views"]["full_width"] = TRUE;
            $data["views"]["header"] = 'inner';           
            $data["views"]["footer"] = 'inner';           
            $data["views"]["content"] = 'profile/forms/edit_profile';  

            $this->load->view(design_path.'/templates/main/core',$data);           

        }else{
            $this->base->response_page(word("error"),"info",word("user_not_found"),1);              
        }

    }    


    public function update_profile(){
                     
        $u_fullname             = trim($this->input->post("u_fullname"));
        $country                = $this->input->post("country");
        $u_emirates_id          = trim($this->input->post("u_emirates_id"));
        $mobile                 = trim($this->input->post("mobile"));
        $u_gender               = $this->input->post("u_gender");
        $u_birthdate            = trim($this->input->post("u_birthdate"));
        $educational_institute  = trim($this->input->post("educational_institute"));
        $educational_level      = $this->input->post("educational_level");        
        $knowledge_field        = $this->input->post("knowledge_field");
        $specialization         = $this->input->post("specialization");
        $u_password             = $this->input->post("u_password");
        $u_password_again       = $this->input->post("u_password_again");

        //@todo More validation Rules
        
        $user_data = array();

        if($educational_institute) $user_data["educational_institute"]  = $educational_institute;
        if($educational_level) $user_data["educational_level"]  = $educational_level;
        if($knowledge_field) $user_data["knowledge_field"]  = $knowledge_field;
        if($specialization) $user_data["specialization"]  = $specialization;


        $user = array();        

        if($u_fullname) $user["u_fullname"]  = $u_fullname;
        if($country) $user["u_country_code"]  = $country;
        if($u_emirates_id) $user["u_emirates_id"]  = $u_emirates_id;
        if($mobile) $user["u_mobile"]  = $mobile;
        if($u_gender) $user["u_gender"]  = $u_gender;
        if($u_birthdate) $user["u_birthdate"]  = $u_birthdate;
        if($u_password && $u_password_again) $user["u_password"]  = md5($u_password);

        $upload_data = array(
            "file_name" => u_id."-photo",
            "folder" => upload_base."users/".u_id."/",
            "field_name" => "u_photo",
            "ext" => "JPG|JPEG|PNG",
            "max_size" => 512,
            "resize" => array(
                "width" => 256,
                "height" => 256,
            ),
        );            
        $uploaded = $this->base->upload_doc($upload_data);

        if($uploaded["result"] == 1 && $uploaded["file_size"] > 0){

            $doc = $uploaded["file"];                            
            $folder = $upload_data["folder"];

            $do_data = array(
                "space_name"=>"storage",
                "path"=> $folder,
                "filename"=>$doc,
                "do_path"=>"ddl.ae/uploads/users/".u_id."/",
                "do_filename"=>$doc,
            );

            $sent = $this->base->send_to_digitalocean($do_data);
            if($sent){ // Success
                @unlink(FCPATH.$folder.$doc);
                $doc = $sent;
            }else{ // Faild
                $doc = $folder.$doc;
            }  
            
            if($doc) $user["u_photo"]  = $doc;

        }            


        if($user){
            $this->db->where("u_id",u_id)->update("users",$user);
            //lq($this->db);
            //prnt($user,FALSE);
        }

        if($user_data){
            $this->db->where("data_u_id",u_id)->update("users_data",$user_data);
            //prnt($user,FALSE);
        }    

        redirect(base_url("profile"));

    }


}