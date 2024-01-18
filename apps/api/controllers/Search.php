<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_Controller {

    function __construct(){
        // Construct the parent class
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
    }    

    public function index_get(){
         
        $valid = array();
        
        $data = $this->input->get();    
        /// Boxes
        if(isset($data["boxes"])){

            $boxes = explode("_",$data["boxes"]);

            foreach($boxes as $box){

                if(isset($data[$box."_operator"]))
                    $_POST[$box."_operator"] = $data[$box."_operator"]; 

                if(isset($data[$box."_keywords"]))
                    $_POST[$box."_keywords"] = $data[$box."_keywords"];

                if(isset($data[$box."_term"]))
                    $_POST[$box."_field"] = $data[$box."_term"];

                if(isset($data[$box."_exact"]))
                    $_POST[$box."_exact"] = $data[$box."_exact"];

            }    
        }
        // echo "<pre>";  
        // print_r($_POST); 
        // print_r($data);
        $valid["queries"] = $this->search_gate->validate_boxes($boxes);
        //print_r($valid);
         // bibs
        if(isset($data["biblo_type"])){            
            $valid["filters"]["bibs"] = explode("_",$data["biblo_type"]);
        }        

        /// dewies
        if(isset($data["subjects"])){            
            $valid["filters"]["dewies"] = explode("_",$data["subjects"]);
        }        

        /// sources
        if(isset($data["sources"])){            
            $valid["filters"]["sources"] = explode("_",$data["sources"]);
        }        

        /// prices
        if(isset($data["price"])){            
            $valid["filters"]["prices"] = explode("_",$data["price"]);
        }        

        /// date
        if(isset($data["date_from"])){            
            $valid["filters"]["date"]["from"] = (int) $data["date_from"];
        }        

        if(isset($data["date_to"])){            
            $valid["filters"]["date"]["to"] = (int) $data["date_to"];
        }    
        $page =1;
        if(isset($data["page"])){            
            $page = (int) $data["page"];
        }    
        $limit =10;
        if(isset($data["limit"])){            
            $limit = (int) $data["limit"];
        } 
        $data= array(
            "data"      => $valid,            
            "faceting"  => TRUE,            
            "page"      => $page, // could be set by get parameter
            "limit"     => $limit,            
            "similar"   => FALSE,            
            "sort"      => FALSE,
        );
        
        $results = $this->search_solr->query_solr($data);
        
        $books  = $results["results"];
        $paging = $results["pagination"];
        
        /// Temp : To allow APP Old Version
        foreach($books as $i => $book){            
            $book->{"productMetadata"} = $book->metadata;
            unset($book->metadata);            
            $books[$i] = $book;            
        }
        
        $pagination = array(
            "page" => $paging["page"],
            "limit" => $paging["limit"],
            "totalResult" => $paging["total"],
            "restTotal" => $paging["rest"],
            "totalPages" => $paging["total_pages"],
        );
        /// Temp : To allow APP Old Version
        
        

        $returned = array(
            "data" => $books,
            "pagination" => $pagination
        );     

        //prnt($returned);

        $this->output->set_content_type('application/json')->set_output(json_encode($returned));        

    }


}


