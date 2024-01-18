<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends MY_Controller{

    public function __construct() {
        parent::__construct(); // getting base constructor
        if(!logged_in && !in_array($this->router->method,array("index","view_package"))){ redirect(base_url()); } 
        $this->load->model("package");

    }     


    public function index(){

        $active_packs_ids = $this->package->get_active_packs(TRUE);

        $data["data"]["active_packs_ids"] = $active_packs_ids;   
        $data["data"]["packages"] = $this->package->get_packages();   
        $data["views"]["content"] = 'packages/forms/subscribe';   
        $data["views"]["title"] = word("packages");                                   
        $this->load->view(design_path.'/templates/main/core',$data);          
    }



    public function create_order(){

        $intersect = FALSE;
        $packs_ids = $this->input->post("packs");
        $plan = $this->input->post("subscribe_plan");

        if($packs_ids){

            $packs = $this->package->get_packages($packs_ids);

            if($packs){

                $active_packs_ids = $this->package->get_active_packs(TRUE);        
                if($active_packs_ids){
                    if(array_intersect($active_packs_ids,$packs_ids)){
                        $intersect = TRUE;    
                    }
                }

                if($intersect == FALSE){

                    $order = $this->shopping->get_unpaid_order("packages");
                    if(!$order){
                        $order_id = $this->shopping->packages_order($packs,$plan);                                        
                        if($order_id){
                            redirect(base_url("orders/show_order/".$order_id));
                        }else{
                            $this->base->response_page(word("error"),"info",word("cannot_create_order"),1);              
                        }
                    }else{
                        $data["data"]["type"]       = "packages";
                        $data["data"]["order"]      = $order;
                        $data["views"]["title"]     = word("orders");
                        $data["views"]["content"]   = 'shopping/unpaid_notice';        
                        $this->load->view(design_path.'/templates/main/core',$data);                
                    }

                }else{
                    $this->base->response_page(word("error"),"error",word("some_packs_already_active"),1);    
                }

            }else{
                redirect(go_back());
            }

        }else{
            redirect(base_url("packages"));
        }

    }



    public function view_package($pack_id){

        if($pack_id){

            $package = $this->package->get_package($pack_id);

            if($package){

                $books = $this->package->get_package_books($pack_id);

                $books_ids = get_ids_array($books,"book_id");

                $params = array(
                    "filters" => array(
                        "ids"=>$books_ids
                    ),
                    "limit" => count($books_ids)
                );
                $returned = $this->searcher->get_records($params);
                
                $books = @$returned["results"];
                
                $books = $this->searcher->sort_result_by($books,$books_ids);

                $data["data"]["package"]    = $package;            
                $data["data"]["books"]      = $books;            
                $data["views"]["title"]     = $package->title." - ".word("packages");
                $data["views"]["content"]   = 'packages/view_package';        
                $this->load->view(design_path.'/templates/main/core',$data);   

            }else{
                $this->base->response_page(word("error"),"error",word("package_not_exist"),1);    
            }
        }else{
            redirect(base_url("packages"));
        }

    }


}