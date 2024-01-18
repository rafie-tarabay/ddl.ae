<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File_manager extends MY_Controller {

    public function __construct() {
        parent::__construct(); // getting base constructor
        if(!logged_in){ redirect(base_url(admin_base."admins/login")); exit; }
    }

    public function index(){

        $count = $this->db->count_all_results("admins_files"); 

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"file_manager/index/",3);            

        $this->db->join("admins","file_admin_id = admin_id","LEFT");        
        $this->db->order_by("file_id","DESC");
        $this->db->limit($per_page, $pagination["page"]); 
        $records = $this->db->get("admins_files")->result();
        $data["data"]["pagination"] = $pagination["links"];

        $data["data"]["count"] = $count;
        $data["data"]["records"] = $records;

        $data["views"]["content"] = 'file_manager/list_all';   
        $data["data"]["title"] = "مدير الملفات";

        $this->load->view(style.'/templates/main/core',$data);            

    }    

    public function upload_file(){

        $data["data"]["upload_folder"] = upload_folder("today",FALSE,TRUE,FALSE,"file_manager");
        
        $data["views"]["content"] = "file_manager/forms/upload";                                
        $data["data"]["title"] = "رفع ملف";                

        $this->load->view(style.'/templates/main/core',$data);    

    } 


    public function upload(){

        $location = $this->input->post("location");
        $space = $this->input->post("space");
        $folder = $this->input->post("folder");

        if(!$folder){
            $folder = upload_folder("today",FALSE,TRUE,FALSE,"file_manager");                 
        }        
        $folder = ltrim($folder, '/');
        
        $upload_data = array(
            "file_name" => "admin_assets_".time(),
            "folder" => upload_base.$folder,
            "field_name" => "files",
            "max_size" => 102400,
        );
        
        $uploaded = $this->base->upload_multi_docs($upload_data);

        //prnt($uploaded);

        foreach($uploaded as $upload){

            if($upload["result"] == 1){
                
                $file_do_url = NULL;
                $file_url = NULL;

                if(in_array($location , array("do","both"))){

                    $do_data = array(
                        "space_name"=>$space,
                        "path"=>$upload["file_path"],
                        "filename"=>$upload["file_name"],
                        "do_path"=> "ddl.ae/uploads/".$folder,
                        "do_filename"=>$upload["file_name"],
                    );

                    $file_do_url = $this->base->send_to_digitalocean($do_data);  

                }

                if(in_array($location , array("both","local"))){
                    $file_url = base_url(upload_base.$folder.$upload["file_name"]);
                }  
                
                $file = array(
                    "file_admin_id" => admin_id,
                    "file_name" => $upload["file_original_name"],
                    "file_url" => $file_url,
                    "file_DO_url" => $file_do_url,
                    "file_ext" => $upload["file_ext"],
                    "file_size" => $upload["file_size"],
                    "file_timestamp" => time(),
                );

                $this->db->insert("admins_files",$file);                
                
                if($location == "do"){
                    @unlink($upload["file_path"].$upload["file_name"]);
                }

            }             

        }


        redirect(base_url(admin_base."file_manager")); 


    }

}