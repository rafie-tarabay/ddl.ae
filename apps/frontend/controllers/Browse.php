<?php
class Browse extends MY_Controller{

    public function index(){

        $result = $this->cache->get("browse_index");        
        if ( !$result ){           

            $data= array(
                "data"      => array(),            
                "faceting"  => TRUE,            
                "limit"     => 1,            
                "similar"   => FALSE,            
            );
            $result = $this->search_solr->query_solr($data);
            //prnt($result);
            $this->cache->save("browse_index", $result, 60*60*2);

        }

        $data["data"]["result"] = $result;               

        $data["views"]["title"] = word("browse_library");                                
        $data["views"]["header"] = 'inner';           
        $data["views"]["footer"] = 'inner';           
        $data["views"]["full_width"] = TRUE;
        $data["views"]["content"] = "browse/browse";

        $this->load->view(design_path.'/templates/main/core',$data);           

    }


    public function trends($type = "users",$dewey = "all"){

        $cache_file = "trends_".$type."_".$dewey;
        $output = $this->cache->get($cache_file);        
        if (true){        
 
            $type = in_array($type , array("users","guests","my")) ? $type : "users";
            if($type == "my" && !logged_in ){
                $type = "users";   
            }
            if( $dewey == "all" || (  !in_array($dewey , range(0,990,10)) && $dewey !== "000" ) ){
                $dewey = FALSE;
            }

            $this->load->model('Logs_analyzer','analyzer');        
            $this->analyzer->set_params($type,$dewey);
            $output = $this->analyzer->latest_all();
            $this->cache->save($cache_file, $output, 60*60*2);
        }

        $data["data"]["books"] = @$output["books"];        
        $data["data"]["dewies"] = @$output["dewies"];                   
        $data["data"]["type"] = $type;                   
        $data["data"]["selected_dewey"] = $dewey;                   
        $data["views"]["title"] = word($type."_trends");                                
        $data["views"]["header"] = 'inner';           
        $data["views"]["footer"] = 'inner';           
        $data["views"]["full_width"] = TRUE;
        $data["views"]["content"] = "browse/trends";

        $this->load->view(design_path.'/templates/main/core',$data);           


    }

    public function reader_corner_trends($type = "users",$dewey = "all"){

        $cache_file = "reader_corner_trends".$type."_".$dewey;
        $output = $this->cache->get($cache_file);        
        if (true){        
 
            $type = in_array($type , array("users","guests","my")) ? $type : "users";
            if($type == "my" && !logged_in ){
                $type = "users";   
            }
            if( $dewey == "all" || (  !in_array($dewey , range(0,990,10)) && $dewey !== "000" ) ){
                $dewey = FALSE;
            }

            $this->load->model('Logs_analyzer','analyzer');        
            $this->analyzer->set_params($type,$dewey);
            $output = $this->analyzer->latest_all();
            $this->cache->save($cache_file, $output, 60*60*2);
        }

        $data["data"]["books"] = @$output["books"];        
        $data["data"]["dewies"] = @$output["dewies"];                   
        $data["data"]["type"] = $type;                   
        $data["data"]["selected_dewey"] = $dewey;                   
        $data["views"]["title"] = word($type."_trends");                                
        $data["views"]["header"] = 'inner';           
        $data["views"]["footer"] = 'inner';           
        $data["views"]["full_width"] = TRUE;
        $data["views"]["content"] = "browse/reader_corner_trends";

        $this->load->view(design_path.'/templates/main/core',$data);           


    }
    public function now_reading(){

        $this->load->model('Logs_analyzer','analyzer');        
        $this->analyzer->set_params("guests");
        $logs = $this->analyzer->get_latest_reading_books(100);

        $data["data"]["logs"] = $logs;  
        $data["views"]["full_width"] = TRUE;         
        $data["views"]["hide_layout"] = TRUE;         

        $data["views"]["title"] = word("now_reading");
        $data["views"]["content"] = 'browse/now_reading';        
        $this->load->view(design_path.'/templates/main/core',$data);               

    }   



    public function keywords_cloud($field="title",$chopped = FALSE){
        
        if(!in_array($field,array("title","content","author","subjects"))){
            $field = "title";
        }
        
        $logs = $this->cache->get("keywords_cloud_".$field."_".$chopped);        
        if ( !$logs ){           
            $this->load->model('Logs_analyzer','analyzer');        
            $logs = $this->analyzer->get_top_keywords($field,$chopped,100);
            
            $this->cache->save("keywords_cloud_".$field."_".$chopped, $logs, 60*60*24*7);
        }        

        $data["data"]["logs"] = $logs;  
        
        $data["views"]["title"] = word("keywords_cloud");
        $data["views"]["content"] = 'browse/keywords_cloud';        
        $this->load->view(design_path.'/templates/main/core',$data);               

    }   




}
