<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publishing extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(!logged_in || can("review_self_pub") == FALSE ){ redirect(base_url(admin_base."admins/login")); exit; }
    }    

    public function index(){

        $data["views"]["content"] = 'publishing/index';   
        $data["data"]["title"] = "النشر الذاتي";

        $this->load->view(style.'/templates/main/core',$data);            

    }

    public function authors($waiting = 0){

        if($waiting) $this->db->where("author_status","waiting_review");
        $count = $this->db->count_all_results("publish_authors"); 

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"publishing/authors/$waiting/",4);            

        $this->db->join("users","author_u_id = u_id","LEFT");
        if($waiting) $this->db->where("author_status","waiting_review");
        $this->db->order_by("FIELD(author_status,'waiting_review','accepted','rejected') , author_id ASC");
        $records = $this->db->get("publish_authors")->result();
        $data["data"]["pagination"] = $pagination["links"];

        $data["data"]["count"] = $count;
        $data["data"]["records"] = $records;

        $data["views"]["content"] = 'publishing/authors';   
        $data["data"]["title"] = "النشر الذاتي - المؤلفين";

        $this->load->view(style.'/templates/main/core',$data);            

    }
    
    public function corporates($waiting = 0){

        if($waiting) $this->db->where("corp_status","waiting_review");
        $count = $this->db->count_all_results("publish_corporates"); 

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"publishing/corporates/$waiting/",4);            

        $this->db->join("users","corp_u_id = u_id","LEFT");
        if($waiting) $this->db->where("corp_status","waiting_review");
        $this->db->order_by("FIELD(corp_status,'waiting_review','accepted','rejected') , corp_id ASC");
        $records = $this->db->get("publish_corporates")->result();
        $data["data"]["pagination"] = $pagination["links"];

        $data["data"]["count"] = $count;
        $data["data"]["records"] = $records;

        $data["views"]["content"] = 'publishing/corporates';   
        $data["data"]["title"] = "النشر الذاتي - الهيئات";

        $this->load->view(style.'/templates/main/core',$data);            

    }

    
    
    public function requests($waiting = 0){

        if($waiting) $this->db->where("req_status","waiting_review");
        $count = $this->db->count_all_results("publish_requests"); 

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"publishing/requests/$waiting/",4);            

        $this->db->join("users","req_u_id = u_id","LEFT");
        if($waiting) $this->db->where("req_status","waiting_review");
        $this->db->order_by("FIELD(req_status,'waiting_review','processing','complete','canceled','rejected'),req_id ASC");
        $records = $this->db->get("publish_requests")->result();

        $data["data"]["pagination"] = $pagination["links"];

        $data["data"]["count"] = $count;
        $data["data"]["records"] = $records;

        $data["views"]["content"] = 'publishing/requests';   
        $data["data"]["title"] = "النشر الذاتي - طلبات النشر";

        $this->load->view(style.'/templates/main/core',$data);            

    }

    
    

    public function view_author($author_id = 0){
                           
        $this->db->where("author_id",$author_id);        
        $author = $this->db->limit(1)->get("publish_authors")->row();

        $data["data"]["author"] = $author;

        $data["views"]["content"] = 'publishing/view_author';   
        $data["data"]["title"] = "النشر الذاتي - عرض بيانات المؤلف";

        $this->load->view(style.'/templates/main/core',$data);            

    }
           
    

    public function view_corp($corp_id = 0){
                           
        $this->db->where("corp_id",$corp_id);        
        $corp = $this->db->limit(1)->get("publish_corporates")->row();

        $data["data"]["corp"] = $corp;

        $data["views"]["content"] = 'publishing/view_corp';   
        $data["data"]["title"] = "النشر الذاتي - عرض بيانات الهيئة";

        $this->load->view(style.'/templates/main/core',$data);            

    }
        
    

    public function view_request($req_id = 0){

        $this->db->where("req_id",$req_id);        
        $request = $this->db->limit(1)->get("publish_requests")->row();
        
        $authors = $this->db->where("ro_request_id",$req_id)->where("ro_type","author")->get("publish_requests_authorities")->result();
        $corporates = $this->db->where("ro_request_id",$req_id)->where("ro_type","corporate")->get("publish_requests_authorities")->result();
        
        if($authors){
            $authors_ids = get_ids_array($authors,"ro_rel_id");
            $request->authors = $this->db->where_in("author_id",$authors_ids)->get("publish_authors")->result();
        }
        
        if($corporates){
            $corps_ids = get_ids_array($corporates,"ro_rel_id");
            $request->corporates = $this->db->where_in("corp_id",$corps_ids)->get("publish_corporates")->result();
        }        
        
        if($request->req_services){
            $services=json_decode($request->req_services);
            $request->req_services = $this->db->where_in("service_name",$services)->get("publish_services")->result();
        }

        $data["data"]["request"] = $request;

        $data["views"]["content"] = 'publishing/view_request';   
        $data["data"]["title"] = "النشر الذاتي - عرض طلب نشر";

        $this->load->view(style.'/templates/main/core',$data);            

    }

    

    public function accept_author($author_id = 0){

        $author = array(
            "author_status" => "accepted",
        );
        $this->db->where("author_id",$author_id);        
        $this->db->limit(1)->update("publish_authors",$author);
        
        $this->base->response_page("تم بنجاح","success","تم قبول المؤلف",1,"publishing/authors");                              

    }     
    
    
    public function reject_author(){

        $author_id = $this->input->post("author_id");
        $reject_reason = $this->input->post("author_reject_reason");
        
        $author = array(
            "author_status" => "rejected",
            "author_reject_reason" => $reject_reason,
        );
        $this->db->where("author_id",$author_id);        
        $this->db->limit(1)->update("publish_authors",$author);

        $this->base->response_page("تم بنجاح","success","تم رفض المؤلف",1,"publishing/authors");                              

    }
    
    

    public function accept_corp($corp_id = 0){

        $corp = array(
            "corp_status" => "accepted",
        );
        $this->db->where("corp_id",$corp_id);        
        $this->db->limit(1)->update("publish_corporates",$corp);
        
        $this->base->response_page("تم بنجاح","success","تم قبول الهيئة",1,"publishing/corporates");                              

    }     
    
    
    public function reject_corp(){

        $corp_id = $this->input->post("corp_id");
        $reject_reason = $this->input->post("corp_reject_reason");
        
        $corp = array(
            "corp_status" => "rejected",
            "corp_reject_reason" => $reject_reason,
        );
        $this->db->where("corp_id",$corp_id);        
        $this->db->limit(1)->update("publish_corporates",$corp);

        $this->base->response_page("تم بنجاح","success","تم رفض الهيئة",1,"publishing/corporates");                              

    }
    

    
    
    
    
    
    
    
    public function request_status($req_id = 0,$status){

        $req = array(
            "req_status" => $status,
        );
        $this->db->where("req_id",$req_id);        
        $this->db->limit(1)->update("publish_requests",$req);
        
        $this->base->response_page("تم بنجاح","success","تم تعديل حالة الطلب",1,"publishing/requests");                              

    }     
    
    
    public function reject_request(){

        $req_id = $this->input->post("req_id");
        $reject_reason = $this->input->post("req_reject_reason");
        
        $req = array(
            "req_status" => "rejected",
            "req_reject_reason" => $reject_reason,
        );
        $this->db->where("req_id",$req_id);        
        $this->db->limit(1)->update("publish_requests",$req);

        $this->base->response_page("تم بنجاح","success","تم رفض الطلب",1,"publishing/requests");                              

    }
           
}