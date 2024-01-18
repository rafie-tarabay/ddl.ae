<?php

class Shopping extends base{

    public function __construct(){
        parent::__construct();  
        $this->db = $this->load->database("frontend",true);         

        $records = $this->session->userdata("cart");
        if(logged_in && $records ){
            $this->transfer_cart();  
        }

        $cart_content = $this->cart_items();

        $this->config->set_item('cart', $cart_content);
        if(!@defined("cart_count")){ @define("cart_count", count($cart_content) ); }              

    }

    public function cart_items(){  
        $returned = array();
        $contents = $this->cart_content();
        foreach($contents as $content){
            $returned[] = $content["id"];
        }
        return $returned;
    }

    public function cart_content(){  

        $contents = array();        
        if(logged_in){                  
            $records = $this->db->where("item_u_id",u_id)->get("cart")->result();                
            foreach($records as $record){
                $contents[] = $record->item_id;
            }     
        }else{
            $records = $this->session->userdata("cart");
            if(@count($records) > 0){
                foreach($records as $item_id => $item_data){
                    $contents[] = $item_id;
                }                                                     
            }
        }
        $contents = $this->validate_cart($contents);
        return $contents;                    
    }    

    public function validate_cart($contents){
        $records = array();
        if($contents){
            $params = array(
                "filters" => array(
                    "ids"=>$contents
                ),
                "limit" => count($contents),
                "no_debug"=>TRUE
            );
            $returned = $this->searcher->get_records($params);      
            if($books = @$returned["results"]){
                foreach($books as $book){
                    $records[] = array(
                        "id"     => $book->getId(),
                        "title"  => $book->getTitle(),
                        "source" => $book->getSource(),
                        "cover"  => $book->getFileCover(),
                        "price"  => $book->getPrice(),
                    );    
                }            
            }
        }        

        return $records;
    }

    public function add_to_cart($item_id){
        if($book = $this->exists_in_solr($item_id)){
            if( $this->exists_in_cart($item_id) == FALSE ){                            

                $item_data = array(
                    "title"     =>  $book->getTitle(),
                    "cover"     =>  $book->getFileCover(),
                    "timestamp" =>  time(),
                ); 
                $item_data = json_encode($item_data);               

                if(logged_in){
                    $data = array(
                        "item_id"           => $item_id,
                        "item_u_id"         => u_id,
                        "item_data"         => $item_data,
                    );
                    $this->db->insert("cart",$data);
                }else{                        
                    $records = $this->session->userdata("cart");
                    if(!is_array($records)) $records = array();
                    $records[$item_id] = $item_data;                    
                    $this->session->set_userdata(array("cart"=>$records));
                } 

                return array("status"=>"added");

            }else{
                return array("status"=>"exists"); 
            }         
        }else{
            return array("status"=>"not_existing");
        }
    }

    public function exists_in_cart($item_id){  
        $cart = $this->config->item('cart');
        if(!is_null($cart) && is_array($cart)){
            return in_array($item_id,$cart) ? TRUE : FALSE;
        }else{
            return FALSE;
        }
        /*
        if(logged_in){
        $row = $this->db->where("item_u_id",u_id)->where("item_id",$item_id)->limit(1)->get("cart")->row();        
        return $row ? json_decode($row->item_data,TRUE) : array();
        }else{
        $records = $this->session->userdata("cart");
        return isset($records[$item_id]) ? json_decode( $records[$item_id] ,TRUE) : FALSE;                 
        }
        */
    }

    public function exists_in_solr($item_id){  
        if($item_id){
            $params = array(
                "filters" => array(
                    "ids"=>array($item_id)
                ),
                "limit" => 1
            );
            $returned = $this->searcher->get_records($params);      
            if($book = @$returned["results"][0]){
                return $book;
            }else{
                return FALSE;
            }        
        }else{
            return FALSE;
        }
    }

    public function transfer_cart(){        
        $records = $this->session->userdata("cart");
        if($records){
            foreach($records as $id => $data){
                $this->add_to_cart($id);
            }            
        }
        $this->session->unset_userdata("cart");
    }

    public function remove_from_cart($item_id){
        if( $this->exists_in_cart($item_id) == TRUE ){                            
            if(logged_in){
                $this->db->where("item_id",$item_id)->where("item_u_id",u_id);
                $this->db->limit(1)->delete("cart");
            }else{
                $records = $this->session->userdata("cart");
                if(isset($records[$item_id])){
                    unset($records[$item_id]);
                    $this->session->set_userdata(array("cart"=>$records));
                }
            }
            return array("status"=>"removed");
        }else{
            return array("status"=>"not_existing");
        }
    }

