<?php if ( ! defined('BASEPATH')) exit('No direct script faq allowed');

class Faq extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(!logged_in || can("edit_faq") == FALSE ){ redirect(base_url(admin_base."admins/login")); exit; }
    }    

    public function index(){

        $this->db->order_by("section_order ASC");
        $sections = $this->db->get("faq_sections")->result();
                
        $data["data"]["sections"] = $sections;   
        $data["views"]["content"] = 'faq/sections';   
        $data["data"]["title"] = "الأسئلة الشائعة" . " - " . "الأقسام";

        $this->load->view(style.'/templates/main/core',$data);            

    }
     
    public function section($section_id){

        $this->db->where("section_id",$section_id);
        $section = $this->db->limit(1)->get("faq_sections")->row();        
        
        $this->db->where("topic_section_id",$section_id);
        $count = $this->db->count_all_results("faq_topics"); 

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"faq/section/$section_id",4);            

        $this->db->where("topic_section_id",$section_id);
        $this->db->limit($per_page, $pagination["page"]); 
        $this->db->order_by("topic_order ASC");

        $topics = $this->db->get("faq_topics")->result();

        $data["data"]["pagination"] = $pagination["links"];

        $data["data"]["section_id"] = $section_id;
        $data["data"]["topics"] = $topics;
        $data["views"]["content"] = 'faq/topics';   
        $data["data"]["title"] = "الأسئلة الشائعة" . " - " . $section->section_title_ar;

        $this->load->view(style.'/templates/main/core',$data);            

    }
        

    public function add_section(){

        $data["data"]["method"] = "insert_section";
        $data["views"]["content"] = 'faq/forms/add_edit_section';   
        $data["data"]["title"] = "الأسئلة الشائعة" . " - " . "إضافة قسم";

        $this->load->view(style.'/templates/main/core',$data);            
    }


    public function insert_section(){

        $section_title_ar = $this->input->post("section_title_ar");
        $section_desc_ar = $this->input->post("section_desc_ar");            
        $section_keywords_ar = $this->input->post("section_keywords_ar");          
        $section_title_en = $this->input->post("section_title_en");
        $section_desc_en = $this->input->post("section_desc_en");            
        $section_keywords_en = $this->input->post("section_keywords_en");            
        $section_order = $this->input->post("section_order"); 

        if($section_title_ar){
        
            $data = array(
                "section_title_ar"=> $section_title_ar,
                "section_desc_ar"=> $section_desc_ar,
                "section_keywords_ar"=> $section_keywords_ar,
                "section_title_en"=> $section_title_en,
                "section_desc_en"=> $section_desc_en,
                "section_keywords_en"=> $section_keywords_en,                
                "section_order"=> $section_order,                    
            );    

            $this->db->insert("faq_sections",$data);
            $section_id = $this->db->insert_id();

            if($section_id){

                //admin log
                $log = array( 
                    "log_type"=>"faq", 
                    "log_action"=>"create_section",  
                    "log_rel_id"=>$section_id,
                    "log_rel_text"=>json_encode($data),
                );                              
                $this->logger->create($log);       

                redirect(base_url(admin_base."faq/section/".$section_id));

            }else{
                $this->base->response_page("خطأ","error","لا يمكن انشاء القسم",1,"auto");                              
            }           

        }else{
            $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
        }            

    }



    public function edit_section($section_id){

        $this->db->where("section_id",$section_id);
        $section = $this->db->limit(1)->get("faq_sections")->row();   
              
        $data["data"]["section"] = $section;
        $data["data"]["method"] = "update_section";
        $data["views"]["content"] = 'faq/forms/add_edit_section';   
        $data["data"]["title"] = "الأسئلة الشائعة" . " - " . "تعديل قسم";

        $this->load->view(style.'/templates/main/core',$data);            
    }



    public function update_section(){

        $section_id = $this->input->post("section_id");

        $section_title_ar = $this->input->post("section_title_ar");
        $section_desc_ar = $this->input->post("section_desc_ar");            
        $section_keywords_ar = $this->input->post("section_keywords_ar");          
        $section_title_en = $this->input->post("section_title_en");
        $section_desc_en = $this->input->post("section_desc_en");            
        $section_keywords_en = $this->input->post("section_keywords_en");  
                 
        $section_order = $this->input->post("section_order"); 

        if($section_title_ar && $section_id){
        
            $data = array(
                "section_title_ar"=> $section_title_ar,
                "section_desc_ar"=> $section_desc_ar,
                "section_keywords_ar"=> $section_keywords_ar,
                "section_title_en"=> $section_title_en,
                "section_desc_en"=> $section_desc_en,
                "section_keywords_en"=> $section_keywords_en,   
                "section_order"=> $section_order,                    
            );    

            $this->db->where("section_id",$section_id)->update("faq_sections",$data);
                         
            //admin log
            $log = array( 
                "log_type"=> "faq", 
                "log_action"=>"update_section",  
                "log_rel_id"=>$section_id,
                "log_rel_text"=>json_encode($data),
            );                              
            $this->logger->create($log);       

            redirect(base_url(admin_base."faq/section/".$section_id));


        }else{
            $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
        }            


    }



    public function delete_section($section_id){
        
        $this->db->limit(1)->where("section_id",$section_id)->delete("faq_sections");
        $this->db->where("topic_section_id",$section_id)->delete("faq_topics");
        
        redirect(base_url(admin_base."faq"));
        
    }        

    
    ////////////////// topics

    
    public function add_topic($section_id = 0){

        $this->db->order_by("section_order ASC");
        $sections = $this->db->get("faq_sections")->result();
                
        $data["data"]["sections"] = $sections;         
        $data["data"]["section_id"] = $section_id;
        $data["data"]["method"] = "insert_topic";
        $data["views"]["content"] = 'faq/forms/add_edit_topic';   
        $data["data"]["title"] = "الأسئلة الشائعة" . " - " . "إضافة موضوع";

        $this->load->view(style.'/templates/main/core',$data);            
    }


    public function insert_topic(){

        $topic_section_id = $this->input->post("topic_section_id");
        
        $topic_title_ar = $this->input->post("topic_title_ar");
        $topic_desc_ar = $this->input->post("topic_desc_ar");            
        $topic_keywords_ar = $this->input->post("topic_keywords_ar");            
        $topic_text_ar = $this->input->post("topic_text_ar");       
                     
        $topic_title_en = $this->input->post("topic_title_en");
        $topic_desc_en = $this->input->post("topic_desc_en");            
        $topic_keywords_en = $this->input->post("topic_keywords_en");            
        $topic_text_en = $this->input->post("topic_text_en");       
             
        $topic_order = $this->input->post("topic_order"); 

        if($topic_title_ar){
        
            $data = array(
                "topic_section_id"=> $topic_section_id,
                
                "topic_title_ar"=> $topic_title_ar,
                "topic_desc_ar"=> $topic_desc_ar,
                "topic_keywords_ar"=> $topic_keywords_ar,
                "topic_text_ar"=> $topic_text_ar,
                
                "topic_title_en"=> $topic_title_en,
                "topic_desc_en"=> $topic_desc_en,
                "topic_keywords_en"=> $topic_keywords_en,
                "topic_text_en"=> $topic_text_en,                
                
                "topic_order"=> $topic_order,                    
            );    

            $this->db->insert("faq_topics",$data);
            $topic_id = $this->db->insert_id();   


            if($topic_id){

                //admin log
                $log = array( 
                    "log_type"=>"faq", 
                    "log_action"=>"create_topic",  
                    "log_rel_id"=>$topic_id,
                );                              
                $this->logger->create($log);       

                redirect(base_url(admin_base."faq/section/".$topic_section_id));

            }else{
                $this->base->response_page("خطأ","error","لا يمكن انشاء الموضوع",1,"auto");                              
            }           

        }else{
            $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
        }            

    }



    public function edit_topic($topic_id){

        $this->db->where("topic_id",$topic_id);
        $topic = $this->db->limit(1)->get("faq_topics")->row();
        
        $this->db->order_by("section_order ASC");
        $sections = $this->db->get("faq_sections")->result();
                
        $data["data"]["topic"] = $topic;         
        $data["data"]["sections"] = $sections;         
        $data["data"]["method"] = "update_topic";
        $data["views"]["content"] = 'faq/forms/add_edit_topic';   
        $data["data"]["title"] = "الأسئلة الشائعة" . " - " . "تعديل موضوع";

        $this->load->view(style.'/templates/main/core',$data);            
    }



    public function update_topic(){
            
        $topic_id = $this->input->post("topic_id");
        $topic_section_id = $this->input->post("topic_section_id");
        
        $topic_title_ar = $this->input->post("topic_title_ar");
        $topic_desc_ar = $this->input->post("topic_desc_ar");            
        $topic_keywords_ar = $this->input->post("topic_keywords_ar");            
        $topic_text_ar = $this->input->post("topic_text_ar");       
                     
        $topic_title_en = $this->input->post("topic_title_en");
        $topic_desc_en = $this->input->post("topic_desc_en");            
        $topic_keywords_en = $this->input->post("topic_keywords_en");            
        $topic_text_en = $this->input->post("topic_text_en");   
                 
        $topic_order = $this->input->post("topic_order"); 

        if($topic_title_ar && $topic_id && $topic_section_id){
        
            $data = array(
                "topic_section_id"=> $topic_section_id,

                "topic_title_ar"=> $topic_title_ar,
                "topic_desc_ar"=> $topic_desc_ar,
                "topic_keywords_ar"=> $topic_keywords_ar,
                "topic_text_ar"=> $topic_text_ar,
                
                "topic_title_en"=> $topic_title_en,
                "topic_desc_en"=> $topic_desc_en,
                "topic_keywords_en"=> $topic_keywords_en,
                "topic_text_en"=> $topic_text_en,                  
                
                "topic_order"=> $topic_order,                    
            );    

            $this->db->where("topic_id",$topic_id)->update("faq_topics",$data);
                      
                         
            //admin log
            $log = array( 
                "log_type"=> "faq", 
                "log_action"=>"update_topic",  
                "log_rel_id"=>$topic_id,
            );                              
            $this->logger->create($log);       

            redirect(base_url(admin_base."faq/section/".$topic_section_id));


        }else{
            $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
        }            


    }



    public function delete_topic($topic_id){
            
        $this->db->where("topic_id",$topic_id);
        $topic = $this->db->limit(1)->get("faq_topics")->row();

        if($topic){

            $this->db->limit(1)->where("topic_id",$topic)->delete("faq_topics");

            //admin log
            $log = array( 
                "log_type"=>"faq", 
                "log_action"=>"delete_topic",  
                "log_rel_id"=>$topic_id,
            );                              
            $this->logger->create($log);                 

            redirect(base_url(admin_base."faq/section/".$topic->topic_section_id));

        }else{
            $this->base->response_page("خطأ","error","الموضوع غير موجود",1);                              
        }

    }        




}