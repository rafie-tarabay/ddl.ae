<?php

class Country extends base{
    
    
    public function fetch_all(){        
        return $this->db->order_by("country_order","ASC")->get("countries")->result();        
    }
            
    public function is_country($val,$field="country_code_ISO3"){        
        return $this->db->where($field,$val)->limit(1)->get("countries")->row();        
    }
        
}