    public function count_cart(){
        if(logged_in){
            $this->db->where("item_u_id",u_id);
            return $this->db->count_all_results("cart");
        }else{
            $records = $this->session->userdata("cart");
            return count($records);
        }
    }

    public function empty_cart(){
        if(logged_in){
            $this->db->where("item_u_id",u_id)->delete("cart");
        }else{
            $this->session->unset_userdata("cart");
        }
    }    

    public function total_price($items){
        $price = 0;
        foreach($items as $item){
            $price += $item["price"];
        }
        return $price;
    }    














    public function get_orders(){
        $this->db->where("order_u_id",u_id);
        return $this->db->order_by("order_id","DESC")->limit(20)->get("orders")->result();               
    }

    public function get_order($order_id){
        $this->db->where("order_u_id",u_id)->where("order_id",$order_id);
        $order = $this->db->limit(1)->get("orders")->row();               
        $order->{"items"} = $this->get_order_items($order_id);
        return $order;
    }

    public function get_order_items($order_id){
        return $this->db->where("item_order_id",$order_id)->get("order_items")->result();
    }

    public function update_order($order_id,$data){
        return $this->db->where("order_id",$order_id)->update("orders",$data);
    }

    public function get_unpaid_order($type=FALSE){
        if($type) $this->db->where("order_type",$type);
        $this->db->where("order_status","unpaid")->where("order_u_id",u_id);
        return $this->db->limit(1)->get("orders")->row();               
    }

    public function cancel_unpaid_orders($type=FALSE,$order_id=FALSE){
        $data = array(
            "order_status" => "canceled",
        );
        if($type) $this->db->where("order_type",$type);
        if($order_id) $this->db->where("order_id",$order_id);
        $this->db->where("order_status","unpaid")->where("order_u_id",u_id);
        $this->db->update("orders",$data);               
    }


    ////////////////// Create orders from cart content
    public function cart_order(){
        $items = $this->cart_content();  

        $this->db->trans_start();

        $order_id = $this->create_order("digital_items");        
        if($order_id){
            $total_price = $this->cart_items_to_order($items,$order_id);                    
            if($total_price){
                $order_update = array(
                    "order_original_price"=>$total_price,
                    "order_total_price"=>$total_price,
                );                
                $this->update_order($order_id,$order_update);
            }
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return $order_id;
        }                
    }


    ////////////////// Create orders from packages
    public function packages_order($items,$plan){

        $this->db->trans_start();

        $order_id = $this->create_order("packages");        
        if($order_id){
            $total_price = $this->packages_to_order($items,$plan,$order_id);                    
            if($total_price){
                $order_update = array(
                    "order_original_price"=>$total_price,
                    "order_total_price"=>$total_price,
                );
                $this->update_order($order_id,$order_update);
            }
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return $order_id;
        }                
    }


    ///// create order
    public function create_order($type){
        $data = array(
            "order_u_id"            => u_id,
            "order_type"            => $type,
            "order_status"          => "unpaid",
            "order_coupon"          => NULL,
            "order_original_price"  => 0,
            "order_total_price"     => 0,
            "order_timestamp"       => time(),
        );
        $this->db->insert("orders",$data);      
        return $this->db->insert_id();
    }

    ///// add items from cart to order
    public function cart_items_to_order($items,$order_id){

        $total_price = 0;

        $data = array();
        foreach($items as $item){

            $item_data = array(
                "title"     => $item["title"],
                "cover"     => $item["cover"],
                "price"     => $item["price"],
                "source_id" => $item["source"]["id"],
            );            

            $data[] = array(
                "item_id"           => $item["id"],
                "item_type"         => "digital_item",                
                "item_order_id"     => $order_id,                
                "item_u_id"         => u_id,     
                "item_source_id"    => $item_data["source_id"],     
                "item_price"        => $item["price"],     
                "item_data"         => json_encode($item_data),
            );

            $total_price += $item["price"];
        }
        $this->db->insert_batch("order_items",$data);   
        return $total_price;
    }



