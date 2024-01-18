<?php

class User extends base{

    public function __construct(){
        parent::__construct();           
        $this->db = $this->load->database("frontend",true);
    }         
    

    public function create_user($data){

        $user = array(
            "u_username" => trim($data->username),
            "u_password" => md5($data->password),
            "u_fullname" => $data->first_name." ".$data->last_name,
            "u_email" => $data->email,            
            "u_mobile" => $data->mobile,
            "u_country_code" => $data->country,
            "u_birthdate" => $data->birthdate,
            "u_emirates_id" => NULL,
            "u_photo" => NULL,
            "u_gender" => $data->gender,
            "u_reg_time" => time(),
            "u_lastvisit" => 0,
            "u_reference" => $data->reference,
        );

        $this->db->insert("users",$user);          
        $u_id = $this->db->insert_id();

        if($u_id){
            $this->create_associated_records($u_id,$data);
            return $u_id;
        }else{
            return FALSE;
        }
    }  

    public function create_associated_records($u_id,$d = ""){
        $data = array(
            "data_u_id" => $u_id,
            "billing_address" => isset($d->billing_address) ? $d->billing_address : NULL,
            "fp_code" => gen_hash(10),
            "fp_trials" => 0,
        );
        $this->db->insert("users_data",$data);
    }     

    public function check_associated_records($u_id){
        return $this->db->where("data_u_id",$u_id)->limit(1)->get("users_data")->row();
    }     

    public function get_user_by_field($val,$field="u_id" ,$join=FALSE){     
        $this->db->join("users_data","data_u_id = u_id","LEFT");
        $this->db->where($field,$val);        
        $user = $this->db->limit(1)->get("users")->row();                
             
        if($user && $join){
            $user->{"country"} = $this->db->where("country_code_ISO3",$user->u_country_code)->limit(1)->get("countries")->row();
            $user->{"knowledge_field"} = $this->db->where("field_dewey",$user->knowledge_field)->limit(1)->get("dewey")->row();
            $user->{"specialization"} = $this->db->where("field_dewey",$user->specialization)->limit(1)->get("dewey")->row();
            $user->{"educational_level"} = $this->db->where("level_id",$user->educational_level)->limit(1)->get("educational_levels")->row();                 
        }        

        return $user;
    }

    public function get_user_for_login($params){
        $this->db->join("users_data","data_u_id = u_id","LEFT");
        $this->db->group_start();
        $this->db->or_where("u_username",$params["username"]);        
        $this->db->or_where("u_email",$params["username"]);        
        $this->db->group_end();
        $this->db->where("u_password",md5($params["password"]));
        $user = $this->db->limit(1)->get("users")->row();                
        
        if($user){
            if(!isset($user->data_u_id)){
                $this->create_associated_records($user->u_id);                
            }            
        }
        
        return $user;
        
    }


    public function update_user($u_id,$data){             
        $this->db->where("u_id",$u_id);        
        return $this->db->limit(1)->update("users",$data);                
    }

    public function update_user_data($u_id,$data){             
        $this->db->where("data_u_id",$u_id);        
        return $this->db->limit(1)->update("users_data",$data);                
    }

    public function login_session($user){
        $session = array(
            "logged_in" => 1,
            "id" => $user->u_id,
            "email" => $user->u_email,
            "full_name" => $user->u_fullname,
            "username" => $user->u_username,
            "u_photo" => @$user->u_photo,
            "u_country" => @$user->u_country_code,
        );
        $this->session->set_userdata("customerSession",$session);
        
        $disclaimer = isset($user->disclaimer_notice) ? $user->disclaimer_notice : 0;
        $this->session->set_userdata("hide_disclaimer",$disclaimer);
    }

    public function logout_session(){
        $this->session->unset_userdata("customerSession");
        $this->session->unset_userdata("free_access");
    }



    //////////////////////// Temp user functions start   

    public function create_temp_user($data){

        $data = array(
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "country" => $data["country"],
            "email" => $data["email"],
            "mobile" => $data["mobile"],
            "mobile_code" => $this->generate_code("mobile"),
            "email_code" => $this->generate_code("email"),
            "reference" => $this->generate_code("reference"),
            "step" => 2,
            "completed" => 0,
            "timestamp" => time(),
        );

        $this->db->insert("users_temp",$data);        

        if($temp_id = $this->db->insert_id()){
            $data["temp_id"] = $temp_id;
            return $data;
        }else{
            return FALSE;
        }

    } 

    public function get_temp_user($reference){  
        $this->db->join("countries","country_code_ISO3 = country","LEFT");
        $this->db->where("reference",$reference);        
        //$this->db->where("completed",0);        
        return $this->db->limit(1)->get("users_temp")->row();                
    }

    public function get_temp_user_by_email($email){
        $this->db->where("email",$email);        
        return $this->db->limit(1)->get("users_temp")->row();                
    }



    public function update_temp_user($reference,$data){             
        $this->db->where("reference",$reference);        
        return $this->db->limit(1)->update("users_temp",$data);                
    }


    //////////////////////// Temp user functions End        


    public function is_valid_email($email){        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return FALSE;
        } else {
            return TRUE;
        }        
    }


    public function is_valid_username($username){
        if(preg_match('/\s/',$username) == FALSE){
            //$pattern = '/^[a-zA-Z0-9]+([a-zA-Z0-9](_|-|\.)[a-zA-Z0-9])*[a-zA-Z0-9]+$/'; // allowed =>  -  _  .               
            $pattern = '/^[a-zA-Z0-9]+([a-zA-Z0-9](\.)[a-zA-Z0-9])*[a-zA-Z0-9]+$/'; // allowed =>  .
            return preg_match($pattern, $username) && strlen($username) >=5;
        }else{
            return FALSE;
        }
    }


    public function is_valid_birthdate($birthdate){
        return TRUE;
    }

    public function format_birthdate($birthdate){
        $timestamp = strtotime($birthdate);
        return date("Y-m-d",$timestamp);
    }


    public function is_valid_password($password){
        return strlen($password) >= 6;
    }


    public function get_educational_levels(){
        return $this->db->order_by("level_order","ASC")->get("educational_levels")->result();                
    }

    public function get_dewey($level = 1){
        return $this->db->where("level",$level)->order_by("field_dewey","ASC")->get("dewey")->result();                
    }

    public function generate_code($for,$suffix=""){
        switch ($for) {
            case "fp":
                return gen_code(6)."00".$suffix;                
                break;
            case "mobile":
                return gen_code(4);
                break;
            case "email":
                return gen_code(4);
                break;
            case "reference":
                return strtolower(gen_code(4)).".".time();
                break;                
            default:

                break;
        }        
    }

}