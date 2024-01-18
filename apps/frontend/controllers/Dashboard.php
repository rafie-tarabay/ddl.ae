<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller{

    public function index(){

        if(logged_in == TRUE){

            $this->load->model('Logs_analyzer','analyzer');
            $books = $this->analyzer->nominated_books();         

            $data["data"]["books"] = $books;

            $this->load->model("social_action","social");
            $favs_count = $this->social->count_favs();
            $purchases_count = $this->shopping->count_purchased();

            $data["data"]["favs_count"] = $favs_count;
            $data["data"]["purchases_count"] = $purchases_count;

            $data["views"]["full_width"] = TRUE;
            $data["views"]["header"] = 'landing';           
            $data["views"]["footer"] = 'landing';           
            $data["views"]["content"] = 'dashboard/nominated';  

            $this->load->view(design_path.'/templates/main/core',$data);            

        }else{
            redirect(base_url("login"));
        }        

    }


    public function favs(){

        if(logged_in == TRUE){

            $this->load->model("social_action","social");

            $count = $this->social->count_favs();

            $per_page = 20;                                    
            $pagination = $this->base->paginate_me($count,$per_page,front_base."dashboard/favs/",3,FALSE);            

            $favs = $this->social->fetch_favs(FALSE,FALSE,$per_page, $pagination["page"]);          

            if($favs){            
                $books_ids = get_ids_array($favs,"fav_item_id");
                
                $params = array(
                    "filters" => array(
                        "ids"=> $books_ids
                    ),
                    "similar" => FALSE,
                    "limit" => count($books_ids),
                );
                $returned = $this->searcher->get_records($params);      

                if ($books = @$returned["results"]){                                                        

                    $books = $this->searcher->sort_result_by($books,$books_ids);

                    $data["data"]["favs"] = $this->social->fetch_favs($books_ids);        
                    $data["data"]["ratings"] =  $this->social->fetch_ratings($books_ids);        
                    $data["data"]["purchases"] = $this->shopping->get_purchased($books_ids);
                }                

            }else{
                $books = array();
            }     

            $data["data"]["pagination"] = $pagination["links"];

            $data["data"]["books"] = $books;

            $data["views"]["full_width"] = TRUE;
            $data["views"]["header"] = 'landing';           
            $data["views"]["footer"] = 'landing';           
            $data["views"]["content"] = 'dashboard/favs';  

            $this->load->view(design_path.'/templates/main/core',$data);            

        }else{
            redirect(base_url("login"));
        }
    }





}