<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupons extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(!logged_in ){ redirect(base_url(admin_base."admins/login")); exit; }
        $this->locale = locale == "ar" ? "ar" : "en";
    }  



    public function index(){

        if( can("add_coupons") ){

            $coupons = $this->db->order_by("coupon_id","DESC")->get("coupons")->result();

            $data["data"]["coupons"]   = $coupons;
            $data["views"]["content"]   = 'coupons/list_coupons';   
            $data["data"]["title"]      = "كوبونات التخفيض";

            $this->load->view(style.'/templates/main/core',$data);    

        } 
    }

      

    public function add_coupon($pack_id=0){

        if( can("add_coupons") ){

            $this->db->select("packages.*, pack_title_".$this->locale." as title");
            $packages = $this->db->order_by("pack_order","ASC")->get("packages")->result();

            $data["data"]["method"]         = 'insert_coupon';   
            $data["data"]["packages"]       = $packages;                        
            $data["views"]["content"]       = 'coupons/forms/add_edit_coupon';               
            $data["data"]["title"]          = "إضافة كوبون";

            $this->load->view(style.'/templates/main/core',$data);    

        }       
    }

    public function insert_coupon(){

        if( can("add_coupons") ){

            $coupon_code        = trim($this->input->post("coupon_code"));              
            $coupon_min_order   = trim($this->input->post("coupon_min_order"));  
            $coupon_percent     = trim($this->input->post("coupon_percent"));              
            $coupon_max_amount  = trim($this->input->post("coupon_max_amount"));              
            $coupon_limit       = trim($this->input->post("coupon_limit"));              
            $coupon_expire      = trim($this->input->post("coupon_expire"));              

            $coupon_order_type  = trim($this->input->post("coupon_order_type"));  
            $packs              = $this->input->post("packs");              
            $coupon_plan        = trim($this->input->post("coupon_plan"));                                   
            $coupon_u_ids       = trim($this->input->post("coupon_u_ids"));                                   
            $coupon_referrer     = trim($this->input->post("coupon_referrer"));                                
                        
            $coupon_u_ids       = $coupon_u_ids ? explode(" ", trim($coupon_u_ids) ) : array();

            $coupon_code        = str_replace(" ","-",$coupon_code);
            
            if( $coupon_code && (  ($coupon_percent && $coupon_percent < 100)  ) ){

                $this->db->where("coupon_code",$coupon_code);
                $exists = $this->db->count_all_results("coupons");

                if(!$exists){

                    $conditions = array(
                        "plan" => $coupon_plan,
                        "packs" => $packs,
                        "u_ids" => $coupon_u_ids,
                        "referrer" => $coupon_referrer,
                    );

                    $coupon_data = array(
                        "coupon_code"           => $coupon_code,
                        "coupon_min_order"      => $coupon_min_order ? $coupon_min_order : NULL,
                        "coupon_percent"        => $coupon_percent ? $coupon_percent : 0,
                        "coupon_max_amount"     => $coupon_max_amount ? $coupon_max_amount : 0,
                        "coupon_limit"          => $coupon_limit ? $coupon_limit : 0,
                        "coupon_expire"         => $coupon_expire ? strtotime($coupon_expire) : NULL,
                        
                        "coupon_order_type"     => $coupon_order_type,
                        "coupon_conditions"     => $coupon_order_type == "packages" ? json_encode($conditions) : NULL,
                        
                        "coupon_usage_count"    => 0,                        
                        "coupon_disabled"        => 0,
                    );                

                    $this->db->insert("coupons",$coupon_data);
   
                    redirect(base_url(admin_base."coupons/"));

                }else{
                    prnt("Coupon Already Exists");
                }

            }else{
                prnt("missing_data");
            }

        }       
    }




    public function disable_coupon($coupon_id=0){
        if( can("add_coupons") ){
            
            $coupon = $this->db->where("coupon_id",$coupon_id)->limit(1)->get("coupons")->row();

            $this->db->where("coupon_code",$coupon->coupon_code);
            $this->db->update("coupons",array("coupon_disabled"=>1));        

            redirect(go_back());
        }       
    }


}