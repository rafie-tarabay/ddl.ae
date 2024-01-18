<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social_actions extends MY_Controller {

    public function __construct() {        
        parent::__construct(); // getting base constructor
        $this->load->model("social_action");
    }    
    
    public function fav(){
        if(logged_in){
            $item_id = $this->input->post("item_id");
            if($item_id){
                if($this->social_action->is_faved($item_id)){
                    $this->social_action->undo_fav($item_id);
                    $btntext = word("fav_add");
                    $returned = array("status"=>"success", "action"=>"removed", "alert"=>word("removed_from_fav") , "btntext"=>$btntext);
                }else{
                    $this->social_action->do_fav($item_id);
                    $btntext = word("fav_remove");
                    $returned = array("status"=>"success", "action"=>"added", "alert"=>word("added_to_fav") , "btntext"=>$btntext);
                }
            }
        }else{
            $returned = array("status"=>"error" , "alert"=>word("need_login_use_property"));
        }
        
        echo json_encode($returned);
    }
    
        
    public function rate(){
        if(logged_in){            
            $item_id = $this->input->post("item_id");
            $value = $this->input->post("value");
            if($item_id && $value){
                if($this->social_action->is_rated($item_id)){
                    $this->social_action->update_book_rating($item_id,$value);
                    $returned = array("status"=>"success", "alert"=>word("rating_done_successfuly"));
                }else{
                    $this->social_action->create_book_rating($item_id,$value);
                    $returned = array("status"=>"success" , "alert"=>word("rating_done_successfuly"));
                }
            }
        }else{
            $returned = array("status"=>"error" , "alert"=>word("need_login_use_property"));
        }
        
        echo json_encode($returned);
    }
    
    
    
    
}