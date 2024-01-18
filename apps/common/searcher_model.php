<?php

require_once(FCPATH."apps/common/search_gate_model.php");            
require_once(FCPATH."apps/common/search_solr_model.php");            
require_once(FCPATH."apps/common/search_parser_model.php"); 
require_once(FCPATH."apps/common/search_object_model.php"); 

class Searcher extends base{

    public $facets;

    public function __construct(){
        parent::__construct();           
        $this->db = $this->load->database("frontend",true);         
        $this->load->model( "search_gate_model"   , "search_gate"   );
        $this->load->model( "search_solr_model"   , "search_solr"   );
        $this->load->model( "search_parser_model" , "search_parser" );             
        $this->load->model( "search_object_model" , "search_object" );             
    } 

    public function get_records($params){

        $filters    = isset($params["filters"])     ? $params["filters"]    :array() ;
        $similar    = isset($params["similar"])     ? $params["similar"]    : FALSE  ;
        $limit      = isset($params["limit"])       ? $params["limit"]      : 1      ;
        $siblings   = isset($params["siblings"])    ? $params["siblings"]   : 1      ;
        $no_debug   = isset($params["no_debug"])    ? $params["no_debug"]   : 1      ;

        $data= array(
            "data"      => array(
                "filters"=> $filters
            ),            
            "limit"     => $limit,            
            "similar"   => $similar,            
            "siblings"   => $siblings,            
            "no_debug"   => $no_debug,            
        );
        $returned = $this->search_solr->query_solr($data);         

        return $returned;

    }

    public function ids_array($books){        
        $ids = array();
        foreach($books as $book){
            $ids[] = $book->getId();
        }        
        return $ids;
    }

    public function sort_result_by($books,$books_ids){        
        foreach($books as $book){
            $id = (string) $book->getId();
            $found = array_search($id,$books_ids);
            $books_ids[$found] = $book;
        }
        return $books_ids;
    }




}