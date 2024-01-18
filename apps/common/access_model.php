<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Access extends base{

    public $today;
    public $ip;
    public $ip_int;
    public $error;    
    public $frontend;    
    public $proxy;
    public $proxy_int;
    public function __construct(){
        parent::__construct();           
        $this->error = FALSE;        
        $this->today = date("Y-m-d");        
        $this->ip = $this->input->ip_address();    
        $this->ip = $this->ip == "::1" ? '0.0.0.0' : $this->ip;     // for localhost testing
        $this->ip_int = ip_to_int($this->ip); 
        $this->frontend = $this->load->database("frontend",true);
        $this->logsDB = $this->load->database("logs",true);
    }        
    public function set_proxy($new_ip=null)
    {
        
         
            $this->proxy = $new_ip;
            $this->proxy_int = ip_to_int($this->proxy);   
            $this->session->set_userdata("proxy",$new_ip); 
         

    }
    public function token($token){ 
        if(u_id && logged_in){
            $this->error = FALSE; // important             
            $this->frontend->where("access_denied",0);
            $access = $this->frontend->where("token",$token)->order_by("access_id","DESC")->limit(1)->get("free_access_tokens")->row();        
            if($access){
                $this->check_access($access);
                if(!$this->error){
                    $this->give("token",$access); // give_access
                    return TRUE;
                }            
                $this->error = TRUE;   
                return FALSE;
            }else{
                $this->error = TRUE;   
                return FALSE;                 
            }
        }else{
            $this->error = "يجب تسجيل الدخول أولاً";   
            return FALSE;                             
        }
    }
    public function proxy($ip_int){   
        $this->access->set_proxy($ip_int);
         
         
        $this->error = FALSE; // important
        $this->frontend->join("users","u_id = access_u_id","LEFT");
        $this->frontend->join("users_data","data_u_id = u_id","right");
        $this->frontend->where("access_denied",0);
        $this->frontend->where("int_start <=",$this->proxy_int);
        $this->frontend->where("int_end >=",$this->proxy_int);
        $results = $this->frontend->order_by("access_id","DESC")->get("free_access_ips")->result();  
        if($results){            
            foreach($results as $access){         
                $this->check_access($access);     
                if($access->u_id > 0 && $access->access_u_id == $access->u_id ){
                    if(!$this->error){
                        $this->load->model("user");                     
                        $this->user->login_session($access); // login_user
                        $this->give("ip",$access); // give_access
                        return TRUE;
                        break;
                    }            
                }
            }
            $this->error = TRUE;
            return FALSE;
        }else{
            $this->error = TRUE;
            return FALSE;
        }                 
        
    }

    public function ip($ip_int){        
        $this->error = FALSE; // important
        $this->frontend->join("users","u_id = access_u_id","LEFT");
        $this->frontend->join("users_data","data_u_id = u_id","right");
        $this->frontend->where("access_denied",0);
        $this->frontend->where("int_start <=",$ip_int);
        $this->frontend->where("int_end >=",$ip_int);
        $results = $this->frontend->order_by("access_id","DESC")->get("free_access_ips")->result();  

        if($results){            
            foreach($results as $access){         
                $this->check_access($access);     
                if($access->u_id > 0 && $access->access_u_id == $access->u_id ){
                    if(!$this->error){
                        $this->load->model("user");                     
                        $this->user->login_session($access); // login_user
                        $this->give("ip",$access); // give_access
                        return TRUE;
                        break;
                    }            
                }
            }
            $this->error = TRUE;
            return FALSE;
        }else{
            $this->error = TRUE;
            return FALSE;
        }                 

    }


    public function get_country_by_ip($ip_int){                
        $this->error = FALSE; // important
        $this->frontend->where("int_start <=",$ip_int);
        $this->frontend->where("int_end >=",$ip_int);
        return $this->frontend->limit(1)->get("countries_ips")->row();
    }

    public function country($ip_int){
        if(u_id && logged_in){

            $country = $this->get_country_by_ip($ip_int);

            if($country){
                $this->frontend->where("access_denied",0);
                $this->frontend->group_start();
                $this->frontend->or_where("country_code_ISO2",$country->country_code_ISO2);
                $this->frontend->or_where("country_code_ISO3",$country->country_code_ISO3);
                $this->frontend->group_end();
                $results = $this->frontend->order_by("access_id","DESC")->get("free_access_countries")->result();    

                if($results){
                    foreach($results as $access){
                        $this->check_access($access);
                        if(!$this->error){
                            $this->give("country",$access); // give_access
                            return TRUE;
                            break;
                        }            
                    }  
                    $this->error = TRUE;
                    return FALSE;                
                }else{
                    $this->error = TRUE;
                    return FALSE;
                }          

            }else{
                $this->error = TRUE;
                return FALSE;
            }    

        }else{
            $this->error = "Access denied, You need to login first";   
            return FALSE;                             
        }             
    }     


    private function check_access($data){
        // early access
        if( ( $data->access_start && $data->access_start != "0000-00-00" ) && $data->access_start > $this->today){
            $this->error = "Access denied, You can start access from: ".$data->access_start;
        }
        // Late access
        if( ( $data->access_expire && $data->access_expire != "0000-00-00" ) && $this->today > $data->access_expire){
            $this->error = "Access denied, Access expired at: ".$data->access_expire;
        }        
        // access Limits
        if($data->access_limit && $data->access_counter > $data->access_limit){
            $this->error = "Access denied, Limits has been reached";
        }                         

        if($data->access_denied == 1){
            $this->error = TRUE;
        }

        return $this->error;  
    }


    public function give($method,$data){        

        $this->frontend->select("rule_rel_type,rule_rel_value");
        $rules = $this->frontend->where("rule_access_id",$data->access_id)->where("rule_access_type",$method)->get("free_access_rules")->result();

        $free_access = array(
            "status" => "active",
            "method" => $method,
            "access_id" => $data->access_id,
            "master_rule" => @$data->access_master_rule ? $data->access_master_rule : "allow",
            "rules" => $rules
        );
        $this->session->set_userdata("free_access",$free_access);                
        return $free_access;
    }   


    public function verify($method , $access_id,$proxy=null){

        if($method == "token"){
            $access = $this->frontend->where("access_id",$access_id)->limit(1)->get("free_access_tokens")->row();  
        }        

        if($method == "ip"){
            $this->frontend->where("int_start <=",$this->ip_int);
            $this->frontend->where("int_end >=",$this->ip_int);            
            $access = $this->frontend->where("access_id",$access_id)->limit(1)->get("free_access_ips")->row();  
             
        }    
        if($method == "proxy"){
            $this->set_proxy($proxy);
            $this->frontend->where("int_start <=",$this->proxy_int);
            $this->frontend->where("int_end >=",$this->proxy_int);            
            $access = $this->frontend->where("access_id",$access_id)->limit(1)->get("free_access_ips")->row();  
             
        }    

        if($method == "country"){
            $country = $this->get_country_by_ip($this->ip_int);
            $this->frontend->group_start();
            $this->frontend->or_where("country_code_ISO2",$country->country_code_ISO2);
            $this->frontend->or_where("country_code_ISO3",$country->country_code_ISO3);
            $this->frontend->group_end();            
            $access = $this->frontend->where("access_id",$access_id)->limit(1)->get("free_access_countries")->row();  
        }

        if(isset($access) && @$access){
            $this->check_access($access); 
            if($this->error){
                $this->session->unset_userdata("free_access");
                return FALSE;
            }else{
                $this->give($method,$access);
                return TRUE;
            }
        }else{
            $this->session->unset_userdata("free_access");
            return FALSE;
        }

    }


    public function log_download($data){

        if($data->item_id > 0 && $data->download_url){

            /// free access data  
            $free_access = $this->session->userdata("free_access");      
            if($free_access){
                $access_id = $free_access["access_id"];
                $method = $free_access["method"];                                            
            }            

            //// check exising

            $this->logsDB->where("download_item_id",$data->item_id);

            $this->logsDB->group_start();

            $this->logsDB->or_group_start();
            $this->logsDB->where("download_session_id",$this->session->session_id);
            $this->logsDB->group_end();

            $this->logsDB->or_group_start();
            $this->logsDB->where("download_ip",$this->ip);
            $this->logsDB->group_end();

            if($free_access){                   
                $this->logsDB->or_group_start();
                $this->logsDB->where("download_access_method",$method);
                $this->logsDB->where("download_access_id",$access_id);
                $this->logsDB->group_end();
            }

            $this->logsDB->group_end();

            $exist = $this->logsDB->limit(1)->get("downloads")->row();

            if(!$exist){

                $country = $this->get_country_by_ip($this->ip_int);

                if($data->freeaccess && !$data->free  && !$data->purchased){
                    $this->increase_free_access_usage($method,$access_id);                
                }

                $item_data = array(
                    "title" => $data->title,
                    "urls" => [$data->download_url]
                );

                $log = array(
                    "download_u_id" => u_id > 1 ? u_id : NULL,
                    "download_source_id" => $data->source_id,
                    "download_item_id" => $data->item_id,
                    "download_item_data" => json_encode($item_data),

                    "download_free_material" => $data->free ? TRUE : NULL,
                    "download_purchased" => $data->purchased ? TRUE : NULL,
                    "download_free_access" => $data->freeaccess ? TRUE : NULL,                    
                    "download_access_method" =>  isset($method) ? $method : NULL,
                    "download_access_id" => isset($access_id) ? $access_id : NULL,

                    "download_session_id" => $this->session->session_id ,
                    "download_ip" => $this->ip,
                    "download_country" => $country ? $country->country_code_ISO2 : NULL,
                    "download_date" => date("Y-m-d"),
                    "download_counts" => 1,
                    "download_timestamp" => time(),
                );

                $this->logsDB->insert("downloads",$log);

            }else{

                $item_data = json_decode($exist->download_item_data,TRUE);
                $item_data["urls"][] = $data->download_url;

                $this->logsDB->set('download_item_data', json_encode($item_data));
                $this->logsDB->set('download_counts', 'download_counts+1', FALSE);
                $this->logsDB->where("download_id",$exist->download_id)->limit(1);                
                $this->logsDB->update("downloads");
            }
        }

    }


    public function increase_free_access_usage($method,$access_id){

        if($access_id > 0){
            $this->frontend->set('access_counter', 'access_counter+1', FALSE);
            $this->frontend->where("access_id",$access_id)->limit(1);

            if($method == "token"){
                $this->frontend->update("free_access_tokens");  
            }        

            if($method == "ip"){
                $this->frontend->update("free_access_ips");  
            }    

            if($method == "country"){
                $this->frontend->update("free_access_countries");  
            }        
        }

    }


    public function log_action($data){

        $this->load->library('user_agent');

        if(@$data["action"] && !$this->agent->is_robot()){

            $country = $this->get_country_by_ip($this->ip_int);

            $log = array(
                "log_action" => @$data["action"],
                "log_type" => isset($data["type"]) ? $data["type"] : NULL,
                "log_rel_id" => isset($data["rel_id"]) ? $data["rel_id"] : NULL,
                "log_rel_id2" => isset($data["rel_id2"]) ? $data["rel_id2"] : NULL,
                "log_rel_text" => isset($data["rel_text"]) ? $data["rel_text"] : NULL,
                "log_dewey" => isset($data["dewey"]) ? $data["dewey"] : NULL,
                "log_country" => $country ? $country->country_code_ISO2 : NULL,
                "log_ip" => $this->ip,
                "log_session" => $this->session->session_id,
                "log_timestamp" => time(),
            );

            if( (logged_in && u_id > 0) || @$data["u_id"] ){
                $log["log_u_id"] = u_id > 0 ? u_id : @$data["u_id"];
                $table = "user_logs";
            }else{
                $table = "guest_logs";
            }

            $this->logsDB->insert($table,$log);

        }

    }

    public function log_search($data){

        $this->load->library('user_agent');

        if( ( @$data["boxes"] || @$data["bibs"] || @$data["dewies"] || @$data["sources"] ) && !$this->agent->is_robot() ){

            $country = $this->get_country_by_ip($this->ip_int);

            $log = array(
                "log_country" => $country ? $country->country_code_ISO2 : NULL,
                "log_ip" => $this->ip,
                "log_session" => $this->session->session_id,
                "log_timestamp" => time(),
            );

            /// keywords fields
            $fields = array("title","author","publisher","content","series","subjects");
            if(@$data["boxes"]){
                foreach($data["boxes"] as $box){
                    
                    $box["keywords"] = str_replace('"',"",$box["keywords"]);
                    
                    if(in_array($box["field"] , $fields)){
                        $log["log_".@$box["field"]."_keywords"] = @$box["keywords"];
                    }elseif($box["field"] == "all"){
                        foreach($fields as $field){                            
                            if( !in_array($field, array("author","publisher")) ){ /// do not save keywords in theses fields if search was in ALL fields
                                $log["log_".$field."_keywords"] = @$box["keywords"];
                            }
                        }                        
                    }               
                }
            }

            /// filters fields
            if(@$data["bibs"]){
                $log["log_bibloType_filters"] = join(",",$data["bibs"]);               
            }
            if(@$data["dewies"]){
                $log["log_subjects_filters"] = join(",",$data["dewies"]);               
            }
            if(@$data["sources"]){
                $log["log_sources_filters"] = join(",",$data["sources"]);               
            }                       

            if(logged_in && u_id > 0){
                $log["log_u_id"] = u_id;
            }

            $this->logsDB->insert("search",$log);
   
        }

    }



    public function shorten_url($url,$exception = FALSE){
        
        if( ( $url && strpos($url,"ddl.ae/search/results/") !== FALSE && strpos($url,"http") !== FALSE ) || $exception == TRUE ){

            $query = "SELECT * FROM ( SELECT * FROM `ddl_short_urls` ORDER BY `id` DESC LIMIT 100 ) AS t WHERE `url` LIKE '".$url."'  LIMIT 1;";             
            $exists = $this->logsDB->query($query)->row();
            if($exists){            
                return "http://link.ddl.ae/".$exists->hash;
            }else{                                
                $hash = gen_hash(8).rand(0,99);
                $data = array(
                    "hash" => $hash,
                    "url" =>$url ,
                    "hits" =>0 ,
                    "last_hit" =>time() ,
                );
                $this->logsDB->insert("short_urls",$data);                

                return "http://link.ddl.ae/".$hash;
            }
        }else{
            return FALSE;
        }
    }



    public function hasAccessOnItem($item){

        $allowed = FALSE;
        $free_access = $this->session->userdata("free_access");
        if($free_access){
            $access_id = $free_access["access_id"];
            $method = $free_access["method"];
            $master_rule = $free_access["master_rule"];            

            $allowed = ($master_rule == "allow") ? TRUE : FALSE;

            $rules = $free_access["rules"];
            
            if($rules){
                $rule_match = $this->check_rules($rules,$item,$master_rule);            
            }else{
                $rule_match = FALSE;
            }

            if( $master_rule == "allow" && $rule_match == TRUE ){
                $allowed = FALSE;
            }elseif( $master_rule == "deny" && $rule_match == TRUE){
                $allowed = TRUE;             
            }

        }

        return $allowed;

    }



    public function  check_rules($rules,$item,$master_rule){

        $matches = FALSE;

        foreach($rules as $rule){

            $vs = explode("-",$rule->rule_rel_value);
            $values = array();
            foreach($vs as $v){
                $v = trim($v);
                $v = str_replace(" ","",$v);
                if($v) $values[] = $v;
            }          

            if(count($values) > 0){

                switch ($rule->rule_rel_type) {

                    case "biblo_id":
                        $id = $item->getId();                    
                        if($id) $matches = in_array($id,$values);
                        break;

                    case "classification_id":
                        $id = $item->getDewey();
                        if($id) $matches = in_array($id,$values);
                        break;

                    case "source_id":
                        $source = $item->getSource();
                        $id = $source ? $source["id"] : FALSE;
                        if($id) $matches = in_array($id,$values);
                        break;

                    case "author_id":
                        $author = $item->getAuthor();
                        $id = $author ? $author["author_id"] : FALSE;
                        if($id) $matches = in_array($id,$values);
                        break;

                    case "publisher_id":
                        $publisher = $item->getPublisher();
                        $id = $publisher ? $publisher["publisher_id"] : FALSE;
                        if($id) $matches = in_array($id,$values);
                        break;

                    case "years_range":

                        // publication year
                        $pub_year = $item->getPublicationYear();                        

                        // years range
                        sort($values);
                        $min = $values[0];
                        $max = $values[count($values)-1];                        

                        // check
                        if($pub_year && is_numeric($pub_year) && is_numeric($min) && is_numeric($max)){
                            $matches = in_array( $pub_year, range($min,$max,1) ) ;
                        }
 
                        break;


                    case "ip_range":

                        $intIps = array();
                        foreach($values as $value){
                            $intIps[] = ip_to_int($value);    
                        }

                        // Ip range
                        sort($intIps);
                        $min = $intIps[0];
                        $max = $intIps[count($intIps)-1];                        

                        // check
                        if($this->ip_int && is_numeric($min) && is_numeric($max)){
                            $matches = ( $this->ip_int > $min && $this->ip_int < $max ) || ( $this->ip_int == $min ) || ( $this->ip_int == $max ) ;
                        }

                        break;

                    case "day_hours":

                        $matches = in_array( date("H") , $values ) ;    

                        break;

                    case "week_days":

                        $matches = in_array( strtolower(date("l")) , $values ) ;    

                        break;                     

                    case "month_days":

                        $matches = in_array( date("d") , $values ) ;    

                        break;
                    case "u_ids":

                        $matches = in_array( u_id , $values ) ;    

                        break;                                          
                }


            }
            
            if($matches)  break;

        }    

        return $matches;   

    }


}