    ///// add items from packages to order
    public function packages_to_order($items,$plan,$order_id){

        $total_price = 0;

        $data = array();
        foreach($items as $item){

            $price = ($plan == "monthly") ? $item->pack_price_monthly : $item->pack_price_yearly; 
            $title = (locale == "ar") ? $item->pack_title_ar : $item->pack_title_en; 

            $item_data = array(
                "title" => $title,
                "cover" => FALSE,
                "price" => $price,
                "plan" => $plan,
            );            

            $data[] = array(
                "item_id"           => $item->pack_id,
                "item_type"         => "package",                
                "item_order_id"     => $order_id,                
                "item_u_id"         => u_id,     
                "item_price"        => $price,     
                "item_data"         => json_encode($item_data),
            );

            $total_price += $price;
        }
        $this->db->insert_batch("order_items",$data);   
        return $total_price;
    }

    public function remove_order_items($order_id,$items_ids){
        if($items_ids){
            $this->db->where_in("item_id",$items_ids);
            $this->db->where("item_order_id",$order_id);
            $this->db->delete("order_items");  

            $this->refresh_order($order_id);            
        }                                       
    }

    public function refresh_order($order_id){

        $items          = $this->get_order_items($order_id);
        $order          = array();
        $total_price    = 0;
        foreach($items as $item){
            $total_price += $item->item_price;    
        }
        if(count($items) == 0) $order["order_status"] = "canceled";
        $order["order_original_price"]  = $total_price;
        $order["order_total_price"]     = $total_price;

        $this->update_order($order_id,$order);

    }













    public function get_payments($wheres=array(),$limit=FALSE){
        if($wheres){
            foreach($wheres as $field => $val){
                $this->db->where($field,$val);
            }        
        }
        $this->db->where("payment_u_id",u_id);
        if($limit == 1){        
            $this->db->limit(1)->get("payments")->row();
        }elseif($limit > 1){        
            return $this->db->limit($limit)->get("payments")->result();            
        }else{
            return $this->db->order_by("payment_id","DESC")->get("payments")->result();            
        }

    }

    public function add_payment($paylog){
        $this->db->insert("payments",$paylog);
        return $this->db->insert_id();
    }

    public function update_payment($pay_id,$paylog){
        $this->db->where("payment_id",$pay_id)->update("payments",$paylog);
    }

    public function get_purchased($items=FALSE,$start=0,$limit=0,$return_ids = TRUE){
        $items_ids = array();
        if(is_array($items) && count($items) > 0){
            $items_ids = $items; 
        }elseif(!is_array($items) && $items){
            $items_ids = array($items); 
        }

        $this->db->join("orders","order_id = item_order_id","LEFT");
        $this->db->where("item_u_id",u_id);
        $this->db->where("order_u_id",u_id);
        $this->db->where("order_status","paid");
        if($items_ids){
            $this->db->where_in("item_id",$items_ids);
        }            
        if($start || $limit){
            $this->db->limit($limit,$start);
        }

        $rows = $this->db->get("order_items")->result();
        return $return_ids == TRUE ? get_ids_array($rows,"item_id") :  $rows;
    }

    public function count_purchased(){ 
        $this->db->join("orders","order_id = item_order_id","LEFT");
        $this->db->where("item_u_id",u_id);
        $this->db->where("order_u_id",u_id);
        $this->db->where("order_status","paid");
        return $this->db->count_all_results("order_items");

    }



    public function get_coupon($code){
        return $this->db->where("coupon_code",$code)->limit(1)->get("coupons")->row();
    }

    public function update_coupon($coupon_id,$data){
        return $this->db->where("coupon_id",$coupon_id)->update("coupons",$data);
    }    

