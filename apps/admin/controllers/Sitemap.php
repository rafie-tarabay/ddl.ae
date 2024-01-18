<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends MY_Controller{

    public function __construct() {
        parent::__construct(); // getting base constructor        
        $this->load->library('sitemaps');
        if(!logged_in ||  can("edit_site_settings") == FALSE ){ redirect(base_url(admin_base."admins/login")); exit; }        
    }    
    
    
    function index(){
                
        $data["views"]["content"] = 'sitemaps/sitemaps';   
        $data["data"]["title"] = "خريطة الموقع";

        $this->load->view(style.'/templates/main/core',$data);         
        
    }
    
    function index_file(){
        
        $contents = scandir(FCPATH."sitemaps");

        $urls = array();
        
        say("index building - Started");
        
        foreach($contents as $content){            
            if(is_file(FCPATH."sitemaps/".$content)){
                $file = base_url("sitemaps/".$content);
                $urls[] = array("loc" => $file ,"lastmod" => date("c"),"changefreq" => "daily","priority" => "0.8");            
                say($file,FALSE);
            }
        }
        
        if($urls){        
            $index_file_name = $this->sitemaps->build_index($urls,"sitemap.xml");        
            $reponses = $this->sitemaps->ping(site_url($index_file_name));                       
        }     
        
        say("index building - Ended");
                
    }

    function main(){

        $main_links = array(
            "",//home
            "page/about",
            "page/contact",
            "page/privacy",
            "page/terms",
            "page/initiatives",
            "free-access",
            "browse",
            "faq",
            
        );
        
        say("main links building - Started");

        foreach($main_links as $link){
            $file = base_url($link);
            say($file,FALSE);
            $item = array("loc" => $file,"lastmod" => date("c"),"changefreq" => "monthly","priority" => "0.8");                           
            $this->sitemaps->add_item($item);                            
        }                                               

        // file name may change due to compression
        $file_name = $this->sitemaps->build("main.xml");
        
        say("main links building - Ended");
           
    }


    public function books(){
        
        /// counting total results
        $this->dumpDB = $this->load->database("dump",true);
        $count = $this->dumpDB->where("status_id !=",0)->count_all_results("marc_bibliographies");
        $limit = 20000;
        $start = 0;

        $i = 1;                   
        
        if($count > 0){
            
            say("books building - Started");
               
            while( $start <= $count ){        
                
                say("File no. <b>$i</b>: From <b>$start</b> - Started");
                   
                @ob_flush();
                @flush();                 
                
                $this->dumpDB->limit($limit,$start);
                $this->dumpDB->select("id");
                $books = $this->dumpDB->where("status_id !=",0)->get("marc_bibliographies")->result();                
                
                //loop
                foreach($books as $book){  
                    
                    $url = base_url("book/".$book->id);
                    
                    say($url,FALSE);                    
                                        
                    $item = array("loc" => $url,"lastmod" => date("c", strtotime("yesterday")),"changefreq" => "yearly","priority" => "0.8");                
                    $this->sitemaps->add_item($item);            
                }
                
                // file name may change due to compression
                $file_name = $this->sitemaps->build("books_".$i.".xml");                                        
                
                @ob_flush();
                @flush();                   
                
                say("File no. <b>$i</b>: From <b>$start</b> - Ended");
                
                //// important
                $start = $start + $limit;                                                    
                
                $i++;   
                
            }   
            
            say("books building - Ended");
            
        }
              

    }
            
    
    
    
    
  


}
