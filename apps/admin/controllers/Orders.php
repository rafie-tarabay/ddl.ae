<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(!logged_in || can("view_orders") == FALSE ){ redirect(base_url(admin_base."admins/login")); exit; }
    }    

    public function index($start=null,$end=null)
    {
         $count = $this->db->count_all_results("orders"); 

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"orders/index/",3);            
        
        $this->db->limit($per_page, $pagination["page"]); 
        $this->db->order_by("order_id","DESC");
        $records = $this->db->get("orders")->result();

        foreach($records as $record){         
            $this->db->select("u_id,u_fullname");
            $this->db->where("u_id",$record->order_u_id)->limit(1);
            $record->user = $this->db->get("users")->row();                     
            
            $this->db->where("item_order_id",$record->order_id);
            $record->items = $this->db->get("order_items")->result();                     
            //prntf($this->db->last_query());
        }        

        $data["data"]["pagination"] = $pagination["links"];

        $data["data"]["count"] = $count;
        $data["data"]["records"] = $records;
        $data["views"]["content"] = 'orders/list_all';   
        $data["data"]["title"] = "الطلبات";

        $this->load->view(style.'/templates/main/core',$data);            

    }
    public function filter()
    {
        $startDate = trim($this->input->post("start_date"));
        $endDate = trim($this->input->post("end_date"));
        $orderStatus = trim($this->input->post("order_status"));
        
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate); 

        if(isset($orderStatus) && !empty($orderStatus) && $orderStatus !='all' )
        {
            $this->db->where('order_status', $orderStatus);
        }
        $this->db->where('order_timestamp >=', $startDate);
        $this->db->where('order_timestamp <=', $endDate);
        $records = $this->db->get('orders')->result();
         
        $count=count($records);
       // echo $this->db->last_query();
       // exit;

        $per_page = 20;                                    
        $pagination = $this->base->paginate_me($count,$per_page,"orders/index/",3);            
        
        $this->db->limit($per_page, $pagination["page"]); 
        $this->db->order_by("order_id","DESC");
        if(isset($orderStatus) && !empty($orderStatus) && $orderStatus!='all')
        {
            $this->db->where('order_status', $orderStatus);
        }
        $this->db->where('order_timestamp >=', $startDate);
        $this->db->where('order_timestamp <=', $endDate);
        $records = $this->db->get("orders")->result();

        foreach($records as $record){         
            $this->db->select("u_id,u_fullname");
            $this->db->where("u_id",$record->order_u_id)->limit(1);
            $record->user = $this->db->get("users")->row();                     
            
            $this->db->where("item_order_id",$record->order_id);
            $record->items = $this->db->get("order_items")->result();                     
            //prntf($this->db->last_query());
        }        

        $data["data"]["pagination"] = $pagination["links"];
        $data["data"]["start_date"] = $startDate;
        $data["data"]["end_date"] = $endDate;
        $data["data"]["order_status"] = $orderStatus;
        $data["data"]["count"] = $count;
        $data["data"]["records"] = $records;
        $data["views"]["content"] = 'orders/list_all';   
        $data["data"]["title"] = "الطلبات";

        $this->load->view(style.'/templates/main/core',$data);        

    }

}