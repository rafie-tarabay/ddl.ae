<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing_content extends MY_Controller {

    var $cat_table = "landing_cats";
    var $content_table = "landing_content";

    public function __construct() {
        parent::__construct();
        if(!logged_in || can("edit_landing_content") == FALSE ){ redirect(base_url(admin_base."admins/login")); exit; }

    }    


    public function index(){

        $cats = $this->db->order_by("cat_order","ASC")->get($this->cat_table)->result();

        $data["data"]["cats"] = $cats;
        $data["views"]["content"] = 'landing_content/board';   
        $data["data"]["title"] = "محتوى الرئيسية";

        $this->load->view(style.'/templates/main/core',$data);            

    }

    public function category($cat_name){

        $cat = $this->db->where("cat_name",$cat_name)->get($this->cat_table)->row();

        $this->db->order_by("content_order",$cat->cat_order_dir);
        $contents = $this->db->where("content_cat",$cat->cat_name)->order_by("content_order","ASC")->get($this->content_table)->result();                  

        $data["data"]["cat"] = $cat;
        $data["data"]["contents"] = $contents;
        $data["views"]["content"] = 'landing_content/category';   
        $data["data"]["title"] = "محتوى الرئيسية - ".$cat->cat_title;

        $this->load->view(style.'/templates/main/core',$data);            

    }




    public function new_content($cat_name = 0){

        $fields = $this->db->list_fields("landing_content");        
        $cats = $this->db->order_by("cat_order","ASC")->get($this->cat_table)->result();

        $data["data"]["fields"] = $fields;
        $data["data"]["cats"] = $cats;
        $data["data"]["cat_name"] = $cat_name;
        $data["data"]["method"] = "insert_content";
        $data["views"]["content"] = 'landing_content/add_edit_content';   
        $data["data"]["title"] = "محتوى الرئيسية - اضافة جديد";

        $this->load->view(style.'/templates/main/core',$data);  
    }


    public function insert_content(){

        $content_cat = $this->input->post("content_cat");
        $content_order = $this->input->post("content_order");
        $content_disabled = $this->input->post("content_disabled");

        if($content_cat){

            $data = array();

            if($content_order){
                $data["content_order"] = $content_order;
            }            

            if($content_disabled){
                $data["content_disabled"] = !is_null($content_disabled) ? $content_disabled : 0;
            }            

            unset($_POST["content_order"]); // important 
            unset($_POST["content_disabled"]); // important 

            foreach( $this->input->post() as $field => $val ){
                $val = str_replace('"',"%22",$val);
                $data[$field] = $val ? (trim($val)) : NULL;                                
            }

            $this->db->insert($this->content_table,$data);
        }

        redirect(base_url(admin_base.ctrl()."/category/$content_cat"));    

    }   




    public function edit_content($content_id = 0){

        $fields = $this->db->list_fields("landing_content");        
        $content = $this->db->where("content_id",$content_id)->get($this->content_table)->row();                                                                                                       
        $cats = $this->db->order_by("cat_order","ASC")->get($this->cat_table)->result();

        $data["data"]["fields"] = $fields;
        $data["data"]["cats"] = $cats;
        $data["data"]["content"] = $content;
        $data["data"]["method"] = "update_content";
        $data["views"]["content"] = 'landing_content/add_edit_content';   
        $data["data"]["title"] = "محتوى الرئيسية - تعديل محتوى";

        $this->load->view(style.'/templates/main/core',$data);  
    }


    public function update_content(){

        $content_id = $this->input->post("content_id");
        $content_cat = $this->input->post("content_cat");
        $content_order = $this->input->post("content_order");

        if($content_id && $content_cat){

            $data = array();

            if($content_order){
                $data["content_order"] = $content_order;
            }

            unset($_POST["content_id"]); // important 
            unset($_POST["content_order"]); // important 

            foreach( $this->input->post() as $field => $val ){
                $val = str_replace('"',"%22",$val);
                $data[$field] = $val ? (trim($val)) : NULL;
            }

            $this->db->where("content_id",$content_id)->update($this->content_table,$data);
        }

        redirect(base_url(admin_base.ctrl()."/category/$content_cat"));    

    }


    public function delete_content($item_id = 0){

        $content = $this->db->where("content_id",$item_id)->get($this->content_table)->row();

        if($content){        
            $this->db->where("content_id",$item_id)->limit(1)->delete($this->content_table);        
        }

        redirect(base_url(admin_base.ctrl()."/category/".$content->content_cat));    

    }


    public function pull_original_images(){
        
        $pull_folder = upload_base."landing/pulled/";
        

        $this->db->group_start();
        $ddl_urls = array("http://","https://","ftp://","//");
        
        foreach($ddl_urls as $url){
            $this->db->or_like("content_rel_image1",$url,"after",FALSE);
            $this->db->or_like("content_rel_image2",$url,"after",FALSE);            
        }
        $this->db->group_end();

        $this->db->limit(20);            
        $results = $this->db->get("landing_content")->result();    

        if($results){   
            
            if(!is_dir($pull_folder) ) mkdir(FCPATH.$pull_folder);

            say("Found Content");  
            foreach($results as $row){
                
                say("[*] Loop Start");  
                $updated = array();
                
                for($i=1;$i<=2;$i++){  

                    $url = $row->{"content_rel_image"."$i"};
                    $ext = pathinfo($url, PATHINFO_EXTENSION);    
                    if($url){
                        say("&nbsp;&nbsp;|-- URL > $url",FALSE);    
                    }
                    
                    if( 
                    $row->{"content_rel_image"."$i"} && strpos($row->{"content_rel_image"."$i"},"http") !== FALSE ||
                    $row->{"content_rel_image"."$i"} && strpos($row->{"content_rel_image"."$i"},"ftp") !== FALSE ||
                    $row->{"content_rel_image"."$i"} && strpos($row->{"content_rel_image"."$i"},"//") !== FALSE                     
                    ){

                        
                        if(!in_array($ext,array("png","jpg","gif"))){
                           $ext = "png"; 
                        }
                        
                        $file_name = $row->content_id."-image".$i.".".$ext;
                        $file_path = $pull_folder.$file_name;
                        $final_path = FCPATH.$file_path;                        
                        $status = curl_fetch($url , $final_path);                    
                        if($status == TRUE){
                                             
                            if(file_exists($final_path)){
                                $updated["content_rel_image"."$i"] = $file_path;                              
                                say("&nbsp;&nbsp;&nbsp;&nbsp;|-- Fetched to : $file_path",FALSE);  
                            }else{
                                say("&nbsp;&nbsp;&nbsp;&nbsp;|-- Failed to Fetch",FALSE);  
                            }
                        }
                    }
                }
                
                if($updated){
                    say("&nbsp;&nbsp;|-- Update Commite ",FALSE);  
                    $this->db->where("content_id",$row->content_id)->update("landing_content",$updated);
                }
                
                say("[*] Loop End");  
            }
        }

    }



    public function content_toggle($content_id,$disable=0){

        if($content_id){

            $content = $this->db->where("content_id",$content_id)->get($this->content_table)->row();                                                                                                       
            
            $data = array();
            $data["content_disabled"] = $disable;
            $this->db->where("content_id",$content_id)->update($this->content_table,$data);
        }

        redirect(base_url(admin_base.ctrl()."/category/".$content->content_cat));    

    }


}