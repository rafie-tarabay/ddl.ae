<?php

class Publish extends base{
    
    
    public function fetch_author($author_id){        
        return $this->db->where("author_id",$author_id)->limit(1)->get("publish_authors")->row();        
    }
          
    public function fetch_authors($apporved = TRUE,$in_ids = array()){        
        if($in_ids == TRUE) $this->db->where_in("author_id",$in_ids);
        if($apporved == TRUE) $this->db->where("author_status","approved");
        return $this->db->where("author_u_id",u_id)->order_by("author_id","DESC")->get("publish_authors")->result();        
    }
                 
    public function fetch_corporates($apporved = TRUE,$in_ids = array()){        
        if($in_ids == TRUE) $this->db->where_in("corp_id",$in_ids);
        if($apporved == TRUE) $this->db->where("corp_status","approved");
        return $this->db->where("corp_u_id",u_id)->order_by("corp_id","DESC")->get("publish_corporates")->result();        
    }
          
    public function fetch_requests(){        
        return $this->db->where("req_u_id",u_id)->order_by("req_id","DESC")->get("publish_requests")->result();            
    }
                
    public function fetch_services(){
        $this->db->select("service_title_".locale." as title, service_id, service_order, service_name");
        return $this->db->order_by("service_order","ASC")->get("publish_services")->result();        
    }
    
    public function insert_author($author,$doc = FALSE){   
        $author["author_u_id"] = u_id;
        $author["author_status"] = "waiting_review";
        if($doc) $author["author_id_doc"] = $doc;
        $this->db->insert("publish_authors",$author);        
        return $this->db->insert_id();
    }
            
    public function insert_corporate($corp){   
        $corp["corp_u_id"] = u_id;
        $corp["corp_status"] = "waiting_review";
        $this->db->insert("publish_corporates",$corp);        
        return $this->db->insert_id();
    }
                            
    public function insert_request($request,$doc = FALSE){   
        $request["req_u_id"] = u_id;
        $request["req_status"] = "waiting_review";
        $request["req_timestamp"] = time();
        if($doc) $request["req_material_file"] = $doc;
        $this->db->insert("publish_requests",$request);        
        return $this->db->insert_id();
    }

    
    public function insert_authorities($req_id,$authors,$corporates){
        
        $data = array();
        foreach($authors as $author){
            $data[] = array(
                "ro_type" => "author",
                "ro_request_id" => $req_id,
                "ro_rel_id" => $author->author_id,
            );
        }
        
        foreach($corporates as $corp){
            $data[] = array(
                "ro_type" => "corporate",
                "ro_request_id" => $req_id,
                "ro_rel_id" => $corp->corp_id,
            );            
        }  
        
        if($data){
            $this->db->insert_batch("publish_requests_authorities",$data);
        }              
        
    }
            
            
    public function check_services($_services){
        $filtered = array();
        $this->db->where_in("service_name",$_services);
        $services = $this->db->get("publish_services")->result();
        foreach($services as $service){
            $filtered[] = $service->service_name;
        }
        return $filtered;
    }
    
    
}