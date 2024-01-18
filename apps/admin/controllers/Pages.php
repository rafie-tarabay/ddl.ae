<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(!logged_in || can("edit_pages") == FALSE ){ redirect(base_url(admin_base."admins/login")); exit; }
    }    



    public function index(){

        $count = $this->db->count_all_results("pages");

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"pages/index/",3);            

        $this->db->limit($per_page, $pagination["page"]); 
        $this->db->order_by("page_order","ASC");
        $pages = $this->db->get("pages")->result();

        $data["data"]["pagination"] = $pagination["links"];

        $data["data"]["pages"] = $pages;
        $data["views"]["content"] = 'pages/list_all';   
        $data["data"]["title"] = "الصفحات";

        $this->load->view(style.'/templates/main/core',$data);            

    }



    public function add_page(){

        $data["views"]["content"] = 'pages/forms/add_edit_page';   
        $data["data"]["title"] = "إضافة صفحة";

        $this->load->view(style.'/templates/main/core',$data);            
    }





    public function insert_page(){

        $page_alias = get_alias($this->input->post("page_alias"));                        

        $page_title_ar = $this->input->post("page_title_ar");
        $page_text_ar = $this->input->post("page_text_ar");            
        $page_desc_ar = $this->input->post("page_desc_ar");            
        $page_keywords_ar = $this->input->post("page_keywords_ar");
        
        $page_title_en = $this->input->post("page_title_en");
        $page_text_en = $this->input->post("page_text_en");            
        $page_desc_en = $this->input->post("page_desc_en");            
        $page_keywords_en = $this->input->post("page_keywords_en");
                
        $page_listed = $this->input->post("page_listed");            
        $page_order = $this->input->post("page_order");                     

        if($page_alias && $page_title_ar){

            $count = $this->db->where("page_alias",$page_alias)->count_all_results("pages");

            if($count == 0){                            

                $data = array(
                    "page_alias"=> $page_alias,
                    
                    "page_title_ar"=> $page_title_ar,
                    "page_text_ar"=> $page_text_ar,                    
                    "page_desc_ar"=> $page_desc_ar,                    
                    "page_keywords_ar"=> $page_keywords_ar,  

                    "page_title_en"=> $page_title_en,
                    "page_text_en"=> $page_text_en,                    
                    "page_desc_en"=> $page_desc_en,                    
                    "page_keywords_en"=> $page_keywords_en,                      
                                      
                    "page_listed" => $page_listed,                     
                    "page_order" => $page_order,                      
                );

                $this->db->insert("pages",$data);
                $page_id = $this->db->insert_id();

                //admin log
                $log = array( 
                    "log_type"=>"create_page", 
                    "log_action"=>"create",  
                    "log_rel_id"=>$page_id,
                );                              
                $this->logger->create($log);                  
                
                redirect(base_url(admin_base."pages"));

            }else{
                $this->base->response_page("خطأ","error","إسم الصفحة مستخدم لصفحة أخرى",1,"auto");                              
            }


        }else{
            $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
        }            

    }



    public function edit_page($page_id){

        $data["data"]["page"] = $this->db->where("page_id",$page_id)->get("pages")->row();
        $data["views"]["content"] = 'pages/forms/add_edit_page';   
        $data["data"]["title"] = "تعديل صفحة";

        $this->load->view(style.'/templates/main/core',$data);            
    }



    public function update_page(){
        
        
        //prnt($_POST);

        $page_id = $this->input->post("page_id");
        $page_alias = get_alias($this->input->post("page_alias"));

        $page_title_ar = $this->input->post("page_title_ar");
        $page_text_ar = $this->input->post("page_text_ar");            
        $page_desc_ar = $this->input->post("page_desc_ar");            
        $page_keywords_ar = $this->input->post("page_keywords_ar");
        
        $page_title_en = $this->input->post("page_title_en");
        $page_text_en = $this->input->post("page_text_en");            
        $page_desc_en = $this->input->post("page_desc_en");            
        $page_keywords_en = $this->input->post("page_keywords_en");
          
        $page_listed = $this->input->post("page_listed");            
        $page_order = $this->input->post("page_order");  
        
        //prnt( htmlentities($page_text_ar) );

        if($page_id && $page_alias && $page_title_ar){

            $count = $this->db->where("page_alias",$page_alias)->where("page_id !=",$page_id)->count_all_results("pages");

            if($count == 0){                

                $page = $this->db->where("page_id",$page_id)->get("pages")->row();

                $data = array(
                    "page_alias"=> $page_alias,
                    
                    "page_title_ar"=> $page_title_ar,
                    "page_text_ar"=> $page_text_ar,                    
                    "page_desc_ar"=> $page_desc_ar,                    
                    "page_keywords_ar"=> $page_keywords_ar,  

                    "page_title_en"=> $page_title_en,
                    "page_text_en"=> $page_text_en,                    
                    "page_desc_en"=> $page_desc_en,                    
                    "page_keywords_en"=> $page_keywords_en, 
                    
                    "page_listed" => $page_listed,                     
                    "page_order" => $page_order,                     
                );

                $this->db->where("page_id",$page_id)->limit(1)->update("pages",$data);

                //admin log
                $log = array( 
                    "log_type"=>"edit_page", 
                    "log_action"=>"edit",  
                    "log_rel_id"=>$page_id,
                );                              
                $this->logger->create($log);                 
                
                //redirect(base_url(admin_base."pages"));


            }else{
                $this->base->response_page("خطأ","error","إسم الصفحة مستخدم لصفحة أخرى",1,"auto");                              
            }


        }else{
            $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
        }            

    }



    public function delete_page($page_id){

        $page = $this->db->where("page_id",$page_id)->get("pages")->row();

        if($page){

            if($page->page_alias != "bank-accounts"){

                $this->db->limit(1)->where("page_id",$page_id)->delete("pages");

                //admin log
                $log = array( 
                    "log_type"=>"delete_page", 
                    "log_action"=>"delete",  
                    "log_rel_id"=>$page_id,
                );                              
                $this->logger->create($log);                 
                
                redirect(base_url(admin_base."pages"));

            }else{
                $this->base->response_page("خطأ","error","لا يمكن حذف هذه الصفحة لأنها تستخدم فى أجزاء هامة فى الموقع",1);                              
            }

        }else{
            $this->base->response_page("خطأ","error","الصفحة غير موجودة",1);                              
        }

    }        

}