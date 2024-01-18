<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Logs_analyzer extends base{

    var $table = "guest_logs"; 
    var $type = "users"; 
    var $dewey = FALSE; 
    var $user_id = FALSE; 
    var $keywords;

    public function set_params($type,$dewey=FALSE){
        $this->table = $type == "guests" ? "guest_logs" : "user_logs";
        $this->type = $type;
        $this->user_id = ($this->type == "my") ? u_id : FALSE;
        $this->dewey = $dewey;
    }


    public function get_top_keywords($_field,$chopped,$limit=5){

        switch ($_field) {
            case "title":
                $field = "log_title_keywords";
                break;
            case "content":
                $field = "log_content_keywords";
                break;
            case "author":
                $field = "log_author_keywords";
                break;           
            case "subjects":
                $field = "log_subjects_keywords";
                break;
            default:
                $field = "log_title_keywords";
                break;
        }


        $this->db = $this->load->database("logs",true);

        $this->db->select("$field as keywords");
        $this->db->where("$field IS NOT NULL");
        $this->db->not_like("$field","OR");
        $this->db->not_like("$field","or");
        $this->db->not_like("$field","and");
        $this->db->not_like("$field","AND");
        $this->db->not_like("$field","SLEEP");
        $this->db->not_like("$field","sleep");
        $this->db->not_like("$field","insert");
        $this->db->not_like("$field","SELECT");
        $this->db->not_like("$field","select");
        $this->db->not_like("$field","INSERT");
        //$logs = $this->db->group_by("log_session")->order_by("log_id","DESC")->limit(10000)->get("search")->result();  
        $logs = $this->db->query('SELECT `'.$field.'` as `word` , COUNT(`log_id`) as count FROM `ddl_search` WHERE `'.$field.'` IS NOT NULL GROUP BY `'.$field.'` HAVING COUNT(`log_id`) > 10 order by COUNT(`log_id`) DESC');  
       
        $this->keywords = $logs->result();
         
        // foreach($logs as $log){

        //     if($chopped){
        //         $words = explode(" ",$log->keywords);                
        //         foreach($words as $word){
        //             $this->cloud_array($word);
        //         }
        //     }else{
        //         $word = $log->keywords;
        //         $this->cloud_array($word);
        //     }

        // }

       // usort($this->keywords, array($this,'cmp'));

      //  $this->keywords = array_slice($this->keywords,0,500);
        
        return $this->keywords;

    }


    private function cloud_array($word){

        if(strlen(utf8_decode($word)) > 3){
            if(isset($this->keywords[md5($word)])){
                $this->keywords[md5($word)]["count"]++;
            }else{
                $this->keywords[md5($word)] = array(
                    "word"=> $word,
                    "count"=> 1,
                );    
            }
        }        

    }


    public function get_latest_reading_logs($limit=5){
        if(!isset($this->logsDB)||empty($this->logsDB))
        {
            $this->logsDB = $this->load->database("logs",true);
        }

        ///        $query = "SELECT * FROM `ddl_guest_logs` ORDER BY `log_timestamp` DESC LIMIT 50";
        $query = "SELECT * FROM `ddl_guest_logs` WHERE `log_action` = 'view_book' ORDER BY `log_id` DESC LIMIT 5";
        $query = $this->logsDB->query($query);
        $result = $query->result();
        // $this->logsDB->select("logs.log_rel_id,logs.log_timestamp,logs.log_rel_text");
        // $this->logsDB->from("(".$query.") as logs");                    
        // $this->logsDB->like("logs.log_action","view_book");        
        // $this->logsDB->group_by("logs.log_rel_id");        
        // $result = $this->logsDB->limit($limit)->order_by("logs.log_id","DESC")->get()->result();  

        return $result;

    }


    public function get_latest_reading_books($limit=5){

        if(!isset($this->logsDB)||empty($this->logsDB))
        {
            $this->logsDB = $this->load->database("logs",true);
        }

        $users  = $this->logsDB->where("log_action","view_book")->limit($limit)->order_by("log_id","DESC")->get("user_logs")->result();
        $users_ids = get_ids_array($users,"log_rel_id");
        $guests = $this->logsDB->where_not_in("log_rel_id",$users_ids)->where("log_action","view_book")->limit($limit)->order_by("log_id","DESC")->get("guest_logs")->result();

        $restuls = array();

        $exists = array();

        foreach($users as $log){
            if(!in_array($log->log_rel_id,$exists)){
                $exists[] = $log->log_rel_id;
                $restuls[$log->log_timestamp] = $log;
            }
        }
        foreach($guests as $log){
            if(!in_array($log->log_rel_id,$exists)){
                $exists[] = $log->log_rel_id;
                $restuls[$log->log_timestamp] = $log;
            }
        }        

        krsort($restuls);   

        if(count($restuls) > $limit){
            $restuls = array_slice($restuls,0,$limit);
        }           

        return $restuls;

    }



    public function latest_all(){

        /// Books Viewed
        $books = $this->top_viewed_books();
        $dewies = $this->top_viewed_dewey();

        if($books["ids"]){            
            $params = array(
                "filters" => array(
                    "ids"=>$books["ids"]
                ),
                "limit"=>count($books["ids"])
            );
            $books_data = $this->searcher->get_records($params);             
        }



        if($dewies["ids"]){
            $dewies_data = $this->search_gate->get_dewies(locale,$dewies["ids"]);
        }

        if(@$books_data){
            foreach($books_data["results"] as $book){
                if($id = $book->getID()){
                    $books["result"][$id]["data"] = $book;
                }
            }
        }

        if(@$dewies_data){
            foreach($dewies_data as $dewey => $title){
                if($id = $dewey){
                    $dewies["result"][$id]["title"] = $title;
                }
            }
        }

        $output = array(
            "books" =>@$books["result"],
            "dewies" =>@$dewies["result"],
        );

        
        return $output;      

    }  


    private function top_viewed_dewey(){

        $actions = array("view_book","view_similar_books","view_book_files");

        if(!isset($this->logsDB)||empty($this->logsDB))
        {
            $this->logsDB = $this->load->database("logs",true);
        }
        /*
        $x = 10000; // Last viewed books
        $y = 100; // Top viewed from the X books


        /// Last X viewed Books
        $this->logsDB->where_in("logs.log_action",$actions);                    
        $this->logsDB->where("log_dewey IS NOT NULL");                    
        if( $this->user_id !== FALSE ) $this->logsDB->where("logs.log_u_id",$this->user_id);   
        $this->logsDB->limit($x);            
        $this->logsDB->order_by("logs.log_id","DESC");            
        $query = $this->logsDB->get($this->table." as ddl_logs");              

        $query = $this->logsDB->last_query();

        /// Select the top from them  
        $this->logsDB->select("count(SUBSTR(logs.log_dewey, 1, 2)) as repeats , SUBSTR(logs.log_dewey, 1, 2) as dewey_2 ,  logs.log_rel_id");            
        $this->logsDB->from("(".$query.") as logs");                    
        $this->logsDB->limit($y);            
        $this->logsDB->group_by("SUBSTR(logs.log_dewey, 1, 2), logs.log_dewey ,logs.log_rel_id");            
        $this->logsDB->order_by("repeats DESC");            
        $results = $this->logsDB->get()->result();              

        //$results = $this->logsDB->get();//->result();                      
        //prnt($this->logsDB->last_query());        
        */
        $sql = "SELECT SUBSTR(log_dewey, 1, 2) as dewey_2, count(`log_id`) as 'repeats' FROM `ddl_guest_logs` WHERE `log_dewey` IS NOT NULL group by SUBSTR(log_dewey, 1, 2) order by  count(`log_id`) DESC";
        $query = $this->logsDB->query($sql);
        $results = $query->result();
        $returned = array("ids"=>array(),"result"=>array());

        foreach($results as $result){

            $returned["ids"][] = $result->dewey_2*10;

            $returned["result"][$result->dewey_2*10] = array(
                "number" => $result->dewey_2*10 ,
                "repeats" => $result->repeats ,
            );
        }
       
        return $returned;        

    }


    private function top_viewed_books(){

        $actions = array("view_book","view_similar_books","view_book_files");

        if(!isset($this->logsDB)||empty($this->logsDB))
        {
            $this->logsDB = $this->load->database("logs",true);
        }

        // $x = 10000; // Last viewed books
        // $y = 100; // Top viewed from the X books


        // /// Last X viewed Books
        // $this->logsDB->where_in("logs.log_action",$actions);                    
        // if( $this->user_id !== FALSE ) $this->logsDB->where("logs.log_u_id",$this->user_id);   
        // if( $this->dewey   !== FALSE ){ 
        //     $this->logsDB->group_start();
        //     $this->logsDB->or_like("logs.log_dewey", substr($this->dewey,0,1), "after" );   
        //     $this->logsDB->or_like("logs.log_dewey", substr($this->dewey,0,2), "after" );               
        //     $this->logsDB->group_end();
        // }
        // $this->logsDB->limit($x);            
        // $this->logsDB->order_by("logs.log_id","DESC");            
        // $query = $this->logsDB->get($this->table." as ddl_logs");              

        // $query = $this->logsDB->last_query(); 

        // /// Select the top from them
        // $this->logsDB->select("count(logs.log_rel_id) as repeats, logs.log_rel_id");            
        // $this->logsDB->from("(".$query.") as logs");                    
        // $this->logsDB->limit($y);            
        // $this->logsDB->group_by("logs.log_rel_id");            
        // $this->logsDB->order_by("repeats DESC");            
        // $results = $this->logsDB->get()->result();      
         
        $sql = "SELECT log_rel_id,count(log_rel_id) as 'repeats' FROM `ddl_".$this->table."` GROUP BY log_rel_id ORDER BY count(log_rel_id) DESC  limit 50";  
        if( $this->user_id !== FALSE ) {
            // $this->logsDB->where("logs.log_u_id",$this->user_id); 
            $sql = "SELECT log_rel_id,count(log_rel_id) as 'repeats' FROM `ddl_".$this->table."` WHERE log_u_id='".$this->user_id."' GROUP BY log_rel_id ORDER BY count(log_rel_id) DESC  limit 50";
            
        } 
        if( $this->dewey   !== FALSE ){ 
            //     $this->logsDB->group_start();
            //     $this->logsDB->or_like("logs.log_dewey", substr($this->dewey,0,1), "after" );   
            //     $this->logsDB->or_like("logs.log_dewey", substr($this->dewey,0,2), "after" );               
            //     $this->logsDB->group_end();
            // }
            //$sql = "SELECT log_rel_id,count(log_rel_id) as 'repeats' FROM `ddl_".$this->table."` WHERE log_dewey like '".substr($this->dewey,0,1)."%'   GROUP BY log_rel_id ORDER BY count(log_rel_id) DESC  limit 50";
         }
      
       
        $query = $this->logsDB->query($sql);
        $results = $query->result();
        $returned = array("ids"=>array(),"result"=>array());

        foreach($results as $result){

            $returned["ids"][] = $result->log_rel_id;

            $returned["result"][$result->log_rel_id] = array(
                "id" => $result->log_rel_id ,
                "repeats" => $result->repeats ,
            );

        }      
        
        return $returned;        

    }


    public function top_views()
    {
        $sql = "SELECT log_rel_id,count(log_rel_id) as 'repeats' FROM `ddl_guest_logs` GROUP BY log_rel_id ORDER BY count(log_rel_id) DESC  limit 50"; 
        $this->logsDB = $this->load->database("logs",true);
        $query = $this->logsDB->query($sql);
        $results = $query->result();
        $returned = array("ids"=>array(),"result"=>array());

        foreach($results as $result){

            $returned["ids"][] = $result->log_rel_id;

            $returned["result"][$result->log_rel_id] = array(
                "id" => $result->log_rel_id ,
                "repeats" => $result->repeats ,
            );

        }      
        if($returned["ids"]){            
            $params = array(
                "filters" => array(
                    "ids"=>$returned["ids"]
                ),
                "limit"=>count($returned["ids"])
            );
            $books_data = $this->searcher->get_records($params); 
            $books_data['views'] = $returned["result"];
            return $books_data;            
        }
        return null;        
    }


    public function nominated_books(){
        $Types = array();                 
        /// Books Viewed
        $keywords = $this->user_view_logs();
        /// Search logs
        if(!$keywords){
            $keywords = $this->user_search_logs();
        }

        usort($keywords, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });           

        $keywords = count($keywords) >= 5 ? array_slice($keywords,0,5) : $keywords;

        if(!$keywords){
            $this->load->model("user");
            $user = $this->user->get_user_by_field(u_id);        
            if(!is_null($user->specialization))  $Types[] = $user->specialization;
            if(!is_null($user->knowledge_field))  $Types[] = $user->knowledge_field;  
        }                                                  

        $queries = array();
        $filters = array();
        if($keywords){
            foreach($keywords as $keyword){
                $queries[] = array(
                    "operator" => "or",
                    "field" => "content",
                    "keywords" => '"'.$keyword["word"].'"',
                );
            }            
        }elseif(is_array($Types) && count($Types)){      
            $filters["bibs"] = $Types;                        
        }     

        $data= array(
            "data"      => array(
                "queries" => $queries,
                "filters" => $filters,
            ),            
            "faceting"  => FALSE,            
            "limit"     => 24,            
            "similar"   => FALSE,            
        );
        $result = $this->search_solr->query_solr($data);          

        if($result["results"]){
            return $result["results"];
        }else{
            return FALSE;
        }

    }




    private function user_view_logs(){

        $this->logsDB = $this->load->database("logs",true);
        $this->logsDB->where("log_u_id",u_id);            
        $this->logsDB->where_in("log_action",array("view_book","view_similar_books","view_book_files"));            
        $this->logsDB->group_by("log_rel_id,log_id");            
        $this->logsDB->order_by("log_id","DESC");                        
        $this->logsDB->limit(20);            
        $results = $this->logsDB->get("user_logs")->result();            

        $keywords = array();

        if($results){
            foreach($results as $result){
                if($result->log_rel_text){
                    $words = explode(" ",$result->log_rel_text);
                    foreach($words as $word){  
                        $word = $this->normalize_word($word);
                        $word = strlen(utf8_decode($word)) >= 4 && strlen(utf8_decode($word)) <= 7 ? $word : FALSE;
                        if($word){
                            $index = array_search($word, array_column($keywords, 'word'));
                            if(!$index && $index !== 0){
                                $keywords[] = array("word"=>$word , "score"=>1);
                            }else{
                                $keywords[$index]["score"]++;
                            }
                        }                    
                    }                
                }
            }

        }

        return $keywords;        

    }

    private function user_search_logs(){

        $this->logsDB = $this->load->database("logs",true);
        $this->logsDB->where("log_u_id",u_id);            
        $this->logsDB->group_start();                    
        $this->logsDB->or_where('log_title_keywords is NOT NULL', NULL, FALSE);
        $this->logsDB->or_where('log_content_keywords is NOT NULL', NULL, FALSE);
        $this->logsDB->or_where('log_series_keywords is NOT NULL', NULL, FALSE);
        $this->logsDB->or_where('log_subjects_keywords is NOT NULL', NULL, FALSE);
        $this->logsDB->group_end();            
        $this->logsDB->order_by("log_id","DESC");                        
        $this->logsDB->limit(20);            
        $results = $this->logsDB->get("search")->result();   

        $keywords = array();

        if($results){
            foreach($results as $result){                       
                if(!is_null($result->log_title_keywords)){
                    $words = explode(" ",$result->log_title_keywords);
                }elseif(!is_null($result->log_content_keywords)){
                    $words = explode(" ",$result->log_content_keywords);
                }elseif(!is_null($result->log_series_keywords)){
                    $words = explode(" ",$result->log_series_keywords);
                }elseif(!is_null($result->log_subjects_keywords)){
                    $words = explode(" ",$result->log_subjects_keywords);                                        
                }
                foreach($words as $word){                          
                    $word = $this->normalize_word($word);
                    $word = strlen(utf8_decode($word)) >= 4 && strlen(utf8_decode($word)) <= 7 ? $word : FALSE;
                    if($word){
                        $index = array_search($word, array_column($keywords, 'word'));
                        if(!$index && $index !== 0){
                            $keywords[] = array("word"=>$word , "score"=>1);
                        }else{
                            $keywords[$index]["score"]++;
                        }
                    }                    
                }                
            }

        }  

        return $keywords;      

    }


    private function normalize_word($word){            
        $string = str_replace("ال","",$word);         
        return $string;
    }      

    private function cmp($a, $b){
        if ($a == $b)
            return 0;
        return ($a['count'] > $b['count']) ? -1 : 1;
    }    

}
