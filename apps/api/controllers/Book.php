<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends MY_Controller {

    function __construct(){
        // Construct the parent class
        header('Access-Control-Allow-Origin: *');
        parent::__construct();

    }    

    public function index_get(){

        $id      = $this->input->get("id");
        $similar = $this->input->get("similar");
        
        $data= array(
            "data"      => array(
                "filters" => array(
                    "ids" => array($id)
                )
            ),            
            "faceting"  => TRUE,            
            "page"      => 0, // could be set by get parameter
            "limit"     => 1,            
            "similar"   => $similar,            
        );
        $results = $this->search_solr->query_solr($data);
        
        $book  = $results["results"][0];

        //$book->metadata["files"] = json_decode($book->metadata["files"]);
        $book->metadata["related_files"] = json_decode($book->metadata["related_files"]);
        //$book->metadata["related_files_loc"] = json_decode($book->metadata["related_files_loc"]);

        $_similar = $book->metadata["similar"];
        
        $similar = array();
        foreach($_similar as $s){
            $s->metadata["related_files"] = json_decode($s->metadata["related_files"]);
            //$s->metadata["related_files_loc"] = json_decode($s->metadata["related_files_loc"]);            
            $s->{"productMetadata"} = $s->metadata;
            unset($s->metadata);         
            $similar[] = $s;
        }
        $book->metadata["similar"] = $similar;
        
        $book->{"productMetadata"} = $book->metadata;
        unset($book->metadata);         
        
        $this->output->set_content_type('application/json')->set_output(json_encode($book));   
        
    }
    
    

}


