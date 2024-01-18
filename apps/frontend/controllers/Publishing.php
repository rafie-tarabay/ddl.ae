<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publishing extends MY_Controller {
    
    public function __construct() {
        parent::__construct(); // getting base constructor
        if(!logged_in){ redirect(base_url()); die(); }
        $this->load->model("publish");
    }    
    

    public function index(){
        
        $data["data"]["authors"] = $this->publish->fetch_authors(FALSE);
        $data["data"]["corporates"] = $this->publish->fetch_corporates(FALSE);
        $data["data"]["requests"] = $this->publish->fetch_requests();

        $data["views"]["content"] = 'publish/dashboard';   
        $data["views"]["title"] = word("self_publish"); 

        $this->load->view(design_path.'/templates/main/core',$data);   
    }
    

    public function create(){
                
        $data["data"]["authors"] = $authors = $this->publish->fetch_authors(FALSE);
        $data["data"]["corporates"] = $corporates = $this->publish->fetch_corporates(FALSE);
        
        if($authors || $corporates){
            $data["data"]["services"] = $this->publish->fetch_services();
            $data["views"]["content"] = 'publish/forms/add_request';   
            $data["views"]["title"] = word("self_publish")." - ".word("publish_request"); 
            $this->load->view(design_path.'/templates/main/core',$data);   
        }else{
            $this->base->response_page(word("error"),"error",word("did_not_add_any_authors"),1,base_url("publishing/add_author"));
        }
    }
    
    
    public function submit_request(){

        // allowed options
        $materials_types = array("article","book","audio");
        $pricing_options = array("totaly-free","one-year-free","paid");
        $publishing_options = array("ddl","qindeel");
        $copyrights_options = array(3,5,7);
        
        $request = array();
        
        
        $request["req_material_title"] = $this->input->post("material_title");
        $request["req_material_type"] = $this->input->post("material_type");        
        $request["req_pricing"] = $this->input->post("pricing");
        $request["req_publish_via"] = $this->input->post("publish_via");
        $request["req_copyrights"] = $this->input->post("copyrights");
        $request["req_comments"] = $this->input->post("comments");
        
        $services = $this->input->post("services");
        $services = $this->publish->check_services($services);
        $request["req_services"] = $services ? json_encode($services) : NULL;
                                                              
        $authors = $this->input->post("authors");
        if($authors) $authors = $this->publish->fetch_authors(FALSE,$authors);
        
        $corporates = $this->input->post("corporates");
        if($corporates) $corporates = $this->publish->fetch_corporates(FALSE,$corporates);        
               
        if( 
            ( $corporates || $authors ) &&
            $request["req_material_title"] &&            
            in_array($request["req_material_type"],$materials_types) &&
            in_array($request["req_pricing"],$pricing_options) &&
            in_array($request["req_publish_via"],$publishing_options) &&
            in_array($request["req_copyrights"],$copyrights_options) 
        ){
            
            $upload_data = array(
                "file_name" => u_id."-material-".time(),
                "folder" => upload_base."publishing/".u_id."/",
                "field_name" => "attach_file",
                "ext" => "DOC|DOCX|PDF|EPUB|MP3",
                "max_size" => 102400,
            );
            $uploaded = $this->base->upload_doc($upload_data);
                
            if($uploaded["result"] == 1 && $uploaded["file_size"] > 0) {
                
                $doc = $uploaded["file"];            
                $folder = $upload_data["folder"];
                
                $do_data = array(
                    "space_name"=>"storage",
                    "path"=>$folder,
                    "filename"=>$doc,
                    "do_path"=>"ddl.ae/uploads/publishing/".u_id."/",
                    "do_filename"=>$doc,
                );
                
                $sent = $this->base->send_to_digitalocean($do_data);
                if($sent){ // Success
                    @unlink(FCPATH.$folder.$doc);
                    $doc = $sent;
                }else{ // Faild
                    $doc = $folder.$doc;
                }                

                $req_id = $this->publish->insert_request($request,$doc);
                
                $this->publish->insert_authorities($req_id,$authors,$corporates);
                
                redirect(base_url("publishing"));        
            }else{
                $this->base->response_page(word("error"),"error",word("error_uploading_file"),1,"auto");
            }
                        
        }else{
            $this->base->response_page(word("error"),"error",word("plz_fill_all"),1,"auto");
        }
        
    }    


    public function add_author(){

        $data["views"]["content"] = 'publish/forms/add_author';   
        $data["views"]["title"] = word("self_publish")." - ".word("add_author"); 

        $this->load->view(design_path.'/templates/main/core',$data);   
    }
    
    
    public function submit_author(){
        
        $author = array();
        
        $author["author_name"] = $this->input->post("author_name");
        $author["author_name_en"] = $this->input->post("author_name_en");
        $author["author_email"] = $this->input->post("author_email");
        $author["author_mobile"] = $this->input->post("author_mobile");
        $author["author_address"] = $this->input->post("author_address");
        $author["author_job_title"] = $this->input->post("author_job_title");
        $author["author_company"] = $this->input->post("author_company");
        $author["author_nationality"] = $this->input->post("author_nationality");
        
        if(
            $author["author_name"] &&
            $author["author_name_en"] &&
            $author["author_email"] &&
            $author["author_mobile"] &&
            $author["author_address"] &&
            $author["author_nationality"]
        ){
            

            $upload_data = array(
                "file_name" => u_id."-author-".time(),
                "folder" => upload_base."publishing/".u_id."/",
                "field_name" => "national_id",
                "ext" => "JPG|JPEG|PNG|PDF",
                "max_size" => 2048,
            );            
            $uploaded = $this->base->upload_doc($upload_data);

            if($uploaded["result"] == 1 && $uploaded["file_size"] > 0){
                
                $doc = $uploaded["file"];                            
                $folder = $upload_data["folder"];
                
                $do_data = array(
                    "space_name"=>"storage",
                    "path"=> $folder,
                    "filename"=>$doc,
                    "do_path"=>"ddl.ae/uploads/publishing/".u_id."/",
                    "do_filename"=>$doc,
                );
                
                $sent = $this->base->send_to_digitalocean($do_data);
                if($sent){ // Success
                    @unlink(FCPATH.$folder.$doc);
                    $doc = $sent;
                }else{ // Faild
                    $doc = $folder.$doc;
                }                

                $this->publish->insert_author($author,$doc);
                
                redirect(base_url("publishing"));        
            }else{
                $this->base->response_page(word("error"),"error",word("error_uploading_file"),1,"auto");
            }
                        
        }else{
            $this->base->response_page(word("error"),"error",word("plz_fill_all"),1,"auto");
        }
        
    }    

    
    

    public function add_corporate(){

        $data["views"]["content"] = 'publish/forms/add_corporate';   
        $data["views"]["title"] = word("self_publish")." - ".word("add_corporate"); 

        $this->load->view(design_path.'/templates/main/core',$data);   
    }
    
    
    public function submit_corporate(){
        
        $corp = array();
        
        $corp["corp_name"] = $this->input->post("corp_name");
        $corp["corp_name_en"] = $this->input->post("corp_name_en");
        $corp["corp_sub_unit"] = $this->input->post("corp_sub_unit");
        $corp["corp_sub_unit_en"] = $this->input->post("corp_sub_unit_en");
        $corp["corp_meeting_loc"] = $this->input->post("corp_meeting_loc");
        $corp["corp_meeting_date"] = $this->input->post("corp_meeting_date");
        
        if(
            $corp["corp_name"] &&
            $corp["corp_name_en"] &&
            $corp["corp_sub_unit"] &&
            $corp["corp_sub_unit_en"] &&
            $corp["corp_meeting_loc"] &&
            $corp["corp_meeting_date"]
        ){
            
            $this->publish->insert_corporate($corp);
            
            redirect(base_url("publishing"));        
         
        }else{
            $this->base->response_page(word("error"),"error",word("plz_fill_all"),1,"auto");
        }
        
    }    
    
    
    
}