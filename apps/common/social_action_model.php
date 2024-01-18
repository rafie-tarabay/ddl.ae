<?php

class Social_action extends base{

    public function __construct(){
        parent::__construct();  
        $this->db = $this->load->database("frontend",true);         
    }    

    public function is_faved($item_id){
        $this->db->where("fav_item_id",$item_id);
        $this->db->where("fav_u_id",u_id);
        return $this->db->limit(1)->get("social_favs")->row();
    }

    public function do_fav($item_id){
        $data = array(
            "fav_item_id" =>$item_id,
            "fav_u_id" =>u_id,
            "fav_timestamp" => time(),
        );
        return $this->db->insert("social_favs",$data);
    }

    public function undo_fav($item_id){
        $this->db->where("fav_item_id",$item_id);
        $this->db->where("fav_u_id",u_id);
        return $this->db->limit(1)->delete("social_favs");
    }


    public function count_favs(){
        $this->db->where("fav_u_id",u_id);
        return $this->db->count_all_results("social_favs");        
    }


    public function fetch_favs($ids = FALSE,$indexed_format = TRUE,$limit = 0,$start = 0){
        if(u_id && logged_in){
            $indexed = array();   

            if($limit){ $this->db->limit($limit, $start); }

            if(is_array($ids) && @count($ids) > 0){ $this->db->where_in("fav_item_id",$ids); }

            $favs = $this->db->where("fav_u_id",u_id)->order_by("fav_timestamp","DESC")->get("social_favs")->result();

            if($favs && $indexed_format){
                foreach($favs as $fav){
                    $indexed[$fav->fav_item_id] = $fav;
                }
                return $indexed;              
            }else{
                return $favs;              
            }            
        }else{
            return FALSE;
        }
    }


    /////////////////////////////////

    public function is_rated($item_id){
        $this->db->where("rating_item_id",$item_id);
        $this->db->where("rating_u_id",u_id);
        return $this->db->limit(1)->get("social_ratings")->row();
    }

    public function create_book_rating($item_id,$value){    
        $data = array(
            "rating_item_id" =>$item_id,
            "rating_u_id" =>u_id,
            "rating_value" =>$value,
            "rating_timestamp" => time(),
        );
        return $this->db->insert("social_ratings",$data);
    }

    public function update_book_rating($item_id,$value){    
        $data = array(
            "rating_value" =>$value,
        );        
        $this->db->where("rating_item_id",$item_id);
        $this->db->where("rating_u_id",u_id);
        return $this->db->update("social_ratings",$data);
    }

    public function fetch_ratings($ids = FALSE){
        if(u_id && logged_in){
            $indexed = array();
            if(is_array($ids) && @count($ids) > 0){
                $this->db->where_in("rating_item_id",$ids);
            }                                              
            $ratings =  $this->db->where("rating_u_id",u_id)->get("social_ratings")->result();            
            if($ratings){
                foreach($ratings as $rating){
                    $indexed[$rating->rating_item_id] = $rating;
                }
            }            
            return $indexed;

        }else{
            return FALSE;
        }
    }           


    /////////////////////////////////


    public function fetch_purchases($ids = FALSE){
        if(u_id && logged_in){
            $indexed = array();
            if(is_array($ids) && @count($ids) > 0){
                $this->db->where_in("product_id",$ids);
            }
            $purchases = $this->db->where("customer_id",u_id)->get("digital_object_shelves")->result();
            if($purchases){
                foreach($purchases as $pur){
                    $indexed[$pur->product_id] = $pur;
                }
            }            
            return $indexed;            
        }else{
            return FALSE;
        }
    }         


}