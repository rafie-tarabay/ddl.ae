<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends MY_Controller {

    public function __construct(){
        parent::__construct(); 
    }    

    public function index(){ 

        $items = $this->shopping->cart_content();
        $total_price = $this->shopping->total_price($items);
        
        $data["data"]["items"]      = $items;
        $data["data"]["total_price"]      = $total_price;
        $data["views"]["title"]     = word("shopping_cart");
        $data["views"]["content"]   = 'shopping/cart';        
        $this->load->view(design_path.'/templates/main/core',$data);         
        
    }       
    
    public function toggle_cart_item(){        
        $item_id = $this->input->post("item_id");

        if($this->shopping->exists_in_cart($item_id) == FALSE){
            $status = $this->shopping->add_to_cart($item_id);       
            if(in_array($status["status"],array("added","exists"))){                  
                $returned = array("status"=>"success","alert"=> word("added_to_cart"), "action"=>"added", "btntext"=>word("cart_remove") , "cart_count"=>$this->shopping->count_cart());  
            }elseif(in_array($status["status"],array("not_existing"))){                                
                $returned = array("status"=>"error","alert"=> word("content_not_found"));                               
            }
        }else{
            $status = $this->shopping->remove_from_cart($item_id);            
            if(in_array($status["status"],array("removed"))){                
                $returned = array("status"=>"success","alert"=> word("removed_from_cart") , "action"=>"removed", "btntext"=>word("cart_add") , "cart_count"=>$this->shopping->count_cart());                               
            }elseif(in_array($status["status"],array("not_existing"))){                
                $returned = array("status"=>"error","alert"=> word("content_not_found"));                               
            }                
        } 

        echo json_encode($returned);

    }
    
    public function remove_item($item_id){        
        $status = $this->shopping->remove_from_cart($item_id);            
        redirect(base_url("cart"));
    }


}