<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fixes extends MY_Controller{


    public function purger($id){

        if(is_numeric($id)){
        
            $data["query"] = "biblo_id:$id";
            
            $result = $this->search_solr->remove_record($data);
            
            say($result);
            
        }
             
    }
    

            


}