<?php

class Helper extends base{

    private $lang = "ar";
    
    public function __construct() {        
        $this->lang = in_array(locale,array("ar","en")) ? locale : "ar";  
    }  
    
    public function is_country($val,$field="country_code_ISO3"){        
        return $this->db->where($field,$val)->limit(1)->get("countries")->row();        
    }    
    
    public function fetch_page($alias){        
        $this->db->select("page_id,page_alias");
        $this->db->select("page_title_".$this->lang." as page_title");
        $this->db->select("page_desc_".$this->lang." as page_desc");
        $this->db->select("page_keywords_".$this->lang." as page_keywords");        
        $this->db->select("page_text_".$this->lang." as page_text");        
        return $this->db->where("page_alias",$alias)->limit(1)->get("pages")->row();        
    }

    public function fetch_pages(){
        $this->db->select("page_id,page_alias");
        $this->db->select("page_title_".$this->lang." as page_title");
        $this->db->select("page_desc_".$this->lang." as page_desc");
        $this->db->select("page_keywords_".$this->lang." as page_keywords");        
        $this->db->select("page_text_".$this->lang." as page_text");         
        $this->db->order_by("page_order","ASC");
        return $this->db->where("page_listed",1)->get("pages")->result();
    } 
    
    public function fetch_faq_sections(){      
        $this->db->select("section_id");
        $this->db->select("section_title_".$this->lang." as section_title");
        $this->db->select("section_desc_".$this->lang." as section_desc");
        $this->db->select("section_keywords_".$this->lang." as section_keywords");
        
        $this->db->order_by("section_order","ASC");
        return $this->db->get("faq_sections")->result();        
    }    
            
    public function fetch_faq_section($section_id){        
        $this->db->select("section_id");
        $this->db->select("section_title_".$this->lang." as section_title");
        $this->db->select("section_desc_".$this->lang." as section_desc");
        $this->db->select("section_keywords_".$this->lang." as section_keywords");        
        return $this->db->where("section_id",$section_id)->limit(1)->get("faq_sections")->row();        
    }    
        
    public function fetch_faq_topics($section_id){ 
        $this->db->select("topic_id,topic_section_id");
        $this->db->select("topic_title_".$this->lang." as topic_title");
        $this->db->select("topic_desc_".$this->lang." as topic_desc");
        $this->db->select("topic_keywords_".$this->lang." as topic_keywords");        
        $this->db->select("topic_text_".$this->lang." as topic_text");        
        $this->db->order_by("topic_order","ASC");       
        return $this->db->where("topic_section_id",$section_id)->get("faq_topics")->result();        
    }    
            
    public function fetch_faq_topic($topic_id){   
        $this->db->select("topic_id,topic_section_id");
        $this->db->select("topic_title_".$this->lang." as topic_title");
        $this->db->select("topic_desc_".$this->lang." as topic_desc");
        $this->db->select("topic_keywords_".$this->lang." as topic_keywords");        
        $this->db->select("topic_text_".$this->lang." as topic_text");      
        
        $this->db->select("section_id");
        $this->db->select("section_title_".$this->lang." as section_title");
        $this->db->select("section_desc_".$this->lang." as section_desc");
        $this->db->select("section_keywords_".$this->lang." as section_keywords");          
        
        $this->db->join("faq_sections","section_id = topic_section_id","left");
        return $this->db->where("topic_id",$topic_id)->limit(1)->get("faq_topics")->row();        
    }    
    

}