    public function validate_coupon($data){

        $coupon_code    = $data["coupon"];
        $order_id       = $data["order_id"];

        $coupon = $this->get_coupon($coupon_code);

        $order = $this->get_order($order_id);                

        if($coupon && $order && $order->items && $order->order_status == "unpaid"){

            $coupon_disabled    = $coupon->coupon_disabled;
            $coupon_expire      = $coupon->coupon_expire;
            $coupon_order_type  = $coupon->coupon_order_type;
            $coupon_conditions  = json_decode($coupon->coupon_conditions);
            $coupon_usage_count = $coupon->coupon_usage_count;
            $coupon_limit       = $coupon->coupon_limit;        
            $coupon_min_order   = $coupon->coupon_min_order;        

            /// If Coupon is disabled
            if( $coupon_disabled ){
                $returned = array("status"=>"error","alert"=>word("coupon_disabled"));
                /// If Coupon is expired
            }elseif( $coupon_expire && (time() > $coupon_expire) ){
                $returned = array("status"=>"error","alert"=>word("coupon_expired"));                
                /// If Coupon over used
            }elseif($coupon_limit > 0 && $coupon_usage_count >= $coupon_limit){
                $returned = array("status"=>"error","alert"=>word("coupon_limit_reached"));                                                        

                /// If minimum order not reached
            }elseif($coupon_min_order > 0 && $order->order_original_price < $coupon_min_order){                
                $returned = array("status"=>"error","alert"=>word("min_order_unreached"));                                            

            }else{

                $reduction = 0;
                $reduced_price = 0;
                
                
                /// No specific Type
                if(!$coupon_order_type){
                    
                    $effect         = $this->couponize($coupon,$order->order_original_price,$order->order_original_price);                     
                    $reduction      = $effect["discount"];
                    $reduced_price  = $effect["new_price"];
                                        
                /// Digital Items    
                }elseif($coupon_order_type == "digital_items"){

                    $effect         = $this->couponize($coupon,$order->order_original_price,$order->order_original_price);                     
                    $reduction      = $effect["discount"];
                    $reduced_price  = $effect["new_price"];

                    /// Packages    
                }elseif($coupon_order_type == "packages"){

                    foreach($order->items as $item){
                        $applicatble = $this->coupon_pack_applicable($item,$coupon_conditions);                        
                        if($applicatble){
                            $effect          = $this->couponize($coupon,$item->item_price,$order->order_original_price);                            
                            $reduction      += $effect["discount"];
                            $reduced_price  += $effect["new_price"];
                        }else{
                            $reduction      += 0;
                            $reduced_price  += $item->item_price;                            
                        }
                    }                    

                }
  
                /// sending feedback
                if($reduction){                      
                    $alert = str_replace("xxx" , word("usd")." ".$reduction , word("you_got_xxx_discount") ); 
                    $returned = array("status"=>"success", "alert"=> $alert, "reduction"=>$reduction, "new_price"=>$reduced_price);
                }else{
                    $returned = array("status"=>"error","alert"=>word("coupon_non_applicable_items"));
                }
            }

        }else{
            $returned = array("status"=>"error","alert"=>word("coupon_invalid"));
        }
                
        // updating order        
        if($returned["status"] === "success"){                    
            /// valid Coupon
            $order_update = array(
                "order_coupon"=>$coupon_code,
                "order_total_price"=>$reduced_price,
            );                        
        }elseif($returned["status"] === "error" && $order->order_original_price){
            /// invalid Coupon
            $order_update = array(
                "order_coupon"=>NULL,
                "order_total_price"=>$order->order_original_price,
            );                            
        }
        $this->update_order($order_id,$order_update);        

        $returned["referrer"] = user_referrer;
        
        return $returned;

    }


    public function coupon_pack_applicable($item,$conditions){
        
        $plan = @$conditions->plan;
        $packs = @$conditions->packs;
        $u_ids = @$conditions->u_ids;
        $referrer = @$conditions->referrer;

        $item_data = json_decode($item->item_data);

        $applicable = FALSE;
        if($plan){                    
            $applicable = $item_data->plan == $plan ? TRUE : FALSE;            
        }else{
            $applicable = TRUE;
        }

        if($applicable == TRUE){
            if( $packs){       
                $applicable = in_array($item->item_id,$packs) ? TRUE : FALSE;
            }else{
                $applicable = TRUE;
            }
        }

        if($applicable == TRUE){
            if( $u_ids){       
                $applicable = in_array(u_id,$u_ids) ? TRUE : FALSE;
            }else{
                $applicable = TRUE;
            }
        }    

        if($applicable == TRUE){
            if( $referrer ){       
                $applicable = user_referrer && strpos(user_referrer,$referrer) !== FALSE ? TRUE : FALSE;                
            }else{
                $applicable = TRUE;
            }
        }        

        return $applicable;

    }



    public function couponize($coupon,$price,$order_price){

        $coupon_percent     = $coupon->coupon_percent;        
        $coupon_max_amount  = $coupon->coupon_max_amount;        

        $discount = round( ( $price * ($coupon_percent/100) ) ,2);
        if($coupon_max_amount){
            $discount = $discount <= $coupon_max_amount ? $discount : $coupon_max_amount;
        }
        $discounted_price = round( ($price - $discount) , 2 );

        $effect = array(
            "old_price" => $price,
            "discount" => $discount,
            "new_price" => $discounted_price,
        );
                  
        return $effect;
    }

    
    
    public function increase_coupon_usage($coupon_code){
        $this->db->set('coupon_usage_count', 'coupon_usage_count+1', FALSE);
        $this->db->where('coupon_code', $coupon_code);
        $this->db->update('coupons');        
    }

}