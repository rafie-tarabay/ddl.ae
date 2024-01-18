<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shortlinks extends MY_Controller {

    public function __construct() {
        parent::__construct(); // getting base constructor
        if(!logged_in){ redirect(base_url(admin_base."admins/login")); exit; }
        $this->logsDB = $this->load->database("logs",true);  
    }

    public function index(){

        $keywords = $this->input->get("keywords");
        if($keywords){
            $this->logsDB->or_like("hash",$keywords,"both");
            $this->logsDB->or_like("url",urlencode($keywords),"both");
            $this->logsDB->or_like("url",$keywords,"both");
        }
        $count = $this->logsDB->count_all_results("short_urls"); 

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"shortlinks/index/",3);            

        if($keywords){
            $this->logsDB->or_like("hash",$keywords,"both");
            $this->logsDB->or_like("url",urlencode($keywords),"both");
            $this->logsDB->or_like("url",$keywords,"both");
        }            
        $this->logsDB->limit($per_page, $pagination["page"]); 
        $this->logsDB->order_by("id","DESC");
        $records = $this->logsDB->get("short_urls")->result();

        $data["data"]["pagination"] = $pagination["links"];

        $data["data"]["keywords"] = $keywords;
        $data["data"]["count"] = $count;
        $data["data"]["records"] = $records;
        $data["views"]["content"] = 'shortlink/list_all';   
        $data["data"]["title"] = "تقصير الروابط ";

        $this->load->view(style.'/templates/main/core',$data);          

    }    

    public function search(){

        $keywords = $this->input->post("keywords");

        redirect(base_url(admin_base."shortlinks/index?keywords=".$keywords));

    } 




    public function add_link(){

        $data["views"]["content"] = 'shortlink/forms/add_link';   
        $data["data"]["title"] = "تقصير رابط";
        $this->load->view(style.'/templates/main/core',$data);   
        
    }


    public function shorten(){

        $this->load->model("access");
        
        $url = $this->input->post("url");
        $utm_campaign = get_alias($this->input->post("utm_campaign"));
        $utm_medium   = get_alias($this->input->post("utm_medium"));
        $utm_source   = get_alias($this->input->post("utm_source"));
        
        parse_str(parse_url($url, PHP_URL_QUERY), $segments);
        
        if($utm_campaign) $segments["utm_campaign"]   = $utm_campaign;
        if($utm_medium)   $segments["utm_medium"]     = $utm_medium;
        if($utm_source)   $segments["utm_source"]     = $utm_source;
  
        $q = http_build_query($segments);
        
        $ex = explode("?",$url);
        $base_link = $ex[0];
        
        $link = $base_link;
        
        if($q){
            $link = $base_link."?".$q;
        }
        
        //$link = urldecode($link);
        
        $shortlink = $this->access->shorten_url($link,TRUE);            
        
        $data["data"]["link"] = $link;
        $data["data"]["shortlink"] = $shortlink;
        
        $data["views"]["content"] = 'shortlink/show_shortlink';           
        $data["data"]["title"] = "الرابط القصير";
        $this->load->view(style.'/templates/main/core',$data);  
        
    }




} 