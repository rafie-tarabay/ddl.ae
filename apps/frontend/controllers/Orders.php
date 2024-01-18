<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends MY_Controller {

    public function __construct(){
        parent::__construct(); // getting base constructor
        $method =  $this->router->fetch_method(); 
        if(!logged_in){
             if($method!='PrintCopy'){
                 redirect(base_url()); 
            }
        }        
    }    

    public function index(){
        $orders = $this->shopping->get_orders();
        $data["data"]["orders"]     = $orders;
        $data["views"]["title"]     = word("orders");
        $data["views"]["content"]   = 'shopping/list_orders';        
        $this->load->view(design_path.'/templates/main/core',$data);  
    }

    public function cart_order(){
        $order = $this->shopping->get_unpaid_order("digital_items");
        if(!$order){
            $content = $this->shopping->cart_content();            
            if($content){        
                $order_id = $this->shopping->cart_order();                                        
                if($order_id){
                    $this->shopping->empty_cart();
                    redirect(base_url("orders/show_order/".$order_id));
                }else{
                    $this->base->response_page(word("error"),"info",word("cannot_create_order"),1);              
                }
            }
        }else{
            $data["data"]["type"]       = "digital_items";
            $data["data"]["order"]      = $order;
            $data["views"]["title"]     = word("orders");
            $data["views"]["content"]   = 'shopping/unpaid_notice';        
            $this->load->view(design_path.'/templates/main/core',$data);                
        }
    }    
    
    public function packages_order(){
        
        
        
    }

    public function cancel_unpaid_orders($type=FALSE,$order_id=0){
        $this->shopping->cancel_unpaid_orders($type,$order_id);
        redirect( go_back( base_url("cart") ));
    }

    public function remove_item($order_id,$item_id){
        $order = $this->shopping->get_order($order_id);
        if($order->order_status == "unpaid"){
            $this->shopping->remove_order_items($order_id,array($item_id));
        }
        redirect( go_back( base_url("orders/show_order/".$order_id) ));
    }



    public function show_order($order_id){
        $order = $this->shopping->get_order($order_id);
        if($order){
            
            /// make sure the coupon is still valid
            if($order->order_status == "unpaid" && $coupon = $order->order_coupon){
                $data = array(
                    "coupon"    => $coupon,
                    "order_id"  => $order_id,
                );                
                $this->shopping->validate_coupon($data); 
                $order = $this->shopping->get_order($order_id);
            }
            
            $data["data"]["order"]      = $order;
            $data["views"]["title"]     = word("orders");
            $data["views"]["content"]   = 'shopping/show_order';        
            $this->load->view(design_path.'/templates/main/core',$data); 
        }else{
            $this->base->response_page(word("error"),"info",word("order_not_found"),1);                  
        } 
    }


    public function purchases(){

        $limit = 10;

        $count = $this->shopping->count_purchased();

        $pagination = $this->base->paginate_me($count,$limit,front_base."orders/purchases/",3);            

        $purchases = $this->shopping->get_purchased(FALSE,$pagination["page"],$limit,FALSE);

        $data["data"]["pagination"] = $pagination["links"];
        $data["data"]["purchases"]  = $purchases;
        $data["views"]["title"]     = word("orders");
        $data["views"]["content"]   = 'shopping/purchases';        
        $this->load->view(design_path.'/templates/main/core',$data); 
    }

    
    public function validate_coupon(){        
        $coupon = $this->input->post("coupon");        
        $order_id = $this->input->post("order_id");    
        
        $data = array(
            "coupon"    => $coupon,
            "order_id"  => $order_id,
        );           
        $valid = $this->shopping->validate_coupon($data);
        
        echo json_encode($valid);
    }    
    
    

    public function PrintCopy(){
        $type = "shipping";
        
        // $data = array(
        //     "order_u_id"            => u_id,
        //     "order_type"            => $type,
        //     "order_status"          => "unpaid",
        //     "order_coupon"          => NULL,
        //     "order_original_price"  => 0,
        //     "order_total_price"     => 0,
        //     "order_timestamp"       => time(),
        // );
        // $data['book_id'] = $this->input->post('book_id');
        // $data['first_name'] = $this->input->post('first_name');
        // $data['last_name'] = $this->input->post('last_name');
        // $data['email'] = $this->input->post('email');
        // $data['mobile'] = $this->input->post('mobile');
        // $data['country'] = $this->input->post('country');
        // $data['address'] = $this->input->post('address');
         
        $this->load->model("mail");
        $messege = "<br/> Request Details";
        $messege .= "<br />"."Book link : <a href='https://ddl.ae/book/".$this->input->post('book_id')."'> Click Here</a> <br /> or copy below link https://ddl.ae/book/".$this->input->post('book_id');
        $messege .= "<br />"."Book Title : ".$this->input->post('Title');
        $messege .= "<br />"."Quantity : ".$this->input->post('Quantity');
        $messege .= "<br />"."User Name : ".$this->input->post('first_name')." ".$this->input->post('last_name');
        $messege .= "<br />"."User Email : ".$this->input->post('email');
        $messege .= "<br />"."User Phone : ".$this->input->post('mobile');
        $messege .= "<br />"."User Country : ".$this->input->post('country');
        $messege .= "<br />"."User address : ".$this->input->post('address');

        $messege .= "<br/>"."<h3> Please communicate with the client ASAP!";

        $data["from"] = "info@ddl.ae";
        $data["to"] = "ahmed.alkailani@qindeel-dist.ae";
        $data["subject"] = "Shipping order from DDL";
        //$data["to"] = "mahmoud.ebid@ddl.ae";
        $data["message"]= $messege;
        $this->mail->send($data); // kilany
        $data["to"] = "mahmoud.ebid@ddl.ae";
        $this->mail->send($data);
        //$this->shipping->create_ship_order($data);
        //echo "done";
        exit;
    }
}