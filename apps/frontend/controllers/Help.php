<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends MY_Controller {

    public function index(){

    }


    public function page($alias = ""){

        if($alias){            
            $this->load->model("helper");
            $page = $this->helper->fetch_page($alias);                
            if($page){            

                $data["data"]["page_desc"] = $page->page_desc;        

                $pages = $this->helper->fetch_pages();                
                $data["data"]["pages"] = $pages;
                $data["data"]["page"] = $page;                                    
 
                $data["views"]["content"] = 'help/page';   
                $data["views"]["title"] = $page->page_title;                                    
                $this->load->view(design_path.'/templates/main/core',$data);                                 
            }                
        }
    }            


    public function faq(){
        $this->load->model("helper");       
        $data["data"]["sections"] = $this->helper->fetch_faq_sections();                                    
        $data["views"]["page_desc"] = word("faqs");        
        $data["views"]["content"] = 'help/faq/sections';   
        $data["views"]["title"] = word("faqs");                                    
        $this->load->view(design_path.'/templates/main/core',$data);   
    }

    public function faq_section($id){
        if($id){            
            $this->load->model("helper");
            $section = $this->helper->fetch_faq_section($id);                
            if($section){              

                $data["data"]["section"] = $section;                                    
                $data["data"]["topics"] = $this->helper->fetch_faq_topics($id);                                    
                $data["data"]["sections"] = $this->helper->fetch_faq_sections();                                    

                $data["views"]["page_desc"] = $section->section_desc;        
                $data["views"]["content"] = 'help/faq/section';   
                $data["views"]["title"] = $section->section_title;                                    
                $this->load->view(design_path.'/templates/main/core',$data);                                 
            }                
        } 
    }


    public function faq_topic($id){
        if($id){            
            $this->load->model("helper");
            $data["data"]["topic"] = $topic = $this->helper->fetch_faq_topic($id);                                    
            $data["data"]["topics"] = $this->helper->fetch_faq_topics($topic->topic_section_id);                                    
            $data["data"]["sections"] = $this->helper->fetch_faq_sections();
                                      
            $data["views"]["page_desc"] = $topic->topic_desc;        
            $data["views"]["content"] = 'help/faq/topic';   
            $data["views"]["title"] = $topic->topic_title;                                    
            $this->load->view(design_path.'/templates/main/core',$data);                                 

        } 
    }





}
