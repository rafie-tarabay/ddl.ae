<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payments extends MY_Controller {

    var $driver;
    var $order_id;

    public function __construct() {
        parent::__construct(); // getting base constructor
        if(!logged_in){ redirect(base_url()); } 

        $this->driver = FALSE;
        $this->order_id  = FALSE;
    }    


    public function index(){

        $payments = $this->shopping->get_payments();
                

        $data["data"]["payments"]   = $payments;
        $data["views"]["title"]     = word("payments");
        $data["views"]["content"]   = 'payments/list_payments';        
        $this->load->view(design_path.'/templates/main/core',$data);       

    }



    public function set_driver($driver){

        $drivers = array('paypal' => array(
            'name'                   => 'paypal', 
            'PayPalMode'             => (settings("localhost") || u_id == 11  || u_id == 2) ? 'sandbox' : 'live',  // sandbox or live
            'PayPalReturnURL'        => base_url(front_base.'order/finalize'), 
            'PayPalCancelURL'        => base_url(front_base.'order/canceled/'), 

            'sandbox'                => array(
                'PayPalAccount'          => 'info@ddl.ae', 
                'PayPalApiUsername'      => 'info-facilitator_api1.ddl.ae', //PayPal API Username
                'PayPalApiPassword'      => 'F2D2KGACRTCQUUM8', //Paypal API password
                'PayPalApiSignature'     => 'Aaose356mD-hOFG7cGBTPyJXSUZEA6aZ1DTQ4dXU4khdjXkIhaJqC6Yc', //Paypal API Signature
                'PayPalCurrencyCode'     => 'USD', //Paypal Currency Code
                'PayPalClientID'         => 'AZXACCKx-7SBs71_wC9UWSXgCpZXQCf4weFUw7Qa_dmAMu295yKR6C0akQmExtUTq6VnwE1AHQ5QZoYC', 
                'PayPalSecret'           => 'EGDK7OV1hWo8KKUxrnso6o8G-oEs7yVUvWgYHv644glzpqJ9hIap7MTwdu-9vkNqlETxWeympVQKYqH4',                 
            ),

            'live'                   => array(
                'PayPalAccount'          => 'info@ddl.ae', 
                'PayPalApiUsername'      => 'info_api1.ddl.ae', //PayPal API Username
                'PayPalApiPassword'      => 'RGG3JL84DWA4H9H5', //Paypal API password
                'PayPalApiSignature'     => 'Aj1.e7zD4D-bCLiIwBVRA8Ai.tGuAds0uWX7E0hCEZs4JWhIQjm6o.Qg', //Paypal API Signature
                'PayPalCurrencyCode'     => 'USD', //Paypal Currency Code
                'PayPalClientID'         => 'AbO0JwXWclRTD-0xLljiW53oebAES4sozaFttkoNP7hvDadEJUbzCIGxqfZdljwron2-1y8mZdaEQpoS', 
                'PayPalSecret'           => 'ELzrQ20LtK_Y1j4snyqsalSEo7FqNEo8oj89zmNijrmWWotkUniW7qQF8LEDT-q-PpJ5Qod8kKDljVe1',                 
            ),

            )
        );

        if(isset($drivers[$driver])){
            $this->driver =  $drivers[$driver];    
        }

    }

    public function process($order_id=FALSE){

        if($order_id == FALSE){
            $this->order_id = $this->input->post("order_id");   
        }  

        if($order_id = $this->order_id){
            
            /// make sure the coupon is still valid
            $coupon = $this->input->post("coupon");
            
            if($coupon){
                $data = array(
                    "coupon"    => $coupon,
                    "order_id"  => $order_id,
                );                
                $this->shopping->validate_coupon($data);                
            }            
            
            $driver = $this->input->post("driver");        
            $this->set_driver($driver);
            $this->{$this->driver["name"]."_initiate"}();        
        }else{
            redirect(base_url("orders"));
        }

    }

    public function paypal_initiate(){

        $this->set_driver("paypal");

        $mode           = $this->driver["PayPalMode"];
        $client_id       = $this->driver[$mode]["PayPalClientID"];

        $order = $this->shopping->get_order($this->order_id);

        if($order->order_status == "unpaid" && $order->order_total_price > 0){
            $data["data"]["client_id"]  = $client_id;
            $data["data"]["order"]      = $order;
            $data["views"]["title"]     = word("orders");
            $data["views"]["content"]   = 'payments/paypal';        
            $this->load->view(design_path.'/templates/main/core',$data);                     
        }else{
            redirect( go_back( base_url("orders/show_order/".$this->order_id) ));
        }

    }

    public function paypal_capture($order_id = FALSE, $invoice_id = FALSE,$auth_id = FALSE){

        $success = FALSE;

        $this->set_driver("paypal");

        if(!$order_id)      $order_id = $this->input->post("order_id"); // our order id
        if(!$invoice_id)    $invoice_id = $this->input->post("invoice_id"); // paypal order id        
        if(!$auth_id)       $auth_id = $this->input->post("auth_id");

        $order_page = base_url("orders/show_order/".$order_id);

        if($order_id && $invoice_id){
            
            $order = $this->shopping->get_order($order_id);

            /// check already paid
            $wheres = array(
                "payment_order_id"  => $order_id,
                "payment_status"    => "captured",
            );
            $payment = $this->shopping->get_payments($wheres,1);

            if(!$payment && $order && $order->order_status == "unpaid"){

                /// loading payment library
                $this->load->library("paypal");
                $paypal = new MyPayments\MyPaypal;
                $paypal->setClient($this->driver) ;

                /// validating paypal record
                $response = $paypal->getOrder($invoice_id);

                /// invoice exists in payal
                if($response->statusCode == 200 && $response->result->status == "COMPLETED"){

                    $payment_id = $response->result->id;
                    $amount     = $response->result->purchase_units[0]->amount->value;    
                    $currency   = $response->result->purchase_units[0]->amount->currency_code;                
                    $details    = array(
                        "invoice_id" => $invoice_id
                    );

                    $mode = $this->driver["PayPalMode"];
                    $paypal_account = $this->driver[$mode]["PayPalAccount"];

                    $paylog = array(
                        "payment_u_id"      => u_id,
                        "payment_order_id"  => $order_id,
                        "payment_method"    => "paypal",
                        "payment_account"   => $paypal_account,
                        "payment_ref_id"    => $payment_id,
                        "payment_amount"    => $amount,
                        "payment_currency"  => $currency,
                        "payment_status"    => NULL,
                        "payment_details"   => json_encode($details),
                        "payment_timestamp" => time(),
                    );                     

                    /// Captured
                    if($response->result->intent == "CAPTURE" ){

                        $paylog["payment_status"] = "captured";

                        $success = TRUE; // Important

                        /// Just authorized needs Capture
                    }elseif($response->result->intent == "AUTHORIZE"){

                        $response = $paypal->capture($auth_id);

                        /// Captured
                        if($response->statusCode == 201 && $response->result->status == "COMPLETED"){                

                            $payment_id = $response->result->id;

                            $paylog["payment_ref_id"] = $payment_id;
                            $paylog["payment_status"] = "captured";                        

                            $success = TRUE; // Important

                        }else{
                            $returned = array("status"=>"error","alert"=>word("payment_not_captured"),"url"=>$order_page);                           
                        }                

                    }else{
                        $returned = array("status"=>"error","alert"=>word("payment_error"),"url"=>$order_page);                           
                    }

                }else{            
                    $returned = array("status"=>"error","alert"=>word("payment_error"),"url"=>$order_page);            
                }    

            }else{
                $returned = array("status"=>"info","alert"=>word("order_already_paid"),"url"=>$order_page);            
            }

        }

        if($success === TRUE){   

            $pay_id = $this->shopping->add_payment($paylog);  
            $updated = $this->shopping->update_order($order_id,array("order_status"=>"paid"));
            
            /// activate packages subscriptions
            if($order->order_type == "packages"){
                
                $this->load->model("package");
                $activated = $this->package->activate_package_subs($order);
                if(!$activated){
                    $updated = FALSE;    
                }
            }
            
            /// save revenue for sources
            if($order->order_type == "digital_items"){                
                $this->save_sources_revenues($order);                                
            }
                        
            /// increase coupon usage
            if($order->order_coupon){
                $this->shopping->increase_coupon_usage($order->order_coupon);
            }
            
            if($pay_id > 0 && $updated == TRUE){
                $returned = array("status"=>"success","alert"=>word("payment_done"),"url"=>$order_page);                                    
            }else{
                $returned = array("status"=>"error","alert"=>word("server_error_contact_admin"));            
                $this->load->model("mail");
                $this->mail->payment_error($paylog);
            }

        }

        echo json_encode($returned);

    }

    
    
    public function save_sources_revenues($order){
        
        foreach($order->items as $item){
        
            if($order->order_original_price){
                $discount_percent = $order->order_total_price / $order->order_original_price;
            }else{
                $discount_percent = 1;
            }
            
            $rev = array(
                "rev_source_id" => $item->item_source_id,
                "rev_order_id" => $order->order_id,
                "rev_item_id" => $item->item_id,
                "rev_amount" => $discount_percent * $item->item_price,
                "rev_timestamp" => $order->order_timestamp,
            );

            $this->db->insert("sources_revenues",$rev);        
            
        }
        
    }


}