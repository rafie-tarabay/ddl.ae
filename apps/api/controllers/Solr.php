<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solr extends MY_Controller {

    function __construct(){
        // Construct the parent class
        parent::__construct();

    }    
    
    
    public function index_get(){
        
        if(isset($_SERVER['QUERY_STRING'])){            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://".solr_host.":8983/solr/core_catalog_metadata_v2/select?" . $_SERVER['QUERY_STRING']);
            curl_setopt($ch, CURLOPT_POST, 0);
            $result = curl_exec($ch);
            curl_close($ch);        
        }
        
    }

    
}