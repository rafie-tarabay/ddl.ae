<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(!logged_in || can("show_access") == FALSE ){ redirect(base_url(admin_base."admins/login")); exit; }
    }    

    public function index(){

        $data["views"]["content"] = 'access/types';   
        $data["data"]["title"] = "صلاحيات الدخول";

        $this->load->view(style.'/templates/main/core',$data);            

    }

    public function list_records($type){

        switch ($type) {
            case "ip":
                $table = "free_access_ips";                 
                break;
            case "token":
                $table = "free_access_tokens"; 
                break;
            case "country":
                $table = "free_access_countries"; 
                break;
        }       

        $count = $this->db->count_all_results($table); 

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"access/list_records/$type",4);            

        if($type == "ip") $this->db->join("users","u_id = access_u_id","LEFT");
        $this->db->limit($per_page, $pagination["page"]); 
        $this->db->order_by("access_denied ASC, access_id DESC");

        $records = $this->db->get($table)->result();

        $data["data"]["pagination"] = $pagination["links"];

        $data["data"]["type"] = $type;
        $data["data"]["records"] = $records;
        $data["views"]["content"] = 'access/list_all';   
        $data["data"]["title"] = "صلاحيات الدخول | ".$type;

        $this->load->view(style.'/templates/main/core',$data);            

    }


    public function add_record($type){

        $data["data"]["method"] = "insert_record";
        $data["data"]["type"] = $type;
        $data["views"]["content"] = 'access/forms/add_edit_record';   
        $data["data"]["title"] = "إضافة صلاحية | ".$type;

        $this->load->view(style.'/templates/main/core',$data);            
    }


    public function insert_record(){

        $type = $this->input->post("type");

        $identifier = trim($this->input->post("identifier"));
        $access_start = trim($this->input->post("access_start"));            
        $access_expire = trim($this->input->post("access_expire")); 
        $access_limit = trim($this->input->post("access_limit"));            
        //$access_counter = $this->input->post("access_counter");                     
        $access_denied = $this->input->post("access_denied");                     
        $access_master_rule = $this->input->post("access_master_rule");                     
        $access_master_rule = in_array($access_master_rule , array("allow","deny")) ? $access_master_rule : "allow";

        $access_notif = $this->input->post("access_notif");                     
        $access_notif_rule = $this->input->post("access_notif_rule");                             

        if($identifier){

            $data = array(
                "identifier"=> $identifier,
                "access_start"=> $access_start,
                "access_expire"=> $access_expire,                    
                "access_limit" => is_integer($access_limit) ? $access_limit : 0,
                "access_counter" => 0,                     
                "access_denied" => $access_denied,                      
                "access_master_rule" => $access_master_rule,                      
            );

            switch ($type) {
                case "ip":
                    $table = "free_access_ips";// table                 
                    $data["access_u_id"] = trim($this->input->post("access_u_id"));
                    $data["range_start"] = trim($this->input->post("range_start"));            
                    $data["range_end"]   = trim($this->input->post("range_end"));
                    $data["int_start"]   = ip_to_int(trim($this->input->post("range_start")));
                    $data["int_end"]     = ip_to_int(trim($this->input->post("range_end")));
                    break;
                case "token":
                    $table = "free_access_tokens";// table 
                    $data["token"] =  trim($this->input->post("token"));
                    $data["group_id"] =  trim($this->input->post("group_id"));
                    break;
                case "country":
                    $table = "free_access_countries";// table 
                    $data["country_code_ISO3"] = trim($this->input->post("country_code_ISO3"));
                    $data["country_code_ISO2"] = trim($this->input->post("country_code_ISO2"));              
                    break;
            }                           

            $expiry = $data["access_expire"];
            $start = $data["access_start"];
            
            if( $expiry && $start &&  $access_notif && $access_notif_rule){
                if(in_array($access_notif_rule,array("0.25","0.5")) ){                    
                    $gap = round( ( strtotime($expiry) - strtotime($start) ) * $access_notif_rule ) ;     
                    $notif_timestamp = strtotime($expiry) - $gap;
                }else{
                   $notif_timestamp = strtotime( $expiry." ".$access_notif_rule ) ;     
                }                
                                
               $data["access_notif"]   = $access_notif;
               $data["access_notif_rule"]   = $access_notif_rule;
               $data["access_notif_date"]   = date("Y-m-d",$notif_timestamp);                               
            }                  
            
            $this->db->insert($table,$data);

            $access_id = $this->db->insert_id();

            if($access_id){

                //admin log
                $log = array( 
                    "log_type"=>"free_access", 
                    "log_action"=>"create",  
                    "log_rel_id"=>$access_id,
                    "log_rel_text"=>json_encode($data),
                );                              
                $this->logger->create($log);       

                redirect(base_url(admin_base."access/list_records/".$type));

            }else{
                prnt($this->db->last_query());
                $this->base->response_page("خطأ","error","لا يمكن انشاء السجل",1,"auto");                              
            }           

        }else{
            $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
        }            

    }



    public function edit_record($type,$access_id){

        switch ($type) {
            case "ip":
                $table = "free_access_ips";                 
                break;
            case "token":
                $table = "free_access_tokens"; 
                break;
            case "country":
                $table = "free_access_countries"; 
                break;
        }           
        $data["data"]["access"] = $this->db->where("access_id",$access_id)->limit(1)->get($table)->row();

        $data["data"]["method"] = "update_record";
        $data["data"]["type"] = $type;
        $data["views"]["content"] = 'access/forms/add_edit_record';   
        $data["data"]["title"] = "تعديل صلاحية | ".$type;

        $this->load->view(style.'/templates/main/core',$data);            
    }



    public function update_record(){

        $type = $this->input->post("type");
        $access_id = $this->input->post("access_id");

        $identifier = trim($this->input->post("identifier"));
        $access_start = trim($this->input->post("access_start"));            
        $access_expire = trim($this->input->post("access_expire")); 
        $access_limit = trim($this->input->post("access_limit"));            
        //$access_counter = $this->input->post("access_counter");                     
        $access_denied = $this->input->post("access_denied");                     
        $access_master_rule = $this->input->post("access_master_rule");                     
        $access_master_rule = in_array($access_master_rule , array("allow","deny")) ? $access_master_rule : "allow";

        $access_notif = $this->input->post("access_notif");                     
        $access_notif_rule = $this->input->post("access_notif_rule");                     
        
        if($identifier && $access_id){

            $data = array(
                "identifier"=> $identifier,
                "access_start"=> $access_start ? date("Y-m-d",strtotime($access_start)) : "",
                "access_expire"=> $access_expire ? date("Y-m-d",strtotime($access_expire)) : "",
                "access_limit" => is_integer($access_limit) ? $access_limit : 0,
                "access_counter" => 0,                     
                "access_denied" => $access_denied,    
                "access_master_rule" => $access_master_rule,                                        
            );

            switch ($type) {
                case "ip":
                    $table = "free_access_ips";// table                 
                    $data["access_u_id"] = trim($this->input->post("access_u_id"));
                    $data["range_start"] = trim($this->input->post("range_start"));            
                    $data["range_end"]   = trim($this->input->post("range_end"));
                    $data["int_start"]   = ip_to_int(trim($this->input->post("range_start")));
                    $data["int_end"]     = ip_to_int(trim($this->input->post("range_end")));
                    break;
                case "token":
                    $table = "free_access_tokens";// table 
                    $data["token"] =  trim($this->input->post("token"));
                    $data["group_id"] =  trim($this->input->post("group_id"));
                    break;
                case "country":
                    $table = "free_access_countries";// table 
                    $data["country_code_ISO3"] = trim($this->input->post("country_code_ISO3"));
                    $data["country_code_ISO2"] = trim($this->input->post("country_code_ISO2"));              
                    break;
            }                           

            $expiry = $data["access_expire"];
            $start = $data["access_start"];
            
            if( $expiry && $start &&  $access_notif && $access_notif_rule){
                if(in_array($access_notif_rule,array("0.25","0.5")) ){                    
                    $gap = round( ( strtotime($expiry) - strtotime($start) ) * $access_notif_rule ) ;     
                    $notif_timestamp = strtotime($expiry) - $gap;
                }else{
                   $notif_timestamp = strtotime( $expiry." ".$access_notif_rule ) ;     
                }                
                                
               $data["access_notif"]   = $access_notif;
               $data["access_notif_rule"]   = $access_notif_rule;
               $data["access_notif_date"]   = date("Y-m-d",$notif_timestamp);                               
            }

            $this->db->where("access_id",$access_id)->update($table,$data);

            //admin log
            $log = array( 
                "log_type"=> "free_access", 
                "log_action"=>"update",  
                "log_rel_id"=>$access_id,
                "log_rel_text"=>json_encode($data),
            );                              
            $this->logger->create($log);       

            redirect(base_url(admin_base."access/list_records/".$type));


        }else{
            $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
        }            


    }



    public function delete_record($type,$access_id){

        switch ($type) {
            case "ip":
                $table = "free_access_ips";// table                 
                break;
            case "token":
                $table = "free_access_tokens";// table 
                break;
            case "country":
                $table = "free_access_countries";// table 
                break;
        }    

        $access = $this->db->where("access_id",$access_id)->get($table)->row();

        if($access){

            $this->db->limit(1)->where("access_id",$access_id)->delete($table);

            //admin log
            $log = array( 
                "log_type"=>"free_access", 
                "log_action"=>"delete",  
                "log_rel_id"=>$access_id,
                "log_rel_text"=>json_encode( (array) $access ),
            );                              
            $this->logger->create($log);                 

            redirect(base_url(admin_base."access/list_records/".$type));

        }else{
            $this->base->response_page("خطأ","error","الصفحة غير موجودة",1);                              
        }

    }        



    public function rules($type,$access_id){

        switch ($type) {
            case "ip":
                $table = "free_access_ips";                 
                break;
            case "token":
                $table = "free_access_tokens"; 
                break;
            case "country":
                $table = "free_access_countries"; 
                break;
        }           
        $data["data"]["access"] = $this->db->where("access_id",$access_id)->limit(1)->get($table)->row();

        $data["data"]["rules"] = $this->db->where("rule_access_type",$type)->where("rule_access_id",$access_id)->get("free_access_rules")->result();

        $data["data"]["type"] = $type;
        $data["views"]["content"] = 'access/access_rules';   
        $data["data"]["title"] = "قواعد الاستثناء";

        $this->load->view(style.'/templates/main/core',$data);            
    }







    public function add_rule($type,$access_id){

        $data["data"]["method"] = "insert_rule";
        $data["data"]["access_id"] = $access_id;
        $data["data"]["type"] = $type;
        $data["views"]["content"] = 'access/forms/add_edit_rule';   
        $data["data"]["title"] = "إضافة قاعدة";

        $this->load->view(style.'/templates/main/core',$data);            
    }


    public function insert_rule(){

        $type = $this->input->post("type");
        $access_id = $this->input->post("access_id"); 

        $rule_rel_type = $this->input->post("rule_rel_type");
        $rule_rel_value = $this->input->post("rule_rel_value");            
        $rule_rel_value = trim($rule_rel_value);
        $rule_rel_value = str_replace(" ","",$rule_rel_value);

        if($rule_rel_type && $rule_rel_value){

            $data = array(
                "rule_access_id"=> $access_id,
                "rule_access_type"=> $type,
                "rule_rel_type"=> $rule_rel_type,                    
                "rule_rel_value" => $rule_rel_value,
            );

            $this->db->insert("free_access_rules",$data);

            redirect(base_url(admin_base."access/rules/".$type."/".$access_id));

        }else{
            $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
        }            

    }



    public function edit_rule($rule_id){

        $data["data"]["rule"] = $rule = $this->db->where("rule_id",$rule_id)->limit(1)->get("free_access_rules")->row();

        $data["data"]["method"] = "update_rule";
        $data["data"]["access_id"] = $rule->rule_access_id;
        $data["data"]["type"] = $rule->rule_access_type;
        $data["views"]["content"] = 'access/forms/add_edit_rule';   
        $data["data"]["title"] = "تعديل قاعدة";

        $this->load->view(style.'/templates/main/core',$data);             
    }



    public function update_rule(){

        $type = $this->input->post("type");
        $access_id = $this->input->post("access_id"); 

        $rule_rel_type = $this->input->post("rule_rel_type");
        $rule_rel_value = $this->input->post("rule_rel_value");            
        $rule_rel_value = trim($rule_rel_value);
        $rule_rel_value = str_replace(" ","",$rule_rel_value);

        $rule_id = $this->input->post("rule_id");            

        if($rule_rel_type && $rule_rel_value){

            $data = array(
                "rule_rel_type"=> $rule_rel_type,                    
                "rule_rel_value" => $rule_rel_value,
            );

            $this->db->where("rule_id",$rule_id)->update("free_access_rules",$data);

            redirect(base_url(admin_base."access/rules/".$type."/".$access_id));

        }else{
            $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
        }  

    }



    public function delete_rule($rule_id){

        $rule = $this->db->where("rule_id",$rule_id)->limit(1)->get("free_access_rules")->row();

        if($rule){

            $this->db->where("rule_id",$rule_id)->limit(1)->delete("free_access_rules");

            redirect(base_url(admin_base."access/rules/".$rule->rule_access_type."/".$rule->rule_access_id));

        }


    }        



    public function tokens_generator(){

        $data["views"]["content"] = 'access/forms/generate_mass_tokens';   
        $data["data"]["title"] = "توليد تذاكر الدخول المجاني";

        $this->load->view(style.'/templates/main/core',$data);    
    }

    public function generate_tokens(){

        $count = trim($this->input->post("count"));
        $identifier = trim($this->input->post("identifier"));
        $group_id = trim($this->input->post("group_id"));
        $access_start = trim($this->input->post("access_start"));
        $access_expire = trim($this->input->post("access_expire"));
        $access_limit = trim($this->input->post("access_limit"));
        
        $group_id = str_replace(" ","",$group_id);

        if($count > 0 && $group_id){

            $tokens = array();

            for($i=1;$i<=$count;$i++){

                $token = $group_id."@".gen_hash(5)."@".$i;
  
                $tokens[] = array(                    
                    "token"=> $token,
                    "group_id"=> $group_id,
                    "identifier"=> $identifier,
                    "access_start"=> $access_start ? date("Y-m-d",strtotime($access_start)) : "",
                    "access_expire"=> $access_expire ? date("Y-m-d",strtotime($access_expire)) : "",
                    "access_limit" => is_integer($access_limit) ? $access_limit : 0,
                    "access_counter" => 0,                     
                    "access_denied" => 0,    
                    "access_master_rule" => "allow",                                        
                );

            }            
            $this->db->insert_batch("free_access_tokens",$tokens);
            
            redirect(base_url(admin_base."access/view_group_tokens/".$group_id));
            
        }
    }
    

    public function view_group_tokens($group_id = 0){
        
        if(!$group_id){
            $group_id = $this->input->post("group_id");
        }
        
        if($group_id){
            $tokens = $this->db->where("group_id",$group_id)->get("free_access_tokens")->result();
        }       
        
        $data["data"]["group_id"] = $group_id;
        $data["data"]["tokens"] = @$tokens;
        $data["views"]["content"] = 'access/view_group_tokens';   
        $data["data"]["title"] = "عرض تذاكر الدخول";            

        $this->load->view(style.'/templates/main/core',$data); 
            
        
    }
    
         

}