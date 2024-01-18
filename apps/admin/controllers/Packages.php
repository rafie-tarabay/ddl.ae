<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packages extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(!logged_in ){ redirect(base_url(admin_base."admins/login")); exit; }
        $this->locale = locale == "ar" ? "ar" : "en";
    }  



    public function index(){

        if( can("edit_packages") ){

            $this->db->select("packages.*, pack_title_".$this->locale." as title");
            $packages = $this->db->order_by("pack_order","ASC")->get("packages")->result();

            $data["data"]["packages"]   = $packages;
            $data["views"]["content"]   = 'packages/list_packages';   
            $data["data"]["title"]      = "حزم الاشتراكات";

            $this->load->view(style.'/templates/main/core',$data);    

        } 
    }


    public function view_package($pack_id){

        if( can("edit_packages") ){

            $this->db->select("packages.*, pack_title_".$this->locale." as title");
            $package = $this->db->where("pack_id",$pack_id)->limit(1)->get("packages")->row();

            $this->db->where("book_package_id",$pack_id);
            $books = $this->db->order_by("book_order","ASC")->get("packages_books")->result();

            $data["data"]["package"]    = $package;            
            $data["data"]["books"]      = $books;            

            $data["views"]["content"]   = 'packages/view_package';   
            $data["data"]["title"]      = "عرض حزمة";

            $this->load->view(style.'/templates/main/core',$data);    

        }       
    }


    public function add_package(){

        if( can("edit_packages") ){

            $data["data"]["method"]     = 'insert_package';   
            $data["views"]["content"]   = 'packages/forms/add_edit_package';   
            $data["data"]["title"]      = "اضافة حزمة";

            $this->load->view(style.'/templates/main/core',$data);    

        }       
    }


    public function insert_package(){

        if( can("edit_packages") ){

            $pack_title_ar          = $this->input->post("pack_title_ar");  
            $pack_title_en          = $this->input->post("pack_title_en");  
            $pack_desc_ar           = $this->input->post("pack_desc_ar");  
            $pack_desc_en           = $this->input->post("pack_desc_en");  
            $pack_price_monthly     = $this->input->post("pack_price_monthly");  
            $pack_price_yearly      = $this->input->post("pack_price_yearly");  
            $pack_order             = $this->input->post("pack_order");  

            $data = array(
                "pack_title_ar"         => trim($pack_title_ar),
                "pack_title_en"         => trim($pack_title_en),
                "pack_desc_ar"          => trim($pack_desc_ar),
                "pack_desc_en"          => trim($pack_desc_en),
                "pack_price_monthly"    => trim($pack_price_monthly),
                "pack_price_yearly"     => trim($pack_price_yearly),
                "pack_count"             => 0,
                "pack_order"             => trim($pack_order) ? trim($pack_order) : 0,
            );

            $this->db->insert("packages",$data);
            $pack_id = $this->db->insert_id();
            if($pack_id){
                redirect(base_url(admin_base."packages/view_package/".$pack_id));
            }else{
                prnt("error");
            }

        }       
    }



    public function edit_package($pack_id){

        if( can("edit_packages") ){

            $this->db->where("pack_id",$pack_id);
            $package = $this->db->limit(1)->get("packages")->row();                        

            $data["data"]["method"]     = 'update_package';   
            $data["data"]["package"]    = $package;
            $data["views"]["content"]   = 'packages/forms/add_edit_package';   
            $data["data"]["title"]      = "تعديل حزمة";            

            $this->load->view(style.'/templates/main/core',$data);    

        }       
    }


    public function update_package(){

        if( can("edit_packages") ){

            $pack_title_ar          = $this->input->post("pack_title_ar");  
            $pack_title_en          = $this->input->post("pack_title_en");  
            $pack_desc_ar           = $this->input->post("pack_desc_ar");  
            $pack_desc_en           = $this->input->post("pack_desc_en");  
            $pack_price_monthly     = $this->input->post("pack_price_monthly");  
            $pack_price_yearly      = $this->input->post("pack_price_yearly");  
            $pack_order             = $this->input->post("pack_order"); 
            $pack_id                = $this->input->post("pack_id");  

            $data = array(
                "pack_title_ar"         => trim($pack_title_ar),
                "pack_title_en"         => trim($pack_title_en),
                "pack_desc_ar"          => trim($pack_desc_ar),
                "pack_desc_en"          => trim($pack_desc_en),
                "pack_price_monthly"    => trim($pack_price_monthly),
                "pack_price_yearly"     => trim($pack_price_yearly),
                "pack_order"             => trim($pack_order) ? trim($pack_order) : 0,
            );         
            $updated = $this->db->where("pack_id",$pack_id)->update("packages",$data);
            if($updated){
                redirect(base_url(admin_base."packages/view_package/".$pack_id));
            }else{
                prnt("error");
            }

        }       
    }




    public function add_book($pack_id=0){

        if( can("edit_packages") ){

            $this->db->select("packages.*, pack_title_".$this->locale." as title");
            $packages = $this->db->order_by("pack_order","ASC")->get("packages")->result();

            $data["data"]["method"]         = 'insert_book';   
            $data["data"]["packages"]       = $packages;                        
            $data["data"]["pack_id"]        = $pack_id;
            $data["views"]["content"]       = 'packages/forms/add_edit_book';               
            $data["data"]["title"]          = "إضافة كتاب لحزمة";

            $this->load->view(style.'/templates/main/core',$data);    

        }       
    }

    public function insert_book(){

        if( can("edit_packages") ){

            $book_id        = (int) trim($this->input->post("book_id"));  
            $packs          = $this->input->post("packs");              
            $book_order     = trim($this->input->post("book_order"));              

            if($book_id){

                $this->load->model("searcher");
                $params = array(
                    "filters" => array(
                        "ids"=>array($book_id)
                    ),
                    "similar" => FALSE
                );
                $returned = $this->searcher->get_records($params);             

                if ($book = @$returned["results"][0]){

                    $data = array();                
                    foreach($packs as $pack_id){
                        $data[] = array(
                            "book_id"           => trim($book_id),
                            "book_package_id"   => trim($pack_id),                
                            "book_title"        => $book->getTitle(),
                            "book_order"        => $book_order,
                            "book_timestamp"    => time(),
                        );
                    }
                    $this->db->insert_batch("packages_books",$data);

                    foreach($packs as $pack_id){
                        $this->update_count($pack_id);
                    }

                    redirect(base_url(admin_base."packages/"));

                }else{
                    die("Book Does not exist");                
                }

            }

        }       
    }



    public function edit_book($pack_id=0,$book_id=0){

        if( can("edit_packages") && $pack_id && $book_id ){

            $this->db->where("book_id",$book_id)->where("book_package_id",$pack_id);
            $book = $this->db->limit(1)->get("packages_books")->row();

            $data["data"]["method"]         = 'update_book';   
            $data["data"]["book"]           = $book;                        
            $data["views"]["content"]       = 'packages/forms/add_edit_book';               
            $data["data"]["title"]          = "إضافة كتاب لحزمة";

            $this->load->view(style.'/templates/main/core',$data);    

        }       
    }

    public function update_book(){

        if( can("edit_packages") ){

            $book_id            = $this->input->post("book_id");  
            $pack_id            = $this->input->post("book_package_id");              
            $book_order         = $this->input->post("book_order");              

            $this->load->model("searcher");
            $params = array(
                "filters" => array(
                    "ids"=>array($book_id)
                ),
                "similar" => FALSE
            );
            $returned = $this->searcher->get_records($params);             

            if ($book = @$returned["results"][0]){

                $data = array(
                    "book_order"        => $book_order,
                );
                $this->db->where("book_package_id",$pack_id)->where("book_id",$book_id)->update("packages_books",$data);

                redirect(base_url(admin_base."packages/view_package/".$pack_id));

            }else{
                die("Book Does not exist");                
            }

        }       
    }    


    public function delete_book($book_id,$pack_id=0){
        if( can("edit_packages") ){
            if($pack_id){
                $this->db->where("book_package_id",$pack_id);                
            }
            $this->db->where("book_id",$book_id)->delete("packages_books");        


            if($pack_id){
                $this->update_count($pack_id);
            }else{
                $packages = $this->db->get("packages")->result();
                foreach($packages as $pack){
                    $this->update_count($pack->pack_id);
                }            
            }            

            redirect(go_back());
        }       
    }

             


    public function update_count($pack_id){
        $count = $this->db->where("book_package_id",$pack_id)->count_all_results("packages_books");
        $data = array(
            "pack_count" => $count,
        );         
        $updated = $this->db->where("pack_id",$pack_id)->update("packages",$data);
    }


  
}