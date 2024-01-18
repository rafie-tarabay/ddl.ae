<?php

class Package extends base{

    public function __construct(){
        parent::__construct();  

    }    

    public function get_package($id){        
        $this->db->select("packages.* , pack_title_".locale." AS title , pack_desc_".locale." AS desc");
        $this->db->where("pack_id",$id);        
        return $this->db->limit(1)->get("packages")->row();        
    }

    public function get_packages($ids=FALSE){        
        $this->db->select("packages.* , pack_title_".locale." AS title , pack_desc_".locale." AS desc");
        if($ids) $this->db->where_in("pack_id",$ids);
        $this->db->where("pack_count >=",50);
        return $this->db->order_by("pack_order","ASC")->get("packages")->result();        
    }

    public function get_active_packs($return_ids = FALSE){
        if(logged_in){
            if($return_ids == TRUE){
                $this->db->select("sub_pack_id");
            }

            $this->db->where("sub_expiry_date >",time());
            $subs = $this->db->where("sub_u_id",u_id)->get("packages_subscriptions")->result();        

            if($return_ids){
                return get_ids_array($subs,"sub_pack_id");
            }else{
                return $subs;
            }
        }else{
            return array();
        }

    }


    public function activate_package_subs($order){

        $items = $order->items;
        $created = array();

        foreach($items as $item){

            $item_data = json_decode($item->item_data);
            $plan = $item_data->plan;
            switch ($plan) {
                case "monthly":
                    $expiry = strtotime("+1 month");
                    break;
                case "yearly":
                    $expiry = strtotime("+1 year");
                    break;
            }
            $data = array(
                "sub_pack_id" => $item->item_id,
                "sub_expiry_date" => $expiry,
            );
            if($this->create_subscription($data)){
                $created[] = 1;
            }
        }

        return count($created) == count($items);
    }



    public function create_subscription($data){
        $data["sub_u_id"]   = u_id;
        $data["sub_method"] = "payment";
        return $this->db->insert("packages_subscriptions",$data);        
    }


    public function get_package_books($pack_id){
        return $this->db->where("book_package_id",$pack_id)->order_by("book_order","ASC")->get("packages_books")->result();
    }

    public function get_packages_books($packs_ids){

        $books = array();

        $packages_books = $this->cache->get('packages_books');        
        if ( !$packages_books ){
            $packages_books = array();
            $packs = $this->get_packages();
            foreach($packs as $pack){
                $packages_books[$pack->pack_id] = $this->get_package_books($pack->pack_id);
            }

            $this->cache->save('packages_books', $packages_books, 60*60*2);
        }           

        foreach($packs_ids as $pack_id){
            if(isset($packages_books[$pack_id])){
                foreach($packages_books[$pack_id] as $books_data){
                    $books[$books_data->book_id] = $books_data->book_id; 
                }
            }
        }

        return $books;

    }


}