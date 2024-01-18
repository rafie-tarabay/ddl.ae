<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bot extends MY_Controller {

    var $bot;
    var $ip;

    public function __construct(){
        parent::__construct();  
        $this->db = $this->load->database("chatbot",true);   
        $this->ip = $this->input->ip_address();    
        $this->ip = $this->ip == "::1" ? '0.0.0.0' : $this->ip;     // for localhost testing        
        $this->restore_bot_session();

    }    


    public function index(){

        $session_data = $this->get_data($this->bot->id);                
        $node = $this->get_node($this->bot->node);               
        $rules = $this->get_node_rules($node->node_name);
        $node = $this->process_statements($node,$session_data);        
        $response = $this->get_response($node,$session_data);

        $data["data"]["session_data"] = $session_data;   
        $data["data"]["node"] = $node;   
        $data["data"]["rules"] = $rules;   
        $data["data"]["response"] = $response;   

        $data["views"]["hide_layout"] = TRUE;   
        $data["views"]["content"] = 'bot/bot';   
        $data["views"]["title"] = "chat bot";                                   
        $this->load->view(design_path.'/templates/main/core',$data);           


    }    

    public function goback(){
        $node = $this->get_node($this->bot->node);       
        $parent = $this->get_parent($node);       
        if($parent->node_name){            
            $this->update_session(array("session_node"=>$parent->node_name));
        }
        redirect(base_url("bot"));
    }

    public function startover(){
        $this->update_session(array("session_closed"=>1));
        redirect(base_url("bot"));
    }


    public function reply(){

        $posted_data = $this->input->post();
        $node = $this->get_node($this->bot->node);                                        
        $rules = $this->get_node_rules($node->node_name);

        if($posted_data){
            $this->catch_data($rules,$posted_data);
        }

        $session_data = $this->get_data($this->bot->id);                
        $pass = $this->check_rules($rules,$session_data);        

        if($pass){
            $this->next_node($node,$posted_data);
        }

        redirect(base_url("bot"));

    }

    public function next_node($node,$posted_data){

        if( @$posted_data["target_node"]){        
            $new_node = $posted_data["target_node"];             
        }elseif($new_node = @$node->target_node && !is_null(@$node->target_node)){
            $new_node = $node->target_node;             
        }
        if($new_node){
            $this->update_session(array("session_node"=>$new_node));
        }
    }


    public function update_session($data){
        $this->db->where("session_id",$this->bot->id)->update("sessions",$data);       
        //lq($this->db);
    }

    public function catch_data($rules,$posted_data){
        foreach($posted_data as $key => $val){
            foreach($rules as $rule){                        
                if( $rule->rule_value == $key ){                    
                    $this->update_data($key,$val);                    
                }            
            }
        }        
    }


    public function update_data($key,$val){
        $this->db->where("data_session_id",$this->bot->id);
        $this->db->where("data_name",$key);
        $row = $this->db->limit(1)->get("session_data")->row();
        if(!$row){
            $data = array(
                "data_session_id" => $this->bot->id,
                "data_name" => $key,
                "data_value" => $val,
            );
            $this->db->insert("session_data",$data);
        }else{
            $data = array(
                "data_value" => $val,
            );
            $this->db->where("data_session_id",$this->bot->id);
            $this->db->where("data_name",$key);            
            $this->db->update("session_data",$data);
        }
    }

    public function check_rules($rules,$data){

        $pass = $rules ? FALSE : TRUE;
        if($rules){
            foreach($rules as $rule){            
                if($rule->rule_action == "check"){
                    if($rule->rule_reference == "var"){
                        if( isset($data[$rule->rule_value]) && @$data[$rule->rule_value] != "" && @!is_null($data[$rule->rule_value]) ){
                            $pass = TRUE;
                        }else{
                            $pass = FALSE;
                        }
                    }
                }
            }        
        }

        return $pass;

    }


    public function get_data($session_id){
        $this->db->where("data_session_id",$session_id);
        $data = $this->db->get("session_data")->result();

        $returned = array();
        if($data){
            foreach($data as $d){
                $returned[$d->data_name] = $d->data_value;
            }
        }        
        return $returned;        
    }


    public function get_node($node_name){
        $this->db->where("node_name",$node_name);
        return $this->db->limit(1)->get("nodes")->row();

    }

    public function get_node_rules($node_name){
        $this->db->where("rule_node",$node_name);
        return $this->db->get("node_rules")->result();

    }

    public function process_statements($node,$session_data){

        foreach($session_data as $key => $val){
            $node->action_url = str_replace('{'.$key.'}',$val,$node->action_url);
            $node->node_statement_ar = str_replace('{'.$key.'}',$val,$node->node_statement_ar);
            $node->action_title_ar = str_replace('{'.$key.'}',$val,$node->action_title_ar);
            $node->node_title_ar = str_replace('{'.$key.'}',$val,$node->node_title_ar);
        }

        return $node;

    }

    public function get_siblings($node){
        $this->db->where("node_parent",$node->node_id);
        return $this->db->order_by("node_id","DESC")->get("nodes")->result();
    }

    public function get_parent($node){
        $this->db->where("node_id",$node->node_parent);
        return $this->db->order_by("node_id","DESC")->limit(1)->get("nodes")->row();
    }


    public function get_response($node,$session_data){     

        switch ($node->req_action) {
            case "fill_form":
                return $this->load->view(style.'/templates/bot/forms/'.$node->action_form,array("node"=>$node),TRUE);           
                break;
            case "show_siblings":
                $siblings = $this->get_siblings($node);
                return $this->load->view(style.'/templates/bot/parts/show_siblings',array("siblings"=>$siblings,"node"=>$node),TRUE);           
                break;
            case "click_link":
                return $this->load->view(style.'/templates/bot/parts/click_link',array("node"=>$node),TRUE);           
                break;            
            case "api_query":
                $data = $this->api_query($node->action_function,$session_data);
                return $this->load->view(style.'/templates/bot/parts/single_book',array("node"=>$node,"books"=>$data),TRUE);           
                break;
        }

    }


    public function api_query($function,$session_data){

        switch ($function) {
            case "search":
                if( $title = $session_data["title"] ){
                    return file_get_contents("https://ddl.ae/api.php/search/?boxes=1&1_keywords=".urlencode($title)."&1_term=title&page=2&apikey=c4cwswo00oggkko80gwkwwgs4cos8sgwsg84ocko&limit=1");
                }
                break;
        }

    }


    public function restore_bot_session(){

        $session_id = $this->session->userdata("bot_session");

        $this->db->group_start();
        $this->db->or_where("session_id",$session_id);
        $this->db->or_where("session_ip",$this->ip);
        if(u_id) $this->db->or_where("session_u_id",u_id);        
        $this->db->group_end();
        $this->db->where("session_closed",0);
        $row = $this->db->order_by("session_id","DESC")->get("sessions")->row();

        if(!$row){
            $session_id = md5(gen_hash());
            $this->session->set_userdata("bot_session",$session_id);
            $data = array(
                "session_u_id" => u_id ? u_id : NULL,
                "session_id" => $session_id,
                "session_ip" => $this->ip,
                "session_node" => "name",
            );
            $this->db->insert("sessions",$data);
        }else{
            $data = array(
                "session_u_id" => u_id ? u_id : NULL,
                "session_id" => $session_id,
                "session_ip" => $this->ip,
                "session_node" => $row->session_node,
            );
            $this->db->where("session_id",$row->session_id)->update("sessions",$data);
        }

        $this->bot = (object) array(
            "id" => $session_id,
            "node" => $data["session_node"],
        );  

    }        

}